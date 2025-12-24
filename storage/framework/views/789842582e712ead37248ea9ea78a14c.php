

<?php $__env->startSection('title', 'แจ้งชำระเงิน - Hotmobily'); ?>

<?php $__env->startSection('content'); ?>
<div class="payment-outer-wrapper">
    <div class="page-container">
        <h1 class="payment-main-headline">แจ้งชำระเงิน</h1>

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
                                <img src="<?php echo e(asset('images/line-qr.png')); ?>" alt="Line QR">
                                <p class="line-id-text">Line : hotstrapthai</p>
                            </div>
                        </div>

                        <p class="office-hours-text">เวลาทำการ : จันทร์-ศุกร์ (08:30-17:30 น.)</p>

                        <div class="sidebar-bank-card">
                            <img src="<?php echo e(asset('images/scb-mobile.png')); ?>" alt="SCB Account" class="scb-img">
                            <button type="button" class="payment-copy-btn">คัดลอก</button>
                        </div>
                    </div>
                </div>

                <div class="col-lg-7 payment-form-column">
                    <form action="#" method="POST" class="payment-main-form">
                        <?php echo csrf_field(); ?>
                        <div class="custom-input-group">
                            <label>หมายเลขคำสั่งซื้อ (Order ID) <span class="req">*</span></label>
                            <input type="text" name="order_id" placeholder="" required>
                        </div>

                        <div class="custom-input-group">
                            <label>ชื่อ - นามสกุล <span class="req">*</span></label>
                            <input type="text" name="name" required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 custom-input-group">
                                <label>อีเมล <span class="req">*</span></label>
                                <input type="email" name="email" required>
                            </div>
                            <div class="col-md-6 custom-input-group">
                                <label>เบอร์โทรศัพท์ <span class="req">*</span></label>
                                <input type="text" name="phone" required>
                            </div>
                        </div>

                        <div class="custom-input-group">
                            <label>ยอดเงินที่โอน <span class="req">*</span></label>
                            <input type="number" step="0.01" name="amount" required>
                        </div>

                        <div class="custom-input-group">
                            <label>วันที่ทำรายการ <span class="req">*</span></label>
                            <input type="date" name="transfer_date" required>
                        </div>

                        <div class="custom-input-group">
                            <label>เวลาที่ทำรายการ <span class="req">*</span></label>
                            <input type="time" name="transfer_time" required>
                        </div>

                        <div class="custom-input-group">
                            <label>หลักฐานการชำระเงิน (pdf, jpg, png หรือ gif) <span class="req">*</span></label>
                            <div class="slip-upload-area" id="drop-zone">
                                <input type="file" id="slip-file" hidden required>
                                <label for="slip-file">
                                    <i class="bi bi-upload"></i>
                                    <p>วางไฟล์ตรงนี้ หรือคลิกเพื่อแนบไฟล์</p>
                                </label>
                            </div>
                        </div>

                        <div class="custom-input-group">
                            <label>ข้อความเพิ่มเติม (ถ้ามี) <span class="req">*</span></label>
                            <input type="text" name="note" required>
                        </div>

                        <div class="submit-btn-wrapper">
                            <button type="submit" class="btn-confirm-payment">ยืนยันการชำระเงิน</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="articles-section">
            <h2 class="articles-title">บทความที่คุณอาจสนใจ</h2>
            <div class="articles-list">
                <a href="<?php echo e(route('order-guide')); ?>" class="article-row">
                    <span>ขั้นตอนการสั่งซื้อสินค้า</span>
                    
                    </a>
                    <a href="<?php echo e(route('design-guide')); ?>" class="article-row">
                        <span>วิธีการออกแบบ</span>
                        
                    </a>
            <a href="<?php echo e(route('payment-method')); ?>#section4" class="article-row">
                <span>วิธีการยกเลิกคำสั่งซื้อ</span>

            </a>
            <a href="<?php echo e(route('payment-method')); ?>#section3" class="article-row">
                <span>การจัดส่งสินค้า</span>
                </a>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const copyBtn = document.querySelector('.payment-copy-btn');
    
    if (copyBtn) {
      copyBtn.addEventListener('click', function() {
        const accountNumber = '1912139535'; 
        
        navigator.clipboard.writeText(accountNumber).then(() => {
          const originalText = copyBtn.innerText;
          
          // 🚩 แก้ไข: เหลือแค่การเปลี่ยนข้อความ ไม่ต้องสั่งเปลี่ยนสี (Style)
          copyBtn.innerText = 'คัดลอกแล้ว ✓';

          setTimeout(() => {
            copyBtn.innerText = originalText;
            // 🚩 ลบส่วนที่สั่งคืนค่าสีเดิมออกไปด้วยเพื่อให้โค้ดสะอาด
          }, 2000);
        });
      });
    }
  });
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/payment.blade.php ENDPATH**/ ?>