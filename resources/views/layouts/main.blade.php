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

    {{-- ✅ Custom CSS --}}
    <link href="{{ asset('css/variables.css') }}" rel="stylesheet">
    <link href="{{ asset('css/fonts.css') }}" rel="stylesheet">
    
    {{-- โหลด CSS ย่อยเฉพาะเมื่อจำเป็น หรือโหลดรวมตามแผนของคุณ --}}
    <link href="{{ asset('css/navbar.css') }}" rel="stylesheet">
    <link href="{{ asset('css/hero.css') }}" rel="stylesheet">
    <link href="{{ asset('css/why.css') }}" rel="stylesheet">
    <link href="{{ asset('css/products.css') }}" rel="stylesheet">
    <link href="{{ asset('css/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('css/contact-step.css') }}" rel="stylesheet">
    <link href="{{ asset('css/products-showcase.css') }}" rel="stylesheet">
    <link href="{{ asset('css/reviews.css') }}" rel="stylesheet">
    <link href="{{ asset('css/cart.css') }}" rel="stylesheet">
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

        /* ✅ Logic สำหรับ 1440px:
           Bootstrap 5 container-xxl จะมีความกว้าง max-width: 1320px
           ซึ่งเหมาะมากกับหน้าจอ 1440px (เหลือขอบข้างละ ~60px สวยงาม)
           
           Class นี้ใส่ไว้เผื่อคุณต้องการใช้ในหน้าอื่นๆ ที่ไม่ใช่ Home 
           เช่น หน้า Contact-Full หรือ Login
        */
        .page-container {
            max-width: 1320px;
            margin-left: auto;
            margin-right: auto;
            padding-left: 12px;
            padding-right: 12px;
        }
    </style>
</head>
<body class="d-flex flex-column min-vh-100">

    {{-- ✅ Navbar --}}
    @include('partials.navbar')

    {{-- ✅ Main Content --}}
    {{-- เราไม่ใส่ container-xxl ตรงนี้ เพื่อให้ Background ของ Hero/Reviews ยาวเต็มจอ --}}
    <main class="flex-grow-1">
        @yield('content')
    </main>

    {{-- ✅ Footer --}}
    @include('partials.footer')

    {{-- ✅ Scripts --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    {{-- Script สำหรับจัดการ Navbar เวลา Scroll --}}
    <script>
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.navbar').addClass('shadow-sm');
            } else {
                $('.navbar').removeClass('shadow-sm');
            }
        });
    </script>

    @stack('scripts')
</body>
</html>