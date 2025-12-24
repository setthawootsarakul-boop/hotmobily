@extends('layouts.main')

@section('title', 'แจ้งชำระเงิน - Hotmobily')

@push('styles')
    <link href="{{ asset('css/payment-page.css') }}" rel="stylesheet">
@endpush

@section('content')
<div class="payment-section">
    <div class="page-container">
        <h1 class="payment-title">แจ้งชำระเงิน</h1>

        <div class="payment-card-container">
            <div class="row g-0">
                <div class="col-lg-5 payment-meta-info">
                    <div class="info-inner">
                        <h4 class="info-headline">หากมีคำถาม ข้อสงสัย หรือ<br>ต้องการความช่วยเหลือ สามารถติดต่อเราได้ที่</h4>
                        
                        <div class="contact-pills">
                            <div class="pill-item"><i class="bi bi-telephone"></i> 064-604-5614</div>
                            <div class="pill-item"><i class="bi bi-telephone"></i> 02-637-8995</div>
                            <div class="pill-item"><i class="bi bi-telephone"></i> 02-637-8997</div>
                        </div>

                        <div class="line-contact-box">
                            <img src="{{ asset('images/line-qr.png') }}" alt="Line QR" class="qr-img">
                            <span class="line-id">Line : hotstrapthai</span>
                        </div>

                        <p class="working-hours">เวลาทำการ : จันทร์-ศุกร์ (08:30-17:30 น.)</p>

                        <div class="bank-display-card">
                            <img src="{{ asset('images/scb-bank-info.png') }}" alt="SCB" class="bank-img">
                            <button onclick="copyAccount('1912139535')" class="btn-copy-overlay">คัดลอก</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 payment-form-container">
                    <form action="#" method="POST" class="payment-form">
                        @csrf
                        <div class="form-group-custom">
                            <label>หมายเลขคำสั่งซื้อ (Order ID) <span class="req">*</span></label>
                            <input type="text" name="order_id" placeholder="ระบุหมายเลขคำสั่งซื้อ" required>
                        </div>

                        <div class="form-group-custom">
                            <label>ชื่อ - นามสกุล <span class="req">*</span></label>
                            <input type="text" name="name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group-custom">
                                <label>อีเมล <span class="req">*</span></label>
                                <input type="email" name="email" required>
                            </div>
                            <div class="col-md-6 form-group-custom">
                                <label>เบอร์โทรศัพท์ <span class="req">*</span></label>
                                <input type="text" name="phone" required>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label>ยอดเงินที่โอน <span class="req">*</span></label>
                            <input type="number" step="0.01" name="amount" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 form-group-custom">
                                <label>วันที่ทำรายการ <span class="req">*</span></label>
                                <input type="date" name="transfer_date" required>
                            </div>
                            <div class="col-md-6 form-group-custom">
                                <label>เวลาที่ทำรายการ <span class="req">*</span></label>
                                <input type="time" name="transfer_time" required>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label>หลักฐานการชำระเงิน (pdf, jpg, png หรือ gif) <span class="req">*</span></label>
                            <div class="custom-file-upload" id="drop-area">
                                <input type="file" name="slip" id="file-input" hidden required>
                                <label for="file-input">
                                    <i class="bi bi-upload"></i>
                                    <span>วางไฟล์ตรงนี้ หรือคลิกเพื่อแนบไฟล์</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-group-custom">
                            <label>ข้อความเพิ่มเติม (ถ้ามี)</label>
                            <textarea name="note" rows="3"></textarea>
                        </div>

                        <button type="submit" class="btn-submit-payment">ยืนยันการชำระเงิน</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="payment-articles-section">
            <h2 class="section-title">บทความที่คุณอาจสนใจ</h2>
            <div class="article-list">
                <a href="#" class="article-item">
                    <span>ขั้นตอนการสั่งซื้อสินค้า</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="#" class="article-item">
                    <span>วิธีการออกแบบ</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="#" class="article-item">
                    <span>วิธีการยกเลิกคำสั่งซื้อ</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
                <a href="#" class="article-item">
                    <span>การจัดส่งสินค้า</span>
                    <i class="bi bi-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyAccount(accNo) {
        navigator.clipboard.writeText(accNo).then(() => {
            alert('คัดลอกเลขบัญชี ' + accNo + ' แล้ว');
        });
    }
</script>
@endpush