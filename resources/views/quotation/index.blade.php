@extends('layouts.main')

@section('title', 'ขอใบเสนอราคา')

@section('content')

{{-- ✅ Link CSS หลัก --}}
<link rel="stylesheet" href="{{ asset('css/quotation.css') }}">

{{-- ✅ Choices.js CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

<style>
    .choices { margin-bottom: 0; }
    .choices__inner { background-color: #fff; border: 1px solid #e0e0e0; border-radius: 6px; min-height: 44px; padding: 4px 10px; display: flex; align-items: center; font-size: 14px; }
    .choices.is-focused .choices__inner { border-color: #FFA726; box-shadow: 0 0 0 0.2rem rgba(255, 167, 38, 0.25); }
    .choices.is-disabled .choices__inner { background-color: #E9ECEF; cursor: not-allowed; }
    .choices__placeholder { color: #6c757d; opacity: 1; }
    
    .form-control::placeholder { color: #6c757d; opacity: 1; }

    .choices__list--dropdown .choices__input { 
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23999' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E"); 
        background-repeat: no-repeat; background-position: 10px center; background-size: 16px; padding-left: 35px !important; border-radius: 4px; background-color: #f8f9fa; border: 1px solid #eee; margin-bottom: 5px; 
    }
    
    .form-control.is-invalid { border-color: #dc3545 !important; padding-right: calc(1.5em + .75rem); background-image: none !important; }
    .choices.is-invalid .choices__inner { border-color: #dc3545 !important; }
    .invalid-feedback { display: none; width: 100%; margin-top: .25rem; font-size: .875em; color: #dc3545; font-weight: 500; }
    .d-block { display: block !important; }

    /* Custom Tax Radio Card */
    .tax-options-container { display: flex; gap: 15px; flex-wrap: wrap; }
    .tax-option-card {
        flex: 1; min-width: 250px; border: 1px solid #e0e0e0; border-radius: 8px;
        padding: 30px 20px; cursor: pointer; transition: all 0.2s ease-in-out; background-color: #fff;
    }
    .tax-option-card.selected { border-color: #FFA726; background-color: #fff9f0; box-shadow: 0 2px 8px rgba(255,167,38,0.15); }
    
    .custom-radio-icon {
        width: 24px; height: 24px; border: 2px solid #ccc; border-radius: 50%;
        display: flex; align-items: center; justify-content: center; margin-right: 10px; flex-shrink: 0;
    }
    .custom-radio-icon.checked { border-color: #FFA726; background-color: #FFA726; color: white; }

    .custom-swal-popup { border-radius: 15px !important; padding: 2rem !important; }
    .custom-swal-confirm { background-color: #FFA726 !important; border-color: #FFA726 !important; padding: 10px 25px !important; font-weight: bold; }
    .custom-swal-cancel { color: #666 !important; background: #f8f9fa !important; border: 1px solid #ddd !important; padding: 10px 25px !important; font-weight: bold; }

    .btn-create-quote:disabled {
        background-color: #dc3545 !important; 
        border-color: #dc3545 !important;
        color: #ffffff !important;          
        opacity: 0.3 !important;            
        cursor: not-allowed !important;      
    }

    .btn-create-quote:not(:disabled) {
        background-color: #dc3545 !important; 
        opacity: 1 !important;
        cursor: pointer !important;
    }
    .captcha-container {
        display: flex;
        justify-content: center;
        align-items: center;
        width: auto;
    }

    /* 📱 แก้ไขเฉพาะส่วน Responsive มือถือ */
    @media (max-width: 991px) {
        .btn-wrapper-flex {
            display: flex !important;
            flex-direction: column !important;
            align-items: center !important;
            gap: 20px !important;
        }

        .captcha-container {
            order: 1 !important;
            width: 100% !important;
            margin: 0 auto !important;
            display: flex !important;
            justify-content: center !important;
        }

        .btn-create-quote {
            order: 2 !important;
            width: 100% !important;
            max-width: 304px !important;
        }

        .btn-back {
            order: 3 !important;
            width: 100% !important;
            max-width: 304px !important;
            text-align: center;
        }
    }
</style>

<div class="container py-5">
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert" style="border-left: 5px solid #dc3545;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div><strong>แจ้งเตือน!</strong> {{ session('error') }}</div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="text-center mb-5"><h1 class="quotation-title">ขอใบเสนอราคา</h1></div>

    {{-- ✅ เพิ่ม enctype="multipart/form-data" เพื่อให้อัปโหลดไฟล์ได้ --}}
    <form action="{{ route('quotation.step1') }}" method="POST" id="quotationForm" enctype="multipart/form-data" novalidate>
        @csrf
        <input type="hidden" name="province_name" id="province_name" value="{{ old('province_name', $tempData['province_name'] ?? '') }}">
        <input type="hidden" name="district_name" id="district_name" value="{{ old('district_name', $tempData['district_name'] ?? '') }}">
        <input type="hidden" name="sub_district_name" id="sub_district_name" value="{{ old('sub_district_name', $tempData['sub_district_name'] ?? '') }}">

        <h4 class="section-header">ที่อยู่ในการรับสินค้า</h4>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $tempData['fullname'] ?? '') }}" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">ชื่อบริษัท / หน่วยงาน <small class="text-muted">(ถ้ามี)</small></label>
                <input type="text" name="company_name" class="form-control" value="{{ old('company_name', $tempData['company_name'] ?? '') }}">
            </div>
            <div class="col-md-6">
                <label class="form-label">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $tempData['phone'] ?? '') }}" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">อีเมล <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $tempData['email'] ?? '') }}" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">จังหวัด <span class="text-danger">*</span></label>
                <select name="province" id="province" class="form-control" required></select>
                <div class="invalid-feedback" id="province-error">โปรดเลือกจังหวัด</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">อำเภอ / เขต <span class="text-danger">*</span></label>
                <select name="district" id="district" class="form-control" required disabled></select>
                <div class="invalid-feedback" id="district-error">โปรดเลือกอำเภอ / เขต</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">ตำบล / แขวง <span class="text-danger">*</span></label>
                <select name="sub_district" id="sub_district" class="form-control" required disabled></select>
                <div class="invalid-feedback" id="sub-district-error">โปรดเลือกตำบล / แขวง</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                <input type="text" name="zipcode" id="zipcode" class="form-control" value="{{ old('zipcode', $tempData['zipcode'] ?? '') }}" style="background-color: #E9ECEF;" readonly required>
            </div>
        </div>

        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label font-weight-bold">เลขที่ <span class="text-danger">*</span></label>
                <input type="text" name="tax_address_no" class="form-control" value="{{ old('tax_address_no', $tempData['tax_address_no'] ?? '') }}" required>
                <div class="invalid-feedback">กรุณากรอกเลขที่</div>
            </div>
            <div class="col-md-4">
                <label class="form-label font-weight-bold">ชื่ออาคาร <span class="text-danger">*</span></label>
                <input type="text" name="tax_building" class="form-control" value="{{ old('tax_building', $tempData['tax_building'] ?? '') }}" required>
                <div class="invalid-feedback">กรุณากรอกชื่ออาคาร</div>
            </div>
            <div class="col-md-4"><label class="form-label">ชั้นที่</label><input type="text" name="floor" class="form-control" value="{{ old('floor', $tempData['floor'] ?? '') }}"></div>
            <div class="col-md-6"><label class="form-label">หมู่</label><input type="text" name="moo" class="form-control" value="{{ old('moo', $tempData['moo'] ?? '') }}"></div>
            <div class="col-md-6"><label class="form-label">หมู่บ้าน</label><input type="text" name="village" class="form-control" value="{{ old('village', $tempData['village'] ?? '') }}"></div>
            <div class="col-md-6"><label class="form-label">ซอย</label><input type="text" name="soi" class="form-control" value="{{ old('soi', $tempData['soi'] ?? '') }}"></div>
            <div class="col-md-6"><label class="form-label">ถนน</label><input type="text" name="road" class="form-control" value="{{ old('road', $tempData['road'] ?? '') }}"></div>
        </div>

        <div class="form-group mb-4">
            <label class="form-label font-weight-bold">แนบรูปภาพ หรือไฟล์งานออกแบบ <small class="text-muted">(ai, psd, pdf, jpeg, jpg, png, zip ไม่เกิน 10MB)</small></label>
            <div class="file-upload-box" id="drop_zone" onclick="document.getElementById('file_input').click()" 
                style="border: 2px dashed #ccc; padding: 20px; text-align: center; cursor: pointer; border-radius: 8px; background: #fdfdfd;">
                <i class="fas fa-cloud-upload-alt fa-2x mb-2 text-primary"></i>
                <p class="mb-0 text-muted small">คลิกเพื่อแนบไฟล์งาน</p>
                <input type="file" name="quotation_attachments[]" id="file_input" hidden multiple onchange="handleFileSelect(this)">
            </div>
            
            {{-- ✅ ส่วนที่เพิ่ม: พื้นที่แสดงรายการไฟล์ที่เลือก พร้อมปุ่มกากบาท --}}
            <div id="file_list_container" class="mt-2"></div>
            
            <div id="file-error-msg" class="text-danger small mt-2" style="display: none; font-weight: 500;"></div>
        </div>

        <div class="mb-5">
            <label class="form-label">ข้อความเพิ่มเติม <small class="text-muted">กรุณาระบุข้อมูล หรือข้อความ ตามที่ท่านต้องการ กรณีไม่มีข้อมูลให้เว้นว่างไว้ไม่ต้องใส่ - (ขีด)</small></label>
            <textarea name="note" class="form-control" rows="3">{{ old('note', $tempData['note'] ?? '') }}</textarea>
        </div>

        <h4 class="section-header">ใบกำกับภาษี</h4>
        
        <div class="tax-options-container mb-5">
            @php $currentTax = old('tax_invoice_req', $tempData['tax_invoice_req'] ?? '0'); @endphp
            
            <div class="tax-option-card {{ $currentTax == '0' ? 'selected' : '' }}" onclick="selectTaxOption(this)">
                <div class="d-flex align-items-center w-100">
                    <div class="custom-radio-icon {{ $currentTax == '0' ? 'checked' : '' }} me-3">
                        @if($currentTax == '0') <i class="bi bi-check-lg"></i> @endif
                    </div>
                    <span class="fw-bold text-dark">ไม่ต้องการใบกำกับภาษี</span>
                </div>
                <input type="radio" name="tax_invoice_req" value="0" {{ $currentTax == '0' ? 'checked' : '' }} hidden>
            </div>

            <div class="tax-option-card {{ $currentTax == '1' ? 'selected' : '' }}" onclick="selectTaxOption(this)">
                <div class="d-flex align-items-center w-100">
                    <div class="custom-radio-icon {{ $currentTax == '1' ? 'checked' : '' }} me-3">
                        @if($currentTax == '1') <i class="bi bi-check-lg"></i> @endif
                    </div>
                    <span class="fw-bold text-dark">แบบกระดาษ</span>
                </div>
                <input type="radio" name="tax_invoice_req" value="1" {{ $currentTax == '1' ? 'checked' : '' }} hidden>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5 gap-3 flex-wrap btn-wrapper-flex">
            <a href="{{ route('cart.index') }}" class="btn btn-back">ย้อนกลับ</a>

            <div class="captcha-container">
                <div class="g-recaptcha" 
                     data-sitekey="{{ env('RECAPTCHA_SITE_KEY') }}" 
                     data-callback="enableSubmitBtn" 
                     data-expired-callback="disableSubmitBtn">
                </div>
                @if ($errors->has('g-recaptcha-response'))
                    <span class="text-danger small d-block text-center mt-1">{{ $errors->first('g-recaptcha-response') }}</span>
                @endif
            </div>

            <button type="button" id="submitBtn" class="btn btn-create-quote" 
                    onclick="preSubmitCheck()" disabled>
                สร้างใบเสนอราคา
            </button>
        </div>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ✅ ตัวแปรระดับ Global สำหรับจัดการสถานะไฟล์
    let selectedFiles = []; 
    let isFileValid = true;
    let provinceChoices, districtChoices, subDistrictChoices;
    let allData = [];

    // --- 1. ฟังก์ชันจัดการปุ่ม Submit ---

    function enableSubmitBtn() {
        const btn = document.getElementById('submitBtn');
        const isCaptchaDone = window.grecaptcha && grecaptcha.getResponse().length > 0;
        
        // เงื่อนไข: ปุ่มจะเปิดเมื่อ (ไม่มีไฟล์ผิดกฎเลย) และ (ติ๊ก reCAPTCHA แล้ว)
        if(btn && isFileValid && isCaptchaDone) {
            btn.disabled = false;
            btn.style.opacity = "1";
            btn.style.cursor = "pointer";
        } else {
            disableSubmitBtn();
        }
    }

    function disableSubmitBtn() {
        const btn = document.getElementById('submitBtn');
        if(btn) {
            btn.disabled = true;
            btn.style.opacity = "0.3";
            btn.style.cursor = "not-allowed";
        }
    }

    // --- 2. ฟังก์ชันจัดการไฟล์แนบ ---

    function handleFileSelect(input) {
        const allowedExtensions = /(\.ai|\.psd|\.pdf|\.jpeg|\.jpg|\.png|\.zip)$/i;
        const maxSize = 10 * 1024 * 1024; // 10MB
        
        const newFiles = Array.from(input.files);
        
        newFiles.forEach(file => {
            let error = null;
            if (!allowedExtensions.exec(file.name)) {
                error = "ประเภทไฟล์ไม่รองรับ (รองรับเฉพาะ ai, psd, pdf, jpg, png, zip)";
            } else if (file.size > maxSize) {
                error = "ไฟล์มีขนาดใหญ่เกิน 10MB";
            }
            
            // เก็บข้อมูลไฟล์พร้อมสถานะ Error รายไฟล์
            selectedFiles.push({
                fileData: file,
                error: error
            });
        });

        input.value = ""; // ล้างค่า input เพื่อให้เลือกไฟล์ซ้ำเดิมได้
        validateAllFiles(); 
        renderFileList();   
    }

    function validateAllFiles() {
        const errorDisplay = document.getElementById('file-error-msg');
        // ตรวจสอบว่ามีไฟล์ใดไฟล์หนึ่งในลิสต์ที่มี error หรือไม่
        const hasInvalidFile = selectedFiles.some(item => item.error !== null);
        
        if (hasInvalidFile) {
            isFileValid = false;
            if (errorDisplay) {
                errorDisplay.innerHTML = `<i class="bi bi-exclamation-triangle-fill"></i> มีไฟล์ที่ไม่ถูกต้องในรายการ กรุณาลบออกก่อนดำเนินการต่อ`;
                errorDisplay.style.display = "block";
            }
            disableSubmitBtn();
        } else {
            isFileValid = true;
            if (errorDisplay) {
                errorDisplay.style.display = "none";
            }
            enableSubmitBtn();
        }
    }

    function renderFileList() {
        const container = document.getElementById('file_list_container');
        const displayDefault = document.getElementById('file_list_display');
        
        if (!container) return;
        container.innerHTML = "";

        if (selectedFiles.length > 0) {
            if (displayDefault) displayDefault.style.display = "none";
            
            selectedFiles.forEach((item, index) => {
                const file = item.fileData;
                const isError = item.error !== null;
                
                const fileRow = document.createElement('div');
                // ไฮไลท์สีแดงถ้าไฟล์ผิดกฎ
                fileRow.className = `d-flex align-items-center justify-content-between p-2 mb-2 rounded border shadow-sm ${isError ? 'border-danger bg-danger-subtle' : 'bg-white'}`;
                fileRow.style.fontSize = "13px";
                
                fileRow.innerHTML = `
                    <div class="text-truncate me-2">
                        <i class="fas ${isError ? 'fa-exclamation-triangle text-danger' : 'fa-file-alt text-primary'} me-2"></i>
                        <strong class="${isError ? 'text-danger' : ''}">${file.name}</strong> 
                        <span class="text-muted ms-1">(${(file.size / (1024 * 1024)).toFixed(2)} MB)</span>
                        ${isError ? `<br><small class="text-danger fw-bold">${item.error}</small>` : ''}
                    </div>
                    <button type="button" class="btn btn-sm text-danger p-0" onclick="removeFile(${index})" title="ลบไฟล์นี้">
                        <i class="bi bi-x-circle-fill fs-5"></i>
                    </button>
                `;
                container.appendChild(fileRow);
            });
        } else {
            if (displayDefault) displayDefault.style.display = "block";
        }
        updateInputFiles();
    }

    function removeFile(index) {
        selectedFiles.splice(index, 1);
        validateAllFiles();
        renderFileList();
    }

    function updateInputFiles() {
        const input = document.getElementById('file_input');
        const dataTransfer = new DataTransfer();
        // ส่งเฉพาะไฟล์ที่ไม่มี Error ไปยัง Server
        selectedFiles.forEach(item => {
            if (item.error === null) {
                dataTransfer.items.add(item.fileData);
            }
        });
        if (input) input.files = dataTransfer.files;
    }

    // --- 3. ฟังก์ชันจัดการที่อยู่ และ LocalStorage ---

    function getSavedValue(key, phpValue) {
        return localStorage.getItem('quote_' + key) || phpValue || '';
    }

    function selectTaxOption(cardElement) {
        document.querySelectorAll('.tax-option-card').forEach(el => el.classList.remove('selected'));
        document.querySelectorAll('.custom-radio-icon').forEach(el => { 
            el.classList.remove('checked'); 
            el.innerHTML = ''; 
        });
        
        cardElement.classList.add('selected');
        const radio = cardElement.querySelector('input[type="radio"]');
        radio.checked = true;
        
        const iconDiv = cardElement.querySelector('.custom-radio-icon');
        iconDiv.classList.add('checked');
        iconDiv.innerHTML = '<i class="bi bi-check-lg"></i>';
        
        localStorage.setItem('quote_tax_invoice_req', radio.value);

        const captchaDiv = document.querySelector('.captcha-container');
        if(captchaDiv) captchaDiv.style.display = "block";

        enableSubmitBtn(); 
    }
    
    function preSubmitCheck() {
        const form = document.getElementById('quotationForm');
        const btn = document.getElementById('submitBtn');
        
        const dataToSave = new FormData(form);
        for (let [key, value] of dataToSave.entries()) {
            if(typeof value === 'string') localStorage.setItem('quote_' + key, value);
        }

        document.getElementById('province_name').value = provinceChoices.getValue(true) || '';
        document.getElementById('district_name').value = districtChoices.getValue(true) || '';
        document.getElementById('sub_district_name').value = subDistrictChoices.getValue(true) || '';

        if (!document.getElementById('province').value) {
            Swal.fire('แจ้งเตือน', 'กรุณาเลือกที่อยู่ให้ครบถ้วน', 'warning');
            return;
        }

        const taxReq = document.querySelector('input[name="tax_invoice_req"]:checked').value;
        
        const showLoading = () => {
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> กำลังประมวลผล...';
        };

        if (taxReq === '1') {
            showLoading();
            form.submit();
        } else {
            Swal.fire({
                title: 'ยืนยันขอใบเสนอราคา',
                html: `<img src="{{ asset('images/Hotmobilyfile/poster/robot-bill.png') }}" style="width:120px;margin-bottom:10px;"><p>ระบบจะสร้างใบเสนอราคาให้อัตโนมัติ</p>`,
                showCancelButton: true, 
                confirmButtonText: 'ดำเนินการต่อ', 
                confirmButtonColor: '#FFA726',
                cancelButtonText: 'ยกเลิก',
                customClass: {
                    confirmButton: 'custom-swal-confirm',
                    cancelButton: 'custom-swal-cancel',
                    popup: 'custom-swal-popup'
                }
            }).then((result) => { 
                if (result.isConfirmed) {
                    showLoading();
                    form.submit(); 
                }
            });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const config = { searchEnabled: true, itemSelectText: '', shouldSort: false, allowHTML: true };
        provinceChoices = new Choices('#province', config);
        districtChoices = new Choices('#district', config);
        subDistrictChoices = new Choices('#sub_district', config);

        // ดึงค่าเก่าจาก LocalStorage
        const textInputs = ['fullname', 'company_name', 'phone', 'email', 'tax_address_no', 'tax_building', 'floor', 'moo', 'village', 'soi', 'road', 'note'];
        textInputs.forEach(name => {
            const el = document.querySelector(`[name="${name}"]`);
            if (el) {
                const val = getSavedValue(name, "");
                if (val) el.value = val;
            }
        });

        const zipcodeInput = document.getElementById('zipcode');

        axios.get('{{ asset("province_with_district_and_sub_district.json") }}').then(response => {
            allData = response.data;
            allData.sort((a, b) => a.name_th === 'กรุงเทพมหานคร' ? -1 : b.name_th === 'กรุงเทพมหานคร' ? 1 : a.name_th.localeCompare(b.name_th, 'th'));
            
            const oldP = getSavedValue('province', "{{ old('province', $tempData['province'] ?? '') }}");
            provinceChoices.setChoices(allData.map(p => ({ 
                value: p.id.toString(), label: p.name_th, selected: (p.id == oldP) 
            })), 'value', 'label', true);

            if (oldP) {
                const pData = allData.find(p => p.id == oldP);
                if (pData) {
                    const oldD = getSavedValue('district', "{{ old('district', $tempData['district'] ?? '') }}");
                    districtChoices.enable();
                    districtChoices.setChoices(pData.districts.map(d => ({
                        value: d.id.toString(), label: d.name_th, selected: (d.id == oldD)
                    })), 'value', 'label', true);

                    if (oldD) {
                        const dData = pData.districts.find(d => d.id == oldD);
                        if (dData) {
                            const oldS = getSavedValue('sub_district', "{{ old('sub_district', $tempData['sub_district'] ?? '') }}");
                            subDistrictChoices.enable();
                            subDistrictChoices.setChoices(dData.sub_districts.map(s => ({
                                value: s.id.toString(), label: s.name_th, selected: (s.id == oldS),
                                customProperties: { zip: s.zip_code }
                            })), 'value', 'label', true);
                            zipcodeInput.value = getSavedValue('zipcode', "{{ old('zipcode', $tempData['zipcode'] ?? '') }}");
                        }
                    }
                }
            }
        });

        document.getElementById('province').addEventListener('change', function(e) {
            const pData = allData.find(p => p.id == e.detail.value);
            districtChoices.clearStore(); subDistrictChoices.clearStore(); subDistrictChoices.disable();
            zipcodeInput.value = '';
            if (pData) {
                pData.districts.sort((a, b) => a.name_th.localeCompare(b.name_th, 'th'));
                districtChoices.enable();
                districtChoices.setChoices(pData.districts.map(d => ({ value: d.id.toString(), label: d.name_th })), 'value', 'label', true);
            }
        });

        document.getElementById('district').addEventListener('change', function(e) {
            const pId = document.getElementById('province').value;
            const pData = allData.find(p => p.id == pId);
            const dData = pData ? pData.districts.find(d => d.id == e.detail.value) : null;
            subDistrictChoices.clearStore();
            zipcodeInput.value = '';
            if (dData) {
                dData.sub_districts.sort((a, b) => a.name_th.localeCompare(b.name_th, 'th'));
                subDistrictChoices.enable();
                subDistrictChoices.setChoices(dData.sub_districts.map(s => ({ value: s.id.toString(), label: s.name_th, customProperties: { zip: s.zip_code } })), 'value', 'label', true);
            }
        });

        document.getElementById('sub_district').addEventListener('addItem', function(e) {
            if (e.detail.customProperties) zipcodeInput.value = e.detail.customProperties.zip;
        });

        disableSubmitBtn();
    });
</script>
@endsection