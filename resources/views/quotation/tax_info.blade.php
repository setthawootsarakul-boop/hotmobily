@extends('layouts.main')

@section('title', 'ขอใบเสนอราคา - ข้อมูลใบกำกับภาษี')

@section('content')



{{-- ✅ Choices.js CSS --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css" />

<style>
    
    .choices { margin-bottom: 0; }
    .choices__inner { background-color: #fff; border: 1px solid #e0e0e0; border-radius: 6px; min-height: 44px; padding: 4px 10px; display: flex; align-items: center; font-size: 14px; }
    .choices.is-focused .choices__inner { border-color: #FFA726; box-shadow: 0 0 0 0.2rem rgba(255, 167, 38, 0.25); }
    .choices.is-disabled .choices__inner { background-color: #E9ECEF; cursor: not-allowed; }
    .choices__placeholder { color: #6c757d; opacity: 1; }
    .form-control::placeholder { color: #6c757d; opacity: 1; }
    .choices__list--dropdown .choices__input { background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23999' class='bi bi-search' viewBox='0 0 16 16'%3E%3Cpath d='M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z'%3E%3C/path%3E%3C/svg%3E"); background-repeat: no-repeat; background-position: 10px center; background-size: 16px; padding-left: 35px !important; border-radius: 4px; background-color: #f8f9fa; border: 1px solid #eee; margin-bottom: 5px; }
    .form-control.is-invalid { border-color: #dc3545 !important; padding-right: calc(1.5em + .75rem); background-image: none !important; }
    .choices.is-invalid .choices__inner { border-color: #dc3545 !important; background-image: none; }
    .invalid-feedback { display: none; width: 100%; margin-top: .25rem; font-size: .875em; color: #dc3545; font-weight: 500; }
    .d-block { display: block !important; }
    .person-type-label { cursor: pointer; display: flex; align-items: center; gap: 8px; margin-right: 20px; font-weight: 500; }
    .person-type-radio { width: 18px; height: 18px; accent-color: #0d6efd; cursor: pointer; }
</style>

<div class="main-wrapper-white" style="background-color: #ffffff; min-height: 100vh;">
<div class="container py-5">
    <div class="text-center mb-5"><h1 class="quotation-title">ขอใบเสนอราคา</h1></div>

    <form action="{{ route('quotation.confirm') }}" method="POST" id="taxInfoForm" novalidate>
        @csrf

        {{-- 🔥 เพิ่ม Hidden Inputs สำหรับเก็บชื่อสถานที่ (ภาษาไทย) เพื่อนำไปโชว์ในใบเสนอราคา 🔥 --}}
        <input type="hidden" name="tax_province_name" id="tax_province_name">
        <input type="hidden" name="tax_district_name" id="tax_district_name">
        <input type="hidden" name="tax_sub_district_name" id="tax_sub_district_name">

        <h4 class="section-header mt-0">ประเภทการขอใบกำกับภาษี</h4>
        <div class="d-flex mb-4">
            <label class="person-type-label">
                <input type="radio" name="tax_person_type" value="individual" class="person-type-radio" checked>
                <span>บุคคลธรรมดา</span>
            </label>
            <label class="person-type-label">
                <input type="radio" name="tax_person_type" value="juristic" class="person-type-radio">
                <span>นิติบุคคล</span>
            </label>
        </div>

        <div class="row g-3 mb-4">
            {{-- ช่องชื่อบริษัท (ซ่อนไว้เริ่มต้น) --}}
            <div class="col-md-12" id="company_name_wrapper" style="display: none;">
                <label class="form-label">ชื่อบริษัท / นิติบุคคล <span class="text-danger">*</span></label>
                <input type="text" name="tax_company" id="tax_company" class="form-control" placeholder="">
                <div class="invalid-feedback">กรุณากรอกชื่อบริษัท</div>
            </div>

            <div class="col-md-6">
                <label class="form-label" id="label_tax_name">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                <input type="text" name="tax_name" class="form-control" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">เลขประจำตัวผู้เสียภาษี <span class="text-danger">*</span></label>
                <input type="text" name="tax_id" class="form-control" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
        </div>

        <h4 class="section-header">ที่อยู่ในใบกำกับภาษี</h4>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">จังหวัด <span class="text-danger">*</span></label>
                <div id="province-wrapper">
                    <select name="tax_province" id="tax_province" class="form-control" required></select>
                </div>
                <div class="invalid-feedback" id="tax_province-error">โปรดเลือกจังหวัด</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">อำเภอ / เขต <span class="text-danger">*</span></label>
                <div id="district-wrapper">
                    <select name="tax_district" id="district" class="form-control" required disabled></select>
                </div>
                <div class="invalid-feedback" id="tax_district-error">โปรดเลือกอำเภอ / เขต</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">ตำบล / แขวง <span class="text-danger">*</span></label>
                <div id="sub-district-wrapper">
                    <select name="tax_sub_district" id="sub_district" class="form-control" required disabled></select>
                </div>
                <div class="invalid-feedback" id="tax_sub_district-error">โปรดเลือกตำบล / แขวง</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
                <input type="text" name="tax_zipcode" id="tax_zipcode" class="form-control" style="background-color: #E9ECEF;" readonly required placeholder="รหัสไปรษณีย์">
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
        </div>

        {{-- Detail Address --}}
        <div class="row g-3 mb-4">
        <div class="col-md-4">
                <label class="form-label font-weight-bold">เลขที่ <span class="text-danger">*</span></label>
                <input type="text" name="tax_address_no" class="form-control" required>
                <div class="invalid-feedback">กรุณากรอกเลขที่ที่อยู่</div>
            </div>
            <div class="col-md-4">
                <label class="form-label font-weight-bold">ชื่ออาคาร <span class="text-danger">*</span></label>
                <input type="text" name="tax_building" class="form-control" required>
                <div class="invalid-feedback">กรุณากรอกชื่ออาคาร</div>
            </div>
            <div class="col-md-4"><label class="form-label">ชั้นที่</label><input type="text" name="tax_floor" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">หมู่</label><input type="text" name="tax_moo" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">หมู่บ้าน</label><input type="text" name="tax_village" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">ซอย</label><input type="text" name="tax_soi" class="form-control"></div>
            <div class="col-md-6"><label class="form-label">ถนน</label><input type="text" name="tax_road" class="form-control"></div>
        </div>

        <div class="mb-5">
            <label class="form-label">ข้อความเพิ่มเติม <small class="text-muted">กรุณาระบุข้อมูล หรือข้อความ ตามที่ท่านต้องการ กรณีไม่มีข้อมูลให้เว้นว่างไว้ไม่ต้องใส่ - (ขีด)</small></label>
            <textarea name="tax_note" class="form-control" rows="3"></textarea>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5">
            <a href="{{ route('quotation.index') }}" class="btn btn-back">ย้อนกลับ</a>
            <button type="button" class="btn btn-create-quote" onclick="preSubmitCheck()">สร้างใบเสนอราคา</button>
        </div>
    </form>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ประกาศตัวแปร instance ของ Choices
    let provinceChoices, districtChoices, subDistrictChoices;


    function preSubmitCheck() {
        const form = document.getElementById('taxInfoForm');
        let isValid = true;

        
        document.getElementById('tax_province_name').value = provinceChoices.getValue(true) || '';
        document.getElementById('tax_district_name').value = districtChoices.getValue(true) || '';
        document.getElementById('tax_sub_district_name').value = subDistrictChoices.getValue(true) || '';

        
        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.choices.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.invalid-feedback').forEach(el => el.classList.remove('d-block'));

        
        form.querySelectorAll('input[required]').forEach(input => {
            
            if (input.offsetParent !== null) {
                if (!input.value.trim()) {
                    input.classList.add('is-invalid');
                    const errorDiv = input.nextElementSibling;
                    if (errorDiv && errorDiv.classList.contains('invalid-feedback')) errorDiv.classList.add('d-block');
                    isValid = false;
                }
            }
        });

        // 2. ตรวจสอบ Select (Choices.js)
        ['tax_province', 'district', 'sub_district'].forEach(id => {
            const select = document.getElementById(id);
            if (select && select.value === "") {
                const wrapper = select.closest('.choices');
                if (wrapper) wrapper.classList.add('is-invalid');
                const errorMsg = document.getElementById(id.includes('tax') ? id + '-error' : 'tax_' + id + '-error');
                if (errorMsg) errorMsg.classList.add('d-block');
                isValid = false;
            }
        });

        if (isValid) {
            Swal.fire({
                title: 'ยืนยันขอใบเสนอราคา',
                html: `<div class="mb-3"><img src="{{ asset('images/Hotmobilyfile/poster/robot-bill.png') }}" style="width: 150px; margin-bottom: 15px;"></div><p class="text-muted" style="font-size: 14px;">ใบเสนอราคานี้จัดทำโดยระบบอัตโนมัติเพื่อเป็นการอ้างอิงราคาเบื้องต้นเท่านั้น</p>`,
                showCancelButton: true, confirmButtonText: 'ดำเนินการต่อ', cancelButtonText: 'ยกเลิก',
                confirmButtonColor: '#ff8c00', cancelButtonColor: '#fff',
                customClass: { popup: 'custom-swal-popup', confirmButton: 'custom-swal-confirm', cancelButton: 'custom-swal-cancel' },
                reverseButtons: true, scrollbarPadding: false, heightAuto: false
            }).then((result) => { if (result.isConfirmed) form.submit(); });
        } else {
            const firstError = document.querySelector('.is-invalid');
            if (firstError) firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const choicesConfig = { searchEnabled: true, itemSelectText: '', shouldSort: false, searchPlaceholderValue: 'พิมพ์เพื่อค้นหา...', noResultsText: 'ไม่พบข้อมูล', noChoicesText: 'ไม่มีข้อมูล', allowHTML: true };
        
        provinceChoices = new Choices('#tax_province', { ...choicesConfig, placeholderValue: 'เลือกจังหวัด' });
        districtChoices = new Choices('#district', { ...choicesConfig, placeholderValue: 'เลือกอำเภอ / เขต' });
        subDistrictChoices = new Choices('#sub_district', { ...choicesConfig, placeholderValue: 'เลือกตำบล / แขวง' });

        // --- ✅ เพิ่มระบบสลับ นิติบุคคล / บุคคลธรรมดา ---
        const radioIndividual = document.querySelector('input[value="individual"]');
        const radioJuristic = document.querySelector('input[value="juristic"]');
        const companyWrapper = document.getElementById('company_name_wrapper');
        const taxCompanyInput = document.getElementById('tax_company');
        const labelTaxName = document.querySelector('label[for="tax_name"]') || document.getElementById('label_tax_name');

        function togglePersonType() {
            if (radioJuristic.checked) {
                companyWrapper.style.display = 'block';
                taxCompanyInput.setAttribute('required', 'required'); // บังคับกรอกชื่อบริษัท
                if(labelTaxName) labelTaxName.innerHTML = 'ชื่อผู้ติดต่อ <span class="text-danger">*</span>';
            } else {
                companyWrapper.style.display = 'none';
                taxCompanyInput.removeAttribute('required'); // ไม่บังคับกรอก
                taxCompanyInput.value = '';
                if(labelTaxName) labelTaxName.innerHTML = 'ชื่อ - นามสกุล <span class="text-danger">*</span>';
            }
        }

        radioIndividual.addEventListener('change', togglePersonType);
        radioJuristic.addEventListener('change', togglePersonType);
        // ------------------------------------------
        
        const zipcodeInput = document.getElementById('tax_zipcode');
        let allData = [];

        axios.get('{{ asset("province_with_district_and_sub_district.json") }}').then(response => { 
            allData = response.data; 
            populateProvinces(); 
        });

        function populateProvinces() {
            allData.sort((a, b) => {
                if (a.name_th === 'กรุงเทพมหานคร') return -1;
                if (b.name_th === 'กรุงเทพมหานคร') return 1;
                return a.name_th.localeCompare(b.name_th);
            });
            const provinceOptions = allData.map(p => ({ value: p.id, label: p.name_th }));
            provinceOptions.unshift({ value: '', label: 'เลือกจังหวัด', selected: true, disabled: true, placeholder: true });
            provinceChoices.setChoices(provinceOptions, 'value', 'label', true);
        }

        document.getElementById('tax_province').addEventListener('change', function(event) {
            const provinceId = parseInt(event.detail.value);
            const provinceData = allData.find(p => p.id === provinceId);
            districtChoices.clearStore(); districtChoices.enable();
            subDistrictChoices.clearStore(); subDistrictChoices.disable();
            zipcodeInput.value = '';
            if (provinceData && provinceData.districts) {
                provinceData.districts.sort((a, b) => a.name_th.localeCompare(b.name_th));
                districtChoices.setChoices(provinceData.districts.map(d => ({ value: d.id, label: d.name_th })), 'value', 'label', true);
            }
        });

        document.getElementById('district').addEventListener('change', function(event) {
            const provinceId = parseInt(document.getElementById('tax_province').value);
            const districtId = parseInt(event.detail.value);
            const provinceData = allData.find(p => p.id === provinceId);
            if (!provinceData) return;
            const districtData = provinceData.districts.find(d => d.id === districtId);
            subDistrictChoices.clearStore(); subDistrictChoices.enable();
            zipcodeInput.value = '';
            if (districtData && districtData.sub_districts) {
                districtData.sub_districts.sort((a, b) => a.name_th.localeCompare(b.name_th));
                subDistrictChoices.setChoices(districtData.sub_districts.map(s => ({ value: s.id, label: s.name_th, customProperties: { zip: s.zip_code } })), 'value', 'label', true);
            }
        });

        document.getElementById('sub_district').addEventListener('addItem', function(event) {
            const zip = event.detail.customProperties.zip; 
            if (zip) zipcodeInput.value = zip;
        });
    });
</script>