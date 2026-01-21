

<?php $__env->startSection('content'); ?>

<div class="design-guide-wrapper">
    <div class="container">
        <h2 class="design-main-title">วิธีการออกแบบ</h2>

        <div class="design-content-box">
            <div class="design-text-only">
                
                <h5 class="design-sub-title">วิธีส่งไฟล์งานอะคริลิค</h5>
                <p class="design-description">
                    หากลูกค้ามีแบบงานของตัวเองอยู่แล้ว สามารถส่งไฟล์งานเป็นสกุล Adobe Illustrator หรือ Photoshop เวอร์ชั่น CC2019 ทางเราจะทำการตรวจสอบ และดูแบบก่อนส่งให้ลูกค้าเช็กงานอีกครั้งก่อนสั่งผลิต หากลูกค้าไม่มีไฟล์ Adobe Illustratorหรือ Photoshop ก็สามารถส่งเป็นไฟล์สกุล jpg, pdf, Clip Studio Paint, IbisPaint
                </p>

                <div class="design-flex-container">
                    <ul class="design-contact-list">
                        <li>ส่งไฟล์งานผ่าน 3 ช่องทางดังนี้</li>
                        <li>Line ID: hotstrapthai</li>
                        <li>Facebook: hotmobilyTH</li>
                        <li>E-mail: sales.ye@youandearth-th.com</li>
                    </ul>
                    <div class="design-qr-box">
                        <img src="<?php echo e(asset('images/line-qr.png')); ?>" alt="Line QR Code">
                    </div>
                </div>

                <div class="design-template-section">
                    <h5 class="template-title">ดาวน์โหลด Template</h5>
                    <p class="template-contact-text">
                        กรุณา<span class="contact-underline">ติดต่อพนักงาน</span> เพื่อขอไฟล์ Template
                    </p>
                    <div class="template-image-wrapper">
                        <img src="<?php echo e(asset('images/image-template.png')); ?>" alt="Template Preview">
                    </div>
                </div>

                <div class="design-placing-section">
                    <h5 class="placing-title">การจัดวางดีไซน์</h5>
                    <p class="placing-contact-text">
                        ลูกค้าสามารถวางแบบดีไซน์ใน Template ให้อยู่ในขนาดที่ทางเรากำหนดคือ จะมีขนาด 50mmx50mm, 75mmx75mm, 100mmx100mm ซึ่งขนาดอาจจะต้องมีขนาดเล็กกว่าไดคัท หรือจะทำตามแบบที่ลูกค้ากำหนดเองก็ได้
                    </p>
                    <div class="placing-image-wrapper">
                        <img src="<?php echo e(asset('images/placing.png')); ?>" alt="Placing Design">
                    </div>
                </div>

                <div class="diecut-placing-section">
                    <h5 class="diecut-title">การทำไดคัทขอบใส</h5>
                    <p class="diecut-contact-text">
                        เพื่อให้ได้รูปทรงตามที่ต้องการ การทำไดคัทขอบใสจึงเป็นสิ่งจำเป็น นำดีไซน์มาวางให้อยู่ในส่วนของไดคัท ซึ่งขอบไดคัท ต้องมีระยะห่างจากดีไซน์ 2mm ขึ้นไป กด P หรือเลือกรูปปากกา เพื่อใช้งาน Pentool คลิกที่ขอบของสิ่งของที่จะเลือก ในลักษณะการต่อจุดไปเรื่อยๆ (ย้ายจากจุดหนึ่งไปยังจุดหนึ่ง จะเกิดเส้นตามมาเอง) จนครบทั้งภาพหรือวัตถุที่ต้องการ แล้วให้ทำการปิดเส้น คือให้มาต่อจุดที่จุดแรกที่ได้เริ่มต้นไว้ หลังจากนั้นให้คลิกขวา เลือก Make selection และให้เลือก Feather Radius = 0 (เราจะไปเลือกละเอียดกว่านี้ภายหลัง) เลือก Select > Select and Mask
                    </p>
                    <div class="diecut-image-wrapper">
                        <img src="<?php echo e(asset('images/diecut.png')); ?>" alt="Diecut Guide">
                    </div>
                </div>

                <div class="screen-section">
                    <h5 class="screen-title">สกรีนขาว</h5>
                    <p class="screen-contact-text">
                        คือการสร้าง Layer แยกสำหรับพิมพ์สีขาวรองพื้น โดยสร้างเส้น Path ตามขอบดีไซน์ (เหมือนการทำไดคัท) และเทสีดำสนิท (K100%) ในส่วนที่ต้องการให้มีสีขาวรองพื้น เพื่อให้สีของดีไซน์สดใสและไม่โปร่งแสง
                    </p>
                    <div class="screen-image-wrapper">
                        <img src="<?php echo e(asset('images/screen1.png')); ?>" alt="Screen White 1">
                        <img src="<?php echo e(asset('images/screen2.png')); ?>" alt="Screen White 2">
                    </div>
                </div>

                <div class="holesloops-section">
                    <h5 class="holesloops-title">การทำรูสำหรับร้อยห่วงพวงกุญแจ</h5>
                    <p class="holesloops-contact-text">
                        กำหนดตำแหน่งรูแขวนโดยสร้าง Layer แยก และใช้สีดำสนิท (K100%) กำหนดจุดที่ต้องการเจาะรู เพื่อความแข็งแรงควรเว้นระยะห่างจากขอบชิ้นงานให้เหมาะสม
                    </p>
                    <div class="screen-image-wrapper">
                        <img src="<?php echo e(asset('images/holesloops.png')); ?>" alt="Holes and Loops Guide">
                    </div>
                </div>

            </div> </div> </div> </div> <div class="faq-header">
    <h1>บทความที่คุณอาจสนใจ</h1>
</div>

<div class="faq-section">
    <div class="faq-item" onclick="location.href='<?php echo e(route('order-guide')); ?>'">ขั้นตอนการสั่งซื้อสินค้า</div>
    <div class="faq-item" onclick="location.href='<?php echo e(route('faq')); ?>'">คำถามที่พบบ่อย (FAQ)</div>
    <div class="faq-item" onclick="location.href='<?php echo e(route('payment-method')); ?>#section4'"> 
        วิธีการยกเลิกคำสั่งซื้อ
    </div>
    <div class="faq-item" onclick="location.href='<?php echo e(route('payment-method')); ?>#section3'"> 
        การจัดส่งสินค้า
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/design-guide.blade.php ENDPATH**/ ?>