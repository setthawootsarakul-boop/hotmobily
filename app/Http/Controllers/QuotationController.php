<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use App\Mail\QuotationNotification; 
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\CartItem;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;
use PHPMailer\PHPMailer\PHPMailer;

class QuotationController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('selected_items')) {
            session()->put('quotation_selected_items', $request->selected_items);
        }
        $tempData = session()->get('quotation_step1', []);
        return view('quotation.index', compact('tempData'));
    }

    public function storeStep1(Request $request)
    {
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

        $data = $request->all();

        // 🔥 ดึงชื่อจาก JSON โดยตรง (วิธีที่แม่นยำที่สุด)
        try {
            $jsonPath = public_path('province_with_district_and_sub_district.json');
            if (File::exists($jsonPath)) {
                $allData = json_decode(File::get($jsonPath), true);
                $collectData = collect($allData);
                
                // 1. หาจังหวัด
                $province = $collectData->firstWhere('id', (int)$request->province);
                if ($province) {
                    $data['province'] = $province['name_th'];
                    
                    // 2. หาอำเภอ
                    $district = collect($province['districts'])->firstWhere('id', (int)$request->district);
                    if ($district) {
                        $data['district'] = $district['name_th'];
                        
                        // 3. หาตำบล
                        $subDistrict = collect($district['sub_districts'])->firstWhere('id', (int)$request->sub_district);
                        if ($subDistrict) {
                            $data['sub_district'] = $subDistrict['name_th'];
                        }
                    }
                }
            }
        } catch (\Exception $e) {
            // Fallback: หาก JSON พัง ให้ใช้ชื่อที่ส่งมาจาก Hidden Input (ถ้ามี) หรือ ID เดิม
            $data['province'] = $request->province_name ?? $request->province;
            $data['district'] = $request->district_name ?? $request->district;
            $data['sub_district'] = $request->sub_district_name ?? $request->sub_district;
        }

        session()->put('quotation_step1', $data);

        if ($request->tax_invoice_req == '1') {
            return redirect()->route('quotation.tax_info');
        } else {
            return $this->saveQuotation($data);
        }
    }

    public function taxInfo()
    {
        if (!session()->has('quotation_step1')) {
            return redirect()->route('quotation.index');
        }
        $step1Data = session()->get('quotation_step1');
        return view('quotation.tax_info', compact('step1Data'));
    }

    public function confirmQuotation(Request $request)
    {
        $request->validate([
            'tax_person_type' => 'required',
            'tax_name' => 'required',
            'tax_id' => 'required',
        ]);

        $step1Data = session()->get('quotation_step1');
        if (!$step1Data) {
            return redirect()->route('quotation.index')->with('error', 'ข้อมูลหมดอายุ กรุณากรอกใหม่');
        }

        $taxData = $request->all();
        
        // 🔥 แปลงที่อยู่ใบกำกับภาษีโดยใช้ Logic เดียวกัน (JSON)
        try {
            $jsonPath = public_path('province_with_district_and_sub_district.json');
            if (File::exists($jsonPath)) {
                $allData = json_decode(File::get($jsonPath), true);
                $collectData = collect($allData);
                
                $p = $collectData->firstWhere('id', (int)$request->tax_province);
                if ($p) {
                    $taxData['tax_province'] = $p['name_th'];
                    $d = collect($p['districts'])->firstWhere('id', (int)$request->tax_district);
                    if ($d) {
                        $taxData['tax_district'] = $d['name_th'];
                        $s = collect($d['sub_districts'])->firstWhere('id', (int)$request->tax_sub_district);
                        if ($s) $taxData['tax_sub_district'] = $s['name_th'];
                    }
                }
            }
        } catch (\Exception $e) {
            $taxData['tax_province'] = $request->tax_province_name ?? $request->tax_province;
            $taxData['tax_district'] = $request->tax_district_name ?? $request->tax_district;
            $taxData['tax_sub_district'] = $request->tax_sub_district_name ?? $request->tax_sub_district;
        }

        $finalData = array_merge($step1Data, $taxData);
        return $this->saveQuotation($finalData);
    }

    private function saveQuotation($data)
    {
        DB::beginTransaction();
        try {
            $sessionId = Session::getId();
            $userId = auth()->id();

            $data['session_id'] = $sessionId;
            $data['user_id'] = $userId;
            $data['status'] = 'pending';
            $data['quotation_number'] = 'HS-T-' . date('ymd') . '_' . rand(10, 99) . '_' . rand(100, 999);
            $data['due_date'] = now()->addDays(30);

            $quotation = Quotation::create($data);

            $selectedRowIds = session()->get('quotation_selected_items', []);
            $cartQuery = CartItem::where('session_id', $sessionId);
            if (!empty($selectedRowIds)) { $cartQuery->whereIn('id', $selectedRowIds); }
            $cartItems = $cartQuery->get();

            if ($cartItems->isEmpty()) { throw new \Exception('ไม่พบรายการสินค้าในตะกร้า'); }

            $grandTotal = 0;
            foreach ($cartItems as $item) {
                $qty = (int)$item->quantity;
                $options = $item->options;
                $product = Product::find($item->product_id);
                $productName = $product ? $product->name : 'สินค้าทั่วไป';

                $priceRecord = ProductPrice::where('product_id', $item->product_id)
                                ->where('quantity_min', '<=', $qty)
                                ->where('quantity_max', '>=', $qty)
                                ->first();
                $unitPrice = $priceRecord ? $priceRecord->price_per_unit : 0;
                $totalLine = $unitPrice * $qty;

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $productName,
                    'options'      => $options,
                    'quantity'     => $qty,
                    'price_per_unit' => $unitPrice,
                    'total_price'  => $totalLine,
                ]);
                $grandTotal += $totalLine;
            }

            $quotation->update(['subtotal' => $grandTotal, 'grand_total' => $grandTotal]);

            if (!empty($selectedRowIds)) { CartItem::whereIn('id', $selectedRowIds)->delete(); }
            else { CartItem::where('session_id', $sessionId)->delete(); }

            session()->forget(['quotation_step1', 'quotation_selected_items']);
            
            DB::commit();

            // 🚀 ส่วนส่งอีเมลแจ้งเตือน
            try {
                $customerName = $data['fullname'] ?? 'ลูกค้า'; 
                $quotationNo = $quotation->quotation_number;
                $siteUrl = url('/');

                $text = '<!DOCTYPE html>
                    <html>
                    <head>
                        <meta charset="utf-8">
                        <style>
                            body { font-family: "Helvetica", Arial, sans-serif; background-color: #f4f4f4; color: #333; }
                            .header { background-color: #fbab00; padding: 30px; text-align: center; color: white; }
                            .content { padding: 30px; background: white; border-radius: 8px; margin-top: 20px; }
                            .order-summary { background-color: #fff8ec; padding: 20px; border-radius: 6px; margin: 20px 0; }
                            .btn { display: inline-block; padding: 12px 25px; background-color: #fbab00; color: white; text-decoration: none; border-radius: 6px; }
                        </style>
                    </head>
                    <body>
                        <div style="max-width: 600px; margin: auto;">
                            <div class="header"><h1>ขอบคุณที่ไว้วางใจ Hotmobily</h1></div>
                            <div class="content">
                                <p>สวัสดีคุณ <strong>' . htmlspecialchars($customerName) . '</strong>,</p>
                                <p>เราได้รับคำขอใบเสนอราคาของคุณเรียบร้อยแล้ว ทีมงานของเรากำลังตรวจสอบข้อมูลและจะติดต่อกลับโดยเร็วที่สุด</p>
                                <div class="order-summary">
                                    <p><strong>เลขที่ใบเสนอราคา:</strong> ' . $quotationNo . '</p>
                                    <p><strong>สถานะ:</strong> กำลังดำเนินการตรวจสอบ</p>
                                </div>
                                <div style="text-align: center;"><a href="' . $siteUrl . '" class="btn">เข้าสู่เว็บไซต์ของเรา</a></div>
                            </div>
                        </div>
                    </body>
                    </html>';

                $phpmailer = new PHPMailer(true);
                $phpmailer->CharSet = "UTF-8";
                $phpmailer->isSMTP();
                $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
                $phpmailer->SMTPAuth = true;
                $phpmailer->Port = 2525;
                $phpmailer->Username = 'd67afb6d8954e9';
                $phpmailer->Password = '280901d4fac261';
                
                // $phpmailer->setFrom('no-reply@hotstrapthai.com', 'Hotstrap Thai');
                
                
                // if(isset($data['email'])) {
                //     $phpmailer->addAddress($data['email']); 
                // }
                
                // สำเนาลับส่งเข้า Mailtrap Sandbox
                $phpmailer->addAddress('cd685a991d-4bf6a9+user1@inbox.mailtrap.io'); 

                $phpmailer->Subject = 'ขอบคุณที่ติดต่อขอใบเสนอราคา - Hotstrap Thai (No. ' . $quotationNo . ')';
                $phpmailer->isHTML(true);
                $phpmailer->Body = $text;
                $phpmailer->send();

            } catch (\Exception $mailEx) {
                
                \Log::error("Mail Error: " . $mailEx->getMessage());
            }

            return redirect()->route('quotation.show', $quotation->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

    public function show($id)
    {
        $quotation = Quotation::with('items')->findOrFail($id);
        return view('quotation.show', compact('quotation'));
    }
}