<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController extends Controller
{
    public function full()
    {
        return view('contact-full'); 
    }
    
    public function showWebview($id)
    {
        $contact = ContactMessage::findOrFail($id);
        
        return view('admin.contact_webview', compact('contact'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'message' => 'required|string',
            'subjects' => 'required|array|min:1',
            'attachment.*' => 'nullable|file|mimes:ai,psd,pdf,doc,xls,jpeg,jpg,png,zip|max:10240',
            'g-recaptcha-response' => 'required',
        ], [
            'g-recaptcha-response.required' => 'กรุณายืนยันว่าคุณไม่ใช่โปรแกรมอัตโนมัติ',
            'subjects.required' => 'กรุณาเลือกเรื่องที่ต้องการติดต่ออย่างน้อย 1 หัวข้อ',
        ]);

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret'   => env('RECAPTCHA_SECRET_KEY'),
            'response' => $request->input('g-recaptcha-response'),
            'remoteip' => $request->ip(),
        ]);

        if (!$response->json('success')) {
            return back()->withErrors(['g-recaptcha-response' => 'การยืนยันตัวตนไม่สำเร็จ กรุณาลองใหม่'])->withInput();
        }

        $attachmentPaths = [];
        $fullFilePaths = []; 

        if ($request->hasFile('attachment')) {
            foreach ($request->file('attachment') as $file) {
                $fileName = time() . '_' . $file->getClientOriginalName();
                $path = $file->storeAs('contacts', $fileName, 'public');
                $attachmentPaths[] = $path;
                $fullFilePaths[] = storage_path('app/public/' . $path);
            }
        }

        // บันทึกลง Database
        ContactMessage::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'phone'       => $request->phone,
            'subjects'    => $request->subjects ?? [],
            'attachments' => $attachmentPaths,
            'message'     => $request->message,
        ]);
 

        try {
            date_default_timezone_set('Asia/Bangkok');
            
            
            $customerName = $request->name;
            $customerEmail = $request->email;
            $customerPhone = $request->phone;
            $subjectsText = implode(', ', $request->subjects ?? ['ทั่วไป']);
            $safeMessage = !empty($request->message) ? nl2br(htmlspecialchars($request->message)) : 'ไม่ได้ระบุข้อความ';
            
            $dateOnly = date('d/m/Y');
            $timeOnly = date('H:i') . ' น.';
            $siteUrl = url('/');
            $year = date('Y');


            $style = '
                <style>
                    .wrapper { width: 100%; background-color: #f4f7f9; padding: 20px 0; }
                    .main-card { max-width: 600px; background-color: #ffffff; border-radius: 12px; margin: 0 auto; overflow: hidden; border: 1px solid #e0e0e0; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
                    .header { background: linear-gradient(135deg, #fbab00 0%, #f7941d 100%); padding: 30px; text-align: center; }
                    .header h1 { margin: 0; color: #ffffff; font-family: sans-serif; font-size: 24px; text-transform: uppercase; }
                    .content { padding: 30px; font-family: "Tahoma", Geneva, sans-serif; color: #333; }
                    .info-table { width: 100%; border-collapse: collapse; }
                    .info-table td { padding: 12px 0; border-bottom: 1px solid #f0f0f0; }
                    .label { font-weight: bold; color: #fbab00; width: 35%; font-size: 13px; text-transform: uppercase; }
                    .value { color: #222; width: 65%; font-size: 15px; }
                    .message-box { background-color: #fff9f0; padding: 20px; border-left: 4px solid #fbab00; margin-top: 10px; line-height: 1.6; word-break: break-all; border-radius: 0 4px 4px 0; }
                    .footer { background-color: #f9f9f9; padding: 25px; text-align: center; color: #666; font-size: 12px; }
                </style>';

            // --- 1. TEMPLATE สำหรับลูกค้า (แจ้งยืนยันการรับข้อมูล) ---
            $customerBody = '
                <!DOCTYPE html><html><head><meta charset="utf-8">'.$style.'</head><body>
                    <div class="wrapper">
                        <div class="main-card">
                            <div class="header"><h1>HotmobilyThai</h1></div>
                            <div class="content">
                                <p style="font-size:18px;">สวัสดีคุณ <strong>'.htmlspecialchars($customerName).'</strong></p>
                                <p>เราได้รับข้อความการติดต่อจากท่านเรียบร้อยแล้ว ทีมงานจะรีบตรวจสอบและติดต่อกลับหาท่านโดยเร็วที่สุด</p>
                                <div class="message-box" style="background-color:#FFF9F0; border-left-color:#fbab00;">
                                    <p><strong>เรื่องที่ติดต่อ:</strong> '.$subjectsText.'</p>
                                    <p><strong>ข้อความของท่าน:</strong>'.$safeMessage.'</p>
                                </div>
                            </div>
                            <div class="footer">ขอบคุณที่ติดต่อเรา <br> &copy; '.$year.' HotmobilyThai.com</div>
                        </div>
                    </div>
                </body></html>';

            
            $saleBody = '
                <!DOCTYPE html><html><head><meta charset="utf-8">'.$style.'</head><body>
                    <div class="wrapper">
                        <div class="main-card">
                            <div class="header"><h1>New Contact Notification</h1></div>
                            <div class="content">
                                <div style="margin-bottom: 20px; font-weight: bold; border-bottom: 2px solid #fbab00; padding-bottom: 5px;">ข้อมูลผู้ติดต่อ : Hotmobily</div>
                                <table class="info-table">
                                    <tr><td class="label">ชื่อ-นามสกุล</td><td class="value">'.htmlspecialchars($customerName).'</td></tr>
                                    <tr><td class="label">อีเมล</td><td class="value">'.htmlspecialchars($customerEmail).'</td></tr>
                                    <tr><td class="label">เบอร์โทรศัพท์</td><td class="value">'.htmlspecialchars($customerPhone).'</td></tr>
                                    <tr><td class="label">เรื่องที่ติดต่อ</td><td class="value">'.htmlspecialchars($subjectsText).'</td></tr>
                                    <tr><td class="label">วันที่ส่ง</td><td class="value">'.$dateOnly.'</td></tr>
                                    <tr><td class="label">เวลาที่ส่ง</td><td class="value">'.$timeOnly.'</td></tr>
                                </table>
                                <div style="margin-top: 25px;">
                                    <div style="font-weight:bold; color:#fbab00; font-size:13px; margin-bottom:8px;">รายละเอียดข้อความ:</div>
                                    <div class="message-box">'.$safeMessage.'</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </body></html>';

            $phpmailer = new PHPMailer(true);
            $phpmailer->CharSet = "UTF-8";
            $phpmailer->setFrom('contact_hs@hotstrapthai.com', 'Hotmobily Admin');
            $phpmailer->isHTML(true);

            foreach ($fullFilePaths as $filePath) {
                if (File::exists($filePath)) {
                    $phpmailer->addAttachment($filePath);
                }
            }

            $phpmailer->addAddress($customerEmail, $customerName);  
            $phpmailer->Subject = 'Hotmobily ได้รับข้อความจากคุณแล้ว - ' . $subjectsText;
            $phpmailer->Body = $customerBody;
            $phpmailer->send();

            $phpmailer->clearAddresses();
            $phpmailer->clearAttachments();
            
            $phpmailer->addAddress(SALE_EMAIL);
            $phpmailer->addCC('hotmobilyweb2017@gmail.com');
            $phpmailer->Subject = '[Sale] แจ้งเตือนใบเสนอราคาใหม่ No. ' . $quotationNo . ' (จากคุณ ' . $customerName . ')';
            $phpmailer->Body = $saleBody;

            // ✅ ต้องเพิ่มลูปนี้กลับเข้ามาอีกครั้งเพื่อให้ไฟล์แนบไปในเมล Sale ด้วย
            if (!empty($quotation->attachments)) {
                foreach ($quotation->attachments as $path) {
                    $fullPath = storage_path('app/public/' . $path);
                    if (File::exists($fullPath)) {
                        $phpmailer->addAttachment($fullPath);
                    }
                }
            }

            $phpmailer->send();

        } catch (\Exception $mailEx) {
            \Log::error("Quotation Mail Error: " . $mailEx->getMessage());
        }

        return redirect()->route('contact.success');
    }

    public function success()
    {
        return view('contact-success');
    }
}