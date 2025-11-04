<nav class="navbar navbar-expand-lg sticky-top bg-orange shadow-sm">
  <div class="container d-flex justify-content-between align-items-center">

    <!-- 🔹 โลโก้ -->
    <a class="navbar-brand d-flex align-items-center" href="/">
      <img src="{{ asset('images/logo.png') }}" alt="Hotmobily Logo" height="40">
    </a>

    <!-- 🔹 ปุ่มเมนู (มือถือเท่านั้น) -->
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- 🔹 เมนู (ตรงกลาง) -->
    <div id="navbarNav" class="collapse navbar-collapse justify-content-center">
      <ul class="navbar-nav align-items-center gap-4">

        <li class="nav-item">
          <a class="nav-link fw-semibold" href="#products">สินค้าทั้งหมด</a>
        </li>

        <li class="nav-item">
          <a class="nav-link fw-semibold" href="#faq">คำถามที่พบบ่อย</a>
        </li>

        <li class="nav-item">
          <a class="nav-link fw-semibold" href="#details">รายละเอียดเพิ่มเติม</a>
        </li>

        <!-- 🔹 เมนูติดต่อเรา (Dropdown) -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarContact" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ติดต่อเรา
          </a>
          <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarContact">
            <li>
              <a class="dropdown-item" href="{{ route('contact.full') }}">ติดต่อบริษัท</a>
            </li>
            <li>
              <a class="dropdown-item" href="#contact">แบบฟอร์มย่อ</a>
            </li>
          </ul>
        </li>

      </ul>
    </div>

    <!-- 🔹 รถเข็น (อยู่ขวาสุดใน desktop) -->
    <a href="#" class="nav-link fs-4 text-white cart-link d-none d-lg-block">
      <i class="bi bi-cart"></i>
    </a>

  </div>
</nav>
