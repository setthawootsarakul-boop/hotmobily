@extends('layouts.main')

@section('title', $product->name . ' | Hotmobily')

@section('content')

<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">

<div class="container-fluid product-detail-page py-4">
    <div class="container">
        
        <nav aria-label="breadcrumb" class="mb-4 product-breadcrumb">
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
                        <button class="btn btn-file-guide w-100 fw-bold py-2 rounded-3 shadow-sm">
                            รูปแบบไฟล์งาน
                        </button>
                    </div>
                </div>

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
                                    <div class="d-flex gap-2" id="size-group">
                                        @foreach($product->sizes as $key => $size)
                                            <button class="btn btn-spec {{ $key == 0 ? 'active' : '' }}" 
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

                            <tr>
                                <td class="label">ระยะเวลาผลิต :</td>
                                <td class="value">{{ $product->production_time }}</td>
                            </tr>
                            
                            @if($product->printings->isNotEmpty())
                            <tr>
                                <td class="label">การสกรีน :</td>
                                <td class="value">
                                    {{ $product->printings->first()->note ?? '-' }}
                                    <div class="d-flex gap-3 mt-2" id="screen-group">
                                        @foreach($product->printings as $key => $printing)
                                            <button class="btn btn-spec {{ $key == 0 ? 'active' : '' }}"
                                                    data-group="screen-group"
                                                    data-table-id="price-table-{{ $printing->id }}"
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
                    
                    @if($product->prices->isNotEmpty())
                    <div class="price-table-wrapper mt-4">
                        
                        @foreach($product->printings as $key => $printing)
                        <div id="price-table-{{ $printing->id }}" 
                             class="price-table table-responsive" 
                             style="{{ $key == 0 ? '' : 'display: none;' }}">
                            
                            <table class="table table-bordered text-center align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th class="">จำนวน</th>
                                        @foreach($product->sizes as $size)
                                            <th class="size-col-{{ $size->id }}">
                                                {{ $size->size_name }}
                                            </th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($quantities as $qty)
                                    <tr class="price-row">
                                        <td>{{ number_format($qty) }}</td>
                                        @foreach($product->sizes as $k_size => $size)
                                            <td class="size-col size-col-{{ $size->id }}">
                                                @php
                                                    $price = $product->prices
                                                                ->where('product_printing_id', $printing->id)
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
                        @endforeach

                    </div>
                    @endif
                    
                    @if($product->parts->isNotEmpty())
                    <div class="mt-5">
                        <h3 class="fw-bold mb-4">ส่วนประกอบเพิ่มเติม</h3>
                        <div class="row g-3">
                            @foreach($product->parts as $part)
                                <div class="col-lg-2 col-md-3 col-4">
                                    <div class="part-box rounded-3 border p-2 text-center {{ $part->is_default ? 'active' : '' }}"
                                         data-group="part-group"
                                         onclick="selectSpec(this, 'part-group')">
                                        @if($part->image_url)
                                            <div class="part-img-box mb-2">
                                                <img src="{{ asset($part->image_url) }}" alt="{{ $part->part_name }}">
                                            </div>
                                        @endif
                                        <small class="part-name d-block fw-bold">{{ $part->part_name }}</small>
                                        
                                        @if($part->price_extra > 0)
                                            <span class="part-price-tag extra">+{{ $part->price_extra }}฿</span>
                                        @else
                                            <span class="part-price-tag free">ฟรี!</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

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

                </div> </div>
        </div>
        
        @if($relatedProducts->isNotEmpty())
        <div class="mt-5">
            <h3 class="fw-bold mb-4">สินค้าอื่นๆ ที่น่าสนใจ</h3>
            <div class="row g-3">
                @foreach($relatedProducts as $related)
                    <div class="col-6 col-md-3 col-xl-2-5">
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

    // ฟังก์ชันใหม่สำหรับ "เลือก 1 อย่าง"
    function selectSpec(element, groupName) {
        const groupElements = document.querySelectorAll(`[data-group="${groupName}"]`);
        groupElements.forEach(el => el.classList.remove('active'));
        element.classList.add('active');
    }

    // ฟังก์ชันสำหรับปุ่มสกรีน (เลือก 1 อย่าง + สลับตาราง)
    function selectScreen(element) {
        selectSpec(element, 'screen-group');
        const tableIdToShow = element.dataset.tableId;
        document.querySelectorAll('.price-table').forEach(el => el.style.display = 'none');
        document.getElementById(tableIdToShow).style.display = 'block';
    }

    // ✅ (แก้ไข) ฟังก์ชันสำหรับปุ่มขนาด (เลือก 1 อย่าง)
    function selectSize(element, sizeId) {
        selectSpec(element, 'size-group');
        
        // (ลบโค้ดสลับคอลัมน์ตารางออก)
    }
</script>

@endsection