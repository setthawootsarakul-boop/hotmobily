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

    
    <link href="<?php echo e(asset('css/variables.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/fonts.css')); ?>" rel="stylesheet">
    
    
    <link href="<?php echo e(asset('css/navbar.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/hero.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/why.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/products.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/footer.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/contact-step.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/products-showcase.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/reviews.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/cart.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/quotation.css')); ?>" rel="stylesheet">
    
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

    
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    
    <main class="flex-grow-1">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <?php echo $__env->make('partials.footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    
    
    <script>
        $(window).scroll(function() {
            if ($(this).scrollTop() > 50) {
                $('.navbar').addClass('shadow-sm');
            } else {
                $('.navbar').removeClass('shadow-sm');
            }
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html><?php /**PATH C:\Hotmobily\hotmobily\resources\views/layouts/main.blade.php ENDPATH**/ ?>