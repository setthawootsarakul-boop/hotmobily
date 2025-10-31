@extends('layouts.main')

@section('content')
<!-- HERO -->
<section class="hero text-center text-white d-flex align-items-center justify-content-center">
  <div class="container">
    <h1 class="fw-bold display-5 mb-3">HotMobily</h1>
    <p class="lead mb-4">พวงกุญแจ เข็มกลัด และของพรีเมียมคุณภาพสูง</p>
    <a href="#contact" class="btn btn-dark px-4 py-2">ขอใบเสนอราคา</a>
  </div>
</section>

<!-- WHY -->
<section id="why" class="section bg-white text-center">
  <div class="container">
    <h2 class="fw-bold mb-5">ทำไมต้องเลือกเรา</h2>
    <div class="row g-4">
      <div class="col-md-3">
        <div class="p-4 shadow-soft rounded-4">
          <i class="bi bi-palette fs-2 text-warning"></i>
          <h5 class="mt-3">ออกแบบฟรี</h5>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 shadow-soft rounded-4">
          <i class="bi bi-hand-thumbs-up fs-2 text-warning"></i>
          <h5 class="mt-3">คุณภาพสูง</h5>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 shadow-soft rounded-4">
          <i class="bi bi-alarm fs-2 text-warning"></i>
          <h5 class="mt-3">ตรงเวลา</h5>
        </div>
      </div>
      <div class="col-md-3">
        <div class="p-4 shadow-soft rounded-4">
          <i class="bi bi-heart fs-2 text-warning"></i>
          <h5 class="mt-3">บริการดีเยี่ยม</h5>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT -->
<section id="contact" class="section bg-light text-center">
  <div class="container">
    <h2 class="fw-bold mb-4">ติดต่อเรา</h2>
    <p class="text-secondary mb-3">แอดไลน์หรือส่งไฟล์เพื่อขอประเมินราคา</p>
    <a href="#" class="btn btn-warning fw-bold text-dark px-4">คุยกับเรา</a>
  </div>
</section>
@endsection
