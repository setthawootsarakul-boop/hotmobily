@extends('layouts.main')

@section('content')

<div class="faq-page-wrapper" style="background-color: #fff8ec; min-height: 100vh; margin-top: -1px; padding-top: 1px;">

<style>
        /* CSS สำหรับจัดระเบียบรูปภาพ FAQ */
        .faq-images-wrapper {
            display: flex;
            flex-wrap: wrap;
            gap: 10px; /* ระยะห่างระหว่างรูป */
            margin-top: 15px;
        }

        .faq-img-box {
            width: 200px;       /* 1. กำหนดความกว้างที่ต้องการ (ปรับเลขนี้ได้) */
            height: 150px;      /* 2. กำหนดความสูงให้เท่ากัน (ปรับเลขนี้ได้) */
            overflow: hidden;   /* ซ่อนส่วนที่ล้น */
            border-radius: 8px; /* มุมมน */
            border: 1px solid #eee;
        }

        .faq-img-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;  /* 3. หัวใจสำคัญ: สั่งให้รูปขยายเต็มกล่องโดยไม่เสียสัดส่วน (ภาพจะถูก crop อัตโนมัติ) */
            display: block;
        }

        /* (Optional) ปรับให้เล็กลงเมื่ออยู่บนมือถือ */
        @media (max-width: 768px) {
            .faq-img-box {
                width: 100%;    /* มือถือให้กว้างเต็ม หรือลดขนาดลง */
                height: 200px;
                max-width: 300px; 
            }
        }
    </style>

    <div class="faq-header">
        <h1>คำถามที่พบบ่อย (FAQ)</h1>
    </div>

    <div class="faq-list">
        @foreach ($faqs as $faq)
            <div class="faq-box active">
                <div class="faq-question">
                    Q : {{ $faq->question }}
                </div>
                <div class="faq-answer">
                    <strong>A : </strong> {!! nl2br(e($faq->answer)) !!}

                    {{-- เช็คว่ามีรูปอย่างน้อย 1 รูป --}}
                    @if ($faq->faq_image_1 || $faq->faq_image_2)
                        <div class="faq-images-wrapper"> 
                            
                            @if ($faq->faq_image_1)
                                <div class="faq-img-box">
                                    <img src="{{ asset($faq->faq_image_1) }}" alt="FAQ Image 1">
                                </div>
                            @endif
                            
                            @if ($faq->faq_image_2)
                                <div class="faq-img-box">
                                    <img src="{{ asset($faq->faq_image_2) }}" alt="FAQ Image 2">
                                </div>
                            @endif

                        </div>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="pagination">
            {{ $faqs->links('pagination::bootstrap-4') }}
        </div>
    </div>

    <div class="faq-contact-area" style="text-align: center; margin-top: 50px;">
        <a href="{{ route('contact.full') }}" class="faq-contact-btn">
            หาคำตอบไม่เจอใช่มั้ย ให้เราช่วยสิ ส่งข้อความหาเรา
        </a>
    </div>

    <div class="faq-header" style="padding-top: 20px;">
        <h1>บทความที่คุณอาจสนใจ</h1>
    </div>

    <div class="faq-section">
        <div class="faq-item" onclick="location.href='{{ route('order-guide') }}#how-to-order'">
            ขั้นตอนการสั่งซื้อสินค้า
        </div>
        <div class="faq-item" onclick="location.href='{{ route('design-guide') }}#design'">
            วิธีการออกแบบ
        </div>
        <div class="faq-item" onclick="location.href='{{ route('payment-method') }}#section4'"> 
            วิธีการยกเลิกคำสั่งซื้อ
        </div>
        <div class="faq-item" onclick="location.href='{{ route('payment-method') }}#section3'"> 
            การจัดส่งสินค้า
        </div>
    </div>
</div>

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