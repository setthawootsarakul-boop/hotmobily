@extends('layouts.main')

@section('title', 'แจ้งชำระเงิน - Hotmobily')

@section('content')
<div class="payment-outer-wrapper">
    <div class="page-container">
        <h1 class="payment-main-headline">แจ้งชำระเงิน</h1>

        {{-- 1. ส่วนแสดงข้อความแจ้งเตือนสำเร็จหรือข้อผิดพลาด --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4 rounded-3" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger rounded-3 mb-4">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="payment-content-card">
            <div class="row g-0">
                <div class="col-lg-5 payment-info-column">
                    <div class="info-content-padding">
                        <h4 class="info-question-text">หากมีคำถาม ข้อสงสัย หรือ<br>ต้องการความช่วยเหลือ สามารถติดต่อเราได้ที่</h4>
                        
                        <div class="contact-methods-flex">
                            <div class="contact-pills-container">
                                <div class="contact-pill-box"><i class="bi bi-telephone-fill"></i> 064-604-5614</div>
                                <div class="contact-pill-box"><i class="bi bi-telephone-fill"></i> 02-637-8995</div>
                                <div class="contact-pill-box"><i class="bi bi-telephone-fill"></i> 02-637-8997</div>
                            </div>

                            <div class="line-qr-wrapper">
                                <a href="https://line.me/R/ti/p/@842kcbjl?oat__id=4123351#~" target="_blank" class="line-link-wrapper">
                                    <img src="{{ asset('images/line-qr.png') }}" alt="Line QR" class="line-qr-img">
                                    <p class="line-id-text">Line : hotstrapthai</p>
                                </a>
                            </div>
                        </div>

                        <p class="office-hours-text">เวลาทำการ : จันทร์-ศุกร์ (08:30-17:30 น.)</p>

                        <div class="sidebar-bank-card">
                            <img src="{{ asset('images/scb-mobile.png') }}" alt="SCB Account" class="scb-img">
                            <button type="button" class="payment-copy-btn">คัดลอก</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 payment-form-column">
                    {{-- 2. อัปเดต action และเพิ่ม enctype เพื่อให้ส่งรูปภาพได้ --}}
                    <form action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data" class="payment-main-form">
                        @csrf
                        
                        <div class="custom-input-group">
                            <label>หมายเลขคำสั่งซื้อ (Order ID) <span class="req">*</span></label>
                            <input type="text" name="order_id" value="{{ old('order_id') }}" required>
                        </div>

                        <div class="custom-input-group">
                            <label>ชื่อ - นามสกุล <span class="req">*</span></label>
                            <input type="text" name="name" value="{{ old('name') }}" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 custom-input-group">
                                <label>อีเมล <span class="req">*</span></label>
                                <input type="email" name="email" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6 custom-input-group">
                                <label>เบอร์โทรศัพท์ <span class="req">*</span></label>
                                <input type="text" name="phone" value="{{ old('phone') }}" required>
                            </div>
                        </div>

                        <div class="custom-input-group">
                            <label>ยอดเงินที่โอน <span class="req">*</span></label>
                            <input type="number" step="0.01" name="amount" value="{{ old('amount') }}" required>
                        </div>

                        <div class="custom-input-group">
                            <label>วันที่ทำรายการ <span class="req">*</span></label>
                            <input type="date" name="transfer_date" value="{{ old('transfer_date') }}" required>
                        </div>

                        <div class="custom-input-group">
                            <label>เวลาที่ทำรายการ <span class="req">*</span></label>
                            <input type="time" name="transfer_time" value="{{ old('transfer_time') }}" required>
                        </div>

                        <div class="custom-input-group">
                            <label>หลักฐานการชำระเงิน (pdf, jpg, png หรือ gif) <span class="req">*</span></label>
                            <div class="slip-upload-area" id="drop-zone">
                                {{-- 3. เพิ่ม name="slip" และ id เพื่อใช้แสดงชื่อไฟล์ใน JS --}}
                                <input type="file" name="slip" id="slip-file" hidden required accept="image/*,.pdf">
                                <label for="slip-file">
                                    <i class="bi bi-upload"></i>
                                    <p id="file-name-text">วางไฟล์ตรงนี้ หรือคลิกเพื่อแนบไฟล์</p>
                                </label>
                            </div>
                        </div>

                        <div class="custom-input-group">
                            <label>ข้อความเพิ่มเติม (ถ้ามี)</label>
                            <input type="text" name="note" value="{{ old('note') }}">
                        </div>

                        <div class="custom-input-group mb-4">
                            <div class="g-recaptcha" 
                                data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" 
                                data-callback="enableSubmitBtn" 
                                data-expired-callback="disableSubmitBtn">
                            </div>
                            @if ($errors->has('g-recaptcha-response'))
                                <span class="text-danger small">{{ $errors->first('g-recaptcha-response') }}</span>
                            @endif
                        </div>

                        <div class="submit-btn-wrapper">
                            <button type="submit" id="submitBtn" class="btn-confirm-payment" disabled style="opacity: 0.5; cursor: not-allowed;">
                                ยืนยันการชำระเงิน
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="articles-section">
            <h2 class="articles-title">บทความที่คุณอาจสนใจ</h2>
            <div class="articles-list">
                <a href="{{ route('order-guide') }}" class="article-row"><span>ขั้นตอนการสั่งซื้อสินค้า</span></a>
                <a href="{{ route('design-guide') }}" class="article-row"><span>วิธีการออกแบบ</span></a>
                <a href="{{ route('payment-method') }}#section4" class="article-row"><span>วิธีการยกเลิกคำสั่งซื้อ</span></a>
                <a href="{{ route('payment-method') }}#section3" class="article-row"><span>การจัดส่งสินค้า</span></a>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function enableSubmitBtn() {
        const btn = document.getElementById('submitBtn');
        if(btn) {
            btn.disabled = false;
            btn.style.opacity = "1";
            btn.style.cursor = "pointer";
        }
    }

    function disableSubmitBtn() {
        const btn = document.getElementById('submitBtn');
        if(btn) {
            btn.disabled = true;
            btn.style.opacity = "0.5";
            btn.style.cursor = "not-allowed";
        }
    }

    // ฟังก์ชัน Loading ขณะส่งข้อมูล
    document.querySelector('.payment-main-form').onsubmit = function() {
        const btn = document.getElementById('submitBtn');
        if(btn) {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> กำลังประมวลผล...';
            btn.style.opacity = "0.7";
        }
    };

  document.addEventListener('DOMContentLoaded', function() {
    const copyBtn = document.querySelector('.payment-copy-btn');
    
    if (copyBtn) {
      copyBtn.addEventListener('click', function() {
        const accountNumber = '1912139535'; 

        function copyToClipboard(text) {
          if (navigator.clipboard && window.isSecureContext) {
            return navigator.clipboard.writeText(text);
          } else {
            // ใช้ Textarea เป็นตัวช่วยหากเป็น HTTP ธรรมดา
            let textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.position = "fixed";
            textArea.style.left = "-999999px";
            textArea.style.top = "-999999px";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            return new Promise((res, rej) => {
              document.execCommand('copy') ? res() : rej();
              textArea.remove();
            });
          }
        }

        copyToClipboard(accountNumber).then(() => {
          const originalText = copyBtn.innerText;
          copyBtn.innerText = 'คัดลอกแล้ว ✓';
          
          
          setTimeout(() => {
            copyBtn.innerText = originalText;
            copyBtn.style.backgroundColor = ''; // คืนค่าสีเดิม
          }, 2000);
        }).catch(err => {
          console.error('ไม่สามารถคัดลอกได้', err);
          alert('ไม่สามารถคัดลอกอัตโนมัติได้ กรุณาคัดลอกด้วยตัวเอง: ' + accountNumber);
        });
      });
    }

    // ระบบแสดงชื่อไฟล์ (โค้ดเดิมของคุณ)
    const fileInput = document.getElementById('slip-file');
    const fileNameText = document.getElementById('file-name-text');
    const dropZone = document.getElementById('drop-zone');

    if (fileInput) {
      fileInput.addEventListener('change', function(e) {
        if (this.files && this.files.length > 0) {
          fileNameText.innerText = 'ไฟล์ที่เลือก: ' + this.files[0].name;
          if(dropZone) dropZone.style.borderColor = '#FFD93D';
        }
      });
    }
  });
</script>
@endpush