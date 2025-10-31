@extends('layouts.main')

@section('content')

<section class="hero-section py-5">
  <div class="container text-center text-lg-start">
    <div class="row align-items-center">
      <div class="col-lg-6">
        <h1 class="fw-bold display-4 mb-3">Hotmobily</h1>
        <p class="lead mb-4">
          รับทำพวงกุญแจ เข็มกลัด สแตนดี้ สติ๊กเกอร์ ยางรัดผม แท่นวางโทรศัพท์ ที่รองแก้ว 
          ยางหุ้มกุญแจ ที่ติดโทรศัพท์ งานอะคริลิค ยาง และงานสะท้อนแสง
        </p>
        <div class="d-flex justify-content-lg-start justify-content-center gap-4">
          <div class="feature"><i class="bi bi-box"></i><p>คุณภาพดี</p></div>
          <div class="feature"><i class="bi bi-alarm"></i><p>ส่งตรงเวลา</p></div>
          <div class="feature"><i class="bi bi-check2-circle"></i><p>สินค้าตามมาตรฐาน</p></div>
        </div>
      </div>
      <div class="col-lg-6 text-center mt-4 mt-lg-0">
        <img src="{{ asset('images/keychain.png') }}" alt="Hotmobily Product" class="hero-img">
      </div>
    </div>
  </div>
</section>

@endsection
