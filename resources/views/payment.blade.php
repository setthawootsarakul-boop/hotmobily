@extends('layouts.main')

@section('title', 'แจ้งชำระเงิน - Hotmobily')

@section('content')
<div class="payment-page-wrapper">
    <div class="page-container">
        <h1 class="payment-main-title">แจ้งชำระเงิน</h1>

        <div class="payment-grid">
            <div class="payment-info-side">
                <div class="payment-contact-box">
                    <h3>หากมีคำถาม ข้อสงสัย หรือ<br>ต้องการความช่วยเหลือ สามารถติดต่อเราได้ที่</h3>
                    <div class="payment-contact-list">
                        <div class="contact-item"><i class="bi bi-telephone-fill"></i> 064-604-5614</div>
                        <div class="contact-item"><i class="bi bi-telephone-fill"></i> 02-637-8995</div>
                        <div class="contact-item"><i class="bi bi-telephone-fill"></i> 02-637-8997</div>
                    </div>
                    <div class="payment-qr-line">
                        <img src="{{ asset('images/line-qr.png') }}" alt="Line QR">
                        <p>Line : hotstrapthai</p>
                    </div>
                    <p class="payment-work-time">เวลาทำการ : จันทร์-ศุกร์ (08:30-17:30 น.)</p>
                </div>

                <div class="payment-bank-card">
                    <img src="{{ asset('images/scb-bank-info.png') }}" alt="SCB Account" class="bank-info-img">
                    <div class="copy-action">
                        <input type="hidden" id="accountNumber" value="1912139535">
                        <button onclick="copyAccount()" class="btn-copy-acc">คัดลอกเลขบัญชี</button>
                    </div>
                </div>
            </div>

            <div class="payment-form-side">
                <form action="#" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="payment-input-group">
                        <label>หมายเลขคำสั่งซื้อ (Order ID) <span class="text-danger">*</span></label>
                        <input type="text" name="order_id" required placeholder="เช่น #12345">
                    </div>

                    <div class="payment-input-group">
                        <label>ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                        <input type="text" name="name" required>
                    </div>

                    <div class="payment-row">
                        <div class="payment-input-group">
                            <label>อีเมล <span class="text-danger">*</span></label>
                            <input type="email" name="email" required>
                        </div>
                        <div class="payment-input-group">
                            <label>เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                            <input type="text" name="phone" required>
                        </div>
                    </div>

                    <div class="payment-input-group">
                        <label>ยอดเงินที่โอน <span class="text-danger">*</span></label>
                        <input type="number" step="0.01" name="amount" required>
                    </div>

                    <div class="payment-row">
                        <div class="payment-input-group">
                            <label>วันที่ทำการโอน <span class="text-danger">*</span></label>
                            <input type="date" name="transfer_date" required>
                        </div>
                        <div class="payment-input-group">
                            <label>เวลาที่ทำการโอน <span class="text-danger">*</span></label>
                            <input type="time" name="transfer_time" required>
                        </div>
                    </div>

                    <div class="payment-input-group">
                        <label>หลักฐานการชำระเงิน (pdf, jpg, png หรือ gif) <span class="text-danger">*</span></label>
                        <div class="payment-upload-zone">
                            <input type="file" name="slip" id="slipInput" required hidden>
                            <label for="slipInput" class="upload-label">
                                <i class="bi bi-upload"></i>
                                <p>วางไฟล์ตรงนี้ หรือคลิกเพื่อแนบไฟล์</p>
                            </label>
                        </div>
                    </div>

                    <div class="payment-input-group">
                        <label>ข้อความเพิ่มเติม (ถ้ามี)</label>
                        <textarea name="note" rows="3"></textarea>
                    </div>

                    <button type="submit" class="btn-payment-submit">ยืนยันการชำระเงิน</button>
                </form>
            </div>
        </div>

        <div class="payment-faq-section">
            <div class="payment-faq-grid">
                <div class="faq-card">
                    <img src="{{ asset('images/faq-order.png') }}" alt="ขั้นตอนการสั่งซื้อ">
                    <h4>ขั้นตอนการสั่งซื้อสินค้า</h4>
                </div>
                <div class="faq-card">
                    <img src="{{ asset('images/faq-design.png') }}" alt="วิธีการออกแบบ">
                    <h4>วิธีการออกแบบ</h4>
                </div>
                <div class="faq-card">
                    <img src="{{ asset('images/faq-cancel.png') }}" alt="การยกเลิก">
                    <h4>วิธีการยกเลิกคำสั่งซื้อ</h4>
                </div>
                <div class="faq-card">
                    <img src="{{ asset('images/faq-shipping.png') }}" alt="การจัดส่ง">
                    <h4>การจัดส่งสินค้า</h4>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function copyAccount() {
        var copyText = document.getElementById("accountNumber").value;
        navigator.clipboard.writeText(copyText).then(() => {
            alert("คัดลอกเลขบัญชี: " + copyText + " เรียบร้อยแล้ว");
        });
    }
</script>
@endpush