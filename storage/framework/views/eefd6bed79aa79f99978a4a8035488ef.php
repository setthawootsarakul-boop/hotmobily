<nav class="navbar navbar-expand-lg sticky-top bg-orange shadow-sm">
  <div class="container d-flex align-items-center justify-content-between px-lg-3 px-2">

    
    <a class="navbar-brand d-flex align-items-center me-lg-2" href="/">
      <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Hotmobily Logo" height="40">
    </a>

    
    <div id="navbarNav" class="collapse navbar-collapse justify-content-center order-2 order-lg-1 d-none d-lg-flex">
      <ul class="navbar-nav align-items-center gap-4">

        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-normal" href="#" id="navbarProducts" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            สินค้าทั้งหมด
            <i class="bi bi-chevron-down caret-icon ms-1"></i>
          </a>
          <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarProducts">
            <li><a class="dropdown-item" href="<?php echo e(route('products.index')); ?>">สินค้าทั้งหมด</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-keychain')); ?>">พวงกุญแจอะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'rubber-keychain')); ?>">พวงกุญแจยาง</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'reflective-keychain')); ?>">พวงกุญแจสะท้อนแสง</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'screen-reflective-keychain')); ?>">พวงกุญแจสกรีนลายสะท้อนแสง</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-coaster')); ?>">ที่รองแก้วอะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'rubber-coaster')); ?>">ที่รองแก้วยาง</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-standee')); ?>">สแตนดี้อะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-phone-stand')); ?>">แท่นวางโทรศัพท์มือถืออะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-pin')); ?>">เข็มกลัดอะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-hair-tie')); ?>">ยางรัดผมอะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'griptok')); ?>">กริ๊บต๊อก</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'key-cover')); ?>">ยางหุ้มกุญแจ</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'reflective-sticker')); ?>">สติ๊กเกอร์สะท้อนแสง</a></li>
          </ul>
        </li>

        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-normal" href="#" id="navbarFAQ" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            คำถามที่พบบ่อย
            <i class="bi bi-chevron-down caret-icon ms-1"></i>
          </a>
          <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarFAQ">
            <li><a class="dropdown-item" href="<?php echo e(route('faq')); ?>">คำถามที่พบบ่อย</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('order-guide')); ?>#how-to-order">วิธีการสั่งสินค้า</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('payment-method')); ?>#payment">วิธีการชำระเงิน</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('design-guide')); ?>#design">วิธีการออกแบบ</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('payment-method')); ?>#section4">วิธีการยกเลิกสินค้า</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('cookie-policy')); ?>#cookie-policy">นโยบายคุกกี้</a></li>
          </ul>
        </li>

        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-normal" href="#" id="navbarDetails" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            รายละเอียดเพิ่มเติม
            <i class="bi bi-chevron-down caret-icon ms-1"></i>
          </a>
          <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarDetails">
            <li><a class="dropdown-item" href="<?php echo e(route('accessories')); ?>#accessory">อุปกรณ์เสริม</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('gallery.index')); ?>#gallery">แกลลอรี่</a></li>
          </ul>
        </li>

        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-normal" href="#" id="navbarContact" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ติดต่อเรา
            <i class="bi bi-chevron-down caret-icon ms-1"></i>
          </a>
          <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarContact">
            <li><a class="dropdown-item" href="<?php echo e(route('contact.full')); ?>">ติดต่อบริษัท</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('payment')); ?>">แจ้งชำระเงิน</a></li>
          </ul>
        </li>
      </ul>
    </div>

    
    <div class="d-flex align-items-center order-1 order-lg-2">
      
    <a href="<?php echo e(route('cart.index')); ?>" class="nav-link cart-link position-relative"> 
          
          <img src="<?php echo e(asset('images/vector.png')); ?>" alt="Cart" class="cart-icon-img">
          
          <?php
              $cartCount = 0;
              // ใช้วิธีดึงจาก DB แทน Cookie
              try {
                  $sessionId = session()->getId();
                  // ถ้ามี Model CartItem ให้เรียกใช้ (ใส่ namespace เต็ม หรือ use ข้างบน)
                  $cartCount = \App\Models\CartItem::where('session_id', $sessionId)->count();
              } catch (\Exception $e) {
                  $cartCount = 0;
              }
          ?>


          
          <?php if($cartCount > 0): ?>
            <span class="badge rounded-pill bg-danger position-absolute custom-badge-pos">
                <?php echo e($cartCount); ?>

                <span class="visually-hidden">items in cart</span>
            </span>
          <?php endif; ?>
      </a>

      <button class="navbar-toggler border-0 d-lg-none ms-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</nav>


