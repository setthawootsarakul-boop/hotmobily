<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\CartItem;
use App\Models\ProductPrice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class QuotationController extends Controller
{
    // =========================================================
    // 1. หน้าแรก (Step 1): กรอกข้อมูลติดต่อ + ที่อยู่จัดส่ง
    // =========================================================
    public function index()
    {
        // ดึงข้อมูลเก่าจาก Session (ถ้ามี) มาแสดงเผื่อลูกค้ากดย้อนกลับ
        $tempData = session()->get('quotation_step1', []);
        return view('quotation.index', compact('tempData'));
    }

    // Handle Step 1 Submit
    public function storeStep1(Request $request)
    {
        // Validate ข้อมูล Step 1
        $request->validate([
            'fullname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'province' => 'required',
            'district' => 'required',
            'sub_district' => 'required',
            'zipcode' => 'required',
            'tax_invoice_req' => 'required'
        ]);

        // เก็บข้อมูล Step 1 ลง Session
        session()->put('quotation_step1', $request->all());

        // เช็คเงื่อนไข
        if ($request->tax_invoice_req == '1') {
            // ถ้าเลือก "แบบกระดาษ" -> ไป Step 2
            return redirect()->route('quotation.tax_info');
        } else {
            // ถ้า "ไม่ต้องการ" -> บันทึกเลย
            return $this->saveQuotation($request->all());
        }
    }

    // =========================================================
    // 2. หน้าสอง (Step 2): กรอกข้อมูลใบกำกับภาษี
    // =========================================================
    public function taxInfo()
    {
        // เช็คว่ามีข้อมูล Step 1 หรือยัง ถ้าไม่มีให้ดีดกลับ
        if (!session()->has('quotation_step1')) {
            return redirect()->route('quotation.index');
        }

        $step1Data = session()->get('quotation_step1');
        return view('quotation.tax_info', compact('step1Data'));
    }

    // Handle Step 2 Submit (Final)
    public function confirmQuotation(Request $request)
    {
        // Validate ข้อมูล Step 2
        $request->validate([
            'tax_person_type' => 'required',
            'tax_name' => 'required',
            'tax_id' => 'required',
            'tax_province' => 'required',
            // ... validate อื่นๆ ตามต้องการ
        ]);

        // รวมข้อมูล Step 1 + Step 2
        $step1Data = session()->get('quotation_step1');
        $finalData = array_merge($step1Data, $request->all());

        return $this->saveQuotation($finalData);
    }

    // =========================================================
    // 3. Logic บันทึกลง Database (Transaction)
    // =========================================================
    private function saveQuotation($data)
    {
        DB::beginTransaction(); // เริ่ม Transaction

        try {
            // 1. ระบุตัวตน
            $sessionId = Session::getId();
            $userId = auth()->id();

            $data['session_id'] = $sessionId;
            $data['user_id'] = $userId;
            $data['status'] = 'pending';

            // 2. สร้างใบเสนอราคา (Head)
            $quotation = Quotation::create($data);

            // 3. ดึงข้อมูลจากตะกร้า
            $cartItems = CartItem::where(function($query) use ($sessionId, $userId) {
                            $query->where('session_id', $sessionId);
                            if ($userId) {
                                $query->orWhere('user_id', $userId);
                            }
                        })->with('product')->get();

            if ($cartItems->isEmpty()) {
                throw new \Exception('ตะกร้าสินค้าว่างเปล่า');
            }

            // 4. วนลูปบันทึกรายการสินค้า (Items)
            foreach ($cartItems as $item) {
                
                $qty = $item->quantity;
                $options = $item->options; // JSON/Array
                
                // คำนวณราคาตามขั้นบันได
                $priceQuery = ProductPrice::where('product_id', $item->product_id)
                                ->where('quantity_min', '<=', $qty)
                                ->where('quantity_max', '>=', $qty);

                if (isset($options['size_id'])) {
                    $priceQuery->where('product_size_id', $options['size_id']);
                }

                $priceRecord = $priceQuery->first();
                $unitPrice = $priceRecord ? $priceRecord->price_per_unit : 0; 

                // บันทึกลง QuotationItem
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id' => $item->product_id,
                    'product_name' => $item->product->name,
                    'options' => $options,
                    'quantity' => $qty,
                    'price_per_unit' => $unitPrice,
                    'total_price' => $unitPrice * $qty,
                ]);
            }

            // 5. ล้างตะกร้าสินค้า
            CartItem::where(function($query) use ($sessionId, $userId) {
                $query->where('session_id', $sessionId);
                if ($userId) {
                    $query->orWhere('user_id', $userId);
                }
            })->delete();

            // 6. ล้าง Session
            session()->forget(['quotation_step1']);

            DB::commit();

            // 7. ไปหน้าใบเสร็จ
            return redirect()->route('quotation.show', $quotation->id);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }
    
    // =========================================================
    // 4. หน้าแสดงผลใบเสนอราคา (Success Page)
    // =========================================================
    public function show($id)
    {
        // ดึงข้อมูลใบเสนอราคาพร้อมรายการสินค้า
        $quotation = Quotation::with('quotationItems')->findOrFail($id);
        
        // TODO: สร้างไฟล์ resources/views/quotation/show.blade.php เพื่อรองรับหน้านี้
        return view('quotation.show', compact('quotation'));
    }
}