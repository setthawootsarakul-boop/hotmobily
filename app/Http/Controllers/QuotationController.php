<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage; // ✅ เพิ่มเพื่อใช้จัดการไฟล์แบบหน้า Contact
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Models\CartItem;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        $rules = [
            'fullname' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'province' => 'required',
            'tax_invoice_req' => 'required',
            // ✅ รับไฟล์จากหน้าแรกเหมือนหน้า Contact
            'quotation_attachments.*' => 'nullable|file|mimes:ai,psd,pdf,doc,xls,jpeg,jpg,png,zip|max:10240',
        ];

        if ($request->tax_invoice_req == '0') {
            $rules['g-recaptcha-response'] = 'required';
        }

        $request->validate($rules);

        if ($request->tax_invoice_req == '0') {
            $this->verifyRecaptcha($request->input('g-recaptcha-response'));
        }

        // ✅ จุดสำคัญ: จัดการไฟล์ทันที (Logic เดียวกับหน้า Contact)
        $attachmentPaths = [];
        if ($request->hasFile('quotation_attachments')) {
            foreach ($request->file('quotation_attachments') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('quotations', $fileName, 'public');
                $attachmentPaths[] = $path;
            }
        }

        // ✅ เก็บข้อมูลลง Session โดยเอา Path ไฟล์ใส่แทนก้อนไฟล์ดิบ
        $data = $request->except('quotation_attachments'); 
        $data['attachments'] = $attachmentPaths; // ใส่พาธไฟล์ลงใน key 'attachments' ให้ตรงกับ DB
        $data['tax_invoice_required'] = $request->tax_invoice_req;

        // (ส่วนดึงที่อยู่ภาษาไทยคงเดิมของคุณ...)
        try {
            $jsonPath = public_path('province_with_district_and_sub_district.json');
            if (File::exists($jsonPath)) {
                $allData = json_decode(File::get($jsonPath), true);
                $collectData = collect($allData);
                $province = $collectData->firstWhere('id', (int)$request->province);
                if ($province) {
                    $data['province'] = $province['name_th'];
                    $district = collect($province['districts'])->firstWhere('id', (int)$request->district);
                    if ($district) {
                        $data['district'] = $district['name_th'];
                        $subDistrict = collect($district['sub_districts'])->firstWhere('id', (int)$request->sub_district);
                        if ($subDistrict) $data['sub_district'] = $subDistrict['name_th'];
                    }
                }
            }
        } catch (\Exception $e) {}

        session()->put('quotation_step1', $data);

        if ($request->tax_invoice_req == '1') {
            return redirect()->route('quotation.tax_info');
        } else {
            return $this->saveQuotation($data);
        }
    }

    public function taxInfo()
    {
        if (!session()->has('quotation_step1')) return redirect()->route('quotation.index');
        $step1Data = session()->get('quotation_step1');
        return view('quotation.tax_info', compact('step1Data'));
    }

    public function confirmQuotation(Request $request)
    {
        $step1Data = session()->get('quotation_step1');
        if (!$step1Data) return redirect()->route('quotation.index')->with('error', 'ข้อมูลหมดอายุ');

        // รวมข้อมูลจากหน้า 1 (ที่มีไฟล์แล้ว) กับหน้า ภาษี
        $finalData = array_merge($step1Data, $request->all());
        return $this->saveQuotation($finalData);
    }

    private function saveQuotation($data)
    {
        DB::beginTransaction();
        try {
            $sessionId = Session::getId(); // ✅ กัน Error variable undefined
            $userId = auth()->id();

            $data['session_id'] = $sessionId;
            $data['user_id'] = $userId;
            $data['status'] = 'pending';
            $data['quotation_number'] = 'HS-T-' . date('ymd') . '_' . rand(10, 99) . '_' . rand(100, 999);
            $data['due_date'] = now()->addDays(30);

            // ✅ บันทึกข้อมูลลง MySQL ( attachments จะมีค่าเพราะเราใส่ไว้ใน $data ตั้งแต่ Step 1 )
            $quotation = Quotation::create($data);

            // (ส่วนบันทึก Items และ Grand Total คงเดิม 100%)
            $selectedRowIds = session()->get('quotation_selected_items', []);
            $cartQuery = CartItem::where('session_id', $sessionId);
            if (!empty($selectedRowIds)) $cartQuery->whereIn('id', $selectedRowIds);
            $cartItems = $cartQuery->get();

            if ($cartItems->isEmpty()) throw new \Exception('ไม่พบสินค้าในตะกร้า');

            $grandTotal = 0;
            foreach ($cartItems as $item) {
                $qty = (int)$item->quantity;
                $product = Product::find($item->product_id);
                $priceRecord = ProductPrice::where('product_id', $item->product_id)
                                ->where('quantity_min', '<=', $qty)
                                ->where('quantity_max', '>=', $qty)
                                ->first();
                $unitPrice = $priceRecord ? $priceRecord->price_per_unit : 0;
                $totalLine = $unitPrice * $qty;

                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'product_id'   => $item->product_id,
                    'product_name' => $product->name ?? 'สินค้าทั่วไป',
                    'options'      => $item->options,
                    'quantity'     => $qty,
                    'price_per_unit' => $unitPrice,
                    'total_price'  => $totalLine,
                ]);
                $grandTotal += $totalLine;
            }

            $quotation->update(['subtotal' => $grandTotal, 'grand_total' => $grandTotal]);
            
            CartItem::whereIn('id', $cartItems->pluck('id'))->delete();
            session()->forget(['quotation_step1', 'quotation_selected_items']);
            DB::commit();

            // ส่ง Email (เรียกฟังก์ชันข้างล่าง)
            $this->sendEmailNotification($quotation, $data);

            return redirect()->route('quotation.show', $quotation->id);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'เกิดข้อผิดพลาด: ' . $e->getMessage());
        }
    }

