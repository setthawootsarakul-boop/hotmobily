<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title>@yield('title', 'Hotmobily - รับทำของพรีเมี่ยม พวงกุญแจ สแตนดี้')</title>

    {{-- ✅ Bootstrap 5.3 CDN --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- ✅ Bootstrap Icons --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    {{-- ✅ Owl Carousel CSS (ใส่ที่นี่เพื่อโหลดทีเดียวทั้งโปรเจกต์) --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link href="{{ asset('css/accessories.css') }}?v={{ filemtime(public_path('css/accessories.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/variables.css') }}?v={{ filemtime(public_path('css/variables.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}?v={{ filemtime(public_path('css/fonts.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/navbar.css') }}?v={{ filemtime(public_path('css/navbar.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/hero.css') }}?v={{ filemtime(public_path('css/hero.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/why.css') }}?v={{ filemtime(public_path('css/why.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/order-guide.css') }}?v={{ filemtime(public_path('css/order-guide.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/products.css') }}?v={{ filemtime(public_path('css/products.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}?v={{ filemtime(public_path('css/footer.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/faq.css') }}?v={{ filemtime(public_path('css/faq.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/cookie-policy.css') }}?v={{ filemtime(public_path('css/cookie-policy.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/contact-step.css') }}?v={{ filemtime(public_path('css/contact-step.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/contact-success.css') }}?v={{ filemtime(public_path('css/contact-success.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/gallery.css') }}?v={{ filemtime(public_path('css/gallery.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/products-showcase.css') }}?v={{ filemtime(public_path('css/products-showcase.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/payment-method.css') }}?v={{ filemtime(public_path('css/payment-method.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/payment-page.css') }}?v={{ filemtime(public_path('css/payment-page.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/payment-status.css') }}?v={{ filemtime(public_path('css/payment-status.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/design-guide.css') }}?v={{ filemtime(public_path('css/design-guide.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/reviews.css') }}?v={{ filemtime(public_path('css/reviews.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/cart.css') }}?v={{ filemtime(public_path('css/cart.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/quotation.css') }}?v={{ filemtime(public_path('css/quotation.css')) }}" rel="stylesheet">
    <link href="{{ asset('css/quotation-show.css') }}?v={{ filemtime(public_path('css/quotation-show.css')) }}" rel="stylesheet">


    @stack('styles')
    {{-- ✅ Global Styles Fix for 1440px Layout --}}
    <style>
        /* บังคับให้หน้าเว็บกว้างเต็มจอเสมอ ไม่เกิดขอบขาวที่ไม่ตั้งใจ */
        html, body {
            width: 100%;
            overflow-x: hidden; /* ป้องกัน Scrollbar แนวนอน */
        }

        /* Main Container: ยืดหยุ่นแต่คุมพฤติกรรมลูก */
        main {
            width: 100%;
            display: block;
            position: relative;
        }

        .page-container {
            max-width: 1320px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 12px;
            padding-right: 12px;
        }

        /* 🚩 เพิ่มเติม: Cookie Banner CSS ตามรูปตัวอย่าง */
        .cookie-banner-wrapper {
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            background: rgba(51, 51, 51, 0.98); /* สีเทาเข้ม */
            color: #fff;
            padding: 15px 0;
            z-index: 99999;
            display: none; /* ซ่อนไว้รอ JS เช็ค */
        }
        .cookie-content {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
            text-align: center;
        }
        .cookie-text { margin: 0; font-size: 0.95rem; }
        .cookie-link { color: #58a6ff; text-decoration: underline; }
        .cookie-actions { display: flex; gap: 12px; }
        
        /* ปุ่มยอมรับ สีแดง */
        .btn-cookie-accept {
            background: #cc0000; color: #fff; border: none;
            padding: 7px 24px; border-radius: 4px; font-weight: 600; cursor: pointer;
        }
        /* ปุ่มปิด สีขาว */
        .btn-cookie-close {
            background: #fff; color: #000; border: none;
            padding: 7px 24px; border-radius: 4px; font-weight: 600; cursor: pointer;
        }

        @media (max-width: 768px) {
            .cookie-content { flex-direction: column; padding: 0 20px; }
            .cookie-actions { width: 100%; }
            .btn-cookie-accept, .btn-cookie-close { flex: 1; }
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- ✅ Navbar --}}
    @include('partials.navbar')

    {{-- ✅ Main Content --}}
    <main class="flex-grow-1" style="background: white;">
        @yield('content')
    </main>

    {{-- 🚩 เพิ่มเติม: Cookie Banner HTML --}}
    <div id="cookie-banner" class="cookie-banner-wrapper">
        <div class="container-xxl">
            <div class="cookie-content">
                <p class="cookie-text">
                    เว็บไซต์นี้มีการจัดเก็บคุกกี้เพื่อมอบประสบการณ์การใช้งานเว็บไซต์ของคุณให้ดียิ่งขึ้น การดำเนินการต่อบนเว็บไซต์นี้ถือว่าคุณยอมรับการใช้งานคุกกี้ 
                    <a href="{{ route('cookie-policy') }}" class="cookie-link">อ่านเพิ่มเติม</a>
                </p>
                <div class="cookie-actions">
                    <button id="accept-cookie" class="btn-cookie-accept">ยอมรับ</button>
                    <button id="close-cookie" class="btn-cookie-close">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    {{-- ✅ Footer --}}
    @include('partials.footer')

    {{-- ✅ Scripts (ของคุณเดิมทั้งหมด + เพิ่ม Logic Cookie) --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // Navbar Shadow
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navbar').addClass('shadow-sm');
                } else {
                    $('.navbar').removeClass('shadow-sm');
                }
            });

            // Cookie Banner Logic
            $('#cookie-banner').show(); 
            $('#accept-cookie, #close-cookie').click(function() {
                $('#cookie-banner').fadeOut(300);
            });

            
            // ✅ Newsletter AJAX Logic ด้วย SweetAlert2
            $(document).on('submit', 'form[action="{{ route('newsletter.subscribe') }}"]', function(e) {
                e.preventDefault();
                let form = $(this);
                let email = form.find('input[name="email"]').val();

                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        email: email
                    },
                    success: function(response) {
                        // แจ้งเตือนเมื่อสำเร็จ
                        Swal.fire({
                            icon: 'success',
                            title: 'สมัครสมาชิกสำเร็จ!',
                            text: 'ขอบคุณที่สมัครรับข่าวสารจาก Hotmobily',
                            confirmButtonColor: '#fbab00', 
                            confirmButtonText: 'ตกลง'
                        });
                        form.find('input[name="email"]').val('');
                    },
                    error: function(xhr) {
                        
                        let errorMsg = xhr.responseJSON && xhr.responseJSON.message 
                                    ? xhr.responseJSON.message 
                                    : 'เกิดข้อผิดพลาด กรุณาลองใหม่อีกครั้ง';
                        
                        Swal.fire({
                            icon: 'error',
                            title: 'ขออภัย...',
                            text: errorMsg,
                            confirmButtonColor: '#333'
                        });
                    }
                });
            });
        });
    </script>

    @stack('scripts')
    
</body>
</html>


    {{-- <script> สำหรับใช้จริง
        $(document).ready(function() {
            // Script เดิมของคุณ: จัดการ Navbar เวลา Scroll
            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navbar').addClass('shadow-sm');
                } else {
                    $('.navbar').removeClass('shadow-sm');
                }
            });

            // 🚩 เพิ่มเติม: Script จัดการ Cookie Banner
            if (!localStorage.getItem('cookie_accepted')) {
                $('#cookie-banner').fadeIn();
            }

            $('#accept-cookie').click(function() {
                localStorage.setItem('cookie_accepted', 'true');
                $('#cookie-banner').fadeOut();
            });

            $('#close-cookie').click(function() {
                $('#cookie-banner').fadeOut();
            });
        });
    </script> --}}