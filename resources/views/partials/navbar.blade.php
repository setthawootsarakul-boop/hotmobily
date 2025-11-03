<nav class="navbar navbar-expand-lg sticky-top bg-orange shadow-sm"> 
  <div class="container">

    <!-- 🔹 ปุ่มมือถือ -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- 🔹 เมนูกลาง (มีโลโก้รวมในนี้ด้วย) -->
    <div id="navbarNav" class="collapse navbar-collapse justify-content-center">
      <ul class="navbar-nav align-items-center gap-4">
        <!-- 🟡 โลโก้อยู่ข้างเมนู -->
        <li class="nav-item d-flex align-items-center">
          <a class="navbar-brand d-flex align-items-center" href="/">
            <img src="{{ asset('images/logo.png') }}" alt="Hotmobily Logo" height="40" class="me-2">
          </a>
        </li>

        <li class="nav-item"><a class="nav-link fw-semibold" href="#products">สินค้าทั้งหมด</a></li>
        <li class="nav-item"><a class="nav-link fw-semibold" href="#faq">คำถามที่พบบ่อย</a></li>
        <li class="nav-item"><a class="nav-link fw-semibold" href="#details">รายละเอียดเพิ่มเติม</a></li>
        <li class="nav-item"><a class="nav-link fw-semibold" href="#contact">ติดต่อเรา</a></li>
      </ul>
    </div>

    <!-- 🔹 ตะกร้าอยู่ขวา -->
    <div class="d-none d-lg-block">
      <a href="#" class="nav-link fs-4 text-dark cart-link">
        <i class="bi bi-cart"></i>
      </a>
    </div>

  </div>
</nav>
