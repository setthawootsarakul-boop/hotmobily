<?php $__env->startSection('title', 'ขอใบเสนอราคา'); ?>

<?php $__env->startSection('content'); ?>


<link rel="stylesheet" href="<?php echo e(asset('css/quotation.css')); ?>">


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

    /* Custom Tax Radio Card */
    .tax-options-container { display: flex; gap: 15px; flex-wrap: wrap; }
    .tax-option-card {
        flex: 1; min-width: 250px;
        border: 1px solid #e0e0e0; border-radius: 8px;
        padding: 15px 20px; cursor: pointer;
        transition: all 0.2s ease-in-out;
        background-color: #fff;
    }
    
    .custom-radio-icon {
        width: 24px; height: 24px;
        border: 2px solid #ccc; border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        margin-right: 10px; flex-shrink: 0;
    }
    .custom-radio-icon.checked {
        border-color: #FFA726; background-color: #FFA726; color: white;
    }

    /* SweetAlert Styles */
    .custom-swal-popup { border-radius: 15px !important; padding: 2rem !important; }
    .custom-swal-confirm { background-color: #FFA726 !important; border-color: #FFA726 !important; box-shadow: none !important; padding: 10px 25px !important; font-weight: bold; }
    .custom-swal-cancel { color: #666 !important; background: #f8f9fa !important; border: 1px solid #ddd !important; padding: 10px 25px !important; font-weight: bold; }
</style>

<div class="container py-5">
    
    <?php if(session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show mb-4 shadow-sm" role="alert" style="border-left: 5px solid #dc3545;">
            <div class="d-flex align-items-center">
                <i class="bi bi-exclamation-triangle-fill fs-4 me-3"></i>
                <div>
                    <strong>แจ้งเตือน!</strong> <?php echo e(session('error')); ?>

                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif; ?>

    <div class="text-center mb-5"><h1 class="quotation-title">ขอใบเสนอราคา</h1></div>

    <form action="<?php echo e(route('quotation.step1')); ?>" method="POST" id="quotationForm" novalidate>
        <?php echo csrf_field(); ?>

        
        <input type="hidden" name="province_name" id="province_name">
        <input type="hidden" name="district_name" id="district_name">
        <input type="hidden" name="sub_district_name" id="sub_district_name">

        
        <h4 class="section-header">ที่อยู่ในการรับสินค้า</h4>

        <div class="row g-3 mb-4">
            <div class="col-md-6">
                <label class="form-label">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                <input type="text" name="fullname" class="form-control" value="<?php echo e(old('fullname', $tempData['fullname'] ?? '')); ?>" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-md-6">
                <label class="form-label">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                <input type="text" name="phone" class="form-control" value="<?php echo e(old('phone', $tempData['phone'] ?? '')); ?>" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
            <div class="col-12">
                <label class="form-label">อีเมล <span class="text-danger">*</span></label>
                <input type="email" name="email" class="form-control" value="<?php echo e(old('email', $tempData['email'] ?? '')); ?>" required>
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
        </div>

        
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
                <input type="text" name="zipcode" id="zipcode" class="form-control" style="background-color: #E9ECEF;" readonly required placeholder="รหัสไปรษณีย์">
                <div class="invalid-feedback">กรุณากรอกข้อมูล</div>
            </div>
        </div>

        
        <div class="row g-3 mb-4">
            <div class="col-md-4"><label class="form-label">เลขที่</label><input type="text" name="address_no" class="form-control" value="<?php echo e(old('address_no', $tempData['address_no'] ?? '')); ?>"></div>
            <div class="col-md-4"><label class="form-label">ชื่ออาคาร</label><input type="text" name="building" class="form-control" value="<?php echo e(old('building', $tempData['building'] ?? '')); ?>"></div>
            <div class="col-md-4"><label class="form-label">ชั้นที่</label><input type="text" name="floor" class="form-control" value="<?php echo e(old('floor', $tempData['floor'] ?? '')); ?>"></div>
            <div class="col-md-6"><label class="form-label">หมู่</label><input type="text" name="moo" class="form-control" value="<?php echo e(old('moo', $tempData['moo'] ?? '')); ?>"></div>
            <div class="col-md-6"><label class="form-label">หมู่บ้าน</label><input type="text" name="village" class="form-control" value="<?php echo e(old('village', $tempData['village'] ?? '')); ?>"></div>
            <div class="col-md-6"><label class="form-label">ซอย</label><input type="text" name="soi" class="form-control" value="<?php echo e(old('soi', $tempData['soi'] ?? '')); ?>"></div>
            <div class="col-md-6"><label class="form-label">ถนน</label><input type="text" name="road" class="form-control" value="<?php echo e(old('road', $tempData['road'] ?? '')); ?>"></div>
        </div>

        <div class="mb-5">
            <label class="form-label">ข้อความเพิ่มเติม <small class="text-muted">* กรุณาระบุข้อมูล หรือข้อความ ตามที่ท่านต้องการ กรณีไม่มีข้อมูลให้เว้นว่างไว้ไม่ต้องใส่ - (ขีด)</small></label>
            <textarea name="note" class="form-control" rows="3"><?php echo e(old('note', $tempData['note'] ?? '')); ?></textarea>
        </div>

        
        <h4 class="section-header">ใบกำกับภาษี</h4>
        
        <div class="tax-options-container mb-5">
            <label class="tax-option-card selected" id="opt-no-tax">
                <div class="d-flex align-items-center w-100">
                    <div class="custom-radio-icon checked me-3">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <span class="fw-bold text-dark">ไม่ต้องการใบกำกับภาษี</span>
                    <i class="bi bi-file-earmark-x ms-2 text-muted fs-4"></i>
                </div>
                <input type="radio" name="tax_invoice_req" value="0" checked hidden onchange="selectTaxOption(this)">
            </label>

            <label class="tax-option-card" id="opt-paper-tax">
                <div class="d-flex align-items-center w-100">
                    <div class="custom-radio-icon me-3"></div>
                    <span class="fw-bold text-dark">แบบกระดาษ</span>
                    <i class="bi bi-file-earmark-text ms-2 text-muted fs-4"></i>
                </div>
                <input type="radio" name="tax_invoice_req" value="1" hidden onchange="selectTaxOption(this)">
            </label>
        </div>

        <div class="d-flex justify-content-between align-items-center mt-5">
            <a href="<?php echo e(route('cart.index')); ?>" class="btn btn-back">ย้อนกลับ</a>
            <button type="button" class="btn btn-create-quote" onclick="preSubmitCheck()">สร้างใบเสนอราคา</button>
        </div>

    </form>
</div>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // ประกาศตัวแปรเก็บ instance ของ Choices เพื่อใช้เรียกภายหลัง
    let provinceChoices, districtChoices, subDistrictChoices;

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

    function preSubmitCheck() {
        const form = document.getElementById('quotationForm');
        let isValid = true;

        // 🔥 ดึงชื่อสถานที่จริงมาเก็บไว้ใน Hidden Input ก่อน Submit 🔥
        // ใช้ .getValue(true) เพื่อเอาข้อความ (Label) แทน Value (ID)
        document.getElementById('province_name').value = provinceChoices.getValue(true) || '';
        document.getElementById('district_name').value = districtChoices.getValue(true) || '';
        document.getElementById('sub_district_name').value = subDistrictChoices.getValue(true) || '';

        form.querySelectorAll('.is-invalid').forEach(el => el.classList.remove('is-invalid'));
        form.querySelectorAll('.choices.is-invalid').forEach(el => el.classList.remove('is-invalid')); 
        form.querySelectorAll('.invalid-feedback').forEach(el => el.classList.remove('d-block'));

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

        ['province', 'district', 'sub_district'].forEach(id => {
            const select = document.getElementById(id);
            if (select && select.value === "") {
                const wrapper = select.closest('.choices') || select.parentElement.querySelector('.choices');
                if(wrapper) wrapper.classList.add('is-invalid');
                const errorMsg = document.getElementById(id + '-error');
                if(errorMsg) errorMsg.classList.add('d-block');
                isValid = false;
            }
        });

        if (isValid) {
            const taxReq = document.querySelector('input[name="tax_invoice_req"]:checked').value;

            if (taxReq === '1') {
                form.submit();
                return; 
            }

            Swal.fire({
                title: 'ยืนยันขอใบเสนอราคา',
                html: `
                    <div class="mb-3">
                        <img src="<?php echo e(asset('images/Hotmobilyfile/poster/robot-bill.png')); ?>" style="width: 150px; margin-bottom: 15px;">
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
            const firstError = document.querySelector('.is-invalid');
            if(firstError) {
                firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
            }
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const choicesConfig = {
            searchEnabled: true, itemSelectText: '', shouldSort: false, searchPlaceholderValue: 'พิมพ์เพื่อค้นหา...', noResultsText: 'ไม่พบข้อมูล', noChoicesText: 'ไม่มีข้อมูล', allowHTML: true
        };

        // กำหนด Instance ให้ตัวแปรที่ประกาศไว้ข้างบน
        provinceChoices = new Choices('#province', { ...choicesConfig, placeholderValue: 'เลือกจังหวัด' });
        districtChoices = new Choices('#district', { ...choicesConfig, placeholderValue: 'เลือกอำเภอ / เขต' });
        subDistrictChoices = new Choices('#sub_district', { ...choicesConfig, placeholderValue: 'เลือกตำบล / แขวง' });

        const zipcodeInput = document.getElementById('zipcode');
        let allData = [];

        axios.get('<?php echo e(asset("province_with_district_and_sub_district.json")); ?>')
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
            provinceOptions.unshift({ value: '', label: 'เลือกจังหวัด', selected: true, disabled: true, placeholder: true });
            provinceChoices.setChoices(provinceOptions, 'value', 'label', true);
        }

        document.getElementById('province').addEventListener('change', function(event) {
            const provinceId = parseInt(event.detail.value);
            const provinceData = allData.find(p => p.id === provinceId);

            districtChoices.clearStore(); districtChoices.setChoices([], 'value', 'label', true); districtChoices.enable();
            subDistrictChoices.clearStore(); subDistrictChoices.setChoices([], 'value', 'label', true); subDistrictChoices.disable();
            zipcodeInput.value = '';

            if (provinceData && provinceData.districts) {
                provinceData.districts.sort((a, b) => a.name_th.localeCompare(b.name_th));
                districtChoices.setChoices(provinceData.districts.map(d => ({ value: d.id, label: d.name_th })), 'value', 'label', true);
            }
        });

        document.getElementById('district').addEventListener('change', function(event) {
            const provinceId = parseInt(document.getElementById('province').value);
            const districtId = parseInt(event.detail.value);
            const provinceData = allData.find(p => p.id === provinceId);
            if (!provinceData) return;
            const districtData = provinceData.districts.find(d => d.id === districtId);

            subDistrictChoices.clearStore(); subDistrictChoices.setChoices([], 'value', 'label', true); subDistrictChoices.enable();
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
        
        document.getElementById('sub_district').addEventListener('change', function(event) {
             if(!event.detail.value) zipcodeInput.value = '';
        });
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Hotmobily\hotmobily\resources\views/quotation/index.blade.php ENDPATH**/ ?>