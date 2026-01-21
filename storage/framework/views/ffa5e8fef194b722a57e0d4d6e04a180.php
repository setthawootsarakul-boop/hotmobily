<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <title><?php echo $__env->yieldContent('title', 'Hotmobily - รับทำของพรีเมี่ยม พวงกุญแจ สแตนดี้'); ?></title>

    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    
    <link href="<?php echo e(asset('css/accessories.css')); ?>?v=<?php echo e(filemtime(public_path('css/accessories.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/variables.css')); ?>?v=<?php echo e(filemtime(public_path('css/variables.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/fonts.css')); ?>?v=<?php echo e(filemtime(public_path('css/fonts.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/navbar.css')); ?>?v=<?php echo e(filemtime(public_path('css/navbar.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/hero.css')); ?>?v=<?php echo e(filemtime(public_path('css/hero.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/why.css')); ?>?v=<?php echo e(filemtime(public_path('css/why.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/order-guide.css')); ?>?v=<?php echo e(filemtime(public_path('css/order-guide.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/products.css')); ?>?v=<?php echo e(filemtime(public_path('css/products.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/footer.css')); ?>?v=<?php echo e(filemtime(public_path('css/footer.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/faq.css')); ?>?v=<?php echo e(filemtime(public_path('css/faq.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/cookie-policy.css')); ?>?v=<?php echo e(filemtime(public_path('css/cookie-policy.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/contact-step.css')); ?>?v=<?php echo e(filemtime(public_path('css/contact-step.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/contact-full.css')); ?>?v=<?php echo e(filemtime(public_path('css/contact-full.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/contact-success.css')); ?>?v=<?php echo e(filemtime(public_path('css/contact-success.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/gallery.css')); ?>?v=<?php echo e(filemtime(public_path('css/gallery.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/products-showcase.css')); ?>?v=<?php echo e(filemtime(public_path('css/products-showcase.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/payment-method.css')); ?>?v=<?php echo e(filemtime(public_path('css/payment-method.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/payment-page.css')); ?>?v=<?php echo e(filemtime(public_path('css/payment-page.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/payment-status.css')); ?>?v=<?php echo e(filemtime(public_path('css/payment-status.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/design-guide.css')); ?>?v=<?php echo e(filemtime(public_path('css/design-guide.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/reviews.css')); ?>?v=<?php echo e(filemtime(public_path('css/reviews.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/cart.css')); ?>?v=<?php echo e(filemtime(public_path('css/cart.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/quotation.css')); ?>?v=<?php echo e(filemtime(public_path('css/quotation.css'))); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('css/quotation-show.css')); ?>?v=<?php echo e(filemtime(public_path('css/quotation-show.css'))); ?>" rel="stylesheet">

    <?php echo $__env->yieldPushContent('styles'); ?>

    <style>
        html, body { width: 100%; overflow-x: hidden; }
        main { width: 100%; display: block; position: relative; }
        .page-container { max-width: 1320px; margin: 0 auto; padding: 0 12px; }

        /* Cookie Banner */
        .cookie-banner-wrapper { position: fixed; bottom: 0; left: 0; width: 100%; background: rgba(51, 51, 51, 0.90); color: #fff; padding: 15px 0; z-index: 99999; display: none; }
        .cookie-content { display: flex; justify-content: center; align-items: center; gap: 25px; flex-wrap: wrap; text-align: center; }
        .btn-cookie-accept { background: #cc0000; color: #fff; border: none; padding: 7px 24px; border-radius: 4px; font-weight: 600; cursor: pointer; }
        .btn-cookie-close { background: #fff; color: #000; border: none; padding: 7px 24px; border-radius: 4px; font-weight: 600; cursor: pointer; }

        .contact-sticky-menu {
                position: fixed;
                bottom: 30px;
                right: 30px;
                z-index: 9999;
            }

        .sbuttons {
            position: relative;
            width: 65px; 
            height: 65px;
        }

        .sbutton {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
            overflow: visible; /* ต้องเป็น visible เพื่อให้ cta-box แสดงออกมาได้ */
            opacity: 0;
            visibility: hidden;
            transform: scale(0);
            transition: all 0.4s cubic-bezier(0.68, -0.55, 0.27, 1.55);
            pointer-events: none;
        }

        .cta-box.hide-forever {
            display: none !important;
            opacity: 0 !important;
            visibility: hidden !important;
        }
        .cta-box {
            position: absolute;
            right: 80px; /* ดันออกไปทางซ้ายของปุ่ม */
            background-color: #ffffff;
            color: #333;
            padding: 10px 20px;
            border-radius: 12px; /* ขอบมน */
            font-size: 18px;
            white-space: nowrap;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            opacity: 1;
            visibility: visible;
            transition: all 0.3s ease;
            pointer-events: none;
        }

        
        .cta-box::after {
            content: "";
            position: absolute;
            right: -10px;
            top: 50%;
            transform: translateY(-50%);
            border-width: 10px 0 10px 10px;
            border-style: solid;
            border-color: transparent transparent transparent #ffffff;
        }

        .sbutton.mainsbutton {
            opacity: 1 !important;
            visibility: visible !important;
            transform: scale(1) !important;
            background-color: #d18d66; /* สีตามรูป */
            z-index: 10;
            pointer-events: auto;
        }

        .sbutton.mainsbutton i {
            font-size: 32px; /* ขนาดไอคอนแชท */
        }

        /* ✅ กำหนดระยะเด้งขึ้นด้านบน (Active) */
        .contact-sticky-menu.active .sbutton.phone     { bottom: 300px; opacity: 1; visibility: visible; transform: scale(1); pointer-events: auto; }
        .contact-sticky-menu.active .sbutton.line      { bottom: 225px; opacity: 1; visibility: visible; transform: scale(1); pointer-events: auto; }
        .contact-sticky-menu.active .sbutton.fb        { bottom: 150px; opacity: 1; visibility: visible; transform: scale(1); pointer-events: auto; }
        .contact-sticky-menu.active .sbutton.messenger { bottom: 75px;  opacity: 1; visibility: visible; transform: scale(1); pointer-events: auto; }

        /* ซ่อนกล่องข้อความเมื่อเปิดเมนูย่อย */
        .contact-sticky-menu.active .cta-box {
            opacity: 0;
            visibility: hidden;
            transform: translateX(10px);
        }

        .sbutton img {
            width: 35px; 
            height: 35px;
            object-fit: contain;
        }

        /* สีปุ่มโซเชียล */
        .sbutton.phone { background-color: #ff4b4b; }
        .sbutton.line { background-color: #00c300; }
        .sbutton.fb { background-color: #1877F2; }
        .sbutton.messenger { background-color: #ffffff; border: 1px solid #eee; color: #0084ff; }

        #main-icon { transition: all 0.2s ease; }
        .sbutton:hover { transform: scale(1.1); box-shadow: 0 6px 20px rgba(0,0,0,0.2); }

            @media (max-width: 768px) { 
                .contact-sticky-menu { bottom: 20px; right: 20px; }
                .cta-box { display: none; } /* มือถือซ่อนกล่องข้อความเพื่อไม่ให้บังจอ */
            }
        </style>
</head>
<body class="d-flex flex-column min-vh-100">

    
    <?php echo $__env->make('partials.navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <main class="flex-grow-1" style="background: white;">
        <?php echo $__env->yieldContent('content'); ?>
    </main>

    
    <div class="contact-sticky-menu">
        <div class="sbuttons">  
            <a href="tel:064-604-5614" class="sbutton phone"><img src="<?php echo e(asset('images/phone-icon.png')); ?>" alt="Phone"></a>
            <a href="https://line.me/R/ti/p/@842kcbjl" target="_blank" class="sbutton line"><img src="<?php echo e(asset('images/line.png')); ?>" alt="Line"></a>
            <a href="https://www.facebook.com/hotmobilyTH" target="_blank" class="sbutton fb"><img src="<?php echo e(asset('images/fb.png')); ?>" alt="Facebook"></a>
            <a href="http://m.me/hotmobilyTH" target="_blank" class="sbutton messenger"><img src="<?php echo e(asset('images/messenger.png')); ?>" alt="Messenger"></a>
            
            <a href="javascript:void(0);" class="sbutton mainsbutton" id="mainsbutton">
                <span class="cta-box">สอบถามเพิ่มเติม</span>
                <i class="fa fa-commenting-o" aria-hidden="true" id="main-icon"></i>
            </a>
        </div>
    </div>

    
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            // --- 🚩 1. ฟังก์ชันจัดการ Cookie (Set/Get) ---
            function setCookie(name, value, days) {
                let expires = "";
                if (days) {
                    let date = new Date();
                    date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
                    expires = "; expires=" + date.toUTCString();
                }
                // ใส่ path=/ เพื่อให้จำค่าได้ทุกหน้าของเว็บไซต์
                document.cookie = name + "=" + (value || "") + expires + "; path=/; SameSite=Lax";
            }

            function getCookie(name) {
                let nameEQ = name + "=";
                let ca = document.cookie.split(';');
                for (let i = 0; i < ca.length; i++) {
                    let c = ca[i];
                    while (c.charAt(0) == ' ') c = c.substring(1, c.length);
                    if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
                }
                return null;
            }

            // --- 🚩 2. ระบบ Cookie Banner (เปลี่ยนจาก localStorage เป็น Cookie) ---
            if (!getCookie('cookie_accepted')) {
                $('#cookie-banner').fadeIn();
            }

            $('#accept-cookie').click(function() {
                setCookie('cookie_accepted', 'true', 365); 
                $('#cookie-banner').fadeOut();
            });

            $('#close-cookie').click(function() {
                $('#cookie-banner').fadeOut();
            });

            // --- 3. Navbar Shadow on Scroll ---
            $(window).scroll(function() {
                $('.navbar').toggleClass('shadow-sm', $(this).scrollTop() > 50);
            });

            // --- 4. Newsletter AJAX ---
            $(document).on('submit', 'form[action="<?php echo e(route('newsletter.subscribe')); ?>"]', function(e) {
                e.preventDefault();
                let form = $(this);
                $.ajax({
                    url: form.attr('action'),
                    method: 'POST',
                    data: { _token: '<?php echo e(csrf_token()); ?>', email: form.find('input[name="email"]').val() },
                    success: function() {
                        Swal.fire({ icon: 'success', title: 'สมัครสมาชิกสำเร็จ!', text: 'ขอบคุณที่ติดตามเรา', confirmButtonColor: '#fbab00' });
                        form.find('input[name="email"]').val('');
                    },
                    error: function(xhr) {
                        Swal.fire({ icon: 'error', title: 'ขออภัย...', text: xhr.responseJSON?.message || 'ลองใหม่อีกครั้ง' });
                    }
                });
            });

            // --- 5. Sticky Contact Menu ---
            $('#mainsbutton').on('click', function(e) {
                e.preventDefault();
                let menu = $('.contact-sticky-menu');
                let icon = $('#main-icon');
                let ctaBox = $(this).find('.cta-box');

                menu.toggleClass('active');
                ctaBox.addClass('hide-forever');

                if (menu.hasClass('active')) {
                    icon.removeClass('fa-commenting-o').addClass('fa-times');
                } else {
                    icon.removeClass('fa-times').addClass('fa-commenting-o');
                }
            });

            // ปิดเมนูเมื่อคลิกที่พื้นที่อื่นๆ
            $(document).on('click', function(event) {
                if (!$(event.target).closest('.contact-sticky-menu').length) {
                    if ($('.contact-sticky-menu').hasClass('active')) {
                        $('.contact-sticky-menu').removeClass('active');
                        $('#main-icon').removeClass('fa-times').addClass('fa-commenting-o');
                    }
                }
            });
        });
    </script>

    <?php echo $__env->yieldPushContent('scripts'); ?>
    
</body>
</html><?php /**PATH C:\project\hotmobily\resources\views/layouts/main.blade.php ENDPATH**/ ?>