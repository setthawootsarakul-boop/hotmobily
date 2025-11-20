@extends('layouts.main')

@section('title', $product->name . ' | Hotmobily')

@section('content')

{{-- [NEW] 1. เพิ่ม CSS ของ GLightbox --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">

<div class="container-fluid product-detail-page py-4">
    <div class="container">
        
        <nav aria-label="breadcrumb" class="mb-4 product-breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">สินค้าทั้งหมด</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
            <div class="row g-5">
                
                {{-- LEFT COLUMN: Gallery --}}
                <div class="col-lg-5">
                    @php
                        $galleryImages = $product->images->where('is_main', 0); 
                        $firstImage = $galleryImages->first(); 
                        $initialSrc = $firstImage ? asset($firstImage->image_url) : asset('images/no-image.png');
                    @endphp

                    <div class="gallery-container">
                        {{-- Thumbnails (ซ้าย) --}}
                        <div class="thumbnails">
                            {{-- [UPDATED] เพิ่ม $index เพื่อใช้ระบุตำแหน่งรูป --}}
                            @foreach($galleryImages->values() as $index => $image)
                                <div class="thumb-item {{ $index == 0 ? 'active' : '' }}" 
                                     onclick="changeMainImage(this, '{{ asset($image->image_url) }}', {{ $index }})">
                                    <img src="{{ asset($image->image_url) }}" alt="{{ $image->alt_text }}">
                                </div>
                            @endforeach
                        </div>

                        {{-- Main Image (ขวา) --}}
                        <div class="main-image-wrapper rounded-3" onclick="openLightbox()">
                            {{-- เพิ่ม cursor-zoom-in ให้รู้ว่ากดได้ --}}
                            <img id="mainProductImage" src="{{ $initialSrc }}" alt="{{ $product->name }}" class="img-fluid" style="cursor: zoom-in;">
                            <div class="zoom-icon">
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button class="btn btn-file-guide fw-bold py-2 px-5 rounded-3 shadow-sm">
                            <i class="bi bi-file-earmark-text me-2"></i> รูปแบบไฟล์งาน
                        </button>
                    </div>
                </div>

                {{-- RIGHT COLUMN: Info (เหมือนเดิม) --}}
                <div class="col-lg-7">
                    <h1 class="product-title fw-bold mb-4">{{ $product->name }}</h1>

                    <table class="table product-info-table">
                        <tbody>
                            <tr>
                                <td class="label">วัสดุ :</td>
                                <td class="value">
                                    @if($product->materials->isNotEmpty())
                                        {{ $product->materials->first()->material_name }} (หนา {{ $product->materials->first()->thickness }})
                                    @else - @endif
                                </td>
                            </tr>
                            @if($product->sizes->isNotEmpty())
                            <tr>
                                <td class="label">ขนาด :</td>
                                <td class="value">
                                    <div class="d-flex gap-2 flex-wrap" id="size-group">
                                        @foreach($product->sizes as $key => $size)
                                            <button class="btn btn-spec {{ $key == 0 ? 'active' : '' }} mb-1" 
                                                    data-group="size-group"
                                                    onclick="selectSize(this, {{ $size->id }})">
                                                {{ $size->size_name }}
                                            </button>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endif
                            <tr><td class="label">สั่งขั้นต่ำ :</td><td class="value">{{ $product->moq }}</td></tr>
                            <tr><td class="label">การบรรจุ :</td><td class="value">{{ $product->packing }}</td></tr>
                            @if($product->special_features)
                            <tr>
                                <td class="label">คุณสมบัติพิเศษ :</td>
                                <td class="value">{!! nl2br(e($product->special_features)) !!}</td>
                            </tr>
                            @endif
                            <tr><td class="label">ระยะเวลาผลิต :</td><td class="value">{{ $product->production_time }}</td></tr>
                            @if($product->printings->isNotEmpty())
                            <tr>
                                <td class="label">การสกรีน :</td>
                                <td class="value">
                                    <span id="printing-note">{{ $product->printings->first()->note ?? '-' }}</span>
                                    <div class="d-flex gap-3 mt-2 flex-wrap" id="screen-group">
                                        @foreach($product->printings as $key => $printing)
                                            <button class="btn btn-spec {{ $key == 0 ? 'active' : '' }} mb-1"
                                                    data-group="screen-group"
                                                    data-table-id="price-table-{{ $printing->id }}"
                                                    data-note="{{ $printing->note ?? '-' }}"
                                                    onclick="selectScreen(this)">
                                                {{ $printing->printing_type }}
                                            </button>
                                        @endforeach
                                    </div>
                                </td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    
                    {{-- Price Tables --}}
                    @if($product->prices->isNotEmpty())
                    <div class="price-table-wrapper mt-4">
                        @foreach($product->printings as $key => $printing)
                        <div id="price-table-{{ $printing->id }}" 
                             class="price-table table-responsive" 
                             style="{{ $key == 0 ? '' : 'display: none;' }}">
                            <table class="table table-bordered text-center align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="background-color: #f8f9fa;">จำนวน</th>
                                        @forelse($product->sizes as $size)
                                            <th class="size-header" style="white-space: nowrap;">
                                                <span style="color: #666; font-weight: normal;">ขนาดไม่เกิน</span> 
                                                {{ $size->size_name }}
                                            </th>
                                        @empty
                                            <th>ราคา / ชิ้น</th>
                                        @endforelse
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quantities as $qty)
                                    <tr class="price-row">
                                        <td class="fw-bold bg-light">{{ number_format($qty) }}</td>
                                        @forelse($product->sizes as $size)
                                            @php
                                                $price = $product->prices
                                                    ->where('product_printing_id', $printing->id)
                                                    ->where('product_size_id', $size->id)
                                                    ->where('quantity_min', $qty)
                                                    ->first();
                                            @endphp
                                            <td class="size-col">{{ $price ? number_format($price->price_per_unit) : '-' }}</td>
                                        @empty
                                            @php
                                                $price = $product->prices->where('quantity_min', $qty)->first();
                                            @endphp
                                            <td class="size-col">{{ $price ? number_format($price->price_per_unit) : '-' }}</td>
                                        @endforelse
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                    <div class="price-notes mt-4 text-secondary" style="font-size: 0.85rem; line-height: 1.6;">
                        <p class="mb-1">1) ราคานี้เป็นราคาผลิตต่อหน่วย ไม่ใช่ราคารวมสินค้า</p>
                        <p class="mb-1">2) ราคานี้รวมค่าบรรจุใส่ถุง และฟรีค่าจัดส่งเมื่อสั่งซื้อตั้งแต่ 1,000 บาทขึ้นไป กรณียอดการสั่งซื้อน้อยกว่า 500 บาทจะมีค่าจัดส่ง 50 บาท</p>
                        <p class="mb-1">3) หากสินค้าที่ท่านสั่งผลิตมีจำนวนมากก็จะได้ราคาถูกมากขึ้นและทางเราจะส่งสินค้าตัวอย่างให้ตรวจสอบก่อนผลิตจริงฟรี</p>
                        <p class="mb-1">4) อาจมีค่าใช้จ่ายเพิ่มเติม สำหรับส่วนประกอบเพิ่มเติมบางรูปแบบ</p>
                        <p class="mb-1">5) ราคาสินค้าที่แสดงยังไม่รวมภาษีมูลค่าเพิ่ม</p>
                        <p class="mb-0">6) หากสั่งซื้อเป็นจำนวนมากกว่าในตารางราคาจะได้ราคาพิเศษ</p>
                    </div>
                    @endif
                    
                    {{-- Parts --}}
                    @if($product->parts->isNotEmpty())
                    <div class="mt-5">
                        <h3 class="fw-bold mb-4">ส่วนประกอบเพิ่มเติม</h3>
                        <div class="row g-3">
                            @foreach($product->parts as $part)
                                <div class="col-lg-3 col-md-3 col-4">
                                    <div class="part-box rounded-3 border p-1 text-center {{ $part->is_default ? 'active' : '' }}"
                                         data-group="part-group"
                                         onclick="selectSpec(this, 'part-group')"
                                         title="{{ $part->part_name }}">
                                    @if($part->image_url)
                                        <div class="part-img-box mb-0">
                                            <img src="{{ asset($part->image_url) }}" alt="{{ $part->part_name }}">
                                        </div>
                                    @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Action Area --}}
                    <div class="action-area bg-white rounded-4 shadow-sm p-4 mt-5">
                        <div class="row justify-content-center align-items-center g-3">
                            <div class="col-lg-3 col-md-4 d-flex align-items-center">
                                <label for="quantityInput" class="form-label fw-bold me-3 mb-0">จำนวน :</label>
                                <input type="number" class="form-control" id="quantityInput" value="1" min="1">
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <button class="btn btn-estimate w-100 fw-bold">ประเมินราคา</button>
                            </div>
                            <div class="col-lg-3 col-md-4">
                                <button class="btn btn-quote w-100 fw-bold">ขอใบเสนอราคา</button>
                            </div>
                            <div class="col-lg-3 col-md-12">
                                <button class="btn btn-add-to-cart w-100 fw-bold">เพิ่มใส่ตะกร้า</button>
                            </div>
                        </div>
                    </div>

                </div> 
            </div>
        </div>
    </div>
