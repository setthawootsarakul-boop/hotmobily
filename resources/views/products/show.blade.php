@extends('layouts.main')

@section('title', $product->name . ' | Hotmobily')

@section('content')

<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">

<div class="container-fluid product-detail-page py-4">
    <div class="container">
        
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb bg-transparent p-0 mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">หน้าหลัก</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="{{ route('products.index') }}">สินค้าทั้งหมด</a>
                </li>
                <li class="breadcrumb-item active" aria-current="page">
                    {{ $product->name }}
                </li>
            </ol>
        </nav>

        <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
            <div class="row g-5">
                
                <div class="col-lg-5">
                    <div class="gallery-container d-flex">
                        <div class="thumbnails d-flex flex-column gap-2 me-3">
                            @foreach($product->images as $index => $image)
                                <div class="thumb-item {{ $image->is_main ? 'active' : ($loop->first && !$product->images->where('is_main', 1)->count() ? 'active' : '') }}" 
                                     onclick="changeMainImage(this, '{{ asset($image->image_url) }}')">
                                    <img src="{{ asset($image->image_url) }}" alt="{{ $image->alt_text }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="main-image-wrapper rounded-3">
                            @php
                                $mainImage = $product->images->where('is_main', 1)->first() ?? $product->images->first();
                                $mainSrc = $mainImage ? asset($mainImage->image_url) : asset('images/no-image.png');
                            @endphp
                            <img id="mainProductImage" src="{{ $mainSrc }}" alt="{{ $product->name }}" class="img-fluid">
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button class="btn btn-file-guide w-100 fw-bold py-2 rounded-3">
                            รูปแบบไฟล์งาน
                        </button>
                    </div>
                </div>

                <div class="col-lg-7">
                    <h1 class="product-title fw-bold mb-4">{{ $product->name }}</h1>

                    <div class="product-info d-flex flex-column gap-3">
                        
                        <div class="d-flex align-items-baseline">
                            <span class="label fw-bold me-3">วัสดุ :</span>
                            <span class="value">
                                @if($product->materials->isNotEmpty())
                                    @foreach($product->materials as $mat)
                                        {{ $mat->material_name }} (หนา {{ $mat->thickness }}){{ !$loop->last ? ',' : '' }}
                                    @endforeach
                                @else
                                    -
                                @endif
                            </span>
                        </div>

                        @if($product->sizes->isNotEmpty())
                        <div class="d-flex align-items-center flex-wrap">
                            <span class="label fw-bold me-3">ขนาด :</span>
                            <div class="d-flex gap-2">
                                @foreach($product->sizes as $key => $size)
                                    <button class="btn-option {{ $key == 0 ? 'active' : '' }}" 
                                            onclick="selectSize(this, {{ $size->id }})">
                                        {{ $size->size_name }}
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="d-flex align-items-baseline">
                            <span class="label fw-bold me-3">สั่งขั้นต่ำ :</span>
                            <span class="value">{{ $product->moq }}</span>
                        </div>

                        <div class="d-flex align-items-baseline">
                            <span class="label fw-bold me-3">การบรรจุ :</span>
                            <span class="value">{{ $product->packing }}</span>
                        </div>

                        @if($product->special_features)
                        <div class="">
                            <span class="label fw-bold me-3">คุณสมบัติพิเศษ :</span>
                            <span class="value">{!! nl2br(e($product->special_features)) !!}</span>
                        </div>
                        @endif

                        <div class="d-flex align-items-baseline">
                            <span class="label fw-bold me-3">ระยะเวลาผลิต :</span>
                            <span class="value">{{ $product->production_time }}</span>
                        </div>

                        @if($product->printings->isNotEmpty())
                        <div class="mt-2">
                            <div class="mb-2">
                                <span class="label fw-bold">การสกรีน :</span> 
                                <span class="value">{{ $product->printings->first()->note ?? '-' }}</span>
                            </div>
                            <div class="d-flex gap-3 mt-2">
                                @foreach($product->printings as $key => $printing)
                                    <button class="btn-screen {{ $key == 0 ? 'active' : '' }}">
                                        {{ $printing->printing_type }}
                                        @if($printing->price_extra > 0) 
                                            <small class="ms-1 text-muted">(+{{ $printing->price_extra }})</small>
                                        @endif
                                    </button>
                                @endforeach
                            </div>
                        </div>
                        @endif

                    </div>

                    @if($product->prices->isNotEmpty())
                    <div class="price-table-container mt-4 table-responsive">
                        <table class="table table-bordered text-center align-middle mb-0">
                            <thead>
                                <tr>
                                    <th class="bg-light">จำนวน</th>
                                    @foreach($product->sizes as $key => $size)
                                        <th class="bg-light size-header size-col-{{ $size->id }}" 
                                            style="{{ $key == 0 ? '' : 'display:none' }}">
                                            ราคา/ชิ้น ({{ $size->size_name }})
                                        </th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($quantities as $qty)
                                <tr>
                                    <td>{{ number_format($qty) }}</td>
                                    @foreach($product->sizes as $key => $size)
                                        <td class="size-col size-col-{{ $size->id }}" 
                                            style="{{ $key == 0 ? '' : 'display:none' }}">
                                            @php
                                                // ค้นหาราคาที่ตรงกับ Size นี้ และ Qty นี้
                                                $price = $product->prices
                                                            ->where('product_size_id', $size->id)
                                                            ->where('quantity_min', $qty)
                                                            ->first();
                                            @endphp
                                            {{ $price ? number_format($price->price_per_unit) : '-' }}
                                        </td>
                                    @endforeach
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    @endif
                    
                    @if($product->parts->isNotEmpty())
                    <div class="mt-5">
                        <h5 class="fw-bold mb-3">ส่วนประกอบเพิ่มเติม</h5>
                        <div class="d-flex flex-wrap gap-4">
                            @foreach($product->parts as $part)
                                <div class="text-center part-item">
                                    @if($part->image_url)
                                        <div class="part-img-box mb-2 rounded-3 border p-2">
                                            <img src="{{ asset($part->image_url) }}" alt="{{ $part->part_name }}" class="img-fluid h-100 object-fit-contain">
                                        </div>
                                    @endif
                                    <small class="d-block fw-bold">{{ $part->part_name }}</small>
                                    <small class="text-danger fw-bold">
                                        {{ $part->price_extra > 0 ? "+".$part->price_extra."฿" : "ฟรี" }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                </div> </div>
        </div>
        
        @if($relatedProducts->isNotEmpty())
        <div class="mt-5">
            <h3 class="fw-bold mb-4">สินค้าอื่นๆ ที่น่าสนใจ</h3>
            <div class="row g-3">
                @foreach($relatedProducts as $related)
                    <div class="col-6 col-md-3">
                        <div class="product-card">
                            @php
                                $rImg = $related->images->where('is_main', 1)->first() ?? $related->images->first();
                                $rSrc = $rImg ? asset($rImg->image_url) : asset('images/no-image.png');
                            @endphp
                            <div class="product-thumb" style="background-image: url('{{ $rSrc }}');"></div>
                            <div class="product-title">
                                <a href="{{ $related->slug ? route('products.show', $related->slug) : '#' }}">
                                    {{ $related->name }}
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </div>
</div>

<script>
    function changeMainImage(element, src) {
        document.getElementById('mainProductImage').src = src;
        document.querySelectorAll('.thumb-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }

    function selectSize(element, sizeId) {
        // 1. เปลี่ยนปุ่ม active
        document.querySelectorAll('.btn-option').forEach(el => el.classList.remove('active'));
        element.classList.add('active');

        // 2. เปลี่ยนคอลัมน์ตารางราคา
        document.querySelectorAll('.size-header, .size-col').forEach(el => el.style.display = 'none');
        document.querySelectorAll('.size-col-' + sizeId).forEach(el => el.style.display = 'table-cell');
    }
</script>

@endsection