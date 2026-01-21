@extends('layouts.main')

@section('title', 'ติดต่อเรา - Hotmobily')

@section('content')

<div class="contact-full-page">
    <div class="container-xxl">
        <h2 class="contact-main-title">ติดต่อเรา</h2>

        <div class="contact-flex-wrapper">
            {{-- ฝั่งซ้าย: ข้อมูลติดต่อ --}}
            <div class="contact-info-side">
                <div class="company-brand-header">
                    <img src="{{ asset('images/logo.png') }}" alt="Hotmobily" class="brand-logo-img">
                    <div class="brand-text">
                        <strong>บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</strong>
                    </div>
                </div>
                
                <p class="address-detail">
                    23/34-35 อาคารโครงการเดอะไพร์ม หัวลำโพง อาคาร A<br>
                    ห้องเลขที่ 404 ชั้นที่ 4 ซอยสุกร แขวงตลาดน้อย<br>
                    เขตสัมพันธวงศ์ กรุงเทพมหานคร 10100
                </p>
                <p class="work-time">เวลาทำการ : จันทร์-ศุกร์ (08:30-17:30 น.)</p>

                <div class="contact-and-qr-wrapper">
                    <div class="contact-channels">
                        <div class="channel-item">
                            <div class="icon-bg-green"><i class="fas fa-phone"></i></div> 
                            064-604-5614
                        </div>
                        <div class="channel-item">
                            <div class="icon-bg-green"><i class="fas fa-phone"></i></div> 
                            02-637-8995
                        </div>
                        <div class="channel-item">
                            <div class="icon-bg-green"><i class="fas fa-phone"></i></div> 
                            02-637-8997
                        </div>
                    </div>

                    <div class="qr-line-section">
                        <a href="https://line.me/R/ti/p/@842kcbjl?oat__id=4123351#~" target="_blank" class="line-link-wrapper">
                            <img src="{{ asset('images/line-qr.png') }}" alt="Line QR" class="line-qr-img">
                            <p class="line-id-text">Line : hotstrapthai</p>
                        </a>
                    </div>
                </div>

                <div class="social-icons">
                    <a href="https://www.facebook.com/hotmobilyTH" target="_blank">
                        <img src="{{ asset('images/fb.png') }}" class="social-img" alt="Facebook">
                    </a>
                    <a href="https://line.me/R/ti/p/@842kcbjl?oat__id=4123351#~" target="_blank">
                        <img src="{{ asset('images/line.png') }}" class="social-img" alt="LINE">
                    </a>
                    <a href="#"><img src="{{ asset('images/x.png') }}" alt="X"></a>
                    <a href="mailto:sales.ye@youandearth-th.com?subject=Inquiry&body="><img src="{{ asset('images/gmail.png') }}" alt="Email"></a>
                </div>
            </div>

            {{-- ฝั่งขวา: แบบฟอร์ม --}}
            <div class="contact-form-side">
                <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    @if(session('success'))
                        <div class="alert alert-success mb-3">{{ session('success') }}</div>
                    @endif

                    {{-- ชื่อ-นามสกุล --}}
                    <div class="form-group-floating mb-3">
                        <input type="text" name="name" class="form-control" id="name" placeholder=" " value="{{ old('name') }}" required>
                        <label for="name">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                    </div>

                    {{-- อีเมล --}}
                    <div class="form-group-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder=" " value="{{ old('email') }}" required>
                        <label for="email">อีเมล <span class="text-danger">*</span></label>
                    </div>

                    {{-- เบอร์โทรศัพท์ --}}
                    <div class="form-group-floating mb-3">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder=" " value="{{ old('phone') }}" required>
                        <label for="phone">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="form-group mb-2">
                        <label>เรื่องที่ต้องการติดต่อ <span class="text-danger">*</span></label>
                        <div class="checkbox-grid">
                            <label><input type="checkbox" name="subjects[]" value="ขอใบเสนอราคา" class="subject-checkbox"> ขอใบเสนอราคา</label>
                            <label><input type="checkbox" name="subjects[]" value="นัดหมายฝ่ายขาย" class="subject-checkbox"> นัดหมายฝ่ายขาย</label>
                            <label><input type="checkbox" name="subjects[]" value="ขอตัวอย่างสินค้า" class="subject-checkbox"> ขอตัวอย่างสินค้า</label>
                            <label><input type="checkbox" name="subjects[]" value="สอบถามข้อมูลทั่วไป" class="subject-checkbox"> สอบถามข้อมูลทั่วไป</label>
                        </div>
                        <div id="subject-alert" class="text-danger small mt-2" style="display: none; font-weight: bold;">
                            <i class="fas fa-exclamation-circle"></i> กรุณาเลือกเรื่องที่ต้องการติดต่ออย่างน้อย 1 รายการ
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>
                            แนบรูปภาพ หรือไฟล์งาน 
                            <span class="file-note">(***ไฟล์ที่อัปโหลดได้คือ ai, psd, pdf, doc, xls, jpeg, jpg, png, zip ขนาดไม่เกิน 10MB***)</span>
                        </label>
                        
                        <div class="file-upload-box" onclick="document.getElementById('file_input').click()">
                            <i class="fas fa-upload"></i>
                            <div id="file_list_display">
                                <p>วางไฟล์ลงที่นี่ หรือคลิกเพื่อแนบไฟล์</p>
                            </div>
                            <input type="file" name="attachment[]" id="file_input" hidden multiple onchange="showMultipleFileNames(this)">
                        </div>
                        <div id="file-alert" class="text-danger small mt-2" style="display: none; font-weight: bold;"></div>
                    </div>

                    {{-- ส่งข้อความเพิ่มเติม --}}
                    <div class="form-group mb-4">
                        <label>ส่งข้อความเพิ่มเติม <span class="text-danger">*</span></label>
                        <div class="form-group-floating">
                            <textarea name="message" class="form-control" id="additional_message" rows="4" placeholder=" " required>{{ old('message') }}</textarea>
                            <label for="additional_message">ข้อความ</label>
                        </div>
                    </div>

                    {{-- reCAPTCHA --}}
                    <div class="form-group mb-4">
                        <div class="g-recaptcha" 
                            data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" 
                            data-callback="enableSubmitBtn" 
                            data-expired-callback="disableSubmitBtn">
                        </div>
                        @if ($errors->has('g-recaptcha-response'))
                            <span class="text-danger small">{{ $errors->first('g-recaptcha-response') }}</span>
                        @endif
                    </div>

                    <button type="submit" id="submitBtn" class="btn-send-message" disabled style="opacity: 0.5; cursor: not-allowed;">
                        ส่งข้อความ
                    </button>
                </form>
            </div>
        </div>
    </div>

    <section class="network-section">
        <h3 class="network-title">เว็บไซต์ในเครือของเรา</h3>
        <div class="network-grid">
            <div class="network-item">
                <a href="https://www.youandearth-th.com/" target="_blank">
                    <img src="{{ asset('images/youandearth.png') }}" alt="You and Earth">
                </a>
            </div>
            <div class="network-item">
                <a href="https://hotstrapthai.com/" target="_blank">
                    <img src="{{ asset('images/hotstrap.png') }}" alt="Hotstrap">
                </a>
            </div>
            <div class="network-item">
                <a href="https://hotmobilythai.com/" target="_blank">
                    <img src="{{ asset('images/hotmobilythai.png') }}" alt="Hotmobily">
                </a>
            </div>
            <div class="network-item">
                <a href="https://silicone-wristband-studio.jp/" target="_blank">
                    <img src="{{ asset('images/silicone.png') }}" alt="Hand">
                </a>
            </div>
        </div>
    </section>
