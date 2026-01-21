<!DOCTYPE html>
<html>
<head>
    <title>แจ้งเตือนฝ่ายขาย</title>
</head>
<body>
    <h2>มีการทำใบเสนอราคาใหม่</h2>
    <p><strong>เลขที่ใบเสนอราคา:</strong> <?php echo e($quotation->quotation_number); ?></p>
    <p><strong>ชื่อลูกค้า:</strong> <?php echo e($quotation->fullname); ?></p>
    <p><strong>อีเมลลูกค้า:</strong> <?php echo e($quotation->email); ?></p>
    <p><strong>เบอร์โทรศัพท์:</strong> <?php echo e($quotation->phone); ?></p>
    <p><strong>ยอดรวมสุทธิ:</strong> <?php echo e(number_format($quotation->grand_total, 2)); ?> บาท</p>
    <hr>
    <p>กรุณาตรวจสอบข้อมูลเพิ่มเติมในระบบหลังบ้าน</p>
</body>
</html><?php /**PATH C:\project\hotmobily\resources\views/emails/quotation_notification.blade.php ENDPATH**/ ?>