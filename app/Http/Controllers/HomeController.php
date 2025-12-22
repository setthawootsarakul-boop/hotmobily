<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review; // ✅ 1. เรียกใช้ Model
use Illuminate\Support\Facades\Artisan;
use Mailtrap\Helper\ResponseHelper;
use Mailtrap\MailtrapClient;
use Mailtrap\Mime\MailtrapEmail;
use Symfony\Component\Mime\Address;
use PHPMailer\PHPMailer\PHPMailer;

class HomeController extends Controller
{
    public function index()
    {
        // ✅ 2. ดึงข้อมูลรีวิวทั้งหมดจากฐานข้อมูล (เรียงจากใหม่สุด)
        $reviews = Review::orderBy('created_at', 'desc')->get();

        // ✅ 3. ส่งตัวแปร $reviews ไปที่หน้า home
        return view('home', compact('reviews'));
    }
    public function sendTestEmail()
    {
        $text = '<!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>ขอบคุณที่ไว้วางใจเรา</title>
                <style>
                    body { font-family: "Noto Sans Thai", Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
                    .wrapper { width: 100%; table-layout: fixed; background-color: #f4f4f4; padding-bottom: 40px; }
                    .main { background-color: #ffffff; margin: 0 auto; width: 100%; max-width: 600px; border-spacing: 0; font-size: 16px; line-height: 1.6; color: #333333; border-radius: 8px; overflow: hidden; }
                    .header { background-color: #fbab00; padding: 40px 20px; text-align: center; color: #ffffff; }
                    .content { padding: 40px 30px; text-align: left; }
                    .footer { padding: 20px; text-align: center; font-size: 14px; color: #888888; background-color: #f9f9f9; }
                    .btn { display: inline-block; padding: 12px 25px; background-color: #fbab00; color: #ffffff; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
                    .order-summary { background-color: #fff8ec; border-radius: 6px; padding: 20px; margin-top: 20px; }
                    h1 { margin: 0; font-size: 24px; }
                    p { margin: 10px 0; }
                </style>
            </head>
            <body>
                <center class="wrapper">
                    <table class="main">
                        <tr>
                            <td class="header">
                                <h1>ขอบคุณที่ไว้วางใจ Hotstrap</h1>
                            </td>
                        </tr>
                        <tr>
                            <td class="content">
                                <p>สวัสดีคุณ <strong>{{$customer_name}}</strong>,</p>
                                <p>เราได้รับคำขอใบเสนอราคาของคุณเรียบร้อยแล้ว ทีมงานของเรากำลังตรวจสอบข้อมูลและจะรีบดำเนินการส่งใบเสนอราคาให้คุณโดยเร็วที่สุด</p>
                                
                                <div class="order-summary">
                                    <p style="margin:0;"><strong>รหัสอ้างอิง:</strong> #{{$quotation_id}}</p>
                                    <p style="margin:0;"><strong>สถานะ:</strong> กำลังดำเนินการตรวจสอบ</p>
                                </div>

                                <p>หากคุณมีคำถามเพิ่มเติม สามารถติดต่อเราได้ทันทีผ่านทาง Line Official หรือโทร 02-637-8995</p>
                                
                                <div style="text-align: center;">
                                    <a href="{{$site_url}}" class="btn">เข้าสู่เว็บไซต์ของเรา</a>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="footer">
                                <p>&copy; 2025 Hotstrap Thai. All rights reserved.</p>
                                <p>23/34-35 อาคารโครงการเดอะไพร์ม หัวลำโพง กรุงเทพฯ 10100</p>
                            </td>
                        </tr>
                    </table>
                </center>
            </body>
            </html>';
            
            $phpmailer = new PHPMailer();
            $phpmailer->CharSet = "UTF-8";
            $phpmailer->isSMTP();
            $phpmailer->Host = 'sandbox.smtp.mailtrap.io';
            $phpmailer->SMTPAuth = true;
            $phpmailer->Port = 2525;
            $phpmailer->Username = 'd67afb6d8954e9';
            $phpmailer->Password = '280901d4fac261';
            $phpmailer->addAddress('cd685a991d-4bf6a9+user1@inbox.mailtrap.io');

            $phpmailer->Subject = 'ขอบคุณที่ติดต่อขอใบเสนอราคา - Hotstrap Thai';
            $phpmailer->isHTML(true);
            $phpmailer->Body = $text;
            $phpmailer->send();

            if(!$phpmailer->send()) {
                echo "Mailer Error: " . $phpmailer->ErrorInfo;
                die;
            }

            echo 'Email has been sended!';
            die;
    }
}