@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('css/faq.css') }}">

<div class="faq-header">
  <!-- 🔸 ปุ่มบนสุด -->
  <a href="{{ route('contact.full') }}" class="faq-contact-btn">
    หากคำตอบไม่เจอใช่มั้ย ให้เราช่วยสิ ส่งข้อความหาเรา
  </a>

  <!-- 🔸 หัวข้อหลัก -->
  <h1>บทความที่คุณอาจสนใจ</h1>
</div>

<!-- 🔹 ส่วนแสดงรายการ FAQ -->
<div class="faq-section">
  <div class="faq-item" onclick="location.href='{{ route('faq') }}#how-to-order'">
    ขั้นตอนการสั่งซื้อสินค้า
  </div>
  <div class="faq-item" onclick="location.href='{{ route('faq') }}#design'">
    วิธีการออกแบบ
  </div>
  <div class="faq-item" onclick="location.href='{{ route('faq') }}#cancel'">
    วิธีการยกเลิกคำสั่งซื้อ
  </div>
  <div class="faq-item" onclick="location.href='{{ route('faq') }}#delivery'">
    การจัดส่งสินค้า
  </div>
</div>
@endsection
