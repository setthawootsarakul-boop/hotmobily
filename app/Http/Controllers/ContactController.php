<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Storage;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController extends Controller
{
    public function full()
    {
        return view('contact-full'); 
    }

    public function store(Request $request)
    {
        // 1. Validation ข้อมูล
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'subjects' => 'nullable|array',
            'message' => 'nullable|string',
            'attachment.*' => 'nullable|file|mimes:ai,psd,pdf,doc,xls,jpeg,jpg,png,zip|max:10240',
        ]);

        $attachmentPaths = [];
        $fullFilePaths = []; // เก็บ Path เต็มเพื่อเอาไว้แนบไฟล์ใน Email

        // 2. จัดการไฟล์แนบ
        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $originalName = $file->getClientOriginalName();
                $fileName = time() . '_' . $originalName;
                
                // เก็บไฟล์
                $path = $file->storeAs('contacts', $fileName, 'public');
                $attachmentPaths[] = $path;
                
                // เก็บ Path เต็มสำหรับ PHPMailer
                $fullFilePaths[] = storage_path('app/public/' . $path);
            }
        }

        // 3. บันทึกลงฐานข้อมูล
        $contact = ContactMessage::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'subjects'    => $request->subjects ?? [],
            'attachments' => $attachmentPaths,
            'message'     => $request->message,
        ]);

        // 4. 🚀 ส่งอีเมลแจ้งเตือนด้วย PHPMailer
        try {
            $customerName = $request->name;
            $customerEmail = $request->email;
            $subjectsText = implode(', ', $request->subjects ?? []);
            $siteUrl = url('/');

            // เตรียม Template HTML สำหรับอีเมล
            $htmlBody = '
            <html>
            <head>
                <meta charset="utf-8">
                <style>
                    body { font-family: "Helvetica", Arial, sans-serif; line-height: 1.6; color: #333; }
                    .container { max-width: 600px; margin: auto; border: 1px solid #ddd; border-radius: 8px; overflow: hidden; }
                    .header { background-color: #FFA726; color: white; padding: 20px; text-align: center; }
                    .content { padding: 20px; }
                    .info-box { background-color: #f9f9f9; padding: 15px; border-radius: 5px; margin: 15px 0; }
                    .footer { text-align: center; font-size: 12px; color: #888; padding: 10px; }
                </style>
            </head>
            <body>
                <div class="container">
                    <div class="header"><h2>มีการติดต่อใหม่ HotmobilyThai</h2></div>
                    <div class="content">
                        <p>สวัสดีทีมงาน,</p>
                        <p>มีลูกค้าติดต่อเข้ามาผ่านหน้าฟอร์ม "ติดต่อเรา" โดยมีรายละเอียดดังนี้:</p>
                        <div class="info-box">
                            <p><strong>ชื่อ-นามสกุล:</strong> ' . htmlspecialchars($customerName) . '</p>
                            <p><strong>อีเมล:</strong> ' . htmlspecialchars($customerEmail) . '</p>
                            <p><strong>เบอร์โทรศัพท์:</strong> ' . htmlspecialchars($request->phone) . '</p>
                            <p><strong>เรื่องที่ติดต่อ:</strong> ' . htmlspecialchars($subjectsText) . '</p>
                            <p><strong>ข้อความ:</strong><br>' . nl2br(htmlspecialchars($request->message)) . '</p>
                        </div>
                        <p>กรุณาตรวจสอบและดำเนินการติดต่อกลับลูกค้า</p>
                    </div>
                    <div class="footer">ส่งจากระบบอัตโนมัติ ' . $siteUrl . '</div>
                </div>
            </body>
            </html>';

            $phpmailer = new PHPMailer(true);
            $phpmailer->CharSet = "UTF-8";
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = 'd67afb6d8954e9'; // จากตัวอย่างของคุณ
            $phpmailer->Password = '280901d4fac261'; // จากตัวอย่างของคุณ
            
            $phpmailer->setFrom('system@hotmobilythai.com', 'Hotmobily System');
            
            // ส่งไปหา Admin (Mailtrap Sandbox)
            // $phpmailer->addAddress('cd685a991d-4bf6a9+user1@inbox.mailtrap.io'); 
            
            // ตอบกลับไปหาลูกค้า (Reply-To)
            $phpmailer->addReplyTo($customerEmail, $customerName);

            // 🚩 แนบไฟล์ที่ลูกค้าอัปโหลดเข้าไปในเมลด้วย
            foreach ($fullFilePaths as $filePath) {
                if (file_exists($filePath)) {
                    $phpmailer->addAttachment($filePath);
                }
            }

            $phpmailer->Subject = '🔔 มีการติดต่อใหม่จากคุณ: ' . $customerName;
            $phpmailer->isHTML(true);
            $phpmailer->Body = $htmlBody;
            
            $phpmailer->send();
        } catch (\Exception $mailEx) {
            \Log::error("Contact Mail Error: " . $mailEx->getMessage());
        }

        // 🚩 เปลี่ยนจาก return back() เป็นการ Redirect ไปหน้าใหม่
        return redirect()->route('contact.success');
    }

    // 🚩 เพิ่มฟังก์ชันสำหรับแสดงหน้า Success
    public function success()
    {
        return view('contact-success');
    }
}