<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header align-items-center">
    <div class="d-flex align-items-center">
      <img src="<?php echo e(asset('images/logo.png')); ?>" alt="Hotmobily Logo" height="40" class="me-2">
      <h5 class="mb-0 fw-bold">Hotmobily Thai</h5>
    </div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body">
    <ul class="navbar-nav flex-column gap-2">
      
      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle fw-bold" href="#" id="mobileProducts" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          สินค้าทั้งหมด
          <i class="bi bi-chevron-down caret-icon ms-auto"></i>
        </a>
        <ul class="dropdown-menu border-0 shadow-sm ps-3" aria-labelledby="mobileProducts">
            <li><a class="dropdown-item" href="<?php echo e(route('products.index')); ?>">สินค้าทั้งหมด</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-keychain')); ?>">พวงกุญแจอะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'rubber-keychain')); ?>">พวงกุญแจยาง</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'reflective-keychain')); ?>">พวงกุญแจสะท้อนแสง</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'screen-reflective-keychain')); ?>">พวงกุญแจสกรีนลายสะท้อนแสง</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-coaster')); ?>">ที่รองแก้วอะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'rubber-coaster')); ?>">ที่รองแก้วยาง</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-standee')); ?>">สแตนดี้อะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-phone-stand')); ?>">แท่นวางโทรศัพท์มือถืออะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-pin')); ?>">เข็มกลัดอะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'acrylic-hair-tie')); ?>">ยางรัดผมอะคริลิค</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'griptok')); ?>">กริ๊บต๊อก</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'key-cover')); ?>">ยางหุ้มกุญแจ</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('products.show', 'reflective-sticker')); ?>">สติ๊กเกอร์สะท้อนแสง</a></li>
        </ul>
      </li>

      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle fw-bold" href="#" id="mobileFAQ" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          คำถามที่พบบ่อย
          <i class="bi bi-chevron-down caret-icon ms-auto"></i>
        </a>
        <ul class="dropdown-menu border-0 shadow-sm ps-3" aria-labelledby="mobileFAQ">
            <li><a class="dropdown-item" href="<?php echo e(route('faq')); ?>">คำถามที่พบบ่อย</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('order-guide')); ?>#how-to-order">วิธีการสั่งสินค้า</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('payment-method')); ?>#payment">วิธีการชำระเงิน</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('design-guide')); ?>#design">วิธีการออกแบบ</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('payment-method')); ?>#section4">วิธีการยกเลิกสินค้า</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('faq')); ?>#cookie-policy">นโยบายคุกกี้</a></li>
        </ul>
      </li>

      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle fw-bold" href="#" id="mobileDetails" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          รายละเอียดเพิ่มเติม
          <i class="bi bi-chevron-down caret-icon ms-auto"></i>
        </a>
        <ul class="dropdown-menu border-0 shadow-sm ps-3" aria-labelledby="mobileDetails">
            <li><a class="dropdown-item" href="<?php echo e(route('accessories')); ?>#accessory">อุปกรณ์เสริม</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('gallery.index')); ?>#gallery">แกลลอรี่</a></li>
        </ul>
      </li>

      
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle fw-bold" href="#" id="mobileContact" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          ติดต่อเรา
          <i class="bi bi-chevron-down caret-icon ms-auto"></i>
        </a>
        <ul class="dropdown-menu border-0 shadow-sm ps-3" aria-labelledby="mobileContact">
            <li><a class="dropdown-item" href="<?php echo e(route('contact.full')); ?>">ติดต่อบริษัท</a></li>
            <li><a class="dropdown-item" href="<?php echo e(route('payment')); ?>">แจ้งชำระเงิน</a></li>
        </ul>
      </li>

    </ul>
  </div>
</div><?php /**PATH C:\project\hotmobily\resources\views/partials/navbar.blade.php ENDPATH**/ ?>