<nav class="navbar navbar-expand-lg sticky-top bg-orange shadow-sm">
  <div class="container d-flex align-items-center justify-content-between px-lg-3 px-2">

    <a class="navbar-brand d-flex align-items-center me-lg-2" href="/">
      <img src="{{ asset('images/logo.png') }}" alt="Hotmobily Logo" height="40">
    </a>

    <div id="navbarNav" class="collapse navbar-collapse justify-content-center order-2 order-lg-1 d-none d-lg-flex">
      <ul class="navbar-nav align-items-center gap-4">

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarProducts" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            สินค้าทั้งหมด
            <i class="bi bi-chevron-down caret-icon ms-1"></i>
          </a>
          <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarProducts">
            <li><a class="dropdown-item" href="{{ route('products.index') }}">สินค้าทั้งหมด</a></li>
            <li><a class="dropdown-item" href="#">พวงกุญแจอะคริลิค</a></li>
            <li><a class="dropdown-item" href="#">พวงกุญแจยาง</a></li>
            <li><a class="dropdown-item" href="#">พวงกุญแจสะท้อนแสง</a></li>
            <li><a class="dropdown-item" href="#">พวงกุญแจสกรีนลายสะท้อนแสง</a></li>
            <li><a class="dropdown-item" href="#">ที่รองแก้วอะคริลิค</a></li>
            <li><a class="dropdown-item" href="#">ที่รองแก้วยาง</a></li>
            <li><a class="dropdown-item" href="#">สแตนดี้อะคริลิค</a></li>
            <li><a class="dropdown-item" href="#">แท่นวางโทรศัพท์มือถืออะคริลิค</a></li>
            <li><a class="dropdown-item" href="#">เข็มกลัดอะคริลิค</a></li>
            <li><a class="dropdown-item" href="#">ยางรัดผมอะคริลิค</a></li>
            <li><a class="dropdown-item" href="#">กริ๊บต๊อก</a></li>
            <li><a class="dropdown-item" href="#">ยางหุ้มกุญแจ</a></li>
            <li><a class="dropdown-item" href="#">สติ๊กเกอร์สะท้อนแสง</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarFAQ" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            คำถามที่พบบ่อย
            <i class="bi bi-chevron-down caret-icon ms-1"></i>
          </a>
          <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarFAQ">
            <li><a class="dropdown-item" href="{{ route('faq') }}">คำถามที่พบบ่อย</a></li>
            <li><a class="dropdown-item" href="{{ route('order-guide') }}#how-to-order">วิธีการสั่งสินค้า</a></li>
            <li><a class="dropdown-item" href="{{ route('faq') }}#payment">วิธีการชำระเงิน</a></li>
            <li><a class="dropdown-item" href="{{ route('faq') }}#design">วิธีการออกแบบ</a></li>
            <li><a class="dropdown-item" href="{{ route('faq') }}#cancel">วิธีการยกเลิกสินค้า</a></li>
            <li><a class="dropdown-item" href="{{ route('faq') }}#cookie-policy">นโยบายคุกกี้</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarDetails" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            รายละเอียดเพิ่มเติม
            <i class="bi bi-chevron-down caret-icon ms-1"></i>
          </a>
          <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarDetails">
            <li><a class="dropdown-item" href="#accessory">อุปกรณ์เสริม</a></li>
            <li><a class="dropdown-item" href="#gallery">แกลลอรี่</a></li>
          </ul>
        </li>

        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarContact" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ติดต่อเรา
            <i class="bi bi-chevron-down caret-icon ms-1"></i>
          </a>
          <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarContact">
            <li><a class="dropdown-item" href="{{ route('contact.full') }}">ติดต่อบริษัท</a></li>
            <li><a class="dropdown-item" href="#contact">แบบฟอร์มย่อ</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <div class="d-flex align-items-center order-1 order-lg-2">
      <a href="#" class="nav-link fs-4 text-white cart-link me-2">
        <i class="bi bi-cart"></i>
      </a>

      <button class="navbar-toggler border-0 d-lg-none" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu" aria-controls="mobileMenu">
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>
  </div>
