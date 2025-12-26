<?php $__env->startSection('title', 'ติดต่อเรา - Hotmobily'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/contact-full.css')); ?>">

<div class="contact-full-page">
    <div class="container-xxl">
        <h2 class="contact-main-title">ติดต่อเรา</h2>

        <div class="contact-flex-wrapper">
            
            <div class="contact-info-side">
                <div class="company-brand-header">
                    <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Hotmobily" class="brand-logo-img">
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
                        <img src="<?php echo e(asset('images/line-qr.png')); ?>" alt="Line QR" class="line-qr-img">
                        <p class="line-id-text">Line : hotstrapthai</p>
                    </div>
                </div>

                <div class="social-icons">
                    <a href="#"><img src="<?php echo e(asset('images/fb.png')); ?>" alt="Facebook"></a>
                    <a href="#"><img src="<?php echo e(asset('images/line.png')); ?>" alt="Line"></a>
                    <a href="#"><img src="<?php echo e(asset('images/x.png')); ?>" alt="X"></a>
                    <a href="#"><img src="<?php echo e(asset('images/gmail.png')); ?>" alt="Email"></a>
                </div>
            </div>

            
            <div class="contact-form-side">
                
                <form action="<?php echo e(route('contact.store')); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    
                    
                    <?php if(session('success')): ?>
                        <div class="alert alert-success mb-3"><?php echo e(session('success')); ?></div>
                    <?php endif; ?>

                    
                    <div class="form-group-floating mb-3">
                        
                        <input type="text" name="name" class="form-control" id="name" placeholder=" " value="<?php echo e(old('name')); ?>" required>
                        <label for="name">ชื่อ - นามสกุล <span class="text-danger">*</span></label>
                    </div>

                    
                    <div class="form-group-floating mb-3">
                        <input type="email" name="email" class="form-control" id="email" placeholder=" " value="<?php echo e(old('email')); ?>" required>
                        <label for="email">อีเมล <span class="text-danger">*</span></label>
                    </div>

                    
                    <div class="form-group-floating mb-3">
                        <input type="text" name="phone" class="form-control" id="phone" placeholder=" " value="<?php echo e(old('phone')); ?>" required>
                        <label for="phone">เบอร์โทรศัพท์ <span class="text-danger">*</span></label>
                    </div>
                    
                    <div class="form-group mb-2">
                        <label>เรื่องที่ต้องการติดต่อ</label>
                        <div class="checkbox-grid">
                            
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
                        
                        
                        <div class="file-upload-box" onclick="document.getElementById('file_input').click()">
                            <i class="fas fa-upload"></i>
                            
                            <div id="file_list_display">
                                <p>วางไฟล์ลงที่นี่ หรือคลิกเพื่อแนบไฟล์</p>
                            </div>
                            
                            
                            <input type="file" name="attachment[]" id="file_input" hidden multiple onchange="showMultipleFileNames(this)">
                        </div>
                    </div>

                    <div class="form-group mb-4">
                        <label>ส่งข้อความเพิ่มเติม</label>
                        <div class="form-group-floating">
                            <textarea name="message" class="form-control" id="additional_message" rows="4" placeholder=" "><?php echo e(old('message')); ?></textarea>
                            <label for="additional_message">ข้อความ</label>
                        </div>
                    </div>

                    <button type="submit" class="btn-send-message">ส่งข้อความ</button>
                </form>
            </div>
        </div>
    </div>

    
    <section class="network-section">
        <h3 class="network-title">เว็บไซต์ในเครือของเรา</h3>
        <div class="network-grid">
            <div class="network-item">
                <a href="https://www.youandearth-th.com/" target="_blank">
                    <img src="<?php echo e(asset('images/youandearth.png')); ?>" alt="You and Earth">
                </a>
            </div>
            <div class="network-item">
                <a href="https://hotstrapthai.com/" target="_blank">
                    <img src="<?php echo e(asset('images/hotstrap.png')); ?>" alt="Hotstrap">
                </a>
            </div>
            <div class="network-item">
                <a href="https://hotmobilythai.com/" target="_blank">
                    <img src="<?php echo e(asset('images/hotmobilythai.png')); ?>" alt="Hotmobily">
                </a>
            </div>
            <div class="network-item">
                <a href="https://silicone-wristband-studio.jp/" target="_blank">
                    <img src="<?php echo e(asset('images/silicone.png')); ?>" alt="Hand">
                </a>
            </div>
        </div>
    </section>
</div>


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
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Hotmobily\hotmobily\resources\views/contact-full.blade.php ENDPATH**/ ?>