</div>

<script>
// ตัวแปรเก็บสถานะความถูกต้องของไฟล์
let isFileValidGlobal = true;

function showMultipleFileNames(input) {
    const displayArea = document.getElementById('file_list_display');
    const fileAlert = document.getElementById('file-alert');
    const allowedExtensions = /(\.ai|\.psd|\.pdf|\.doc|\.docx|\.xls|\.xlsx|\.jpeg|\.jpg|\.png|\.zip)$/i;
    const maxSize = 10 * 1024 * 1024; // 10MB
    
    isFileValidGlobal = true; // รีเซ็ตสถานะทุกครั้งที่เลือกใหม่
    let errorMsg = "";

    if (input.files && input.files.length > 0) {
        let fileNames = '<ul style="list-style: none; padding: 0; margin-top: 10px; color: #333; text-align: left;">';
        
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            
            // 1. ตรวจสอบนามสกุล
            if (!allowedExtensions.exec(file.name)) {
                isFileValidGlobal = false;
                errorMsg = '<i class="fas fa-exclamation-circle"></i> ประเภทไฟล์ไม่ถูกต้อง (รองรับ ai, psd, pdf, doc, xls, jpg, png, zip)';
            }
            // 2. ตรวจสอบขนาดไฟล์
            if (file.size > maxSize) {
                isFileValidGlobal = false;
                errorMsg = '<i class="fas fa-exclamation-circle"></i> ไฟล์ "' + file.name + '" ใหญ่เกิน 10MB';
            }

            fileNames += '<li><i class="fas fa-file-alt"></i> ' + file.name + ' (' + (file.size / (1024 * 1024)).toFixed(2) + 'MB)</li>';
        }
        fileNames += '</ul>';
        displayArea.innerHTML = fileNames;
    } else {
        displayArea.innerHTML = '<p>วางไฟล์ลงที่นี่ หรือคลิกเพื่อแนบไฟล์</p>';
    }

    // จัดการการแสดงผล Alert ของไฟล์
    if (!isFileValidGlobal) {
        fileAlert.innerHTML = errorMsg;
        fileAlert.style.display = "block";
        // หมายเหตุ: ไม่ล้าง input.value เพื่อให้ user เห็นว่าเลือกอะไรผิด แต่จะล็อกปุ่มส่งแทน
    } else {
        fileAlert.style.display = "none";
    }

    validateContactForm(); // ตรวจสอบความพร้อมของปุ่ม Submit
}