</nav>

<div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="mobileMenu" aria-labelledby="mobileMenuLabel">
  <div class="offcanvas-header align-items-center border-bottom">
    <div class="d-flex align-items-center">
      <img src="{{ asset('images/logo.png') }}" alt="Hotmobily Logo" height="40" class="me-2">
      <h5 class="mb-0 fw-bold">Hotmobily Thai</h5>
    </div>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>

  <div class="offcanvas-body">
    <ul class="navbar-nav flex-column gap-2">
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="mobileProducts" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          สินค้าทั้งหมด
          <i class="bi bi-chevron-down caret-icon ms-auto"></i>
        </a>
        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="mobileProducts">
          <li><a class="dropdown-item" href="{{ route('products.index') }}">สินค้าทั้งหมด</a></li>
          <li><a class="dropdown-item" href="#">พวงกุญแจอะคริลิค</a></li>
          <li><a class="dropdown-item" href="#">พวงกุญแจยาง</a></li>
          <li><a class="dropdown-item" href="#">พวงกุญแจสะท้อนแสง</a></li>
          <li><a class="dropdown-item" href="#">พวงกุญแจสกรีนลายสะท้อนแสง</a></li>
          <li><a class="dropdown-item" href="#">ที่รองแก้วอะคริลิค</a></li>
          <li><a class="dropdown-item" href="#">ที่รองแก้วยาง</a></li>
          <li><a class="dropdown-item" href="#">สแตนดี้อะคริลิค</a></li>
          <li><a class="dropdown-item" href="#">แท่นวางโทรศัพท์มือถืออะคริลิค</a></li>
          <li><a class="dropdown-item" href="#">เข็มกลัดอะคริลิค</a></li>
          <li><a class="dropdown-item" href="#">ยางรัดผมอะคริลิค</a></li>
          <li><a class="dropdown-item" href="#">กริ๊บต๊อก</a></li>
          <li><a class="dropdown-item" href="#">ยางหุ้มกุญแจ</a></li>
          <li><a class="dropdown-item" href="#">สติ๊กเกอร์สะท้อนแสง</a></li>
        </ul>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="mobileFAQ" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          คำถามที่พบบ่อย
          <i class="bi bi-chevron-down caret-icon ms-auto"></i>
        </a>
        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="mobileFAQ">
          <li><a class="dropdown-item" href="{{ route('faq') }}">คำถามที่พบบ่อย</a></li>
          <li><a class="dropdown-item" href="{{ route('order-guide') }}#how-to-order">วิธีการสั่งสินค้า</a></li>
          <li><a class="dropdown-item" href="{{ route('order-guide') }}#payment">วิธีการชำระเงิน</a></li>
          <li><a class="dropdown-item" href="{{ route('faq') }}#design">วิธีการออกแบบ</a></li>
          <li><a class="dropdown-item" href="{{ route('faq') }}#cancel">วิธีการยกเลิกสินค้า</a></li>
          <li><a class="dropdown-item" href="{{ route('faq') }}#cookie-policy">นโยบายคุกกี้</a></li>
        </ul>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="mobileDetails" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          รายละเอียดเพิ่มเติม
          <i class="bi bi-chevron-down caret-icon ms-auto"></i>
        </a>
        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="mobileDetails">
          <li><a class="dropdown-item" href="#accessory">อุปกรณ์เสริม</a></li>
          <li><a class="dropdown-item" href="#gallery">แกลลอรี่</a></li>
        </ul>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle fw-semibold" href="#" id="mobileContact" role="button" data-bs-toggle="dropdown" aria-expanded="false">
          ติดต่อเรา
          <i class="bi bi-chevron-down caret-icon ms-auto"></i>
        </a>
        <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="mobileContact">
          <li><a class="dropdown-item" href="{{ route('contact.full') }}">ติดต่อบริษัท</a></li>
          <li><a class="dropdown-item" href="#contact">แบบฟอร์มย่อ</a></li>
        </ul>
      </li>
    </ul>
  </div>
</div>