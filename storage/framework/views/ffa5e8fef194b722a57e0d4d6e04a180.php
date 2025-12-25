<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title><?php echo $__env->yieldContent('title', 'Hotmobily - รับทำของพรีเมี่ยม พวงกุญแจ สแตนดี้'); ?></title>

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
    <link href="<?php echo e(asset('css/accessories.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/variables.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/fonts.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/navbar.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/hero.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/why.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/order-guide.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/products.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/footer.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/cookie-policy.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/contact-step.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/contact-success.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/gallery.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/products-showcase.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/payment-method.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/payment-page.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/payment-status.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/design-guide.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/reviews.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/cart.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/quotation.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/quotation-show.css')); ?>" rel="stylesheet">


    <?php echo $__env->yieldPushContent('styles'); ?>
    
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

    
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <main class="flex-grow-1" style="background: white;">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <div id="cookie-banner" class="cookie-banner-wrapper">
        <div class="container-xxl">
            <div class="cookie-content">
                <p class="cookie-text">
                    เว็บไซต์นี้มีการจัดเก็บคุกกี้เพื่อมอบประสบการณ์การใช้งานเว็บไซต์ของคุณให้ดียิ่งขึ้น การดำเนินการต่อบนเว็บไซต์นี้ถือว่าคุณยอมรับการใช้งานคุกกี้ 
                    <a href="<?php echo e(route('cookie-policy')); ?>" class="cookie-link">อ่านเพิ่มเติม</a>
                </p>
                <div class="cookie-actions">
                    <button id="accept-cookie" class="btn-cookie-accept">ยอมรับ</button>
                    <button id="close-cookie" class="btn-cookie-close">ปิด</button>
                </div>
            </div>
        </div>
    </div>

    
    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <script>
        $(document).ready(function() {

            $(window).scroll(function() {
                if ($(this).scrollTop() > 50) {
                    $('.navbar').addClass('shadow-sm');
                } else {
                    $('.navbar').removeClass('shadow-sm');
                }
            });


            $('#cookie-banner').show(); 


            $('#accept-cookie, #close-cookie').click(function() {
                $('#cookie-banner').fadeOut(300);

            });
        });
    </script>    

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>


    <?php /**PATH C:\project\hotmobily\resources\views/layouts/main.blade.php ENDPATH**/ ?>