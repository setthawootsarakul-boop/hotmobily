<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PaymentController extends Controller {
    
    public function index() {
        return view('payment');
    }

    public function store(Request $request) {
        // 1. ตรวจสอบข้อมูล
        $request->validate([
            'order_id'      => 'required|string',
            'name'          => 'required|string',
            'email'         => 'required|email',
            'phone'         => 'required',
            'amount'        => 'required|numeric',
            'transfer_date' => 'required|date',
            'transfer_time' => 'required',
            'slip'          => 'required|mimes:jpeg,png,jpg,pdf|max:2048', 
        ]);

        // 2. จัดการไฟล์และเตรียม Path สำหรับ localhost
        $filePath = null;
        $fullPath = null;
        $publicUrl = null;
        $extension = null;

        if ($request->hasFile('slip')) {
            $file = $request->file('slip');
            $extension = strtolower($file->getClientOriginalExtension());
            $fileName = time() . '_' . $file->getClientOriginalName();
            
            // เก็บไฟล์ใน storage/app/public/slips
            $filePath = $file->storeAs('slips', $fileName, 'public');
            
            // Path สำหรับแนบไปกับเมล (ต้องใช้ Absolute Path บนเครื่อง)
            $fullPath = storage_path('app/public/' . $filePath);

            // URL สำหรับกดดูผ่านเบราว์เซอร์ (localhost)
            // สำคัญ: ต้องรัน php artisan storage:link ก่อน
            $publicUrl = url('storage/' . $filePath);
        }

        // 3. บันทึกข้อมูล
        Payment::create([
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

        // 🚀 4. ส่งอีเมลพร้อมปุ่มกดดูไฟล์และรูปตัวอย่าง
        try {
            $phpmailer = new PHPMailer(true);
            $phpmailer->CharSet = "UTF-8";
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io'; // ตาม QuotationController
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = 'd67afb6d8954e9';
            $phpmailer->Password = '280901d4fac261';

            $phpmailer->setFrom('system@hotmobily.com', 'Hotmobily System');
            $phpmailer->addAddress('cd685a991d-4bf6a9+user1@inbox.mailtrap.io'); 

            // แนบไฟล์จริงไปกับอีเมล
            if ($fullPath && file_exists($fullPath)) {
                $phpmailer->addAttachment($fullPath, 'Slip_Order_' . $request->order_id . '.' . $extension);
            }

            // --- เริ่มต้นเนื้อหาอีเมล ---
            $htmlBody = '
            <body style="font-family: sans-serif; line-height: 1.6; color: #333;">
                <div style="max-width: 600px; margin: auto; border: 1px solid #eee; padding: 20px; border-radius: 10px;">
                    <h2 style="color: #28a745; text-align: center;">🔔 มีรายการแจ้งชำระเงินใหม่ Hotmobily</h2>
                    <hr style="border: 0; border-top: 1px solid #eee;">
                    
                    <p style="font-size: 16px;"><strong>รายละเอียดการโอนเงิน:</strong></p>
                    <table style="width: 100%; border-collapse: collapse;">
                        <tr><td style="padding: 8px 0;"><strong>หมายเลขสั่งซื้อ:</strong></td><td>'.$request->order_id.'</td></tr>
                        <tr><td style="padding: 8px 0;"><strong>ชื่อผู้โอน:</strong></td><td>'.$request->name.'</td></tr>
                        <tr><td style="padding: 8px 0;"><strong>ยอดเงิน:</strong></td><td style="color: #d9534f; font-weight: bold;">'.number_format($request->amount, 2).' บาท</td></tr>
                        <tr><td style="padding: 8px 0;"><strong>วัน/เวลา:</strong></td><td>'.$request->transfer_date.' '.$request->transfer_time.'</td></tr>
                    </table>

                    <div style="text-align: center; margin-top: 30px; padding: 20px; background-color: #fcfcfc; border: 1px dashed #ddd; border-radius: 8px;">
                        <p style="margin-bottom: 15px; font-weight: bold; color: #555;">หลักฐานการโอนเงิน (Slip):</p>';
            
            
            if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif'])) {
                $htmlBody .= '<img src="'.$publicUrl.'" style="max-width: 250px; margin-bottom: 15px; border: 1px solid #eee; border-radius: 5px;"><br>';
            }

            
            $htmlBody .= '
                        <a href="'.$publicUrl.'" target="_blank" 
                           style="background-color: #28a745; color: #ffffff; padding: 12px 25px; text-decoration: none; border-radius: 5px; display: inline-block; font-weight: bold;">
                           กดเพื่อดูหลักฐานฉบับเต็ม ('.$extension.')
                        </a>
                        <p style="font-size: 12px; color: #999; margin-top: 10px;">* ลิงก์นี้จะเปิดได้เฉพาะเครื่อง Localhost ของคุณเท่านั้น</p>
                    </div>

                    <p style="margin-top: 20px; font-size: 13px; color: #777; text-align: center;">
                        ส่งจากระบบอัตโนมัติ Hotmobily
                    </p>
                </div>
            </body>';

            $phpmailer->Subject = 'แจ้งชำระเงินใหม่ Hotmobily - Order ID: ' . $request->order_id;
            $phpmailer->isHTML(true);
            $phpmailer->Body = $htmlBody;

            $phpmailer->send();

        } catch (\Exception $mailEx) {
            \Log::error("Payment Mail Error: " . $mailEx->getMessage());
        }

        return redirect()->route('payment.success');
    }

    public function success() {
        return view('payment-success');
    }
}