@extends('layouts.main')

@section('content')
<link rel="stylesheet" href="{{ asset('css/faq.css') }}">

<!-- =========================
     🔹 ส่วนที่ 1: คำถามที่พบบ่อย (FAQ)
========================= -->
<div class="faq-header">
  <h1>คำถามที่พบบ่อย (FAQ)</h1>
</div>

<!-- 🔸 กรอบรายการคำถาม -->
<div class="faq-list">
  @foreach ($faqs as $faq)
    <div class="faq-box active">
      <div class="faq-question">
        Q : {{ $faq->question }}
      </div>
      <div class="faq-answer">
        A : {!! nl2br(e($faq->answer)) !!}
        @if ($faq->faq_image_1)
          <div style="margin-top: 10px;">
            <img src="{{ asset('storage/' . $faq->faq_image_1) }}" alt="FAQ Image 1" style="max-width: 100%; border-radius: 8px;">
          </div>
        @endif
        @if ($faq->faq_image_2)
          <div style="margin-top: 10px;">
            <img src="{{ asset('storage/' . $faq->faq_image_2) }}" alt="FAQ Image 2" style="max-width: 100%; border-radius: 8px;">
          </div>
        @endif
      </div>
    </div>
  @endforeach

  <div class="pagination">
    {{ $faqs->links('pagination::bootstrap-4') }}
  </div>
</div>

<!-- ✅ ปุ่มอยู่นอกกรอบ -->
<div class="faq-contact-area" style="text-align: center; margin-top: 50px;">
  <a href="{{ route('contact.full') }}" class="faq-contact-btn">
    หาคำตอบไม่เจอใช่มั้ยให้เราช่วยสิ ส่งข้อความหาเรา
  </a>
</div>

<!-- =========================
     🔹 ส่วนที่ 2: บทความที่คุณอาจสนใจ
========================= -->
<div class="faq-header" style="padding-top: 20px;">
  <h1>บทความที่คุณอาจสนใจ</h1>
</div>

<div class="faq-section">
  <div class="faq-item" onclick="location.href='{{ route('order-guide') }}#how-to-order'">
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

<!-- 🧩 แสดง/ซ่อนคำตอบ -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const questions = document.querySelectorAll('.faq-question');
  questions.forEach(q => {
    q.addEventListener('click', () => {
      const box = q.parentElement;
      box.classList.toggle('active');
    });
  });
});
</script>

@endsection
