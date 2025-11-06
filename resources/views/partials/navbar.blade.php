<nav class="navbar navbar-expand-lg sticky-top bg-orange shadow-sm">
  <div class="container d-flex align-items-center justify-content-between px-lg-3 px-2">

    <!-- 🔹 โลโก้ (ซ้ายสุด) -->
    <a class="navbar-brand d-flex align-items-center me-lg-2" href="/">
      <img src="{{ asset('images/logo.png') }}" alt="Hotmobily Logo" height="40">
    </a>

    <!-- 🔹 เมนูหลัก (Desktop: อยู่กลาง, Mobile: ซ่อนใน collapse) -->
    <div id="navbarNav" class="collapse navbar-collapse justify-content-center order-2 order-lg-1">
      <ul class="navbar-nav align-items-center gap-4">
        <li class="nav-item"><a class="nav-link fw-semibold" href="#products">สินค้าทั้งหมด</a></li>
        <li class="nav-item"><a class="nav-link fw-semibold" href="#faq">คำถามที่พบบ่อย</a></li>
        <li class="nav-item"><a class="nav-link fw-semibold" href="#details">รายละเอียดเพิ่มเติม</a></li>

        <!-- 🔹 Dropdown -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle fw-semibold" href="#" id="navbarContact" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            ติดต่อเรา
          </a>
          <ul class="dropdown-menu border-0 shadow-sm" aria-labelledby="navbarContact">
            <li><a class="dropdown-item" href="{{ route('contact.full') }}">ติดต่อบริษัท</a></li>
            <li><a class="dropdown-item" href="#contact">แบบฟอร์มย่อ</a></li>
          </ul>
        </li>
      </ul>
    </div>

    <!-- 🔹 กลุ่มปุ่มขวา (รถเข็น + Hamburger) -->
    <div class="d-flex align-items-center order-1 order-lg-2">
      <!-- รถเข็น -->
      <a href="#" class="nav-link fs-4 text-white cart-link me-2">
        <i class="bi bi-cart"></i>
      </a>

      <!-- Hamburger -->
      <button
        class="navbar-toggler border-0"
        type="button"
        data-bs-toggle="collapse"
        data-bs-target="#navbarNav"
        aria-controls="navbarNav"
        aria-expanded="false"
        aria-label="Toggle navigation"
      >
        <span class="navbar-toggler-icon"></span>
      </button>
    </div>

  </div>
</nav>
