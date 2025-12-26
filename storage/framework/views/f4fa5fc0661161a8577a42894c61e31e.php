<footer class="footer-section text-light pt-5"> 
  <div class="footer-box">
    <div class="container pb-4">
      <div class="row gy-4 align-items-stretch">
        
        <div class="col-md-4 text-center text-md-start footer-company">
          <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Hotmobily Logo" class="footer-logo mb-3">
          
          <p class="mb-2">บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</p>
          <p class="mb-2">(จันทร์ - ศุกร์ 8.30 - 17.30)</p>
          
          <p class="mb-2">
            ที่อยู่ : 23/34-35<br>
            อาคารโครงการเดอะโฟร์ม หัวลำโพง<br>
            อาคาร A ห้องเลขที่ 303 ชั้นที่ 3<br>
            ซอยสุกร แขวงตลาดน้อย<br>
            เขตสัมพันธวงศ์ กรุงเทพมหานคร<br>
            10100
          </p>
          
          <p class="mt-2">
            โทร : <a href="tel:0646045614">064-604-5614</a>
          </p>
        </div>

        <div class="col-md-4 text-center text-md-start footer-subscribe">
            <h5 class="fw-bold mb-3" style="color: #ddd;">สมัครสมาชิกเพื่อรับข่าวสาร</h5>
            <p class="small mb-3">รับโปรโมชั่นลับพิเศษและข่าวสารใหม่ๆ จากเราได้ก่อนใคร</p>
            
            <form action="<?php echo e(route('newsletter.subscribe')); ?>" method="POST" class="d-flex flex-column">
                <?php echo csrf_field(); ?>
                <div class="d-flex flex-column flex-sm-row gap-2">
                    <input type="email" name="email" class="form-control me-2" placeholder="ระบุอีเมลของคุณ" required>
                    <button type="submit" class="btn btn-warning fw-semibold px-3">สมัครเลย</button>
                </div>
                
                
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <small class="text-danger mt-2"><?php echo e($message); ?></small>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                
                <?php if(session('subscribe_success')): ?>
                    <small class="text-success mt-2"><?php echo e(session('subscribe_success')); ?></small>
                <?php endif; ?>
            </form>
        </div>

        <div class="col-md-4 text-center text-md-start footer-social">
          <div class="social-icons-footer">
            <a href="#"><img src="<?php echo e(asset('images/fb.png')); ?>" class="social-img" alt="Facebook"></a>
            <a href="#"><img src="<?php echo e(asset('images/line.png')); ?>" class="social-img" alt="LINE"></a>
            <a href="#"><img src="<?php echo e(asset('images/x.png')); ?>" class="social-img" alt="X"></a>
            <a href="#"><img src="<?php echo e(asset('images/gmail.png')); ?>" class="social-img" alt="Gmail"></a>
          </div>
          <p>Line : <span>hotstrapthai</span></p>
          <img src="<?php echo e(asset('images/line-qr.png')); ?>" alt="Line QR Code" class="qr-code">
        </div>

      </div>
    </div>

    <div class="footer-links-section py-3"> 
      <div class="container text-center">
        <div class="footer-links d-flex flex-wrap justify-content-center align-items-center">
          
        <div class="footer-links">
            <a href="<?php echo e(route('products.index')); ?>">สินค้าทั้งหมด</a> <span class="divider">|</span>
            <a href="<?php echo e(route('order-guide')); ?>">วิธีการสั่งสินค้า</a> <span class="divider">|</span>
            <a href="<?php echo e(route('payment-method')); ?>">วิธีการชำระเงิน</a> <span class="divider">|</span>
            <a href="<?php echo e(route('design-guide')); ?>">วิธีการออกแบบ</a> <span class="divider">|</span>
            <a href="<?php echo e(route('payment-method')); ?>#section4">วิธีการยกเลิกสินค้า</a> <span class="divider">|</span>
            <a href="<?php echo e(route('payment-method')); ?>#section4">ระยะเวลาการจัดส่ง</a> <span class="divider">|</span>
            
            <div class="w-100 d-none d-lg-block my-1"></div>
            
            <a href="<?php echo e(route('payment')); ?>">แจ้งชำระเงิน</a> <span class="divider">|</span>
            <a href="<?php echo e(route('accessories')); ?>">อุปกรณ์เสริม</a> <span class="divider">|</span>
            <a href="<?php echo e(route('gallery.index')); ?>">แกลลอรี่</a> <span class="divider">|</span>
            <a href="<?php echo e(route('contact')); ?>">ติดต่อเรา</a> <span class="divider">|</span>
            <a href="<?php echo e(route('faq')); ?>">คำถามที่พบบ่อย</a> <span class="divider">|</span>
            <a href="<?php echo e(route('cookie-policy')); ?>">นโยบายคุกกี้</a>
        </div>

        </div>
      </div>
    </div>

    <div class="footer-bottom-section">
      <p>Copyright © 2025 YOU AND EARTH (THAILAND) CO., LTD.</p>
    </div>
  </div>

<button type="button" class="btn-back-to-top" id="btn-back-to-top" aria-label="Back to Top">
  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 16 16">
    <path fill-rule="evenodd" d="M7.646 4.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1-.708.708L8 5.707l-5.646 5.647a.5.5 0 0 1-.708-.708l6-6z"/>
  </svg>
</button>

<style>
  .btn-back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    z-index: 9999;
    
    width: 50px;
    height: 50px;
    border-radius: 50%;
    border: none;
    
    /* สีพื้นหลังแบบไล่เฉด (Modern Gradient) เข้ากับธีมสีส้ม/เหลือง */
    background: linear-gradient(135deg, #ffc107, #fbab00);
    color: #fff;
    

    display: flex;
    align-items: center;
    justify-content: center;

    opacity: 0;
    visibility: hidden;
    transform: translateY(20px); /* ดันลงไปข้างล่างนิดหน่อยตอนซ่อน */
    
    /* Animation Settings */
    transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55); /* เด้งดึ๋งนิดๆ */
    cursor: pointer;
  }

  /* สถานะตอนโชว์ (Class นี้จะถูกใส่ด้วย JS) */
  .btn-back-to-top.show {
    opacity: 1;
    visibility: visible;
    transform: translateY(0);
  }

  
  /* Active Effect (ตอนกด) */
  .btn-back-to-top:active {
    transform: scale(0.95);
  }
</style>

<script>
  // ดึงปุ่มมาเก็บในตัวแปร
  let mybutton = document.getElementById("btn-back-to-top");

  // เมื่อมีการ Scroll ให้ทำงานฟังก์ชัน
  window.onscroll = function () {
    scrollFunction();
  };

  function scrollFunction() {
    // ถ้าเลื่อนลงมามากกว่า 300px ให้ใส่ class "show" เพื่อ Fade In
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
      mybutton.classList.add("show");
    } else {
      mybutton.classList.remove("show");
    }
  }

  // เมื่อกดปุ่ม ให้เลื่อนขึ้นบนสุด
  mybutton.addEventListener("click", backToTop);

  function backToTop() {
    window.scrollTo({
      top: 0,
      behavior: "smooth" // เลื่อนแบบนุ่มนวล
    });
  }
</script><?php /**PATH C:\project\hotmobily\resources\views/partials/footer.blade.php ENDPATH**/ ?>