private function sendEmailNotification($quotation, $data)
    {
        try {
            date_default_timezone_set('Asia/Bangkok');
            $customerName = $data['fullname'] ?? 'ลูกค้า';
            $companyName = !empty($data['company_name']) ? ' (' . htmlspecialchars($data['company_name']) . ')' : '';
            $quotationNo = $quotation->quotation_number;
            $customerEmail = $data['email'];
            $siteUrl = url('/');


            $dateOnly = date('d/m/Y');
            $timeOnly = date('H:i') . ' น.';


            $style = '<style>
                body { font-family: "Helvetica", Arial, sans-serif; line-height: 1.6; color: #333; }
                .header { background-color: #fbab00; padding: 20px; text-align: center; color: white; }
                .content { padding: 30px; background: white; border: 1px solid #ddd; border-radius: 8px; }
                .order-summary { background-color: #fff8ec; padding: 20px; border-radius: 6px; margin: 20px 0; border: 1px solid #fbab00; }
                .btn { display: inline-block; padding: 12px 25px; background-color: #fbab00; color: white !important; text-decoration: none; border-radius: 6px; font-weight: bold; }
                .info-list { list-style: none; padding: 0; margin: 0; }
                .info-list li { padding: 8px 0; border-bottom: 1px dashed #fbab0050; }
                .label { font-weight: bold; color: #fbab00; display: inline-block; width: 110px; }
                .note-box { background:#fdfdfd; padding:15px; border-left:4px solid #fbab00; margin-top:15px; font-style: italic; }
            </style>';

            $customerBody = '<!DOCTYPE html><html><head><meta charset="utf-8">' . $style . '</head><body>
                <div style="max-width: 600px; margin: auto;">
                    <div class="header"><h1>ขอบคุณที่ไว้วางใจ Hotmobily</h1></div>
                    <div class="content">
                        <p>สวัสดีคุณ <strong>' . htmlspecialchars($customerName) . $companyName . '</strong>,</p>
                        <p>เราได้รับคำขอใบเสนอราคาของคุณเรียบร้อยแล้ว ทีมงานจะตรวจสอบข้อมูลและติดต่อกลับหาท่านโดยเร็วที่สุด</p>
                        
                        <div class="order-summary">
                            <ul class="info-list">
                                <li><span class="label">เลขที่ขอ:</span> ' . $quotationNo . '</li>
                                <li><span class="label">วันที่ขอ:</span> ' . $dateOnly . '</li>
                                <li><span class="label">เวลาที่ขอ:</span> ' . $timeOnly . '</li>
                                <li><span class="label">สถานะ:</span> กำลังดำเนินการ</li>
                            </ul>
                        </div>

                        <div style="text-align: center; margin-top:30px;">
                            <a href="' . $siteUrl . '" class="btn">เข้าสู่เว็บไซต์ของเรา</a>
                        </div>
                    </div>
                </div></body></html>';

            // ✅ 2. Template สำหรับฝ่ายขาย (ปรับเป็นสีส้มธีมเดียวกัน)
            $saleBody = '<!DOCTYPE html><html><head><meta charset="utf-8">' . $style . '</head><body>
                <div style="max-width: 600px; margin: auto;">
                    <div class="header"><h1>แจ้งเตือนใบเสนอราคาใหม่</h1></div>
                    <div class="content">
                        <p><strong>มีรายการขอใบเสนอราคาใหม่เข้ามาจากหน้าเว็บไซต์ : Hotmobily</strong></p>
                        
                        <div class="order-summary">
                            <p style="margin-bottom:10px; font-weight:bold; color:#fbab00; text-decoration:underline;">รายละเอียดการส่ง</p>
                            <ul class="info-list">
                                <li><span class="label">เลขที่ใบเสนอราคา:</span> ' . $quotationNo . '</li>
                                <li><span class="label">วันที่ส่งข้อมูล:</span> ' . $dateOnly . '</li>
                                <li><span class="label">เวลาที่ส่งข้อมูล:</span> ' . $timeOnly . '</li>
                            </ul>

                            <p style="margin-top:20px; margin-bottom:10px; font-weight:bold; color:#fbab00; text-decoration:underline;">ข้อมูลผู้ติดต่อ</p>
                            <ul class="info-list">
                                <li><span class="label">ชื่อลูกค้า:</span> ' . htmlspecialchars($customerName) . '</li>
                                <li><span class="label">บริษัท/หน่วยงาน:</span> ' . (!empty($data['company_name']) ? htmlspecialchars($data['company_name']) : '-') . '</li>
                                <li><span class="label">เบอร์โทรศัพท์:</span> ' . ($data['phone'] ?? '-') . '</li>
                                <li><span class="label">อีเมล:</span> ' . ($data['email'] ?? '-') . '</li>
                                <li><span class="label">จังหวัด:</span> ' . ($data['province'] ?? '-') . '</li>
                            </ul>
                        </div>

                        <p><strong>ข้อความเพิ่มเติมจากลูกค้า:</strong></p>
                        <div class="note-box">
                            ' . (!empty($data['note']) ? nl2br(htmlspecialchars($data['note'])) : 'ไม่มีข้อความเพิ่มเติม') . '
                        </div>
                    </div>
                </div></body></html>';

            $phpmailer = new PHPMailer(true);
            $phpmailer->CharSet = "UTF-8";
            $phpmailer->setFrom('contact_hs@hotstrapthai.com', 'Hotmobily System');
            $phpmailer->isHTML(true);

            // --- 🚩 ส่งเมลให้ลูกค้า ---
            $phpmailer->addAddress($customerEmail); 
            $phpmailer->Subject = 'ขอบคุณที่ติดต่อขอใบเสนอราคา - Hotmobily (No. ' . $quotationNo . ')';
            $phpmailer->Body = $customerBody;
            if ($quotation->attachments) {
                foreach ($quotation->attachments as $path) {
                    $f = storage_path('app/public/' . $path);
                    if (File::exists($f)) $phpmailer->addAttachment($f);
                }
            }
            $phpmailer->send();

            // --- 🚩 ส่งเมลให้ฝ่ายขาย (Sale) ---
            $phpmailer->clearAddresses();
            $phpmailer->clearAttachments(); 
            $phpmailer->addAddress('setthawootsarakul@gmail.com');
            $phpmailer->addCC('hotmobilyweb2017@gmail.com');
            $phpmailer->Subject = '[Sale] ใบเสนอราคาใหม่ No. ' . $quotationNo . ' (จากคุณ ' . $customerName . ')';
            $phpmailer->Body = $saleBody;
            // แนบไฟล์เดิมอีกครั้งเพื่อให้ Sale ได้รับไฟล์ด้วย
            if ($quotation->attachments) {
                foreach ($quotation->attachments as $path) {
                    $f = storage_path('app/public/' . $path);
                    if (File::exists($f)) $phpmailer->addAttachment($f);
                }
            }
            $phpmailer->send();

        } catch (\Exception $mailEx) {
            \Log::error("Quotation Mail Error: " . $mailEx->getMessage());
        }
    }

    private function verifyRecaptcha($token)
    {
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $token,
        ]);
        if (!$response->json('success')) abort(back()->withErrors(['g-recaptcha-response' => 'ยืนยันตัวตนไม่สำเร็จ']));
    }

    public function show($id)
    {
        $quotation = Quotation::with('items')->findOrFail($id);
        return view('quotation.show', compact('quotation'));
    }
}