</div>

{{-- [NEW] 2. เพิ่ม Script GLightbox --}}
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>

<script>
    // เตรียมข้อมูลรูปภาพสำหรับ Lightbox (แปลงจาก PHP array เป็น JS array)
    const productImages = [
        @foreach($galleryImages as $img)
            {
                'href': '{{ asset($img->image_url) }}',
                'type': 'image',
                'title': '{{ $img->alt_text }}'
            },
        @endforeach
    ];

    // ตัวแปรเก็บ index รูปปัจจุบัน (เริ่มที่ 0)
    let currentImageIndex = 0;

    // Init GLightbox (แบบพื้นฐานไว้ก่อน)
    const lightbox = GLightbox({
        touchNavigation: true,
        loop: true,
        autoplayVideos: true
    });

    function changeMainImage(element, src, index) {
        // เปลี่ยนรูปหลัก
        document.getElementById('mainProductImage').src = src;
        
        // จัดการ Active Class ของ Thumbnails
        document.querySelectorAll('.thumb-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');

        // [NEW] อัปเดต index ปัจจุบัน เพื่อให้เวลาเปิด Lightbox มันเริ่มที่รูปนี้
        currentImageIndex = index;
    }

    // [NEW] ฟังก์ชันเปิด Lightbox เมื่อกดรูปใหญ่
    function openLightbox() {
        if(productImages.length > 0) {
            // ตั้งค่ารูปภาพใหม่ให้ Lightbox (เผื่อมีอะไรเปลี่ยน)
            lightbox.setElements(productImages);
            // เปิด Lightbox ที่รูปปัจจุบัน (currentImageIndex)
            lightbox.openAt(currentImageIndex);
        }
    }

    // ---------------------------------------------------
    // ฟังก์ชันอื่นๆ เหมือนเดิม
    function selectSpec(element, groupName) {
        document.querySelectorAll(`[data-group="${groupName}"]`).forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }

    function selectScreen(element) {
        selectSpec(element, 'screen-group');
        const tableIdToShow = element.dataset.tableId;
        document.querySelectorAll('.price-table').forEach(el => el.style.display = 'none');
        const tableToShow = document.getElementById(tableIdToShow);
        if(tableToShow) tableToShow.style.display = 'block';
        const noteText = element.getAttribute('data-note');
        const noteElement = document.getElementById('printing-note');
        if(noteElement) noteElement.innerText = noteText;
    }
    
    function selectSize(element, sizeId) {
        selectSpec(element, 'size-group');
    }
</script>
@endsection