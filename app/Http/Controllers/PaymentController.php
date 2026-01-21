<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PaymentController extends Controller
{
    public function index()
    {
        return view('payment');
    }

        public function showWebview($id)
    {
        $payment = \App\Models\Payment::findOrFail($id);
        return view('admin.payment_webview', compact('payment'));
    }

    public function store(Request $request)
    {
        // 1. Validation (รวม reCAPTCHA)
        $request->validate([
            'order_id'      => 'required|string',
            'name'          => 'required|string',
            'email'         => 'required|email',
            'phone'         => 'required',
            'amount'        => 'required|numeric',
            'transfer_date' => 'required|date',
            'transfer_time' => 'required',
            'slip'          => 'required|mimes:jpeg,png,jpg,pdf|max:2048', 
            'note'          => 'nullable|string|max:1000',
            'g-recaptcha-response' => 'required',
        ]);

        // 2. ตรวจสอบ Token reCAPTCHA กับ Google API
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            return back()->withErrors(['g-recaptcha-response' => 'การยืนยันตัวตนไม่สำเร็จ'])->withInput();
        }

        // 3. จัดการไฟล์ Slip และบันทึกข้อมูล
        $filePath = null;
        $fullPath = null;
        $extension = null;

        if ($request->hasFile('slip')) {
            $file = $request->file('slip');
            $extension = strtolower($file->getClientOriginalExtension());
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            $filePath = $file->storeAs('slips', $fileName, 'public');
            $fullPath = storage_path('app/public/' . $filePath);
        }

        $payment = Payment::create([
            'order_id'      => $request->order_id,
            'name'          => $request->name,
            'email'         => $request->email,
            'phone'         => $request->phone,
            'amount'        => $request->amount,
            'transfer_date' => $request->transfer_date,
            'transfer_time' => $request->transfer_time,
            'slip_path'     => $filePath,
            'note'          => $request->note,
        ]);

        try {
            date_default_timezone_set('Asia/Bangkok');
            
            // --- ข้อมูลสำหรับแสดงผล ---
            $orderId      = $payment->order_id;
            $customerName = $payment->name;
            $customerEmail = $payment->email;
            $customerPhone = $payment->phone;
            $amount       = number_format($payment->amount, 2);
            $transferDate = date('d/m/Y', strtotime($payment->transfer_date));
            $transferTime = date('H:i', strtotime($payment->transfer_time)) . ' น.';
            $note         = !empty($payment->note) ? $payment->note : '-';

            $customerEmailTarget = $request->email; // สำหรับ Test
            $saleEmailTarget     = 'setthawootsarakul@gmail.com'; // สำหรับ Test

            $style = '
                <style>
                    body { font-family: "Helvetica", Arial, sans-serif; line-height: 1.6; color: #333; }
                    .header { background-color: #FBAB00; padding: 25px; text-align: center; color: white; }
                    .content { padding: 30px; background: white; border: 1px solid #ddd; border-radius: 8px; }
                    .payment-summary { background-color: #fff8ec; padding: 20px; border-radius: 6px; margin: 20px 0; border: 1px solid #FBAB00; }
                    .label { font-weight: bold; color: #555; width: 160px; display: inline-block; }
                    .value { color: #333; }
                </style>';

            $customerBody = '<!DOCTYPE html><html><head><meta charset="utf-8">' . $style . '</head><body>
                <div style="max-width: 600px; margin: auto;">
                    <div class="header"><h1>ได้รับแจ้งชำระเงินเรียบร้อยแล้วจาก Hotmobily</h1></div>
                    <div class="content">
                        <p>สวัสดีคุณ <strong>' . htmlspecialchars($customerName) . '</strong>,</p>
                        <p>ระบบได้รับข้อมูลการแจ้งชำระเงินของท่านเรียบร้อยแล้ว ทีมงานจะรีบตรวจสอบและดำเนินการในลำดับถัดไป</p>
                        <div class="payment-summary">
                            <p><span class="label">หมายเลขคำสั่งซื้อ:</span> <span class="value">#' . $orderId . '</span></p>
                            <p><span class="label">ยอดเงินที่โอน:</span> <span class="value" style="color:#FBAB00;">' . $amount . ' บาท</span></p>
                        </div>
                    </div>
                </div></body></html>';

            // --- 2. Template สำหรับ SALE (เก็บค่าครบตามฟอร์มที่กรอกมา) ---
            $saleBody = '<!DOCTYPE html><html><head><meta charset="utf-8">' . $style . '</head><body>
                <div style="max-width: 600px; margin: auto;">
                    <div class="header"><h1>แจ้งชำระเงินใหม่ (Order #' . $orderId . ')</h1></div>
                    <div class="content">
                        <p><strong>รายละเอียดข้อมูลที่ลูกค้ากรอกแจ้งโอน : Hotmobily</strong></p>
                        <div class="payment-summary">
                            <p><span class="label">หมายเลขคำสั่งซื้อ:</span> <span class="value">' . $orderId . '</span></p>
                            <p><span class="label">ชื่อ - นามสกุล:</span> <span class="value">' . htmlspecialchars($customerName) . '</span></p>
                            <p><span class="label">อีเมล:</span> <span class="value">' . $customerEmail . '</span></p>
                            <p><span class="label">เบอร์โทรศัพท์:</span> <span class="value">' . $customerPhone . '</span></p>
                            <p><span class="label">ยอดเงินที่โอน:</span> <span class="value" style="font-size: 18px; color: #FBAB00; font-weight: bold;">' . $amount . ' บาท</span></p>
                            <p><span class="label">วันที่ทำรายการ:</span> <span class="value">' . $transferDate . '</span></p>
                            <p><span class="label">เวลาที่ทำรายการ:</span> <span class="value">' . $transferTime . '</span></p>
                            <p><span class="label">ข้อความเพิ่มเติม:</span> <span class="value">' . htmlspecialchars($note) . '</span></p>
                        </div>
                    </div>
                </div></body></html>';

            $phpmailer = new PHPMailer(true);
            $phpmailer->CharSet = "UTF-8";
            $phpmailer->setFrom('contact_hs@hotstrapthai.com', 'Hotmobily System');
            $phpmailer->isHTML(true);

            
            if ($fullPath && File::exists($fullPath)) {
                $phpmailer->addAttachment($fullPath, 'Slip_Order_' . $orderId . '.' . $extension);
            }

            
            $phpmailer->addAddress($customerEmailTarget); 
            $phpmailer->Subject = 'ยืนยันการแจ้งชำระเงิน Order #' . $orderId;
            $phpmailer->Body = $customerBody;
            $phpmailer->send();

           
            $phpmailer->clearAddresses();
            $phpmailer->addAddress(SALE_EMAIL);
            $phpmailer->addCC('hotmobilyweb2017@gmail.com');

            $phpmailer->Subject = '[แจ้งชำระเงินใหม่] Order #' . $orderId . ' - ' . $customerName;
            $phpmailer->Body = $saleBody;
            $phpmailer->send();


            $phpmailer->clearAttachments();

        } catch (\Exception $mailEx) {
            \Log::error("Payment Mail Error: " . $mailEx->getMessage());
        }

        return redirect()->route('payment.success');
    }

    public function success() {
        return view('payment-success');
    }
}