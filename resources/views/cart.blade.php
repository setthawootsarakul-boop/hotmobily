@extends('layouts.main')

@section('title', 'ตะกร้าสินค้า')

@section('content')

{{-- ✅ เรียกใช้ไฟล์ CSS ที่แยกไว้ --}}
<link rel="stylesheet" href="{{ asset('css/cart.css') }}">

<div class="container py-5">
    
    {{-- 🔥 ย้ายหัวข้อมาไว้ตรงนี้ เพื่อให้แสดงตลอดเวลา ไม่ว่าจะมีของหรือไม่มี --}}
    <h1 class="cart-title">ตะกร้าสินค้า</h1>

    @if(count($cartItems) > 0)
        
        {{-- Header Row (Desktop Only) --}}
        <div class="row"> 
            <div class="col-md-4 header-product">สินค้า</div> 
            <div class="col-md-8 header-detail">รายละเอียด</div>
        </div>
        <hr class="d-none d-md-block text-secondary opacity-25">
        
        <div class="cart-list">
            @foreach($cartItems as $index => $item)
                @php
                    $product = $products[$item['product_id']] ?? null;
                    $imgSrc = $product && $product->images->first() ? asset($product->images->first()->image_url) : asset('images/no-image.png');
                    $productName = $product ? $product->name : 'สินค้าไม่ทราบชื่อ';
                    
                    $opt = $item['options'];
                    $detailString = "{$productName} > {$opt['size_name']}";
                    if($opt['print_name'] && $opt['print_name'] != '-') $detailString .= " > {$opt['print_name']}";
                    if($opt['part_name'] && $opt['part_name'] != '-') $detailString .= " > {$opt['part_name']}";
                    $detailString .= " > จำนวน " . number_format($item['quantity']) . " ชิ้น";
                @endphp

                <div class="row cart-item-row align-items-start" id="row-{{ $item['row_id'] }}">
                    
                    {{-- Column 1: Checkbox + Image --}}
                    <div class="col-md-4 col-img-wrapper mb-3 mb-md-0">
                        <div class="custom-checkbox cart-checkbox" onclick="toggleCheck(this)">
                            <i class="bi bi-check-lg"></i>
                        </div>

                        <div class="product-img-frame">
                            <img src="{{ $imgSrc }}" alt="{{ $productName }}" class="product-thumb">
                        </div>
                    </div>

                    {{-- Column 2: Details + Actions --}}
                    <div class="col-md-8 col-detail-wrapper">
                        <div class="product-name-header">{{ $productName }}</div>
                        
                        <div class="d-flex align-items-center flex-wrap flex-md-nowrap">
                            <div class="detail-box">
                                {{ $detailString }}
                            </div>
                            
                            <div class="action-group">
                                {{-- ปุ่มแก้ไข --}}
                                <a href="{{ route('products.show', $product->slug) }}?mode=edit&row_id={{ $item['row_id'] }}&qty={{ $item['quantity'] }}" class="btn-edit">
                                    <i class="bi bi-pencil-square me-1"></i> แก้ไข
                                </a>
                                
                                {{-- ปุ่มลบ --}}
                                <a href="javascript:void(0)" class="btn-delete" onclick="removeItem('{{ $item['row_id'] }}')">
                                    <i class="bi bi-trash3"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Footer --}}
        <div class="cart-footer">
            <div class="total-items-text">
                สินค้าในตะกร้า (<span id="total-count">{{ count($cartItems) }}</span>)
            </div>
            <button class="btn btn-request-quote">
                ขอใบเสนอราคา (<span id="selected-count">0</span>)
            </button>
        </div>

    @else
        {{-- =================================================================
             ✅ ส่วนแสดงผลเมื่อไม่มีสินค้า (Empty Cart UI)
             ================================================================= --}}
        <div class="empty-cart-container text-center py-5">
            {{-- 1. รูปภาพตะกร้า --}}
            <img src="{{ asset('images/Hotmobilyfile/poster/cart1.png') }}" alt="Empty Cart" class="empty-cart-icon mb-4">
            
            {{-- 2. ข้อความ (25px bold) --}}
            <h3 class="empty-cart-text">ยังไม่มีสินค้าในตะกร้าของคุณ</h3>
            
            {{-- 3. ปุ่มเลือกซื้อสินค้า (FFA726, 20px, normal) --}}
            <a href="{{ route('products.index') }}" class="btn btn-shop-now">
                เลือกซื้อสินค้า
            </a>
        </div>
    @endif

</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function toggleCheck(element) {
        element.classList.toggle('checked');
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const count = document.querySelectorAll('.custom-checkbox.checked').length;
        document.getElementById('selected-count').innerText = count;
    }

    function removeItem(rowId) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "คุณต้องการลบสินค้านี้ออกจากตะกร้าใช่ไหม",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('{{ route("cart.remove") }}', {
                    row_id: rowId,
                    _token: '{{ csrf_token() }}'
                }).then(response => {
                    location.reload();
                });
            }
        });
    }
</script>

@endsection