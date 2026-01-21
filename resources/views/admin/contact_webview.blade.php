@extends('layouts.admin')

@section('title', 'รายละเอียดข้อความติดต่อ - ' . $contact->name)

@section('content')
<style>
    /* --- UI ปกติบนหน้าจอ (เลียนแบบหน้าบ้าน) --- */
    .contact-view-container {
        max-width: 900px;
        margin: 20px auto;
        background: #fff;
        padding: 40px;
        border: 1px solid #eee;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        position: relative;
    }

    .header-title-bar {
        background: linear-gradient(135deg, #fbab00 0%, #f7941d 100%);
        color: #fff;
        text-align: center;
        padding: 12px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 30px;
        border-radius: 8px;
    }

    .company-info-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
        border-bottom: 2px solid #fbab00;
        padding-bottom: 20px;
    }

    .company-details { font-size: 13px; line-height: 1.6; color: #333; }
    .company-logo img { max-width: 150px; }

    .doc-info-table { border-collapse: collapse; font-size: 13px; width: 100%; }
    .doc-info-table td { padding: 10px 15px; border: 1px solid #eee; }
    .doc-info-table td.label { 
        background: #fff9f0 !important; 
        font-weight: bold; 
        width: 150px; 
        color: #f7941d;
        text-transform: uppercase;
        font-size: 11px;
    }

    .message-box {
        background-color: #fff9f0;
        padding: 15px 20px;
        border-left: 5px solid #fbab00;
        margin-top: 5px;
        line-height: 1.6;
        border-radius: 0 8px 8px 0;
        font-size: 15px;
        color: #222;
        white-space: pre-line;
        word-break: break-word;
    }

    .attachment-card {
        display: inline-flex;
        align-items: center;
        padding: 8px 15px;
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 25px;
        text-decoration: none !important;
        color: #333;
        font-size: 12px;
        margin-right: 8px;
        margin-bottom: 8px;
        transition: 0.2s;
    }
    .attachment-card:hover { border-color: #fbab00; background: #fffcf5; }
    .attachment-card i { color: #f7941d; margin-right: 8px; }

    /* --- 🖨️ แก้ไข CSS สำหรับการพิมพ์ (Print Mode) --- */
    @media print {
        @page {
            size: A4;
            margin: 1cm;
        }
        body { background: #fff !important; }
        .no-print, .btn, .app-header, .app-sidebar, .main-footer { display: none !important; }
        
        .contact-view-container {
            width: 100% !important;
            max-width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }

        .header-title-bar {
            background: #fbab00 !important;
            color: #fff !important;
            -webkit-print-color-adjust: exact;
        }
        .doc-info-table td.label {
            background: #fff9f0 !important;
            color: #f7941d !important;
            -webkit-print-color-adjust: exact;
        }
        .message-box {
            background-color: #fff9f0 !important;
            border-left: 5px solid #fbab00 !important;
            -webkit-print-color-adjust: exact;
        }
        .company-info-header { border-bottom: 2px solid #fbab00 !important; }
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between mb-4 no-print">
        <a href="{{ url()->previous() }}" class="btn btn-light border rounded-pill px-4 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> กลับหน้าจัดการ
        </a>
        <button onclick="window.print()" class="btn btn-danger rounded-pill px-4 shadow-sm">
            <i class="bi bi-printer me-1"></i> พิมพ์ / บันทึก PDF
        </button>
    </div>

    <div class="contact-view-container">
        <div class="header-title-bar">Customer Contact Message</div>

        <div class="company-info-header">
            <div class="company-details">
                <strong>YOU AND EARTH (THAILAND) CO., LTD.</strong><br>
                23/34-35 The Prime Hua Lamphong, Building A, 4th Floor,<br>
                Talat Noi, Samphanthawong, Bangkok 10100<br>
                Tel : 064-604-5614 | Line: hotstrapthai
            </div>
            <div class="company-logo">
                <img src="{{ asset('images/Hotmobilyfile/logo-thai-s.jpg') }}" alt="Logo"> 
            </div>
        </div>

        <div class="mb-4">
            <div style="font-weight: bold; color: #f7941d; margin-bottom: 10px; border-bottom: 1px dashed #ddd; padding-bottom: 5px;">
                <i class="bi bi-person-lines-fill me-2"></i>รายละเอียดผู้ติดต่อ
            </div>
            <table class="doc-info-table">
                <tr>
                    <td class="label">ชื่อ-นามสกุล</td>
                    <td><strong>{{ $contact->name }}</strong></td>
                    <td class="label">วันที่ได้รับ</td>
                    <td>{{ $contact->created_at->format('d/m/Y H:i') }} น.</td>
                </tr>
                <tr>
                    <td class="label">อีเมล</td>
                    <td>{{ $contact->email }}</td>
                    <td class="label">เบอร์โทรศัพท์</td>
                    <td>{{ $contact->phone }}</td>
                </tr>
                <tr>
                    <td class="label">หัวข้อเรื่อง</td>
                    <td colspan="3">
                        @php 
                            $subjects = is_array($contact->subjects) ? $contact->subjects : json_decode($contact->subjects, true); 
                        @endphp
                        <span class="fw-bold" style="color: #333;">
                            {{ is_array($subjects) ? implode(', ', $subjects) : ($contact->subjects ?: 'ไม่ระบุ') }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        <div class="mb-4">
            <div style="font-weight: bold; color: #f7941d; margin-bottom: 5px; font-size: 14px;">
                <i class="bi bi-chat-left-text-fill me-2"></i>ข้อความจากลูกค้า:
            </div>
            <div class="message-box">
                {{ $contact->message }}
            </div>
        </div>

        @if(!empty($contact->attachments))
            @php 
                $files = is_array($contact->attachments) ? $contact->attachments : json_decode($contact->attachments, true); 
            @endphp
            @if(is_array($files) && count($files) > 0)
                <div class="mt-5 border-top pt-4 no-print"> {{-- <--- เพิ่ม no-print ตรงนี้ --}}
                    <div style="font-weight: bold; color: #333; margin-bottom: 15px; font-size: 14px;">
                        <i class="bi bi-paperclip me-2"></i>Attachments (ไฟล์แนบ):
                    </div>
                    <div class="d-flex flex-wrap">
                        @foreach($files as $file)
                            <a href="{{ asset('storage/'.$file) }}" target="_blank" class="attachment-card">
                                <i class="bi bi-file-earmark-arrow-down-fill"></i>
                                {{ basename($file) }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        @endif

        <div style="margin-top: 50px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 20px;">
            This is an automated message record from HotmobilyThai.com System.<br>
            &copy; {{ date('Y') }} YOU AND EARTH (THAILAND) CO., LTD. All rights reserved.
        </div>
    </div>
</div>
@endsection