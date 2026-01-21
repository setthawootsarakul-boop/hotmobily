@extends('layouts.main')

@section('title', 'แจ้งชำระเงินสำเร็จ - Hotmobily')


@section('content')
<div class="payment-success-container">
    <div class="success-card">
        <div class="success-icon-box">
            <img src="{{ asset('images/green-mail.png') }}" alt="Success" class="success-img">
        </div>

        <h1 class="success-title">แจ้งชำระเงินสำเร็จ</h1>
        
        <p class="success-description">
            ทีมงานได้รับการแจ้งชำระเงินแล้ว<br>
            และจะรีบติดต่อกลับไปในไม่ช้า
        </p>

        <div class="success-action-buttons">
            <a href="{{ route('home') }}" class="btn-primary-action">
               กลับไปหน้าหลัก
            </a>
            <a href="{{ route('products.index') }}" class="btn-secondary-action">
               ดูสินค้าของเรา
            </a>
        </div>
    </div>
</div>
@endsection