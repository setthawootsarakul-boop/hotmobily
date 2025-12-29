@extends('layouts.main')

@section('title', 'ติดต่อเรา - Hotmobily')

@section('content')
<link rel="stylesheet" href="{{ asset('css/contact-full.css') }}">

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
                    ห้องเลขที่ 303 ชั้นที่ 3 ซอยสุกร แขวงตลาดน้อย<br>
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
                        {{-- ครอบลิงก์ทั้งหมด และเพิ่มคลาส text-decoration-none --}}
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
                    <a href="mailto:setthawootsarakul@gmail.com?subject=Inquiry&body="><img src="{{ asset('images/gmail.png') }}" alt="Email"></a>
                </div>
            </div>

            {{-- ฝั่งขวา: แบบฟอร์ม --}}
            <div class="contact-form-side">
                {{-- 1. เพิ่ม action และ enctype เพื่อรองรับการส่งไฟล์ --}}
                <form action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    {{-- แสดงข้อความแจ้งเตือนเมื่อบันทึกสำเร็จ --}}
                    @if(session('success'))
                        <div class="alert alert-success mb-3">{{ session('success') }}</div>
                    @endif

                    {{-- ชื่อ-นามสกุล --}}
                    <div class="form-group-floating mb-3">
                        {{-- 2. ใส่ name="name" และใช้ old() เพื่อจำค่าเดิมกรณี error --}}
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
                        <label>เรื่องที่ต้องการติดต่อ</label>
                        <div class="checkbox-grid">
                            {{-- 3. ใส่ name="subjects[]" เป็น array --}}
                            <label><input type="checkbox" name="subjects[]" value="ขอใบเสนอราคา"> ขอใบเสนอราคา</label>
                            <label><input type="checkbox" name="subjects[]" value="นัดหมายฝ่ายขาย"> นัดหมายฝ่ายขาย</label>
                            <label><input type="checkbox" name="subjects[]" value="ขอตัวอย่างสินค้า"> ขอตัวอย่างสินค้า</label>
                            <label><input type="checkbox" name="subjects[]" value="สอบถามข้อมูลทั่วไป" checked> สอบถามข้อมูลทั่วไป</label>
                        </div>
                    </div>

                    <div class="form-group mb-3">
                        <label>
                            แนบรูปภาพ หรือไฟล์งาน 
                            <span class="file-note">(***ไฟล์ที่อัปโหลดได้คือ ai, psd, pdf, doc, xls, jpeg, jpg, png, zip ขนาดไม่เกิน 10MB***)</span>
                        </label>
                        
                        {{-- ส่วนกล่อง Upload ปรับปรุงให้รองรับหลายไฟล์ --}}
                        <div class="file-upload-box" onclick="document.getElementById('file_input').click()">
                            <i class="fas fa-upload"></i>
                            {{-- เปลี่ยน ID สำหรับแสดงรายชื่อไฟล์ --}}
                            <div id="file_list_display">
                                <p>วางไฟล์ลงที่นี่ หรือคลิกเพื่อแนบไฟล์</p>
                            </div>
                            
                            {{-- 🚩 1. เพิ่ม multiple และ 2. เปลี่ยน name เป็น attachment[] (Array) --}}
                            <input type="file" name="attachment[]" id="file_input" hidden multiple onchange="showMultipleFileNames(this)">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label>ส่งข้อความเพิ่มเติม</label>
                        <div class="form-group-floating">
                            <textarea name="message" class="form-control" id="additional_message" rows="4" placeholder=" ">{{ old('message') }}</textarea>
                            <label for="additional_message">ข้อความ</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-send-message">ส่งข้อความ</button>
                </form>
            </div>
        </div>
    </div>

    {{-- ส่วนเว็บไซต์ในเครือ --}}
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

{{-- 5. สคริปต์แสดงชื่อไฟล์เมื่อเลือก --}}
<script>
function showMultipleFileNames(input) {
    const displayArea = document.getElementById('file_list_display');
    
    if (input.files && input.files.length > 0) {
        let fileNames = '<ul style="list-style: none; padding: 0; margin-top: 10px; color: #333;">';
        
        // วนลูปเพื่อดึงชื่อไฟล์ทั้งหมดออกมาแสดง
        for (let i = 0; i < input.files.length; i++) {
            fileNames += '<li><i class="fas fa-file-alt"></i> ' + input.files[i].name + '</li>';
        }
        
        fileNames += '</ul>';
        displayArea.innerHTML = fileNames;
    } else {
        displayArea.innerHTML = '<p>วางไฟล์ลงที่นี่ หรือคลิกเพื่อแนบไฟล์</p>';
    }
}
</script>
@endsection