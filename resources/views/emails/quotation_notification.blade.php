<!DOCTYPE html>
<html>
<head>
    <title>แจ้งเตือนฝ่ายขาย</title>
</head>
<body>
    <h2>มีการทำใบเสนอราคาใหม่</h2>
    <p><strong>เลขที่ใบเสนอราคา:</strong> {{ $quotation->quotation_number }}</p>
    <p><strong>ชื่อลูกค้า:</strong> {{ $quotation->fullname }}</p>
    <p><strong>อีเมลลูกค้า:</strong> {{ $quotation->email }}</p>
    <p><strong>เบอร์โทรศัพท์:</strong> {{ $quotation->phone }}</p>
    <p><strong>ยอดรวมสุทธิ:</strong> {{ number_format($quotation->grand_total, 2) }} บาท</p>
    <hr>
    <p>กรุณาตรวจสอบข้อมูลเพิ่มเติมในระบบหลังบ้าน</p>
</body>
</html>