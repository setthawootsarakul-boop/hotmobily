@extends('layouts.admin')

@section('title', 'รายละเอียดการแจ้งโอน - ' . $payment->order_id)

@section('content')
<style>
    /* --- UI ปกติบนหน้าจอ --- */
    .payment-card {
        max-width: 850px;
        margin: 30px auto;
        background: #fff;
        padding: 50px;
        border: 1px solid #eee;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
    }
    .header-bar {
        background: linear-gradient(135deg, #198754 0%, #146c43 100%); 
        color: #fff !important;
        text-align: center;
        padding: 15px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-bottom: 40px;
        border-radius: 8px;
    }
    .info-table { width: 100%; border-collapse: collapse; margin-bottom: 30px; }
    .info-table td { padding: 15px; border: 1px solid #eee; font-size: 14px; }
    .label-cell { 
        background: #f8fdfa !important; 
        font-weight: bold; 
        width: 200px; 
        color: #198754 !important; 
        text-transform: uppercase; 
        font-size: 11px; 
    }

    /* --- 🖨️ แก้ไขปัญหา Save PDF เพี้ยน และพื้นที่ว่างด้านล่าง --- */
    @media print {
        @page {
            size: A4;
            margin: 1cm;
        }

        /* 1. ล้างค่าพื้นหลังและระยะสูงของ Template Admin ทั้งหมด */
        html, body, .app-wrapper, .content-wrapper, .app-main, .container-fluid {
            background-color: #fff !important;
            height: auto !important;
            min-height: 0 !important;
            margin: 0 !important;
            padding: 0 !important;
            box-shadow: none !important;
        }

        /* 2. ซ่อน Sidebar, Header แอดมิน และปุ่มต่างๆ */
        .app-header, .app-sidebar, .main-footer, .no-print, .btn {
            display: none !important;
        }

        /* 3. ปรับตัว Card ให้พอดีหน้ากระดาษ (ลบ Margin/Shadow) */
        .payment-card { 
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important; 
            padding: 0 !important; /* ใช้ padding 0 เพื่อให้ตารางชิดขอบตามสไตล์เอกสาร */
            border: none !important; 
            box-shadow: none !important;
        }
        
        /* 4. บังคับให้สีและกราเดียนต์แสดงผลใน PDF */
        .header-bar { 
            background: #198754 !important; 
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color: #fff !important; 
            padding: 15px !important;
        }
        
        .label-cell { 
            background-color: #f8fdfa !important; 
            color: #198754 !important; 
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
        }

        .info-table td {
            border: 1px solid #eee !important;
        }

        /* 5. ซ่อนส่วนที่ไม่ต้องการ (สลิป) */
        .slip-section { display: none !important; }
    }
</style>

<div class="container-fluid py-4">
    {{-- ปุ่ม Action --}}
    <div class="d-flex justify-content-between mb-4 no-print">
        <a href="{{ url()->previous() }}" class="btn btn-light border rounded-pill px-4 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> กลับหน้าจัดการ
        </a>
        <button onclick="window.print()" class="btn btn-success rounded-pill px-4 shadow-sm">
            <i class="bi bi-printer me-1"></i> พิมพ์ใบแจ้งโอน (PDF)
        </button>
    </div>

    <div class="payment-card">
        <div class="header-bar">Payment Notification Detail</div>

        <table class="info-table">
            <tr>
                <td class="label-cell">Order ID / เลขที่อ้างอิง</td>
                <td><strong>#{{ $payment->order_id }}</strong></td>
            </tr>
            <tr>
                <td class="label-cell">ชื่อผู้โอน</td>
                <td>{{ $payment->name }}</td>
            </tr>
            <tr>
                <td class="label-cell">ยอดเงินที่โอน</td>
                <td><strong class="text-success" style="font-size: 18px;">฿{{ number_format($payment->amount, 2) }}</strong></td>
            </tr>
            <tr>
                <td class="label-cell">ช่องทางการโอน</td>
                <td>{{ $payment->bank_account ?? 'โอนผ่านธนาคาร' }}</td>
            </tr>
            <tr>
                <td class="label-cell">วันที่/เวลาที่โอน</td>
                <td>{{ $payment->transfer_date }} {{ $payment->transfer_time }}</td>
            </tr>
            <tr>
                <td class="label-cell">วันที่แจ้งระบบ</td>
                <td>{{ $payment->created_at->format('d/m/Y H:i') }} น.</td>
            </tr>
            @if($payment->note)
            <tr>
                <td class="label-cell">หมายเหตุเพิ่มเติม</td>
                <td>{{ $payment->note }}</td>
            </tr>
            @endif
        </table>

        {{-- ส่วนของสลิป: แสดงบนเว็บ แต่ถูกซ่อนใน PDF --}}
        @if($payment->slip_path)
        <div class="slip-section mt-4">
            <div style="font-weight: bold; color: #198754; margin-bottom: 15px; font-size: 14px; border-bottom: 1px dashed #ddd; padding-bottom: 5px;">
                <i class="bi bi-image me-2"></i>หลักฐานการโอนเงิน (สลิป)
            </div>
            <div class="text-center bg-light p-3 rounded-4 border">
                @php $finalPath = str_contains($payment->slip_path, 'slips/') ? $payment->slip_path : 'slips/' . $payment->slip_path; @endphp
                <img src="{{ asset('storage/' . $finalPath) }}" style="max-width: 100%; max-height: 500px; border-radius: 8px;" class="shadow-sm">
                <div class="mt-3">
                    <a href="{{ asset('storage/' . $finalPath) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill">
                        <i class="bi bi-zoom-in"></i> ดูรูปขนาดเต็ม
                    </a>
                </div>
            </div>
        </div>
        @endif

        <div style="margin-top: 50px; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 20px;">
            This is an automated payment notification record from HotmobilyThai.com System.<br>
            &copy; {{ date('Y') }} YOU AND EARTH (THAILAND) CO., LTD.
        </div>
    </div>
</div>
@endsection