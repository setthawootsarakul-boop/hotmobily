@extends('layouts.admin')

@section('content')
<style>
    .nav-pills .nav-link { 
        width: auto !important; 
        white-space: nowrap !important;
        padding: 10px 25px; 
        border-radius: 25px; 
        font-size: 14px; 
        border: 1px solid #ddd; 
        color: #666; 
        background: #fff;
        margin-right: 8px;
        margin-bottom: 10px;
        transition: all 0.3s;
    }
    .nav-pills .nav-link.active { 
        background: #000 !important; 
        color: #fff !important; 
        border-color: #000; 
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    .custom-gallery-item {
            width: 148px; /* ปรับขนาดความกว้างที่ต้องการตรงนี้ */
            height: 210px; /* ความสูงรวมส่วนท้ายปุ่มลบ */
            flex: 0 0 auto; /* ป้องกันไม่ให้ Flexbox บีบขนาด (shrink) */
            margin-right: 20px;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
            display: flex;
            flex-direction: column;
            transition: transform 0.2s, box-shadow 0.2s;
        }
    .custom-gallery-item:hover { 
        transform: translateY(-8px); 
        box-shadow: 0 12px 20px rgba(0,0,0,0.08); 
        border-color: #dee2e6; 
    }
    .custom-gallery-item .img-container { 
        height: 180px; 
        width: 100%; 
        background: #ffffff; 
        display: flex; 
        align-items: center; 
        justify-content: center; 
        padding: 12px; 
        position: relative;
    }
    .custom-gallery-item .img-container img { 
        max-width: 100%; 
        max-height: 100%; 
        object-fit: contain; 
    }
    .custom-gallery-item .action-footer { padding: 10px 15px; background: #ffffff; display: flex; justify-content: space-between; align-items: center; }
    
    /* ปุ่มเลือกรูปภาพแบบ Overlay */
    .btn-upload-overlay {
        position: absolute;
        bottom: 8px;
        right: 8px;
        background: rgba(0, 0, 0, 0.6);
        color: #fff;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: 1px solid rgba(255,255,255,0.3);
        transition: 0.2s;
        z-index: 10;
    }
    .btn-upload-overlay:hover { background: #000; transform: scale(1.1); }

    /* Badge แสดงสถานะ */
    .status-badge {
        position: absolute;
        top: 10px;
        left: 10px;
        z-index: 5;
        font-size: 10px;
        padding: 4px 8px;
        border-radius: 20px;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* UI Elements */
    .card { border-radius: 12px; border: none; }
    .table thead th { background-color: #fcfcfc; color: #888; font-weight: 600; border-bottom: 1px solid #eee; padding: 15px; font-size: 11px; text-transform: uppercase; }
    .table tbody td { padding: 15px; border-color: #f8f8f8; font-size: 14px; }
    .form-control-clean { 
        border: none; 
        background: #f4f6f9; 
        border-radius: 8px; 
        padding: 10px 12px; 
        font-size: 14px; 
        line-height: 1.5; 
    }
    
    .addon-edit-box { height: auto !important; min-height: 380px !important; }
    .addon-input-label { font-size: 10px; color: #999; margin-bottom: 3px; display: block; font-weight: 600; text-transform: uppercase; }

    /* SIMPLE ALERT NOTIFICATION */
    #admin-alert {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        min-width: 280px;
        display: none;
        animation: slideUp 0.3s ease-out;
    }
    @keyframes slideUp { from { transform: translateY(100%); opacity: 0; } to { transform: translateY(0); opacity: 1; } }
    
    .alert-custom {
        background: #1a1a1a;
        color: white;
        border-left: 4px solid #fff;
    }
    .price-table-container {
        background: transparent !important;
        border: none !important;
        margin-top: 15px;
        overflow: visible !important;
        box-shadow: none !important;
    }

    .card-footer {
        padding-left: 1.5rem !important;
        padding-right: 1.5rem !important;
        background-color: #fcfdfe !important;
    }

    /* ตารางหลัก: ใช้โครงสร้างเส้นเดียว (Single Border) */
    .table-price-grid {
        width: 100% !important;
        margin: 0 auto;
        border-collapse: collapse; /* ยุบเส้นที่ซ้อนกันให้เหลือเส้นเดียว */
        border: 1px solid #e2e8f0; /* ขอบนอกสุดของตาราง */
        background-color: #fff;
    }

    /* หัวตาราง: ปรับเส้นให้จางลงแต่คม */
    .table-price-grid thead th {
        background: #f8fafc !important; /* เปลี่ยนเป็นสีเทาอ่อนสะอาดตา */
        color: #475569 !important;      /* สีตัวหนังสือเทาเข้ม */
        padding: 10px !important;
        font-size: 13px;
        border: 1px solid #e2e8f0 !important;
        vertical-align: middle;
        position: relative;
        /* box-shadow: inset 0 -2px 0 #3b82f6; เพิ่มเส้นขีดล่างสีฟ้าให้ดูรู้ว่าเป็นหัวข้อ */
    }

    /* ช่อง Input ในตาราง: ลบขอบออกให้ดูเนียน */
    .input-price-cell {
        width: 100% !important;
        height: 45px;
        box-sizing: border-box;
        padding: 5px 10px;
        border: none !important; /* ลบขอบ input ออก */
        background: transparent;
        text-align: center;
        font-family: 'Consolas', monospace;
    }
    
    /* เส้นแบ่งระหว่างช่องราคา */
    .table-price-grid tbody td {
        border: 1px solid #f1f5f9; /* เส้นจางๆ ระหว่างช่องราคา */
        padding: 0 !important;
    }

    .input-price-cell:focus { 
        background: #fff8e1 !important; 
        outline: none; 
        box-shadow: inset 0 0 0 2px #fbbf24; /* ใส่เส้นขอบด้านในเวลาโฟกัส */
        z-index: 10;
    }

    /* ปุ่มลบ: คงค่าเดิมไว้แต่ปรับขอบให้คม */
    .delete-indicator {
        position: absolute;
        background: #ef4444;
        color: white;
        width: 22px;
        height: 22px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        cursor: pointer;
        z-index: 999;
        box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        border: 2px solid #fff;
        transition: transform 0.2s;
    }
    .delete-indicator:hover { transform: scale(1.2); background: #dc2626; }

    /* แถบจำนวน (ด้านซ้าย): เน้นเส้นแบ่งขวาเส้นเดียว */
    .qty-label-cell {
        background: #f8fafc !important;
        font-weight: bold;
        color: #475569;
        width: 130px;
        border-right: 2px solid #e2e8f0 !important; /* เส้นแบ่งแนวตั้งหลัก */
        border-bottom: 1px solid #f1f5f9 !important;
    }

    /* ช่องกรอกชื่อขนาดที่หัวตาราง */
    .size-name-input {
        width: 100% !important;
        background: #ffffff !important;
        border: 1px solid #cbd5e1 !important; /* เพิ่มขอบให้ดูเป็นกล่อง */
        border-radius: 6px;
        color: #1e293b !important;
        text-align: center;
        font-size: 13px;
        font-weight: 700;
        padding: 6px 4px;
        transition: all 0.2s;
        cursor: text;
    }

    .size-name-input:focus {
    border-color: #3b82f6 !important;
    background: #f0f7ff !important;
    outline: none;
    box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
    }

    .size-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
    }

    .size-input-wrapper::after {
    content: '\F4CB'; /* Bootstrap Icon: Pencil */
    font-family: 'bootstrap-icons';
    position: absolute;
    right: 8px;
    font-size: 10px;
    color: #94a3b8;
    pointer-events: none; /* ให้คลิกทะลุไปที่ input ได้ */
    }

    .nav-item-tech {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 30px;
        display: flex;
        align-items: center;
        padding: 5px 12px;
        transition: all 0.2s ease;
        cursor: pointer;
    }

    /* สถานะเมื่อ Tab ถูกเลือก (Active) */
    .nav-item-tech.active {
        border-color: #3b82f6 !important;
        background-color: #f8faff !important;
        box-shadow: 0 0 0 1px #3b82f6;
    }

    .nav-item-tech:hover {
        border-color: #94a3b8;
    }

    /* ปรับปุ่มลบให้ไม่เด่นเกินไปจนกว่าจะ Hover */
    .btn-del-tech {
        color: #94a3b8;
        font-size: 16px;
        line-height: 1;
        opacity: 0.6;
        transition: 0.2s;
    }
    .nav-item-tech:hover .btn-del-tech {
        opacity: 1;
    }
    .btn-del-tech:hover {
        color: #ef4444;
    }

    /* เส้นประบอกว่าแก้ไขชื่อได้ */
    .tech-edit-input {
        border: none !important;
        background: transparent !important;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        text-align: center;
        width: 110px;
        outline: none !important;
        border-bottom: 1px dashed #cbd5e1 !important;
    }
    
    .tech-edit-input:focus {
        border-bottom: 1px solid #3b82f6 !important;
    }

    .custom-switch {
        width: 3rem !important;      /* ความยาวปุ่ม */
        height: 1.6rem !important;     /* ความสูงปุ่ม */
        cursor: pointer;
        border-color: #ddd !important;
    }

    /* ปรับสีเมื่อเปิด (Online) เป็นสีเขียวเข้มแบบสะอาดๆ */
    .custom-switch:checked {
        background-color: #198754 !important; /* สี Success ของ Bootstrap */
        border-color: #198754 !important;
    }
    .delete-col-btn {
        position: absolute;
        top: 50%;
        right: 8px; /* ชิดขวา */
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: all 0.2s;
    }
    .delete-col-btn:hover { background: #b02a37; transform: translateY(-50%) scale(1.1); }

    /* ปรับ Input ของขนาดให้มีที่ว่างด้านขวา กันตัวหนังสือทับปุ่มลบ */
    .size-name-input {
        padding-right: 25px !important; 
    }

    /* 🔴 ปุ่มลบจำนวน (Row): อยู่ด้านหน้าตัวเลข (ซ้ายสุด) */
    .delete-row-btn {
        position: absolute;
        top: 50%;
        left: 5px; /* ชิดซ้าย */
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        background: #dc3545;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 16px;
        line-height: 1;
        cursor: pointer;
        z-index: 10;
        box-shadow: 0 2px 4px rgba(0,0,0,0.2);
        transition: all 0.2s;
    }
    .delete-row-btn:hover { background: #b02a37; transform: translateY(-50%) scale(1.1); }

    /* ปรับ Input ของจำนวนให้ขยับหนีปุ่มลบมาทางขวา */
    .qty-val-input {
        text-align: center;
        /* margin-left: 20px !important;  ดันตัวเลขหนีปุ่มลบ */
    }
</style>


<div id="admin-alert">
    <div class="alert alert-custom shadow-lg px-4 py-3 d-flex align-items-center mb-0" style="border-radius: 15px;">
        <div id="alert-icon-bg" class="rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 35px; height: 35px; background: rgba(255,255,255,0.1);">
            <i class="bi bi-info-circle" id="alert-icon" style="font-size: 1.2rem;"></i>
        </div>
        <span id="alert-message" class="small fw-bold"></span>
    </div>
</div>

<div class="container-fluid">
    {{-- Header --}}
    <div class="mb-4">
        <h4 class="fw-bold mb-1 text-dark">
            @if($viewType == 'products') จัดการรายการสินค้า
            @elseif($viewType == 'gallery') จัดการแกลเลอรี่ผลงาน
            @elseif($viewType == 'addons') จัดการอุปกรณ์เสริม
            @elseif($viewType == 'quotations') รายการใบเสนอราคา
            @elseif($viewType == 'contacts') ข้อความติดต่อ
            @elseif($viewType == 'payments') รายการแจ้งโอนเงิน
            @elseif($viewType == 'faq') จัดการคำถามที่พบบ่อย (FAQ)
            @else แผงควบคุมสถิติระบบ @endif
        </h4>
    </div>


    <div class="card-body p-0" style="{{ $viewType == 'dashboard' ? 'background:none !important;' : 'margin-top: 20px;' }}">
            
        @if($viewType == 'dashboard')
            <div class="container-fluid px-0">
                <div class="row g-3 mb-4">
                    @php 
                        $stats_data = [
                            ['รออนุมัติใบเสนอราคา', $stats['pending_q'], 'bi-file-earmark-text-fill', 'text-primary', 'bg-primary'],
                            ['ข้อความลูกค้าใหม่', $stats['unread_msg'], 'bi-chat-left-text-fill', 'text-success', 'bg-success'],
                            ['รายการสินค้าทั้งหมด', $stats['total_prod'], 'bi-box-seam-fill', 'text-danger', 'bg-danger'],
                            ['รอตรวจสอบยอดโอน', $stats['pending_pay'], 'bi-cash-stack', 'text-warning', 'bg-warning']
                        ];
                    @endphp
                    @foreach($stats_data as $s)
                    <div class="col-lg-3 col-6">
                        <div class="card shadow-sm border-0 h-100 rounded-4">
                            <div class="card-body p-3 d-flex align-items-center">
                                <div class="rounded-4 d-flex align-items-center justify-content-center {{ $s[4] }} bg-opacity-10" style="width: 50px; height: 50px;">
                                    <i class="bi {{ $s[2] }} fs-4 {{ $s[3] }}"></i>
                                </div>
                                <div class="ms-3">
                                    <div class="text-muted small fw-bold mb-1">{{ $s[0] }}</div>
                                    <div class="fs-4 fw-bold mb-0 text-dark">{{ number_format($s[1]) }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="row g-3">
                    {{-- 📈 ส่วนที่ 1: Visual Analytics (ประมวลผลข้อมูลจริงย้อนหลัง 7 วัน) --}}
                    <div class="col-lg-8">
                        <div class="bg-white border rounded-4 p-4 shadow-sm h-100">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div>
                                    <h6 class="fw-bold text-dark mb-0">สถิติธุรกรรมรายสัปดาห์</h6>
                                    <p class="text-muted small mb-0">ปริมาณการขอใบเสนอราคาและข้อความติดต่อ</p>
                                </div>
                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-3 py-2 rounded-pill small">
                                    <i class="bi bi-graph-up-arrow me-1"></i> ข้อมูลเรียลไทม์
                                </span>
                            </div>

                            @php
                                $days = []; $counts = [];
                                for ($i = 6; $i >= 0; $i--) {
                                    $date = \Carbon\Carbon::today()->subDays($i);
                                    $days[] = $date->format('D');
                                    $qCount = $quotations->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->isSameDay($date))->count();
                                    $cCount = $contacts->filter(fn($item) => \Carbon\Carbon::parse($item->created_at)->isSameDay($date))->count();
                                    $counts[] = $qCount + $cCount;
                                }
                                $maxVal = max($counts) > 0 ? max($counts) : 1;
                            @endphp

                            <div class="d-flex align-items-end gap-3 px-1" style="height: 180px;">
                                @foreach($counts as $val)
                                    @php $percent = ($val / $maxVal) * 100; @endphp
                                    <div class="flex-grow-1 bg-light rounded-top position-relative" style="height: 100%;">
                                        <div class="bg-dark rounded-top w-100 position-absolute bottom-0 opacity-75 transition-all" 
                                            style="height: {{ max($percent, 5) }}%; cursor: pointer;" 
                                            title="{{ $val }} รายการ">
                                            @if($val > 0)
                                                <span class="position-absolute top-0 start-50 translate-middle-x pt-2 text-white fw-bold" style="font-size: 9px;">{{ $val }}</span>
                                            @endif
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <div class="d-flex justify-content-between mt-3 text-muted small fw-bold">
                                @foreach($days as $day) <span style="font-size: 10px;">{{ strtoupper($day) }}</span> @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="bg-white border rounded-4 shadow-sm p-4 h-100">
                            <h6 class="fw-bold text-dark mb-4 small text-uppercase" style="letter-spacing: 1px;">ทางลัดจัดการ</h6>
                            <div class="d-grid gap-3">
                                <a href="?view=products" class="text-decoration-none p-3 border rounded-4 d-block hover-bg-light transition-all border-light-subtle">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-primary bg-opacity-10 text-primary rounded-3 p-2 me-3"><i class="bi bi-pencil-square fs-4"></i></div>
                                            <div>
                                                <div class="fw-bold small text-dark">แก้ไขราคาสินค้า</div>
                                                <div class="text-muted" style="font-size: 11px;">Update Price Matrix</div>
                                            </div>
                                        </div>
                                        <i class="bi bi-chevron-right text-muted opacity-50"></i>
                                    </div>
                                </a>
                                <a href="?view=faq" class="text-decoration-none p-3 border rounded-4 d-block hover-bg-light transition-all border-light-subtle">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-success bg-opacity-10 text-success rounded-3 p-2 me-3"><i class="bi bi-question-circle fs-4"></i></div>
                                            <div>
                                                <div class="fw-bold small text-dark">จัดการ FAQ</div>
                                                <div class="text-muted" style="font-size: 11px;">Support Center</div>
                                            </div>
                                        </div>
                                        <i class="bi bi-chevron-right text-muted opacity-50"></i>
                                    </div>
                                </a>
                                <a href="?view=quotations" class="text-decoration-none p-3 border rounded-4 d-block hover-bg-light transition-all border-light-subtle">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <div class="bg-warning bg-opacity-10 text-warning rounded-3 p-2 me-3"><i class="bi bi-file-earmark-text fs-4"></i></div>
                                            <div>
                                                <div class="fw-bold small text-dark">ใบเสนอราคา</div>
                                                <div class="text-muted" style="font-size: 11px;">View All Requests</div>
                                            </div>
                                        </div>
                                        <i class="bi bi-chevron-right text-muted opacity-50"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>

                    {{-- 📜 ส่วนที่ 3: Activity Logs (แสดงผลเต็มความกว้าง) --}}
                    <div class="col-12 mt-2">
                        <div class="bg-white border rounded-4 shadow-sm overflow-hidden">
                            <div class="p-3 border-bottom d-flex align-items-center justify-content-between">
                                <h6 class="fw-bold mb-0 small text-dark"><i class="bi bi-activity me-2 text-danger"></i>กิจกรรมล่าสุดในระบบ</h6>
                                <span class="text-muted" style="font-size: 11px;">อัปเดต: {{ date('H:i') }} น.</span>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-hover mb-0 align-middle">
                                    <thead class="bg-light">
                                        <tr class="small text-muted border-0">
                                            <th class="ps-4 py-3 border-0">รายการกิจกรรม</th>
                                            <th class="border-0">ผู้ทำรายการ</th>
                                            <th class="border-0 text-center">ID อ้างอิง</th>
                                            <th class="text-end pe-4 border-0">เวลา</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($activities->take(8) as $a)
                                        <tr class="border-bottom-0">
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center">
                                                    <i class="bi {{$a->icon ?? 'bi-dot'}} text-primary me-2"></i>
                                                    <span class="small fw-bold text-dark">{{$a->type}}</span>
                                                </div>
                                            </td>
                                            <td class="small text-muted">{{$a->user}}</td>
                                            <td class="text-center"><code class="text-primary fw-bold bg-primary bg-opacity-10 px-2 py-1 rounded">#{{$a->ref}}</code></td>
                                            <td class="text-end pe-4 small text-muted">{{ \Carbon\Carbon::parse($a->created_at)->diffForHumans() }}</td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center py-5 text-muted small">ยังไม่มีข้อมูลกิจกรรม</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>



            @elseif($viewType == 'products')
                @php 
                    $activeProductId = request('product_id');
                    $subAction = request('sub');
                @endphp

                <div class="px-3 pb-5">
                    @if(!$activeProductId)
                        {{-- 🟢 1. หน้าตารางรายการสินค้าหลัก (Minimal Table View) --}}
                        <div class="card shadow-sm border-0 rounded-4 overflow-hidden mb-4">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr class="text-secondary small fw-bold border-bottom">
                                            <th class="ps-4 py-3" style="width: 110px;">รูปสินค้า</th>
                                            <th class="py-3 text-center">ชื่อสินค้า</th>
                                            <th class="py-3">วัสดุหลัก (Base Material)</th>
                                            <th class="py-3 text-center" style="width: 120px;">สถานะ</th>
                                            <th class="text-center pe-4 py-3">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($products as $p)
                                        <tr class="border-bottom">
                                            <td class="ps-4 py-3">
                                                @php $mainImg = DB::table('product_images')->where('product_id', $p->id)->orderBy('is_main', 'desc')->first(); @endphp
                                                <div class="rounded-3 border bg-white overflow-hidden p-1 shadow-sm" style="width: 65px; height: 65px;">
                                                    @if($mainImg) 
                                                        <img src="{{ asset($mainImg->image_url) }}" class="w-100 h-100 object-fit-contain">
                                                    @else 
                                                        <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-light text-muted small">
                                                            <i class="bi bi-image"></i>
                                                        </div> 
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="py-3 text-center">
                                                <div class="fw-bold text-dark fs-6">{{ $p->name }}</div>
                                                <div class="text-muted small">ID: #{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</div>
                                            </td>
                                            <td class="py-3">
                                                <span class="badge bg-white text-dark border px-3 py-2 rounded-pill fw-medium shadow-sm">
                                                    {{ $p->base_material ?: 'ไม่ได้ระบุ' }}
                                                </span>
                                            </td>
                                            <td class="py-3 text-center">
                                                <div class="form-check form-switch d-inline-block p-0">
                                                    <input class="form-check-input custom-switch m-0" type="checkbox" role="switch" 
                                                        id="status_{{ $p->id }}" 
                                                        {{ $p->status == 1 ? 'checked' : '' }}
                                                        onchange="toggleProductStatus({{ $p->id }}, this)">
                                                </div>
                                                <div class="fw-bold mt-1" id="status_text_{{ $p->id }}" 
                                                    style="font-size: 9px; letter-spacing: 0.5px; color: {{ $p->status == 1 ? '#198754' : '#dc3545' }};">
                                                    {{ $p->status == 1 ? 'ONLINE' : 'OFFLINE' }}
                                                </div>
                                            </td>
                                            <td class="text-center pe-4 py-3">
                                                <div class="dropdown">
                                                    <button class="btn btn-white border rounded-pill px-4 fw-bold shadow-sm dropdown-toggle btn-sm" type="button" data-bs-toggle="dropdown">
                                                        เลือกจัดการ
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end shadow border-0 rounded-3 mt-2">
                                                        <li>
                                                            <a class="dropdown-item py-2 px-3 fw-medium" href="?view=products&product_id={{$p->id}}&sub=price">
                                                                <i class="bi bi-grid-3x3 me-2"></i> จัดการราคาและเทคนิค
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item py-2 px-3 fw-medium" href="?view=products&product_id={{$p->id}}&sub=details">
                                                                <i class="bi bi-card-list me-2"></i> แก้ไขรายละเอียดสินค้า
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item py-2 px-3 fw-medium" href="?view=products&product_id={{$p->id}}&sub=gallery">
                                                                <i class="bi bi-images me-2"></i> จัดรูปภาพแสดง
                                                            </a>
                                                        </li>
                                                        <li><hr class="dropdown-divider"></li>
                                                        <li>
                                                            <a class="dropdown-item py-2 px-3 text-secondary small fw-medium" href="{{ url('/products/'.$p->slug) }}" target="_blank">
                                                                <i class="bi bi-eye me-2"></i> ดูหน้าเว็บจริง
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        {{-- 🔵 2. หน้าแก้ไขสินค้า (Single Isolated View) --}}
                        @php $p = $products->where('id', $activeProductId)->first(); @endphp

                        @if($p)
                            {{-- Header Navigation --}}
                            <div class="d-flex align-items-center" style="margin-left: 20px">
                                <a href="?view=products" class="btn btn-white border rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 45px; height: 45px;">
                                    <i class="bi bi-arrow-left fs-4 text-dark"></i>
                                </a>
                                <div>
                                    <h4 class="fw-bold text-dark mb-1">{{ $p->name }}</h4>
                                    <div class="d-flex align-items-center">
                                        <span class="text-secondary small fw-bold text-uppercase">
                                            @if($subAction == 'price') จัดการราคาและเทคนิค 
                                            @elseif($subAction == 'gallery') จัดลำดับรูปภาพย่อย
                                            @else แก้ไขรายละเอียดหน้าบ้าน @endif
                                        </span>
                                        <span class="text-muted mx-2">|</span>
                                        <span class="text-muted small">ID: #{{ str_pad($p->id, 4, '0', STR_PAD_LEFT) }}</span>
                                    </div>
                                </div>
                            </div>

                            <div class="card border-0 shadow-sm rounded-4 p-4 bg-white border">
                                @if($subAction == 'details')
                                    {{-- 🟡 โหมด: รายละเอียดสินค้า --}}
                                    <div class="row g-4">
                                        <div class="col-md-3">
                                            <label class="small fw-bold text-secondary mb-2">สั่งขั้นต่ำ (MOQ)</label>
                                            <input type="text" id="moq_{{$p->id}}" class="form-control border-light bg-light rounded-3 shadow-none px-3" value="{{$p->moq}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small fw-bold text-secondary mb-2">การบรรจุ (Packing)</label>
                                            <input type="text" id="packing_{{$p->id}}" class="form-control border-light bg-light rounded-3 shadow-none px-3" value="{{$p->packing}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small fw-bold text-secondary mb-2">ระยะเวลาผลิต</label>
                                            <input type="text" id="prod_time_{{$p->id}}" class="form-control border-light bg-light rounded-3 shadow-none px-3" value="{{$p->production_time}}">
                                        </div>
                                        <div class="col-md-3">
                                            <label class="small fw-bold text-secondary mb-2">ตัวอย่างสินค้า</label>
                                            <input type="text" id="sample_{{$p->id}}" class="form-control border-light bg-light rounded-3 shadow-none px-3" value="{{$p->free_sample_text}}">
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <div class="p-4 rounded-4 border bg-white">
                                                <h6 class="fw-bold text-dark mb-4">ข้อมูลเพิ่มเติม (Custom Fields)</h6>
                                                <div id="custom-fields-container-{{$p->id}}" class="custom-fields-list">
                                                    @php $extras = !empty($p->custom_fields) ? json_decode($p->custom_fields, true) : []; @endphp
                                                    @foreach($extras as $label => $value)
                                                    <div class="row g-2 mb-3 custom-field-row align-items-center">
                                                        <div class="col-md-4">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text bg-light border-0 text-muted small fw-bold">หัวข้อ</span>
                                                                <input type="text" class="form-control border-0 bg-light extra-label px-3" value="{{$label}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-7">
                                                            <div class="input-group input-group-sm">
                                                                <span class="input-group-text bg-light border-0 text-muted small fw-bold">รายละเอียด</span>
                                                                <input type="text" class="form-control border-0 bg-light extra-value px-3" value="{{$value}}">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1 text-end">
                                                            <button class="btn btn-link text-danger p-0" onclick="this.closest('.custom-field-row').remove()"><i class="bi bi-trash3"></i></button>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div>
                                                <button type="button" class="btn btn-sm btn-dark rounded-pill px-4 fw-bold mt-2" onclick="addCustomField({{$p->id}})">+ เพิ่มหัวข้อ</button>
                                            </div>
                                        </div>

                                        <div class="col-md-12 mt-4">
                                            <label class="small fw-bold text-secondary mb-2">คุณสมบัติพิเศษ / คำอธิบาย</label>
                                            <textarea id="special_{{$p->id}}" class="form-control border-light bg-light rounded-4 p-3 shadow-none" rows="5">{!! $p->special_features !!}</textarea>
                                        </div>
                                    </div>
                                    <div class="mt-5 text-end border-top pt-4">
                                        <button class="btn btn-success rounded-pill px-5 fw-bold" onclick="saveProductDetails({{$p->id}})">บันทึกการเปลี่ยนแปลง</button>
                                    </div>

                                @elseif($subAction == 'price')
                                    {{-- 🔵 โหมด: จัดการราคา Matrix --}}
                                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                                        <h6 class="fw-bold text-dark mb-0">ตารางราคาและเทคนิค</h6>
                                        <div class="btn-group btn-group-sm rounded-pill overflow-hidden border shadow-sm">
                                            <button class="btn btn-white fw-bold px-3 py-2" onclick="addPrintingType({{$p->id}})">+ เทคนิค</button>
                                            <button class="btn btn-white fw-bold px-3 py-2 border-start" onclick="addSizeColumn(this, {{$p->id}})">+ ขนาด</button>
                                            <button class="btn btn-white fw-bold px-3 py-2 border-start" onclick="addQtyRow(this, {{$p->id}})">+ จำนวน</button>
                                            <button class="btn btn-white fw-bold px-3 py-2 border-start text-danger font-monospace" onclick="toggleDeleteMode({{$p->id}})">โหมดลบ</button>
                                        </div>
                                    </div>

                                    @php $prodPrintings = $printings->where('product_id', $p->id)->values(); @endphp
                                    <div class="nav nav-pills mb-4" id="pills-tab-{{$p->id}}">
                                        @foreach($prodPrintings as $index => $print)
                                            <div class="nav-item nav-item-tech @if($index==0) active @endif me-2 mb-2 border rounded-pill shadow-sm bg-light" data-bs-toggle="pill" data-bs-target="#tab-{{$p->id}}-{{$index}}" role="button" style="padding: 4px 15px;">
                                                <input type="text" class="tech-edit-input fw-bold bg-transparent border-0 text-center" value="{{ $print->printing_type }}" onchange="updatePrintingName({{ $print->id }}, this.value)" onclick="event.stopPropagation();">
                                                <span class="btn-del-tech text-muted opacity-50 ms-1" onclick="event.stopPropagation(); deletePrintingType({{ $print->id }}, '{{ $print->printing_type }}')"><i class="bi bi-x-circle-fill"></i></span>
                                            </div>
                                        @endforeach
                                    </div>

                                <div id="priceEdit{{$p->id}}">
                                <div class="tab-content">
                                        @foreach($prodPrintings as $index => $print)
                                            <div class="tab-pane fade @if($index==0) show active @endif" id="tab-{{$p->id}}-{{$index}}">
                                                
                                                <div class="mb-3">
                                                    <div class="input-group shadow-sm">
                                                            <span class="input-group-text bg-white border-end-0 text-muted">
                                                                <i class="bi bi-pencil-square"></i>
                                                            </span>
                                                            <input type="text" 
                                                                class="form-control border-start-0 ps-0 text-secondary printing-note-input" 
                                                                placeholder="ระบุเงื่อนไข/หมายเหตุ สำหรับเทคนิคนี้" 
                                                                value="{{ $print->note ?? '' }}" 
                                                                style="font-size: 13px;">
                                                        </div>
                                                    </div>

                                                <div class="overflow-auto rounded-4 border">
                                                    <table class="table-price-grid text-center mb-0 w-100" id="table-{{$p->id}}-{{$index}}" data-print-id="{{$print->id}}">
                                                        <thead>
                                                            <tr class="bg-dark text-white border-0">
                                                                <th class="py-3" style="width: 120px;">จำนวน \ ขนาด</th>
                                                                @php 
                                                                    $thisPrintSizes = $prices->where('product_printing_id', $print->id)->where('product_id', $p->id)->pluck('product_size_id')->unique();
                                                                    $currentSizes = $sizes->whereIn('id', $thisPrintSizes)->values();
                                                                @endphp
                                                                @foreach($currentSizes as $sz)
                                                                    {{-- 🔽 ส่วนหัวตาราง (ขนาด) --}}
                                                                    <th class="position-relative border-start border-secondary py-3">
                                                                        <input type="text" class="size-name-input bg-transparent border-0 text-white text-center fw-bold" 
                                                                            value="{{$sz->size_name}}"
                                                                            style="width: 80px; margin: 0 auto;">
                                                                        
                                                                        {{-- ปุ่มลบแบบ Overlay ด้านขวา --}}
                                                                        <div class="delete-col-btn col-del-{{$p->id}} d-none" onclick="deleteCol(this)">
                                                                            <i class="bi bi-x"></i>
                                                                        </div>
                                                                    </th>
                                                                @endforeach
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @php $thisPrintQtys = $prices->where('product_printing_id', $print->id)->where('product_id', $p->id)->pluck('quantity_min')->unique()->sort()->values(); @endphp
                                                            @foreach($thisPrintQtys as $qty)
                                                                <tr>
                                                                    {{-- 🔽 ส่วนแถว (จำนวน) --}}
                                                                    <td class="bg-light border-bottom border-end fw-bold position-relative">
                                                                        {{-- ปุ่มลบอยู่ด้านหน้า (ซ้ายสุด) --}}
                                                                        <div class="delete-row-btn row-del-{{$p->id}} d-none" onclick="deleteRow(this)">-</div>

                                                                        <input type="number" class="qty-val-input border-0 bg-transparent text-center w-100" 
                                                                            value="{{$qty}}" 
                                                                            style="width: 60px; margin: 0 auto; display: block;">
                                                                    </td>

                                                                    @foreach($currentSizes as $sz)
                                                                        @php $priceItem = $prices->where('product_printing_id', $print->id)->where('product_size_id', $sz->id)->where('quantity_min', $qty)->first(); @endphp
                                                                        <td class="border-bottom border-start p-0">
                                                                            <input type="number" step="0.01" class="input-price-cell w-100 border-0 text-center py-2" 
                                                                                value="{{ $priceItem ? $priceItem->price_per_unit : 0 }}"
                                                                                style="width: 90px; margin: 0 auto; display: block;">
                                                                        </td>
                                                                    @endforeach
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div class="mt-5 text-end border-top pt-4">
                                        <button class="btn btn-success rounded-pill px-5 fw-bold shadow" onclick="saveRebuiltTable({{$p->id}})">บันทึกข้อมูลราคาทั้งหมด</button>
                                    </div>

                                @elseif($subAction == 'gallery')
                                    {{-- 🖼️ โหมด: จัดลำดับรูปภาพย่อย (Gallery) --}}
                                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom">
                                        <div>
                                            <h6 class="fw-bold text-dark mb-1">จัดลำดับรูปภาพย่อย (Gallery)</h6>
                                            <p class="text-muted small mb-0">ลากวางเพื่อเรียงลำดับรูปภาพย่อย (เฉพาะรูปที่ไม่ใช่รูปหลัก)</p>
                                        </div>
                                        <button class="btn btn-success rounded-pill px-4 fw-bold shadow-sm" onclick="saveImageOrder({{$p->id}})">
                                            <i class="bi bi-check-lg me-1"></i> บันทึกลำดับรูป
                                        </button>
                                    </div>

                                    @php 
                                        $mainImg = DB::table('product_images')->where('product_id', $p->id)->where('is_main', 1)->first();
                                        $galleryImgs = DB::table('product_images')
                                                        ->where('product_id', $p->id)
                                                        ->where('is_main', 0)
                                                        ->orderBy('sort_order', 'asc')
                                                        ->get();
                                    @endphp

                                    <div class="row g-3">
                                    @if($mainImg)
                                            <div class="col-6 col-md-3 col-lg-2">
                                                <div class="card h-100 border-primary border-2 shadow-none rounded-3 overflow-hidden position-relative" 
                                                    onclick="document.getElementById('change_img_{{ $mainImg->id }}').click()" style="cursor: pointer;">
                                                    <div class="position-absolute top-0 start-0 m-1" style="z-index: 5;">
                                                        <span class="badge bg-primary" style="font-size: 9px;">รูปหลัก (คลิกเปลี่ยน)</span>
                                                    </div>
                                                    <div class="d-flex align-items-center justify-content-center bg-white" style="height: 140px;">
                                                        <img src="{{ asset($mainImg->image_url) }}" id="img_view_{{ $mainImg->id }}" class="w-100 h-100 object-fit-contain p-2">
                                                    </div>
                                                    {{-- Hidden Input สำหรับเปลี่ยนรูปหลัก --}}
                                                    <input type="file" id="change_img_{{ $mainImg->id }}" hidden accept="image/*" 
                                                        onchange="updateProductImage(this, {{ $mainImg->id }})">
                                                </div>
                                            </div>
                                            @endif

                                            {{-- Container สำหรับรูปย่อย --}}
                                            <div id="image-sortable-container" class="col-12 row g-3 m-0 p-0">
                                                @foreach($galleryImgs as $img)
                                                    <div class="col-6 col-md-3 col-lg-2 image-item" data-id="{{$img->id}}">
                                                        <div class="card h-100 border shadow-none rounded-3 overflow-hidden bg-white position-relative">
                                                            {{-- คลิกที่ส่วนรูปเพื่อเปลี่ยน --}}
                                                            <div class="d-flex align-items-center justify-content-center" style="height: 140px; cursor: pointer;" 
                                                                onclick="document.getElementById('change_img_{{ $img->id }}').click()">
                                                                <img src="{{ asset($img->image_url) }}" id="img_view_{{ $img->id }}" class="w-100 h-100 object-fit-contain p-2">
                                                                <div class="position-absolute bottom-0 end-0 m-1 badge bg-dark opacity-50" style="font-size: 8px;">เปลี่ยนรูป</div>
                                                            </div>
                                                            {{-- Hidden Input สำหรับเปลี่ยนรูปย่อย --}}
                                                            <input type="file" id="change_img_{{ $img->id }}" hidden accept="image/*" 
                                                                onchange="updateProductImage(this, {{ $img->id }})">

                                                            <div class="card-footer py-1 px-2 bg-light border-0 text-center" style="cursor: grab;">
                                                                <span class="text-muted" style="font-size: 10px;">
                                                                    <i class="bi bi-arrows-move"></i> ลำดับที่ <span class="order-num">{{ $loop->iteration }}</span>
                                                                </span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                @endif {{-- ปิด subAction --}}
                            </div> {{-- ปิด card p-4 --}}
                        @endif
                    @endif 
                </div> 

@elseif($viewType == 'gallery')
    <div class="p-4">
        {{-- ครอบด้วย Card ขาว --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <div class="nav nav-pills d-flex flex-wrap">
                    @foreach($products as $idx => $prod)
                        <button class="nav-link {{ $idx == 0 ? 'active' : '' }} me-2 mb-2 px-4 rounded-pill fw-bold" 
                                data-bs-toggle="tab" 
                                data-bs-target="#tab-{{ $prod->id }}">
                            {{ $prod->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="card-body p-4">
                <div class="tab-content">
                    @foreach($products as $idx => $prod)
                    <div class="tab-pane fade {{ $idx == 0 ? 'show active' : '' }}" id="tab-{{ $prod->id }}">
                        
                        {{-- ส่วนหัวของ Tab --}}
                        <div class="d-flex justify-content-between align-items-center mb-4 pb-3 border-bottom border-light">
                            <div>
                                <h5 class="fw-bold mb-1 text-dark">จัดการคลังภาพ: {{ $prod->name }}</h5>
                                <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> ลากวางรูปภาพเพื่อจัดลำดับการแสดงผล</p>
                            </div>
                            <button class="btn btn-success btn-sm rounded-pill px-4 fw-bold shadow-sm" onclick="saveGalleryOrder({{ $prod->id }})">
                                <i class="bi bi-check-lg me-1"></i> บันทึกลำดับรูป
                            </button>
                        </div>

                        <div class="d-flex flex-wrap align-items-start">
                            {{-- ปุ่มเพิ่มรูป --}}
                            <div class="custom-gallery-item d-flex align-items-center justify-content-center me-3 mb-3" 
                                style="border: 2px dashed #ddd; cursor: pointer; background: #fafafa; border-radius: 12px; transition: all 0.3s;" 
                                onclick="document.getElementById('gallery_file_{{ $prod->id }}').click()"
                                onmouseover="this.style.borderColor='#000'; this.style.background='#f0f0f0';"
                                onmouseout="this.style.borderColor='#ddd'; this.style.background='#fafafa';">
                                <div class="text-center text-muted">
                                    <i class="bi bi-plus-circle-dotted fs-1"></i>
                                    <p class="small fw-bold mb-0 mt-2">เพิ่มรูปผลงาน</p>
                                </div>
                            </div>
                            <input type="file" id="gallery_file_{{ $prod->id }}" hidden accept="image/*" multiple onchange="uploadGallery(this, {{ $prod->id }})">

                            {{-- กล่อง Sortable --}}
                            <div id="sortable-gallery-{{ $prod->id }}" class="d-flex flex-wrap gallery-sortable-container">
                                @foreach($galleries->where('product_id', $prod->id)->sortBy('sort_order') as $img)
                                <div class="custom-gallery-item gallery-item me-3 mb-3 shadow-sm border border-light" id="g-{{$img->id}}" data-id="{{$img->id}}" 
                                     style="cursor: grab; border-radius: 12px; overflow: hidden; background: #fff;">
                                    <div class="img-container" style="height: 140px; overflow: hidden; position: relative;">
                                        <img src="{{ asset('images/gallery/'.$img->image_path) }}" 
                                             alt="Portfolio" 
                                             style="width: 100%; height: 100%; object-fit: cover;">
                                    </div>
                                    <div class="action-footer p-2 bg-white d-flex justify-content-between align-items-center border-top border-light">
                                        <span class="text-truncate px-2 text-muted" style="max-width: 110px; font-size: 11px;">{{ $img->image_path }}</span>
                                        <button class="btn btn-danger btn-sm rounded-circle d-flex align-items-center justify-content-center" 
                                                onclick="delG({{$img->id}})" 
                                                style="width:24px; height:24px;">
                                            <i class="bi bi-trash fs-6"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div> {{-- จบ card --}}
    </div>

@elseif($viewType == 'addons')
    <style>
.addon-card-item {
            width: 250px; 
            flex: 0 0 auto;
            margin-right: 20px;
            margin-bottom: 20px;
            border-radius: 15px;
            overflow: hidden;
            background: #fff;
            display: flex;
            flex-direction: column;
            border: 1px solid #eee;
            transition: all 0.3s ease;
        }

        .addon-card-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1) !important;
        }

        .addon-card-item .img-container {
            width: 100%;
            height: 180px;
            position: relative;
            background: #ffffff;
            /* จัดกึ่งกลางรูป */
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .addon-card-item .img-container img {
            /* ปรับรูปให้เล็กลงโดยการใส่ padding หรือลด % width/height */
            width: 80%; 
            height: 80%;
            /* ใช้ contain เพื่อให้เห็นรูปครบถ้วนและอยู่กลางกล่อง */
            object-fit: contain; 
        }

        /* ปุ่มเพิ่มอุปกรณ์เสริมแบบ Card (ปรับขนาดให้ล้อตาม addon-card-item) */
        .btn-add-addon {
            width: 250px;
            min-height: 400px; 
            border: 2px dashed #ddd;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            background: #fafafa;
            margin-right: 20px;
            margin-bottom: 20px;
            transition: all 0.3s;
        }
        .btn-add-addon:hover {
            border-color: #000;
            background: #f0f0f0;
        }

        .addon-input-label {
            font-size: 10px;
            font-weight: bold;
            color: #999;
            text-transform: uppercase;
            display: block;
            margin-bottom: 2px;
        }

        .form-control-clean {
            border: none;
            border-bottom: 1px solid #eee;
            border-radius: 0;
            padding: 5px 0;
            font-size: 13px;
            background: transparent;
        }
        .form-control-clean:focus {
            outline: none;
            border-bottom-color: #000;
        }
    </style>

    <div class="p-4">
        {{-- Card พื้นหลังขาว --}}
        <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
            <div class="card-header bg-white border-bottom-0 pt-4 px-4">
                <div class="nav nav-pills d-flex flex-wrap">
                    @foreach($products as $idx => $prod)
                        <button class="nav-link {{ $idx == 0 ? 'active' : '' }} me-2 mb-2 px-4 rounded-pill fw-bold" 
                                data-bs-toggle="tab" 
                                data-bs-target="#parts-tab-{{ $prod->id }}">
                            {{ $prod->name }}
                        </button>
                    @endforeach
                </div>
            </div>

            <div class="card-body p-4">
                <div class="tab-content">
                    @foreach($products as $idx => $prod)
                    <div class="tab-pane fade {{ $idx == 0 ? 'show active' : '' }}" id="parts-tab-{{ $prod->id }}">
                        
                        <div class="mb-4 pb-3 border-bottom border-light">
                            <h5 class="fw-bold mb-1 text-dark">จัดการอุปกรณ์เสริม: {{ $prod->name }}</h5>
                            <p class="text-muted small mb-0"><i class="bi bi-info-circle me-1"></i> แก้ไขข้อมูลและราคาเพิ่มของแต่ละชิ้นส่วน</p>
                        </div>

                        <div class="d-flex flex-wrap align-items-start">
                            {{-- 🆕 ปุ่มเพิ่มอุปกรณ์เสริม --}}
                            <div class="btn-add-addon" onclick="addPart({{ $prod->id }})">
                                <div class="text-center text-muted">
                                    <i class="bi bi-plus-circle-dotted fs-1"></i>
                                    <p class="small fw-bold mb-0 mt-2">เพิ่มอุปกรณ์เสริมใหม่</p>
                                </div>
                            </div>

                            @foreach($productParts->where('product_id', $prod->id) as $part)
                                <div class="addon-card-item shadow-sm" id="part-{{ $part->id }}">
                                    <div class="img-container">
                                        <img id="preview_{{ $part->id }}" src="{{ $part->image_url ? asset('images/jp-attachments/attachments/' . $part->image_url) : 'https://placehold.co/250x180?text=No+Image' }}">
                                        
                                        {{-- สถานะ --}}
                                        <div style="position: absolute; top: 10px; left: 10px;">
                                            @if($part->part_name !== 'อุปกรณ์ใหม่ (รอแก้ไข)' && !empty($part->part_name) && !empty($part->image_url))
                                                <span class="badge bg-success shadow-sm"><i class="bi bi-check-circle-fill"></i> ออนไลน์</span>
                                            @else
                                                <span class="badge bg-warning text-dark shadow-sm"><i class="bi bi-exclamation-triangle-fill"></i> รอตรวจสอบ</span>
                                            @endif
                                        </div>
                                        
                                        <label for="file_{{ $part->id }}" class="btn-upload-overlay" style="position: absolute; bottom: 10px; right: 10px; background: rgba(0,0,0,0.5); color: #fff; width: 35px; height: 35px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer;">
                                            <i class="bi bi-camera-fill"></i>
                                        </label>
                                        <input type="file" id="file_{{ $part->id }}" hidden accept="image/*" onchange="previewImg(this, {{ $part->id }})">
                                    </div>

                                    <div class="p-3">
                                        <div class="mb-3">
                                            <label class="addon-input-label">ชื่ออุปกรณ์เสริม</label>
                                            <textarea id="p_name_{{ $part->id }}" class="form-control-clean w-100" rows="1" style="resize: none;">{{ $part->part_name }}</textarea>
                                        </div>
                                        
                                        <div class="row g-2 mb-3">
                                            <div class="col-6">
                                                <label class="addon-input-label">สี/ลักษณะ</label>
                                                <input type="text" id="p_color_{{ $part->id }}" class="form-control-clean w-100" value="{{ $part->color }}">
                                            </div>
                                            <div class="col-6">
                                                <label class="addon-input-label">ราคาเพิ่ม (฿)</label>
                                                <input type="number" id="p_price_{{ $part->id }}" class="form-control-clean w-100 fw-bold text-success" value="{{ $part->price_extra }}">
                                            </div>
                                        </div>

                                        <div class="d-flex gap-2 mt-2">
                                            <button class="btn btn-success btn-sm rounded-pill flex-grow-1 fw-bold" onclick="updatePart({{ $part->id }})">Update</button>
                                            <button class="btn btn-outline-danger btn-sm rounded-circle d-flex align-items-center justify-content-center" onclick="delPart({{ $part->id }})" style="width:32px; height:32px;">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    
{{-- 5. QUOTATIONS VIEW --}}
            @elseif($viewType == 'quotations')
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead class="bg-light text-muted small">
                            <tr class="border-0">
                                <th class="ps-4 py-3 border-0">เลขที่ใบเสนอราคา</th>
                                <th class="border-0">ชื่อลูกค้า</th>
                                <th class="border-0 text-center">ยอดเงินรวม</th>
                                <th class="border-0 text-end pe-4">วันที่รายการ</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($quotations as $q)
                            <tr class="border-bottom-0">
                                <td class="ps-4 py-3">
                                    {{-- ลิงก์ WebView ผ่านเลขที่ใบเสนอราคา --}}
                                    <a href="{{ route('admin.quotation.view', $q->quotation_number) }}" target="_blank" class="fw-bold text-primary text-decoration-none">
                                        <i class="bi bi-file-earmark-text me-1"></i> {{ $q->quotation_number }}
                                    </a>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark small">{{ $q->fullname }}</div>
                                    <div class="text-muted" style="font-size: 11px;">{{ $q->email ?? 'ไม่มีอีเมล' }}</div>
                                </td>
                                <td class="text-center">
                                    <span class="fw-bold text-dark">฿{{ number_format($q->grand_total, 2) }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <span class="text-muted small">
                                        <i class="bi bi-clock me-1"></i> {{ \Carbon\Carbon::parse($q->created_at)->format('d/m/Y H:i') }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr><td colspan="4" class="text-center py-5 text-muted small">ไม่พบรายการใบเสนอราคา</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- 🔵 Pagination UI (Custom Modern) --}}
                @if($quotations->hasPages())
                <div class="p-4 border-top bg-white d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                    <div class="small text-muted fw-medium">
                        Showing <span class="text-dark fw-bold">{{ $quotations->firstItem() }}</span> to <span class="text-dark fw-bold">{{ $quotations->lastItem() }}</span> of <span class="text-dark fw-bold">{{ $quotations->total() }}</span> results
                    </div>
                    
                    <nav>
                        <ul class="pagination mb-0 gap-1">
                            @if ($quotations->onFirstPage())
                                <li class="page-item disabled"><span class="page-link border-0 bg-light rounded-3 text-muted px-3 py-2"><i class="bi bi-chevron-left"></i></span></li>
                            @else
                                <li class="page-item"><a class="page-link border-0 shadow-sm rounded-3 text-dark bg-white px-3 py-2" href="{{ $quotations->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a></li>
                            @endif

                            @foreach ($quotations->getUrlRange(max(1, $quotations->currentPage() - 1), min($quotations->lastPage(), $quotations->currentPage() + 1)) as $page => $url)
                                <li class="page-item {{ ($page == $quotations->currentPage()) ? 'active' : '' }}">
                                    <a class="page-link border-0 shadow-sm rounded-3 px-3 py-2 {{ ($page == $quotations->currentPage()) ? 'bg-dark text-white' : 'bg-white text-dark' }}" href="{{ $url }}">{{ $page }}</a>
                                </li>
                            @endforeach

                            @if ($quotations->hasMorePages())
                                <li class="page-item"><a class="page-link border-0 shadow-sm rounded-3 text-dark bg-white px-3 py-2" href="{{ $quotations->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link border-0 bg-light rounded-3 text-muted px-3 py-2"><i class="bi bi-chevron-right"></i></span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
                @endif

                @elseif($viewType == 'contacts')
                    <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4">
                        
                        {{-- 1. ตารางแสดงรายการ --}}
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="bg-light text-muted small">
                                    <tr class="border-0 text-uppercase fw-bold text-nowrap">
                                        <th class="ps-4 py-3 border-0" style="width: 20%;">ผู้ติดต่อ</th>
                                        <th class="border-0" style="width: 35%;">ข้อความ</th>
                                        <th class="border-0" style="width: 20%;">ช่องทางติดต่อ</th>
                                        <th class="text-center border-0" style="width: 10%;">วันที่แจ้ง</th>
                                        <th class="text-end pe-4 border-0" style="width: 15%;">จัดการ</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($contacts as $c)
                                    <tr class="border-bottom-0">
                                        {{-- Col 1: ผู้ติดต่อ --}}
                                        <td class="ps-4 py-3 fw-bold text-dark small align-top">
                                            <div class="d-flex align-items-center mt-1">
                                                <i class="bi bi-person-circle me-2 text-muted fs-6"></i> 
                                                {{ $c->name ?? 'ไม่ระบุชื่อ' }}
                                            </div>
                                        </td>

                                        {{-- Col 2: ข้อความ (แสดงผลเต็ม ไม่ตัดคำ) --}}
                                        <td class="align-top py-3">
                                            @if(isset($c->subjects))
                                                @php 
                                                    $subs = json_decode($c->subjects); 
                                                    $subjectText = is_array($subs) ? implode(', ', $subs) : $c->subjects;
                                                @endphp
                                                <div class="fw-bold text-primary mb-1" style="font-size: 11px;">
                                                    หัวข้อ: {{ $subjectText }}
                                                </div>
                                            @endif
                                            <div class="text-muted small lh-sm text-break">
                                                {!! nl2br(e($c->message ?? 'ไม่มีข้อความ')) !!}
                                            </div>
                                        </td>

                                        {{-- Col 3: ช่องทางติดต่อ --}}
                                        <td class="align-top py-3">
                                            <div style="font-size: 11px;" class="mb-1 text-nowrap">
                                                <i class="bi bi-envelope-fill text-muted me-1"></i> {{ $c->email ?? '-' }}
                                            </div>
                                            <div style="font-size: 11px;" class="text-nowrap">
                                                <i class="bi bi-telephone-fill text-muted me-1"></i> {{ $c->phone ?? '-' }}
                                            </div>
                                        </td>

                                        <td class="text-center align-top py-3">
                                            <span class="text-muted small text-nowrap">
                                                {{ isset($c->created_at) ? \Carbon\Carbon::parse($c->created_at)->format('d/m/Y H:i') : '-' }}
                                            </span>
                                        </td>

                                        <td class="text-end pe-4 align-top py-3">
                                            <a href="{{ route('admin.contact.webview', $c->id) }}" 
                                            target="_blank" 
                                            class="btn btn-sm btn-outline-primary rounded-pill px-3 fw-bold text-nowrap" 
                                            style="font-size: 11px;">
                                                <i class="bi bi-eye-fill me-1"></i> ดูรายละเอียด
                                            </a>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center py-5 text-muted small">ไม่พบข้อความติดต่อ</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        {{-- 2. Pagination (โครงสร้างที่คุณต้องการ) --}}
                        @if($contacts->hasPages())
                        <div class="p-4 border-top bg-white d-flex flex-column flex-md-row justify-content-between align-items-center gap-3">
                            <div class="small text-muted fw-medium">
                                Showing <span class="text-dark fw-bold">{{ $contacts->firstItem() }}</span> to <span class="text-dark fw-bold">{{ $contacts->lastItem() }}</span> of <span class="text-dark fw-bold">{{ $contacts->total() }}</span> messages
                            </div>
                            <nav>
                                <ul class="pagination mb-0 gap-1">
                                    @if ($contacts->onFirstPage())
                                        <li class="page-item disabled"><span class="page-link border-0 bg-light rounded-3 text-muted px-3 py-2"><i class="bi bi-chevron-left"></i></span></li>
                                    @else
                                        <li class="page-item"><a class="page-link border-0 shadow-sm rounded-3 text-dark bg-white px-3 py-2" href="{{ $contacts->previousPageUrl() }}"><i class="bi bi-chevron-left"></i></a></li>
                                    @endif

                                    @foreach ($contacts->getUrlRange(max(1, $contacts->currentPage() - 1), min($contacts->lastPage(), $contacts->currentPage() + 1)) as $page => $url)
                                        <li class="page-item {{ ($page == $contacts->currentPage()) ? 'active' : '' }}">
                                            <a class="page-link border-0 shadow-sm rounded-3 px-3 py-2 {{ ($page == $contacts->currentPage()) ? 'bg-dark text-white' : 'bg-white text-dark' }}" href="{{ $url }}">{{ $page }}</a>
                                        </li>
                                    @endforeach

                                    @if ($contacts->hasMorePages())
                                        <li class="page-item"><a class="page-link border-0 shadow-sm rounded-3 text-dark bg-white px-3 py-2" href="{{ $contacts->nextPageUrl() }}"><i class="bi bi-chevron-right"></i></a></li>
                                    @else
                                        <li class="page-item disabled"><span class="page-link border-0 bg-light rounded-3 text-muted px-3 py-2"><i class="bi bi-chevron-right"></i></span></li>
                                    @endif
                                </ul>
                            </nav>
                        </div>
                        @endif
                    </div>

                    {{-- 3. Modal สำหรับแสดงรายละเอียด --}}
                    <div class="modal fade" id="contactDetailModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-lg">
                            <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
                                <div class="modal-header bg-dark text-white px-4 py-3 border-0">
                                    <h5 class="modal-title fs-6 fw-bold">
                                        <i class="bi bi-card-text me-2"></i> รายละเอียดข้อความติดต่อ
                                    </h5>
                                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body p-0 bg-light">
                                    <div class="p-4">
                                        {{-- Card ข้อมูลผู้ติดต่อ --}}
                                        <div class="bg-white p-4 rounded-4 shadow-sm mb-3">
                                            <div class="row g-3">
                                                <div class="col-md-8">
                                                    <h5 class="fw-bold text-dark mb-1" id="modal_contact_name">-</h5>
                                                    <div class="d-flex gap-3 mt-2 text-muted small">
                                                        <span><i class="bi bi-envelope me-1"></i> <span id="modal_contact_email">-</span></span>
                                                        <span><i class="bi bi-telephone me-1"></i> <span id="modal_contact_phone">-</span></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-md-end">
                                                    <div class="text-muted small mb-1">วันที่ส่งข้อความ</div>
                                                    <div class="fw-bold text-primary" id="modal_contact_date">-</div>
                                                </div>
                                            </div>
                                            <hr class="my-3 text-light">
                                            <div>
                                                <label class="small text-uppercase text-muted fw-bold mb-2">หัวข้อเรื่องที่ติดต่อ</label>
                                                <div id="modal_contact_subject" class="fw-bold text-dark">-</div>
                                            </div>
                                        </div>

                                        {{-- Card เนื้อหาข้อความ --}}
                                        <div class="bg-white p-4 rounded-4 shadow-sm">
                                            <label class="small text-uppercase text-muted fw-bold mb-3"><i class="bi bi-chat-quote me-1"></i> ข้อความจากลูกค้า</label>
                                            <div class="p-3 bg-light rounded-3 border text-dark" id="modal_contact_message" style="white-space: pre-line; line-height: 1.6; font-size: 14px;">
                                                -
                                            </div>

                                            {{-- ส่วนไฟล์แนบ --}}
                                            <div id="modal_attachments_container" class="mt-4 d-none">
                                                <label class="small text-uppercase text-muted fw-bold mb-2"><i class="bi bi-paperclip me-1"></i> ไฟล์แนบ</label>
                                                <div id="modal_attachments_list" class="d-flex flex-wrap gap-2"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer bg-light border-top px-4 py-2">
                                    <button type="button" class="btn btn-secondary rounded-pill px-4 btn-sm fw-bold" data-bs-dismiss="modal">ปิดหน้าต่าง</button>
                                </div>
                            </div>
                        </div>
                    </div>
            {{-- 7. PAYMENTS VIEW --}}
                    @elseif($viewType == 'payments')
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead>
                                    <tr class="bg-light text-muted small">
                                        <th class="ps-4 border-0">วันที่แจ้ง</th>
                                        <th class="border-0">Order ID</th>
                                        <th class="border-0">ชื่อผู้โอน</th>
                                        <th class="border-0">ยอดเงิน</th>
                                        <th class="text-end pe-4 border-0">หลักฐาน</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($payments as $pay)
                                    <tr class="border-bottom-0">
                                        <td class="ps-4 small text-muted">
                                            {{ isset($pay->created_at) ? \Carbon\Carbon::parse($pay->created_at)->format('d/m/Y H:i') : '-' }}
                                        </td>
                                        <td>
                                            {{-- 🔗 แก้ไขตรงนี้: ทำเป็นลิงก์กดเข้าหน้า Webview --}}
                                            <a href="{{ route('admin.payment.webview', $pay->id) }}" target="_blank" class="fw-bold small text-primary text-decoration-none">
                                                <i class="bi bi-file-earmark-check me-1"></i>#{{ $pay->order_id ?? '-' }}
                                            </a>
                                        </td>
                                        <td><span class="small text-dark">{{ $pay->name ?? 'ไม่ระบุชื่อ' }}</span></td>
                                        <td class="fw-bold text-success">฿{{ number_format($pay->amount, 2) }}</td>
                                        <td class="text-end pe-4">
                                            @if(!empty($pay->slip_path))
                                                @php $finalSlipPath = str_contains($pay->slip_path, 'slips/') ? $pay->slip_path : 'slips/' . $pay->slip_path; @endphp
                                                <a href="{{ asset('storage/' . $finalSlipPath) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill px-3 shadow-sm" style="font-size: 11px;">
                                                    <i class="bi bi-image me-1"></i>ดูสลิป
                                                </a>
                                            @else 
                                                <span class="text-muted small italic">ไม่มีไฟล์</span> 
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr><td colspan="5" class="text-center py-5 text-muted small">ไม่พบรายการแจ้งโอนเงิน</td></tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                @elseif($viewType == 'faq')
                    <div class="px-4 pb-5">
                        <div class="d-flex justify-content-between align-items-center mb-4" style="padding: 0 10px;">
                            <div class="text-nowrap me-3">
                                <h5 class="fw-bold text-dark mb-0">รายการคำถามที่พบบ่อย (FAQ)</h5>
                            </div>

                            <div class="text-nowrap">
                                <button class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm" onclick="addNewFaq()">
                                    <i class="bi bi-plus-lg me-1"></i> เพิ่มหัวข้อใหม่
                                </button>
                            </div>
                        </div>

                        <div class="card border-0 shadow-sm rounded-4 overflow-hidden bg-white border">
                            <div class="table-responsive">
                                <table class="table table-hover align-middle mb-0">
                                    <thead class="bg-light">
                                        <tr class="text-secondary small fw-bold">
                                            <th class="ps-4 py-3" style="width: 55%;">รายละเอียดคำถามและคำตอบ</th>
                                            <th class="py-3 text-center" style="width: 15%;">รูปประกอบ</th>
                                            <th class="py-3 text-center" style="width: 15%;">สถานะหน้าเว็บ</th>
                                            <th class="text-end pe-4 py-3" style="width: 15%;">จัดการ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($faqs->sortBy('id') as $f) 
                                        <tr id="faq-item-{{ $f->id }}" class="border-bottom">
                                            <td class="ps-4 py-4">
                                                <div class="mb-3">
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="badge bg-dark me-2">Q:</span>
                                                        <label class="small text-muted fw-bold mb-0">หัวข้อคำถาม</label>
                                                    </div>
                                                    <input type="text" class="form-control border-light bg-light fw-bold faq-question px-3 py-2 shadow-none" 
                                                        value="{{ $f->question }}" placeholder="ระบุคำถาม...">
                                                </div>
                                                <div>
                                                    <div class="d-flex align-items-center mb-1">
                                                        <span class="badge bg-secondary me-2">A:</span>
                                                        <label class="small text-muted fw-bold mb-0">คำตอบ</label>
                                                    </div>
                                                    <textarea class="form-control border-light bg-light small text-muted faq-answer px-3 py-2 shadow-none" 
                                                            rows="5" placeholder="ระบุคำตอบ...">{{ $f->answer }}</textarea>
                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <div class="d-flex flex-row gap-3 justify-content-center align-items-center">
                                                    
                                                    {{-- ช่องรูปที่ 1 --}}
                                                    <div class="faq-img-upload-container position-relative">
                                                        <div class="border rounded bg-light d-flex align-items-center justify-content-center overflow-hidden shadow-sm" 
                                                            style="width: 85px; height: 65px; cursor: pointer; border-style: dashed !important;"
                                                            onclick="document.getElementById('faq_img1_{{$f->id}}').click()">
                                                            
                                                            @if($f->faq_image_1)
                                                                <img id="view_faq_img1_{{$f->id}}" src="{{ asset($f->faq_image_1) }}" class="w-100 h-100 object-fit-cover">
                                                                <div id="placeholder_faq1_{{$f->id}}" class="text-center text-muted d-none"> {{-- ซ่อน placeholder ถ้ามีรูป --}}
                                                                    <i class="bi bi-image d-block fs-5"></i>
                                                                    <span style="font-size: 8px;" class="fw-bold text-uppercase">Slot 1</span>
                                                                </div>
                                                            @else
                                                                <div id="placeholder_faq1_{{$f->id}}" class="text-center text-muted">
                                                                    <i class="bi bi-image d-block fs-5"></i>
                                                                    <span style="font-size: 8px;" class="fw-bold text-uppercase">Slot 1</span>
                                                                </div>
                                                                <img id="view_faq_img1_{{$f->id}}" src="" class="w-100 h-100 object-fit-cover d-none"> {{-- ซ่อนรูปถ้าไม่มี --}}
                                                            @endif
                                                        </div>

                                                        {{-- ✅ แก้ไขตรงนี้: ใช้สไตล์ d-flex หรือ d-none ตามข้อมูลจริง --}}
                                                        <button id="btn_del_faq1_{{ $f->id }}" 
                                                                class="position-absolute top-0 end-0 border-0 bg-danger text-white rounded-circle {{ $f->faq_image_1 ? 'd-flex' : 'd-none' }} align-items-center justify-content-center shadow-sm" 
                                                                style="width: 20px; height: 20px; font-size: 12px; transform: translate(35%, -35%); z-index: 10;"
                                                                onclick="deleteFaqImage({{ $f->id }}, 1)">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                        
                                                        <input type="file" id="faq_img1_{{$f->id}}" hidden accept="image/*" onchange="updateFaqImage(this, {{ $f->id }}, 1)">
                                                    </div>

                                                    {{-- (ทำแบบเดียวกันกับ Slot 2) --}}
                                                    <div class="faq-img-upload-container position-relative">
                                                        <div class="border rounded bg-light d-flex align-items-center justify-content-center overflow-hidden shadow-sm" 
                                                            style="width: 85px; height: 65px; cursor: pointer; border-style: dashed !important;"
                                                            onclick="document.getElementById('faq_img2_{{$f->id}}').click()">
                                                            
                                                            @if($f->faq_image_2)
                                                                <img id="view_faq_img2_{{$f->id}}" src="{{ asset($f->faq_image_2) }}" class="w-100 h-100 object-fit-cover">
                                                                <div id="placeholder_faq2_{{$f->id}}" class="text-center text-muted d-none">
                                                                    <i class="bi bi-image d-block fs-5"></i>
                                                                    <span style="font-size: 8px;" class="fw-bold text-uppercase">Slot 2</span>
                                                                </div>
                                                            @else
                                                                <div id="placeholder_faq2_{{$f->id}}" class="text-center text-muted">
                                                                    <i class="bi bi-image d-block fs-5"></i>
                                                                    <span style="font-size: 8px;" class="fw-bold text-uppercase">Slot 2</span>
                                                                </div>
                                                                <img id="view_faq_img2_{{$f->id}}" src="" class="w-100 h-100 object-fit-cover d-none">
                                                            @endif
                                                        </div>

                                                        <button id="btn_del_faq2_{{ $f->id }}" 
                                                                class="position-absolute top-0 end-0 border-0 bg-danger text-white rounded-circle {{ $f->faq_image_2 ? 'd-flex' : 'd-none' }} align-items-center justify-content-center shadow-sm" 
                                                                style="width: 20px; height: 20px; font-size: 12px; transform: translate(35%, -35%); z-index: 10;"
                                                                onclick="deleteFaqImage({{ $f->id }}, 2)">
                                                            <i class="bi bi-x"></i>
                                                        </button>
                                                        
                                                        <input type="file" id="faq_img2_{{$f->id}}" hidden accept="image/*" onchange="updateFaqImage(this, {{ $f->id }}, 2)">
                                                    </div>

                                                </div>
                                            </td>

                                            <td class="text-center">
                                                <div class="form-check form-switch d-inline-block p-0">
                                                    <input class="form-check-input custom-switch m-0" type="checkbox" role="switch" 
                                                        id="faq_status_{{ $f->id }}" 
                                                        {{ $f->status == 1 ? 'checked' : '' }}
                                                        onchange="toggleFaqStatus({{ $f->id }}, this)">
                                                </div>
                                                <div class="fw-bold mt-1" id="faq_status_text_{{ $f->id }}" 
                                                    style="font-size: 9px; letter-spacing: 0.5px; color: {{ $f->status == 1 ? '#198754' : '#dc3545' }};">
                                                    {{ $f->status == 1 ? 'ONLINE' : 'OFFLINE' }}
                                                </div>
                                            </td>

                                            <td class="text-end pe-4">
                                                <div class="d-flex justify-content-end gap-2">
                                                    <button class="btn btn-success rounded-pill px-3 fw-bold shadow-sm btn-sm" onclick="updateFaq({{ $f->id }})">บันทึก</button>
                                                    <button class="btn btn-sm btn-outline-danger rounded-circle d-flex align-items-center justify-content-center" 
                                                            onclick="deleteFaq({{ $f->id }})" style="width:32px; height:32px;">
                                                        <i class="bi bi-trash"></i>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr><td colspan="4" class="text-center py-5 text-muted">ยังไม่มีข้อมูลคำถาม</td></tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
/**
 * 🔔 1. ระบบแจ้งเตือน
 */
function showAlert(message, type = 'success') {
    const alertBox = document.getElementById('admin-alert');
    const alertMsg = document.getElementById('alert-message');
    const alertIcon = document.getElementById('alert-icon');
    
    if (!alertBox) {
        alert(message);
        return;
    }
    
    alertMsg.innerText = message;
    const iconClass = (type === 'success') ? "bi-check-circle-fill" : "bi-exclamation-triangle-fill";
    const iconColor = (type === 'success') ? "#28a745" : "#dc3545";
    
    alertIcon.className = `bi ${iconClass}`;
    alertIcon.style.color = iconColor;
    alertBox.style.display = 'block';
    
    setTimeout(() => {
        alertBox.style.display = 'none';
    }, 3000);
}

/**
 * 🛠 2. จัดการตารางราคาและโครงสร้าง
 */
function toggleDeleteMode(productId) {
    const btns = document.querySelectorAll(`.col-del-${productId}, .row-del-${productId}`);
    btns.forEach(el => {
        el.classList.toggle('d-none');
        el.classList.toggle('d-flex'); 
    });
}

function addSizeColumn(btn, productId) {
    const container = document.querySelector(`#priceEdit${productId} .tab-pane.active`);
    const table = container.querySelector('table.table-price-grid');
    if (!table) return;

    const headerRow = table.querySelector('thead tr');
    const newTh = document.createElement('th');
    newTh.className = 'position-relative border-start border-secondary py-3';
    
    // ✅ เพิ่ม class "size-name-input" ให้ตรงกับตัว Validate
    newTh.innerHTML = `
        <input type="text" class="size-name-input bg-transparent border-0 text-white text-center fw-bold" 
               value="" placeholder="ระบุขนาด" 
               style="width: 80px; margin: 0 auto;">
        <div class="delete-col-btn col-del-${productId}" onclick="deleteCol(this)">
            <i class="bi bi-x"></i>
        </div>`;
    
    headerRow.appendChild(newTh);

    // เพิ่มช่องราคาในทุกแถวที่มีอยู่
    table.querySelectorAll('tbody tr').forEach(row => {
        const newCell = row.insertCell(-1);
        newCell.className = 'border-bottom border-start p-0';
        // ✅ เพิ่ม class "input-price-cell" ให้ตรงกับตัว Validate
        newCell.innerHTML = `<input type="number" step="0.01" class="input-price-cell border-0 text-center py-2 w-100" 
                                    value="0" 
                                    style="width: 90px; margin: 0 auto; display: block;">`;
    });
}

function addQtyRow(btn, productId) {
    const container = document.querySelector(`#priceEdit${productId} .tab-pane.active`);
    const table = container.querySelector('table.table-price-grid');
    if (!table) return;

    const theadRow = table.querySelector('thead tr');
    const colCount = theadRow.querySelectorAll('th').length; 
    
    const body = table.querySelector('tbody');
    const newRow = body.insertRow();

    for (let i = 0; i < colCount; i++) {
        const cell = newRow.insertCell(i);
        if (i === 0) {
            // คอลัมน์แรก: ช่องใส่จำนวน
            cell.className = 'bg-light border-bottom border-end fw-bold position-relative';
            // ✅ เพิ่ม class "qty-val-input" ให้ตรงกับตัว Validate
            cell.innerHTML = `
                <div class="delete-row-btn row-del-${productId}" onclick="deleteRow(this)">-</div>
                <input type="number" class="qty-val-input border-0 bg-transparent text-center w-100" 
                       value="" placeholder="จำนวน" 
                       style="width: 60px; margin: 0 auto; display: block;">`;
        } else {
            // คอลัมน์อื่นๆ: ช่องใส่ราคา
            cell.className = 'border-bottom border-start p-0';
            // ✅ เพิ่ม class "input-price-cell" ให้ตรงกับตัว Validate
            cell.innerHTML = `<input type="number" step="0.01" class="input-price-cell border-0 text-center py-2 w-100" 
                                     value="0" 
                                     style="width: 90px; margin: 0 auto; display: block;">`;
        }
    }
}

function deleteCol(btn) {
    const th = btn.closest('th');
    const index = th.cellIndex;
    const table = btn.closest('table'); 
    if (confirm('ยืนยันการลบขนาดนี้?')) {
        Array.from(table.rows).forEach(row => {
            if (row.cells[index]) row.deleteCell(index);
        });
    }
}

function deleteRow(btn) {
    const row = btn.closest('tr');
    const table = btn.closest('table');
    if (confirm('ยืนยันการลบแถวนี้?')) {
        table.deleteRow(row.rowIndex);
    }
}

/**
 * 💾 3. บันทึกตารางราคา (Snapshot Rebuild)
 */
function saveRebuiltTable(productId) {
    const container = document.querySelector(`#priceEdit${productId}`);
    const tables = container.querySelectorAll('table.table-price-grid');
    
    let allData = [];
    let hasError = false;

    // วนลูปเช็คทีละตาราง (ทีละเทคนิค)
    for (const table of tables) {
        if (hasError) break;

        const printId = table.getAttribute('data-print-id');
        
        // หาชื่อ Tab (เทคนิค) เพื่อเอามาแจ้งเตือนให้ชัดเจน
        const tabPane = table.closest('.tab-pane');
        const tabNameInput = document.querySelector(`input[onchange*="updatePrintingName(${printId}"]`); 
        const techniqueName = tabNameInput ? tabNameInput.value : "เทคนิคปัจจุบัน";

        // เช็คว่า Tab นี้ Active อยู่หรือไม่? (ถ้าจะให้แจ้งเตือนเฉพาะ Tab ที่เปิดอยู่)
        // แต่ปกติเราควรเช็คทั้งหมดก่อนบันทึก
        
        const noteInput = tabPane.querySelector('.printing-note-input');
        const noteVal = noteInput ? noteInput.value.trim() : '';

        // ------------------------------------------
        // 1. ตรวจสอบ: หัวตาราง (Size)
        // ------------------------------------------
        let sizesArr = [];
        // ✅ ใช้ selector ให้ตรงกับที่สร้างใน addSizeColumn
        const sizeInputs = table.querySelectorAll('thead th .size-name-input');
        
        // ถ้าไม่มีขนาดเลย -> ข้ามตารางนี้ไป (ถือว่า user ไม่ได้ใช้งานเทคนิคนี้)
        // หรือถ้าคุณต้องการบังคับว่าต้องมี ให้เปิดคอมเมนต์ด้านล่าง
        if (sizeInputs.length === 0) {
             // showAlert(`เทคนิค "${techniqueName}" ยังไม่มีขนาดสินค้า`, 'error');
             // hasError = true; break;
             continue; // ข้ามไป ไม่บันทึก แต่ไม่ Error
        }

        for (const [index, input] of sizeInputs.entries()) {
            const val = input.value.trim();
            if (val === "") {
                showAlert(`[${techniqueName}] กรุณาระบุชื่อ "ขนาด" ในคอลัมน์ที่ ${index + 1}`, 'error');
                // สลับไป Tab ที่มีปัญหา
                const tabId = tabPane.id;
                document.querySelector(`button[data-bs-target="#${tabId}"]`)?.click();
                setTimeout(() => input.focus(), 300);
                
                input.style.border = "2px solid #dc3545"; 
                input.addEventListener('input', () => input.style.border = "none", {once: true});
                hasError = true; break;
            }
            sizesArr.push(val);
        }
        if (hasError) break;

        // ------------------------------------------
        // 2. ตรวจสอบ: แถวและราคา
        // ------------------------------------------
        let gridData = [];
        let usedQtys = new Set();
        const rows = table.querySelectorAll('tbody tr');

        if (rows.length === 0) {
            // ถ้ามีขนาดแล้ว แต่ไม่มีแถวจำนวน -> แจ้งเตือน
            showAlert(`[${techniqueName}] กรุณาเพิ่ม "จำนวน" อย่างน้อย 1 แถว`, 'error');
            const tabId = tabPane.id;
            document.querySelector(`button[data-bs-target="#${tabId}"]`)?.click();
            hasError = true; break;
        }

        for (const [rowIndex, row] of rows.entries()) {
            // 2.1 เช็คจำนวน
            const qtyInput = row.querySelector('.qty-val-input');
            const qtyRaw = qtyInput ? qtyInput.value.trim() : "";
            
            if (qtyRaw === "") {
                showAlert(`[${techniqueName}] แถวที่ ${rowIndex + 1}: กรุณาระบุ "จำนวนชิ้น"`, 'error');
                // สลับ Tab
                const tabId = tabPane.id;
                document.querySelector(`button[data-bs-target="#${tabId}"]`)?.click();
                setTimeout(() => qtyInput.focus(), 300);

                qtyInput.style.borderBottom = "2px solid #dc3545";
                qtyInput.addEventListener('input', () => qtyInput.style.borderBottom = "none", {once: true});
                hasError = true; break;
            }

            const qty = parseInt(qtyRaw);
            if (usedQtys.has(qty)) {
                showAlert(`[${techniqueName}] จำนวน "${qty}" ซ้ำกัน กรุณาแก้ไข`, 'error');
                const tabId = tabPane.id;
                document.querySelector(`button[data-bs-target="#${tabId}"]`)?.click();
                setTimeout(() => qtyInput.focus(), 300);
                
                qtyInput.style.color = "#dc3545";
                hasError = true; break;
            }
            usedQtys.add(qty);

            // 2.2 เช็คราคา
            let prices = [];
            const priceInputs = row.querySelectorAll('.input-price-cell');
            
            for (const [colIndex, pInput] of priceInputs.entries()) {
                const priceRaw = pInput.value.trim();
                
                if (priceRaw === "") {
                    const sizeName = sizesArr[colIndex] || `คอลัมน์ ${colIndex + 1}`;
                    showAlert(`[${techniqueName}] กรุณาระบุราคา (ขนาด: ${sizeName}, จำนวน: ${qty})`, 'error');
                    
                    const tabId = tabPane.id;
                    document.querySelector(`button[data-bs-target="#${tabId}"]`)?.click();
                    setTimeout(() => pInput.focus(), 300);

                    pInput.style.backgroundColor = "#ffe6e6";
                    pInput.addEventListener('input', () => pInput.style.backgroundColor = "transparent", {once: true});
                    
                    hasError = true; break;
                }
                prices.push(parseFloat(priceRaw));
            }
            if (hasError) break;

            gridData.push({ quantity: qty, prices: prices });
        }
        if (hasError) break;

        // ผ่านหมด เก็บข้อมูล
        allData.push({ 
            printing_id: printId, 
            sizes: sizesArr,     
            grid: gridData,
            note: noteVal 
        });
    }

    if (hasError) return;

    // --- ส่วนส่งข้อมูล Custom Fields (เหมือนเดิม) ---
    let customFieldsObj = {};
    const cfContainer = document.getElementById(`custom-fields-container-${productId}`);
    if (cfContainer) {
        cfContainer.querySelectorAll('.custom-field-row').forEach(row => {
            const l = row.querySelector('.extra-label').value.trim();
            const v = row.querySelector('.extra-value').value.trim();
            if (l !== "") customFieldsObj[l] = v;
        });
    }

    showAlert('กำลังบันทึกข้อมูล...', 'success');

    axios.post("{{ route('admin.update') }}", {
        type: 'rebuild_price_table',
        product_id: productId,
        data: allData,
        custom_fields: JSON.stringify(customFieldsObj),
        _token: '{{csrf_token()}}'
    })
    .then(res => { 
        if (res.data.status === 'success') { 
            showAlert('บันทึกข้อมูลราคาทั้งหมดเรียบร้อยแล้ว', 'success'); 
            setTimeout(() => location.reload(), 1000); 
        } 
    })
    .catch(err => {
        console.error(err);
        showAlert('เกิดข้อผิดพลาดในการบันทึก', 'error');
    });
}

/**
 * ⚙️ 4. จัดการสถานะและข้อมูลสินค้า
 */
function toggleProductStatus(productId, element) {
    // เช็คค่าที่ User เพิ่งกดไป
    const isChecked = element.checked;
    const actionName = isChecked ? "เปิด (Online)" : "ปิด (Offline)";

    // 🛑 1. แสดง Confirm Box
    if (confirm(`คุณต้องการ "${actionName}" การแสดงผลสินค้านี้ใช่หรือไม่?`)) {
        
        // ✅ 2. ถ้าตอบ OK -> ส่งข้อมูลไป Server
        const status = isChecked ? 1 : 0;
        const statusText = document.getElementById(`status_text_${productId}`);
       
        axios.post("{{ route('admin.update') }}", {
            type: 'product_status_toggle',
            id: productId,
            status: status,
            _token: '{{csrf_token()}}'
        })
        .then(res => {
            if (res.data.status === 'success') {
                statusText.innerText = isChecked ? 'ONLINE' : 'OFFLINE';
                statusText.className = `small fw-bold ${isChecked ? 'text-success' : 'text-danger'}`;
                showAlert(`สถานะสินค้าถูกเปลี่ยนเป็น ${actionName} แล้ว`);
            }
        })
        .catch(err => {
            console.error(err);
            showAlert('ไม่สามารถเปลี่ยนสถานะได้', 'error');
            element.checked = !isChecked; 
        });

    } else {
        element.checked = !isChecked;
    }
}

function addCustomField(id) {
    // ❌ ของเดิม (ผิด): มันมองหาลูก ซึ่งหาไม่เจอ
    // const list = document.querySelector(`#custom-fields-container-${id} .custom-fields-list`);
    
    // ✅ แก้เป็น (ถูกต้อง): เลือกจาก ID โดยตรงเลย
    const list = document.getElementById(`custom-fields-container-${id}`);

    if (!list) {
        console.error("หา Container ไม่เจอ: custom-fields-container-" + id);
        return;
    }

    const div = document.createElement('div');
    div.className = 'row g-2 mb-3 custom-field-row align-items-center';
    
    div.innerHTML = `
        <div class="col-md-4">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-0 text-muted small fw-bold">หัวข้อ</span>
                <input type="text" class="form-control border-0 bg-light extra-label" placeholder="เช่น น้ำหนัก">
            </div>
        </div>
        <div class="col-md-7">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-light border-0 text-muted small fw-bold">รายละเอียด</span>
                <input type="text" class="form-control border-0 bg-light extra-value" placeholder="ระบุข้อมูล">
            </div>
        </div>
        <div class="col-md-1 text-end">
            <button class="btn btn-link text-danger p-0" onclick="this.closest('.custom-field-row').remove()">
                <i class="bi bi-trash3-fill fs-5"></i>
            </button>
        </div>`;
    
    list.appendChild(div);
}
function saveProductDetails(id) {
    let customFieldsObj = {};
    document.querySelectorAll(`#custom-fields-container-${id} .custom-field-row`).forEach(row => {
        const l = row.querySelector('.extra-label').value.trim();
        const v = row.querySelector('.extra-value').value.trim();
        if (l !== "") customFieldsObj[l] = v;
    });

    axios.post("{{ route('admin.update') }}", {
        type: 'product_details_update',
        id: id,
        moq: document.getElementById('moq_'+id).value,
        packing: document.getElementById('packing_'+id).value,
        production_time: document.getElementById('prod_time_'+id).value,
        free_sample_text: document.getElementById('sample_'+id).value,
        special_features: document.getElementById('special_'+id).value,
        custom_fields: JSON.stringify(customFieldsObj),
        _token: '{{csrf_token()}}'
    }).then(res => {
        if (res.data.status === 'success') { 
            showAlert('อัปเดตสำเร็จ'); 
            setTimeout(() => location.reload(), 1000); 
        }
    }).catch(err => {
        console.error(err);
        showAlert('เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
    });
}

/**
 * 🖼️ 5. ระบบแกลเลอรี่และรูปภาพ
 */
function uploadGallery(input, productId) {
    if (!input.files || input.files.length === 0) return;

    const formData = new FormData();
    formData.append('type', 'gallery_upload');
    formData.append('product_id', productId);
    formData.append('_token', '{{ csrf_token() }}');

    for (let i = 0; i < input.files.length; i++) {
        formData.append('images[]', input.files[i]);
    }

    showAlert('กำลังอัปโหลดรูปภาพ...', 'success');

    axios.post("{{ route('admin.update') }}", formData)
    .then(res => {
        if (res.data.status === 'success') {
            showAlert('อัปโหลดรูปภาพสำเร็จ');
            setTimeout(() => location.reload(), 1000);
        }
    })
    .catch(err => {
        console.error(err);
        showAlert('เกิดข้อผิดพลาดในการอัปโหลด', 'error');
    });
}

// โหลดระบบ Sortable เมื่อหน้าเว็บพร้อม
document.addEventListener('DOMContentLoaded', function() {
    // ระบบ Sortable สำหรับแก้ไขรูปภาพย่อยใน Product Edit
    const el = document.getElementById('image-sortable-container');
    if (el) {
        new Sortable(el, {
            animation: 150,
            ghostClass: 'bg-light',
            onEnd: function() {
                document.querySelectorAll('.order-num').forEach((span, idx) => {
                    span.innerText = idx + 1;
                });
            }
        });
    }

    // 🆕 ระบบ Sortable สำหรับ Gallery Tab (ทุก Tab ของสินค้า)
    document.querySelectorAll('.gallery-sortable-container').forEach(el => {
        new Sortable(el, {
            animation: 150,
            ghostClass: 'bg-light',
            draggable: ".gallery-item", // ลากได้เฉพาะรูปภาพ ไม่โดนปุ่มเพิ่มรูป
            onEnd: function() {}
        });
    });
});

// ฟังก์ชันบันทึกลำดับ Gallery ใหม่
function saveGalleryOrder(productId) {
    const container = document.getElementById(`sortable-gallery-${productId}`);
    if (!container) return;

    const items = container.querySelectorAll('.gallery-item');
    const orderData = [];

    items.forEach((item, index) => {
        orderData.push({
            id: item.getAttribute('data-id'),
            sort_order: index + 1
        });
    });

    if (orderData.length === 0) return;

    showAlert('กำลังบันทึกลำดับรูปภาพ...', 'success');

    axios.post("{{ route('admin.update') }}", {
        type: 'gallery_sort',
        product_id: productId,
        order: orderData,
        _token: '{{csrf_token()}}'
    })
    .then(res => {
        if (res.data.status === 'success') {
            showAlert('จัดลำดับรูปภาพสำเร็จ');
        }
    })
    .catch(err => {
        console.error(err);
        showAlert('เกิดข้อผิดพลาดในการบันทึก', 'error');
    });
}

function saveImageOrder(productId) {
    const container = document.getElementById('image-sortable-container');
    const items = container.querySelectorAll('.image-item');
    const orderData = [];

    items.forEach((item, index) => {
        orderData.push({
            id: item.getAttribute('data-id'),
            sort_order: index + 1
        });
    });

    if (orderData.length === 0) return;

    axios.post("{{ route('admin.update') }}", {
        type: 'product_images_sort',
        product_id: productId,
        order: orderData,
        _token: '{{csrf_token()}}'
    })
    .then(res => {
        if (res.data.status === 'success') {
            showAlert('จัดลำดับรูปภาพย่อยสำเร็จ');
        }
    });
}

function updateProductImage(input, imageId) {
    if (!input.files || !input.files[0]) return;

    const formData = new FormData();
    formData.append('type', 'product_image_update');
    formData.append('image_id', imageId);
    formData.append('image', input.files[0]);
    formData.append('_token', '{{ csrf_token() }}');

    showAlert('กำลังอัปโหลดรูปภาพใหม่...', 'success');

    axios.post("{{ route('admin.update') }}", formData)
    .then(res => {
        if(res.data.status === 'success') {
            const reader = new FileReader();
            reader.onload = e => {
                document.getElementById('img_view_' + imageId).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
            showAlert('เปลี่ยนรูปภาพสำเร็จ');
        }
    })
    .catch(err => {
        console.error(err);
        showAlert('เกิดข้อผิดพลาดในการอัปโหลด', 'error');
    });
}

function updateFaqImage(input, faqId, slotNum) {
    if (!input.files || !input.files[0]) return;

    const formData = new FormData();
    formData.append('type', 'faq_image_update');
    formData.append('faq_id', faqId);
    formData.append('slot', slotNum);
    formData.append('image', input.files[0]);
    formData.append('_token', '{{ csrf_token() }}');

    showAlert(`กำลังอัปโหลดรูปภาพที่ ${slotNum}...`, 'success');

    axios.post("{{ route('admin.update') }}", formData)
    .then(res => {
        if(res.data.status === 'success') {
            const imgEl = document.getElementById(`view_faq_img${slotNum}_${faqId}`);
            const holderEl = document.getElementById(`placeholder_faq${slotNum}_${faqId}`);
            const delBtn = document.getElementById(`btn_del_faq${slotNum}_${faqId}`);

            if(imgEl) {
                imgEl.src = res.data.path + '?v=' + new Date().getTime();
                imgEl.classList.remove('d-none');
            }
            if(holderEl) {
                holderEl.classList.add('d-none');
            }
            if(delBtn) {
                delBtn.classList.remove('d-none');
                delBtn.classList.add('d-flex');
                delBtn.style.setProperty('display', 'flex', 'important');
            }
            showAlert('อัปเดตภาพประกอบสำเร็จ', 'success');
        }
    })
    .catch(err => {
        console.error(err);
        showAlert('เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ', 'error');
    });
}

function deleteFaqImage(faqId, slotNum) {
    if(!confirm(`ยืนยันการลบรูปภาพที่ ${slotNum}?`)) return;

    axios.post("{{ route('admin.update') }}", {
        type: 'faq_image_delete',
        faq_id: faqId,
        slot: slotNum,
        _token: '{{ csrf_token() }}'
    })
    .then(res => {
        if(res.data.status === 'success') {
            const imgEl = document.getElementById(`view_faq_img${slotNum}_${faqId}`);
            if(imgEl) {
                imgEl.src = "";
                imgEl.classList.add('d-none');
            }
            const holderEl = document.getElementById(`placeholder_faq${slotNum}_${faqId}`);
            if(holderEl) {
                holderEl.classList.remove('d-none');
            }
            const delBtn = document.getElementById(`btn_del_faq${slotNum}_${faqId}`);
            if(delBtn) {
                delBtn.classList.remove('d-flex'); 
                delBtn.classList.add('d-none');    
                delBtn.style.setProperty('display', 'none', 'important');
            }
            showAlert('ลบรูปภาพสำเร็จ');
        }
    })
    .catch(err => {
        console.error(err);
        showAlert('เกิดข้อผิดพลาดในการลบรูปภาพ', 'error');
    });
}

function toggleFaqStatus(id, element) {
    const isChecked = element.checked;
    const actionName = isChecked ? "เปิด (Online)" : "ปิด (Offline)";

    if (confirm(`ยืนยันการ "${actionName}" คำถามข้อนี้?`)) {
        
        const statusVal = isChecked ? 1 : 0;
        const statusText = document.getElementById(`faq_status_text_${id}`);

        axios.post("{{ route('admin.update') }}", {
            type: 'faq_status_toggle', 
            id: id,
            status: statusVal,
            _token: '{{csrf_token()}}'
        })
        .then(res => {
            if(res.data.status === 'success') {
                if(statusText) {
                    statusText.innerText = isChecked ? 'ONLINE' : 'OFFLINE';
                    statusText.style.color = isChecked ? '#198754' : '#dc3545';
                }
                showAlert('อัปเดตสถานะ FAQ สำเร็จ');
            } else {
                element.checked = !isChecked; // Revert if logic fail
            }
        })
        .catch(err => {
            console.error(err);
            showAlert('เกิดข้อผิดพลาดในการเชื่อมต่อ', 'error');
            element.checked = !isChecked; // Revert on error
        });

    } else {
        // User กด Cancel -> ดีดปุ่มกลับ
        element.checked = !isChecked;
    }
}

function updateFaq(id) {
    const card = document.getElementById(`faq-item-${id}`);
    const q = card.querySelector('.faq-question').value;
    const a = card.querySelector('.faq-answer').value;

    axios.post("{{ route('admin.update') }}", {
        type: 'faq_update',
        id: id,
        question: q,
        answer: a,
        _token: '{{csrf_token()}}'
    }).then(res => {
        if(res.data.status === 'success') showAlert('บันทึกข้อมูลเรียบร้อย');
    }).catch(err => {
        console.error(err);
        showAlert('เกิดข้อผิดพลาดในการบันทึกข้อมูล', 'error');
    });
}

function addNewFaq() {
    axios.post("{{ route('admin.update') }}", {
        type: 'faq_add',
        _token: '{{csrf_token()}}'
    }).then(() => {
        location.reload();
    });
}

function deleteFaq(id) {
    if(!confirm('ยืนยันการลบคำถามนี้?')) return;
    axios.post("{{ route('admin.update') }}", {
        type: 'faq_delete',
        id: id,
        _token: '{{csrf_token()}}'
    }).then(() => {
        const el = document.getElementById(`faq-item-${id}`);
        if(el) el.remove();
        showAlert('ลบข้อมูลสำเร็จ');
    });
}

/**
 * 🔧 6. ฟังก์ชันเสริมอื่นๆ
 */
function saveP(id) {
    const n = document.getElementById('n_'+id).value;
    const m = document.getElementById('m_'+id).value;
    axios.post("{{ route('admin.update') }}", {
        type: 'product_update', 
        id: id, 
        name: n, 
        base_material: m, 
        _token: '{{csrf_token()}}'
    }).then(() => showAlert('อัปเดตข้อมูลสำเร็จ'));
}

function addPrintingType(productId) {
    const name = prompt("ชื่อเทคนิคใหม่:");
    if (!name) return;
    axios.post("{{ route('admin.update') }}", { 
        type: 'printing_add', 
        product_id: productId, 
        printing_name: name, 
        _token: '{{csrf_token()}}' 
    }).then(() => location.reload());
}

function updatePrintingName(id, name) {
    axios.post("{{ route('admin.update') }}", { type: 'printing_name_update', id: id, name: name, _token: '{{csrf_token()}}' });
}

function updatePrintingNote(id, note) {
    const inputEl = document.activeElement;
    const originalBorder = inputEl.style.borderColor;
    inputEl.style.borderColor = "#ffc107"; // สีเหลืองตอนกำลังส่ง

    axios.post("{{ route('admin.update') }}", { 
        type: 'printing_note_update', 
        id: id, 
        note: note, 
        _token: '{{csrf_token()}}' 
    })
    .then(res => {
        if(res.data.status === 'success') {
            inputEl.style.borderColor = "#198754"; 
            setTimeout(() => {
                inputEl.style.borderColor = originalBorder; 
            }, 1500);

        }
    })
    .catch(err => {
        console.error(err);
        inputEl.style.borderColor = "#dc3545"; // สีแดงเมื่อพัง
        showAlert('เกิดข้อผิดพลาดในการบันทึกหมายเหตุ', 'error');
    });
}

function deletePrintingType(id, name) {
    if (confirm(`คุณต้องการลบเทคนิค "${name}" ใช่หรือไม่?`)) {
        axios.post("{{ route('admin.update') }}", { type: 'printing_delete', id: id, _token: '{{csrf_token()}}' }).then(() => location.reload());
    }
}

function delG(id) {
    if (!confirm('ยืนยันการลบรูปภาพ?')) return;
    axios.post("{{ route('admin.update') }}", {type: 'gallery_delete', id: id, _token: '{{csrf_token()}}'}).then(() => { 
        const el = document.getElementById('g-' + id);
        if (el) el.remove(); 
    });
}

function addPart(productId) {
    axios.post("{{ route('admin.update') }}", {
        type: 'part_add', 
        product_id: productId, 
        _token: '{{csrf_token()}}'
    })
    .then(res => {
        if (res.data.status === 'success') {

            showAlert('เพิ่มอุปกรณ์เสริมใหม่เรียบร้อยแล้ว', 'success');
            
            setTimeout(() => location.reload(), 1000); 
        } else {
            showAlert('ไม่สามารถเพิ่มอุปกรณ์เสริมได้', 'error');
        }
    })
    .catch(err => {
        console.error(err);
        showAlert('เกิดข้อผิดพลาดในการเชื่อมต่อ Server', 'error');
    });
}

function updatePart(id) {
    // 1. ดึง Element มาเก็บไว้ในตัวแปร
    const nameInput = document.getElementById('p_name_' + id);
    const priceInput = document.getElementById('p_price_' + id);
    const fileInput = document.getElementById('file_' + id);
    const previewImg = document.getElementById('preview_' + id);

    // ดึงค่า
    const nameVal = nameInput.value.trim();
    const priceVal = priceInput.value.trim();

    // =========================================================
    // 🛡️ ส่วนตรวจสอบเงื่อนไข (Validation)
    // =========================================================

    // เงื่อนไขที่ 1: ชื่ออุปกรณ์ห้ามว่าง
    if (nameVal === '' || nameVal === 'อุปกรณ์ใหม่ (รอแก้ไข)') {
        showAlert('กรุณาระบุ "ชื่ออุปกรณ์เสริม" ให้ถูกต้อง', 'error');
        nameInput.focus();
        nameInput.style.borderBottom = "2px solid #dc3545"; // ขีดเส้นแดง
        return; // ❌ หยุดการทำงานทันที ไม่ส่งข้อมูล
    } else {
        nameInput.style.borderBottom = "1px solid #eee"; // คืนค่าเส้นปกติ
    }

    // เงื่อนไขที่ 2: ราคาห้ามว่าง และต้องเป็นตัวเลข
    if (priceVal === '' || isNaN(priceVal)) {
        showAlert('กรุณาระบุ "ราคา" เป็นตัวเลข', 'error');
        priceInput.focus();
        priceInput.style.borderBottom = "2px solid #dc3545"; 
        return; // ❌ หยุดการทำงานทันที
    } else {
        priceInput.style.borderBottom = "1px solid #eee";
    }

    // เงื่อนไขที่ 3: (ถ้าต้องการบังคับ) ตรวจสอบว่ามีรูปภาพหรือยัง?
    // เช็คว่าไม่มีไฟล์ใหม่ที่เลือก AND รูปปัจจุบันยังเป็น Placeholder (No Image) อยู่
    // (ถ้าคุณไม่ต้องการบังคับรูป ให้ลบเงื่อนไขนี้ออกได้ครับ)
    if (fileInput.files.length === 0 && previewImg.src.includes('No+Image')) {
        showAlert('กรุณาอัปโหลด "รูปภาพประกอบ" ด้วยครับ', 'error');
        // ทำเอฟเฟกต์กระพริบที่ปุ่มกล้อง
        const cameraBtn = document.querySelector(`label[for="file_${id}"]`);
        if(cameraBtn) {
            cameraBtn.style.backgroundColor = "red";
            setTimeout(() => cameraBtn.style.backgroundColor = "rgba(0,0,0,0.5)", 500);
        }
        return; // ❌ หยุดการทำงานทันที
    }

    // =========================================================
    // 🚀 ส่วนส่งข้อมูลไป Server
    // =========================================================
    const formData = new FormData();
    formData.append('type', 'part_update');
    formData.append('id', id);
    formData.append('part_name', nameVal);
    formData.append('color', document.getElementById('p_color_' + id).value);
    formData.append('price_extra', priceVal);
    formData.append('_token', '{{csrf_token()}}');
    
    if (fileInput.files[0]) {
        formData.append('image', fileInput.files[0]);
    }
    
    showAlert('กำลังบันทึกข้อมูล...', 'success');

    axios.post("{{ route('admin.update') }}", formData)
    .then(res => { 
        // ✅ เช็ค Response จาก Server ก่อนบอกว่าสำเร็จ
        if (res.data.status === 'success') {
            showAlert('อัปเดตข้อมูลสำเร็จ'); 
            setTimeout(() => location.reload(), 1000); 
        } else {
            // กรณี Server ตอบกลับมาว่ามี Error (เช่น ไฟล์ใหญ่เกิน, นามสกุลผิด)
            showAlert(res.data.message || 'เกิดข้อผิดพลาดในการบันทึก', 'error');
        }
    })
    .catch(err => {
        console.error(err);
        showAlert('เกิดข้อผิดพลาดในการเชื่อมต่อ Server', 'error');
    });
}

function delPart(id) {
    if (confirm('ยืนยันการลบอุปกรณ์เสริม?')) {
        axios.post("{{ route('admin.update') }}", {type: 'part_delete', id: id, _token: '{{csrf_token()}}'}).then(() => { 
            const el = document.getElementById('part-' + id);
            if (el) el.remove(); 
        });
    }
}

function previewImg(input, id) {
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = e => { 
            const preview = document.getElementById('preview_' + id);
            if (preview) preview.src = e.target.result; 
        };
        reader.readAsDataURL(input.files[0]);
    }
}

document.addEventListener('input', e => {
    if (e.target.tagName === 'TEXTAREA') {
        e.target.style.height = 'auto';
        e.target.style.height = e.target.scrollHeight + 'px';
    }
});

function viewContactDetail(contact) {
    // 1. จัดการส่วนหัวข้อ (Subjects) - รองรับทั้ง Array และ JSON String
    let subjects = [];
    try {
        subjects = (typeof contact.subjects === 'string') ? JSON.parse(contact.subjects) : contact.subjects;
    } catch (e) {
        subjects = [contact.subjects];
    }
    
    // สร้าง HTML Badges สำหรับแสดงใน Modal
    const subjectHtml = Array.isArray(subjects) 
        ? subjects.map(s => `<span class="badge bg-warning text-dark me-1 px-3 py-2 rounded-pill">${s}</span>`).join('') 
        : `<span class="badge bg-warning text-dark px-3 py-2 rounded-pill">${subjects}</span>`;

    // 2. จัดรูปแบบวันที่ให้เป็นภาษาไทย
    const dateObj = new Date(contact.created_at);
    const dateStr = dateObj.toLocaleDateString('th-TH', {
        year: 'numeric',
        month: 'long',
        day: 'numeric',
    }) + ' เวลา ' + dateObj.toLocaleTimeString('th-TH', { hour: '2-digit', minute: '2-digit' }) + ' น.';

    // 3. หยอดข้อมูลพื้นฐานลงใน Modal
    document.getElementById('modal_contact_name').innerText = contact.name || 'ไม่ระบุชื่อ';
    document.getElementById('modal_contact_email').innerText = contact.email || '-';
    document.getElementById('modal_contact_phone').innerText = contact.phone || '-';
    document.getElementById('modal_contact_subject').innerHTML = subjectHtml; // ใช้ innerHTML เพราะมี tags
    document.getElementById('modal_contact_date').innerText = dateStr;
    document.getElementById('modal_contact_message').innerText = contact.message || '-';

    // 4. จัดการส่วนไฟล์แนบ (Attachments)
    const attachContainer = document.getElementById('modal_attachments_container');
    const attachList = document.getElementById('modal_attachments_list');
    attachList.innerHTML = ''; // ล้างข้อมูลเก่าออกก่อน

    let attachments = [];
    try {
        attachments = (typeof contact.attachments === 'string') ? JSON.parse(contact.attachments) : contact.attachments;
    } catch (e) {
        console.error("Error parsing attachments:", e);
    }

    if (attachments && Array.isArray(attachments) && attachments.length > 0) {
        attachContainer.classList.remove('d-none'); // แสดงส่วนไฟล์แนบ
        attachments.forEach(path => {
            // ดึงชื่อไฟล์ออกมาจาก path
            const fileName = path.split('/').pop(); 
            
            // สร้าง Element สำหรับลิงก์ดาวน์โหลด
            const link = document.createElement('a');
            link.href = `/storage/${path}`; 
            link.target = '_blank';
            link.className = 'btn btn-light border btn-sm rounded-pill d-flex align-items-center text-decoration-none text-dark px-3 py-2 mt-1';
            link.style.fontSize = '12px';
            link.innerHTML = `<i class="bi bi-file-earmark-arrow-down text-primary me-2 fs-6"></i> ${fileName}`;
            
            attachList.appendChild(link);
        });
    } else {
        attachContainer.classList.add('d-none');
    }


    const contactModalElement = document.getElementById('contactDetailModal');
    const myModal = new bootstrap.Modal(contactModalElement);
    myModal.show();
}
</script>
@endsection