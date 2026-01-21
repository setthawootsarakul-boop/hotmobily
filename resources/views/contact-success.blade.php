@extends('layouts.main')

@section('title', 'ส่งข้อความสำเร็จ - Hotmobily')



@section('content')
<div class="success-section">
    <div class="success-card">
        {{-- ตรวจสอบว่าไฟล์รูปภาพอยู่ที่ public/images/green-mail.png --}}
        <img src="{{ asset('images/green-mail.png') }}" alt="Success" class="success-icon-img">
        
        <h1>ขอบคุณที่ติดต่อเรา</h1>
        <p>ทีมงานได้รับข้อความแล้ว<br>และจะรีบติดต่อกลับไปในไม่ช้า</p>
        
        <a href="{{ url('/') }}" class="btn-home">กลับไปหน้าหลัก</a>
        <a href="{{ url('/products') }}" class="btn-products">ดูสินค้าของเรา</a>
    </div>
</div>
@endsection