function validateContactForm() {
    const btn = document.getElementById('submitBtn');
    const alertBox = document.getElementById('subject-alert');
    
    // เช็คหัวข้อติดต่อ
    const checkboxes = document.querySelectorAll('.subject-checkbox');
    const isSubjectChecked = Array.from(checkboxes).some(cb => cb.checked);
    
    // เช็ค reCAPTCHA
    let isCaptchaDone = false;
    if (typeof grecaptcha !== "undefined") {
        isCaptchaDone = grecaptcha.getResponse().length > 0;
    }

    // 🚩 Logic การเปิด-ปิดปุ่ม (เพิ่มเงื่อนไข isFileValidGlobal)
    if (isSubjectChecked && isCaptchaDone && isFileValidGlobal) {
        btn.disabled = false;
        btn.style.opacity = "1";
        btn.style.cursor = "pointer";
        alertBox.style.display = "none";
    } else {
        btn.disabled = true;
        btn.style.opacity = "0.5";
        btn.style.cursor = "not-allowed";

        // แสดงแจ้งเตือนหัวข้อติดต่อ ถ้ากัปช่าผ่านแล้วแต่ยังไม่เลือกหัวข้อ
        if (isCaptchaDone && !isSubjectChecked) {
            alertBox.style.display = "block";
        } else {
            alertBox.style.display = "none";
        }
    }
}

function enableSubmitBtn() { validateContactForm(); }
function disableSubmitBtn() { validateContactForm(); }

document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.subject-checkbox');
    checkboxes.forEach(cb => {
        cb.addEventListener('change', validateContactForm);
    });
    validateContactForm();
});

document.querySelector('form').onsubmit = function(e) {
    const btn = document.getElementById('submitBtn');
    
    // กันเหนียว: ถ้าไฟล์ไม่ถูกต้อง ไม่ให้ส่งแน่นอน
    if (!isFileValidGlobal) {
        e.preventDefault();
        alert("กรุณาตรวจสอบไฟล์งานให้ถูกต้อง (ขนาดและประเภทไฟล์)");
        return false;
    }

    if(btn && !btn.disabled) {
        btn.disabled = true;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> กำลังส่งข้อความ...';
        btn.style.opacity = "0.7";
    }
};
</script>