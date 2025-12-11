@extends('layouts.main')

@section('title', 'ขอใบเสนอราคา')

@section('content')

{{-- ✅ Link CSS หลัก --}}
<link rel="stylesheet" href="{{ asset('css/quotation.css') }}">

{{-- ✅ Choices.js CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

{{-- ✅ Custom Style: Choices.js & Error UI --}}
<style>
    /* ... (Choices Style เดิม) ... */
    .choices { margin-bottom: 0; }
    .choices__inner {
        background-color: #fff;
        border: 1px solid #e0e0e0;
        border-radius: 6px;
        min-height: 44px;
        padding: 4px 10px;
        display: flex; align-items: center; font-size: 14px;
    }
    .choices.is-focused .choices__inner {
        border-color: #FFA726;
        box-shadow: 0 0 0 0.2rem rgba(255, 167, 38, 0.25);
    }
    .choices__item--choice { font-size: 14px; }
    .choices.is-disabled .choices__inner {
        background-color: #E9ECEF; cursor: not-allowed;
    }
    .choices__placeholder { color: #6c757d; opacity: 1; }

    /* Search Icon */
    .choices__list--dropdown .choices__input {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23999' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: 10px center;
        background-size: 16px;
        padding-left: 35px !important;
        border-radius: 4px;
        background-color: #f8f9fa;
        border: 1px solid #eee;
        margin-bottom: 5px;
    }

    /* 🔥 Error Styles (เหมือน tax_info) 🔥 */
    .form-control.is-invalid {
        border-color: #dc3545 !important; /* ขอบแดง */
        padding-right: calc(1.5em + .75rem);
        background-image: none !important;
    }
    
    /* Error ของ Choices.js */
    .choices.is-invalid .choices__inner {
        border-color: #dc3545 !important;
        background-image: none;
    }

    /* ข้อความ Error */
    .invalid-feedback {
        display: none;
        width: 100%;
        margin-top: .25rem;
        font-size: .875em;
        color: #dc3545;
        font-weight: 500;
    }
    
    .d-block { display: block !important; }
</style>

<div class="container py-5">
    
    <div class="text-center mb-5">
        <h1 class="quotation-title">ขอใบเสนอราคา</h1>
    </div>

    {{-- ✅ novalidate ปิด popup เดิม --}}
    <form action="{{ route('quotation.step1') }}" method="POST" id="quotationForm" novalidate>
        @csrf

        {{-- 🔸 Section 1: ที่อยู่ --}}
        <h4 class="section-header">ที่อยู่ในการรับสินค้า</h4>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                <input type="text" name="fullname" class="form-control" value="{{ old('fullname', $tempData['fullname'] ?? '') }}" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone', $tempData['phone'] ?? '') }}" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-12">
                <label class="form-label">อีเมล <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $tempData['email'] ?? '') }}" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
        </div>

        {{-- Address Dropdowns --}}
        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">จังหวัด <span class="text-danger">*</span></label>
                <div id="province-wrapper">
                    <select name="province" id="province" class="form-control" required></select>
                </div>
                <div class="invalid-feedback" id="province-error">โปรดเลือกจังหวัด</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">อำเภอ / เขต <span class="text-danger">*</span></label>
                <div id="district-wrapper">
                    <select name="district" id="district" class="form-control" required disabled></select>
                </div>
                <div class="invalid-feedback" id="district-error">โปรดเลือกอำเภอ / เขต</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">ตำบล / แขวง <span class="text-danger">*</span></label>
                <div id="sub-district-wrapper">
                    <select name="sub_district" id="sub_district" class="form-control" required disabled></select>
                </div>
                <div class="invalid-feedback" id="sub-district-error">โปรดเลือกตำบล / แขวง</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                <input type="text" name="zipcode" id="zipcode" class="form-control" style="background-color: #E9ECEF;" readonly required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
        </div>

        {{-- Detail Address --}}
        <div class="row g-3 mb-4">
            <div class="col-md-4">
                <label class="form-label">เลขที่</label>
                <input type="text" name="address_no" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">ชื่ออาคาร</label>
                <input type="text" name="building" class="form-control">
            </div>
            <div class="col-md-4">
                <label class="form-label">ชั้นที่</label>
                <input type="text" name="floor" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label">หมู่</label>
                <input type="text" name="moo" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">หมู่บ้าน</label>
                <input type="text" name="village" class="form-control">
            </div>
            
            <div class="col-md-6">
                <label class="form-label">ซอย</label>
                <input type="text" name="soi" class="form-control">
            </div>
            <div class="col-md-6">
                <label class="form-label">ถนน</label>
                <input type="text" name="road" class="form-control">
            </div>
        </div>

        <div class="mb-5">
            <label class="form-label">ข้อความเพิ่มเติม <small class="text-muted">* กรุณาระบุข้อมูล หรือข้อความ ตามที่ท่านต้องการ กรณีไม่มีข้อมูลให้เว้นว่างไว้ไม่ต้องใส่ - (ขีด)</small></label>
            <textarea name="note" class="form-control" rows="3"></textarea>
        </div>

        {{-- 🔸 Section 2: ใบกำกับภาษี --}}
        <h4 class="section-header">ใบกำกับภาษี</h4>
        
        <div class="tax-options-container mb-5">
            <label class="tax-option-card selected" id="opt-no-tax">
                <div class="d-flex align-items-center w-100">
                    <div class="custom-radio-icon checked me-3">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <span class="fw-bold text-dark">ไม่ต้องการใบกำกับภาษี</span>
                    <i class="bi bi-file-earmark-x ms-2 text-muted fs-1"></i>
                </div>
                <input type="radio" name="tax_invoice_req" value="0" checked hidden onchange="selectTaxOption(this)">
            </label>

            <label class="tax-option-card" id="opt-paper-tax">
                <div class="d-flex align-items-center w-100">
                    <div class="custom-radio-icon me-3"></div>
                    <span class="fw-bold text-dark">แบบกระดาษ</span>
                    <i class="bi bi-file-earmark-text ms-2 text-muted fs-1"></i>
                </div>
                <input type="radio" name="tax_invoice_req" value="1" hidden onchange="selectTaxOption(this)">
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5">
            <a href="{{ route('cart.index') }}" class="btn btn-back">ย้อนกลับ</a>
            <button type="button" class="btn btn-create-quote" onclick="preSubmitCheck()">สร้างใบเสนอราคา</button>
        </div>

    </form>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // 1. Logic Radio
    function selectTaxOption(radio) {
        document.querySelectorAll('.tax-option-card').forEach(el => el.classList.remove('selected'));
        document.querySelectorAll('.custom-radio-icon').forEach(el => {
            el.classList.remove('checked');
            el.innerHTML = '';
        });
        const parentLabel = radio.closest('label');
        parentLabel.classList.add('selected');
        const iconDiv = parentLabel.querySelector('.custom-radio-icon');
        iconDiv.classList.add('checked');
        iconDiv.innerHTML = '<i class="bi bi-check-lg"></i>';
    }

    // 2. 🔥 Logic Validation & Alert (ปรับปรุงใหม่) 🔥
    function preSubmitCheck() {
        const form = document.getElementById('quotationForm');
        let isValid = true;

        // Reset Styles
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.classList.remove('d-block'));
        document.querySelectorAll('.choices').forEach(el => el.classList.remove('is-invalid'));

        // Validate Inputs
        form.querySelectorAll('input[required]').forEach(input => {
            if (!input.value.trim()) {
                input.classList.add('is-invalid');
                const errorDiv = input.nextElementSibling;
                if(errorDiv && errorDiv.classList.contains('invalid-feedback')) {
                    errorDiv.classList.add('d-block');
                }
                isValid = false;
            }
        });

        // Validate Choices.js Dropdowns
        ['province', 'district', 'sub_district'].forEach(id => {
            const select = document.getElementById(id);
            if (select.value === "") {
                const wrapper = select.closest('.choices');
                if(wrapper) wrapper.classList.add('is-invalid');
                const errorMsg = document.getElementById(id + '-error');
                if(errorMsg) errorMsg.classList.add('d-block');
                isValid = false;
            }
        });

        if (isValid) {
            const taxReq = document.querySelector('input[name="tax_invoice_req"]:checked').value;

            // ✅ ถ้าเลือก "แบบกระดาษ" -> ไปต่อเลย (ไม่ต้องถาม)
            if (taxReq === '1') {
                form.submit();
                return; 
            }

            // ✅ ถ้าเลือก "ไม่ต้องการ" -> ถามยืนยัน
            Swal.fire({
                title: 'ยืนยันขอใบเสนอราคา',
                html: `
                    <div class="mb-3">
                        <img src="{{ asset('images/Hotmobilyfile/poster/robot-bill.png') }}" style="width: 150px; margin-bottom: 15px;">
                    </div>
                    <p class="text-muted" style="font-size: 14px;">
                        ใบเสนอราคานี้จัดทำโดยระบบอัตโนมัติเพื่อเป็นการอ้างอิงราคาเบื้องต้นเท่านั้น<br>
                        กรุณาติดต่อฝ่ายขายเพื่อยืนยันข้อมูลการสั่งซื้อและราคาอย่างเป็นทางการ
                    </p>
                `,
                showCancelButton: true,
                confirmButtonText: 'ดำเนินการต่อ',
                cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#ff8c00',
                cancelButtonColor: '#fff',
                customClass: {
                    popup: 'custom-swal-popup',
                    confirmButton: 'custom-swal-confirm',
                    cancelButton: 'custom-swal-cancel'
                },
                reverseButtons: true,
                scrollbarPadding: false,
                heightAuto: false 
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });

        } else {
            // Scroll ไปหา error แรก
            const firstError = document.querySelector('.is-invalid');
            if(firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }

    // 3. Choices.js Logic (เหมือนเดิม)
    document.addEventListener('DOMContentLoaded', function() {
        const choicesConfig = {
            searchEnabled: true, itemSelectText: '', shouldSort: false, searchPlaceholderValue: 'พิมพ์เพื่อค้นหา...', noResultsText: 'ไม่พบข้อมูล', noChoicesText: 'ไม่มีข้อมูล', allowHTML: true
        };

        const provinceChoices = new Choices('#province', { ...choicesConfig, placeholderValue: 'เลือกจังหวัด' });
        const districtChoices = new Choices('#district', { ...choicesConfig, placeholderValue: 'เลือกอำเภอ / เขต' });
        const subDistrictChoices = new Choices('#sub_district', { ...choicesConfig, placeholderValue: 'เลือกตำบล / แขวง' });

        const zipcodeInput = document.getElementById('zipcode');
        let allData = [];

        function updateZipcodeStyle() {
            if (zipcodeInput.value && zipcodeInput.value.trim() !== "") {
                zipcodeInput.style.backgroundColor = "#fff"; 
            } else {
                zipcodeInput.style.backgroundColor = "#E9ECEF"; 
            }
        }

        axios.get('{{ asset("province_with_district_and_sub_district.json") }}')
            .then(response => {
                allData = response.data;
                populateProvinces();
            })
            .catch(error => { console.error('Error:', error); });

        function populateProvinces() {
            allData.sort((a, b) => {
                if (a.name_th === 'กรุงเทพมหานคร') return -1;
                if (b.name_th === 'กรุงเทพมหานคร') return 1;
                return a.name_th.localeCompare(b.name_th);
            });
            const provinceOptions = allData.map(p => ({ value: p.id, label: p.name_th }));
            provinceChoices.setChoices(provinceOptions, 'value', 'label', true);
        }

        document.getElementById('province').addEventListener('change', function(event) {
            const provinceId = parseInt(event.detail.value);
            const provinceData = allData.find(p => p.id === provinceId);

            districtChoices.clearStore();
            districtChoices.setChoices([], 'value', 'label', true);
            districtChoices.enable();

            subDistrictChoices.clearStore();
            subDistrictChoices.setChoices([], 'value', 'label', true);
            subDistrictChoices.disable();

            zipcodeInput.value = '';
            updateZipcodeStyle();

            if (provinceData && provinceData.districts) {
                provinceData.districts.sort((a, b) => a.name_th.localeCompare(b.name_th));
                const districtOptions = provinceData.districts.map(d => ({ value: d.id, label: d.name_th }));
                districtChoices.setChoices(districtOptions, 'value', 'label', true);
            }
        });

        document.getElementById('district').addEventListener('change', function(event) {
            const provinceId = parseInt(document.getElementById('province').value);
            const districtId = parseInt(event.detail.value);
            const provinceData = allData.find(p => p.id === provinceId);
            if (!provinceData) return;
            const districtData = provinceData.districts.find(d => d.id === districtId);

            subDistrictChoices.clearStore();
            subDistrictChoices.setChoices([], 'value', 'label', true);
            subDistrictChoices.enable();

            zipcodeInput.value = '';
            updateZipcodeStyle();

            if (districtData && districtData.sub_districts) {
                districtData.sub_districts.sort((a, b) => a.name_th.localeCompare(b.name_th));
                const subOptions = districtData.sub_districts.map(s => ({
                    value: s.id,
                    label: s.name_th,
                    customProperties: { zip: s.zip_code }
                }));
                subDistrictChoices.setChoices(subOptions, 'value', 'label', true);
            }
        });

        document.getElementById('sub_district').addEventListener('addItem', function(event) {
            const zip = event.detail.customProperties.zip;
            if (zip) {
                zipcodeInput.value = zip;
                updateZipcodeStyle();
            }
        });
        
        document.getElementById('sub_district').addEventListener('change', function(event) {
             if(!event.detail.value) {
                 zipcodeInput.value = '';
                 updateZipcodeStyle();
             }
        });
    });
</script>

@endsection