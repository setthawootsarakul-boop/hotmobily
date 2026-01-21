@extends('layouts.main')

@section('title', $product->name . ' | Hotmobily')

@section('content')

@php
    $isEditMode = request('mode') == 'edit';
    $editRowId = request('row_id');
    $editQty = request('qty', 1);

    // 🔥 รับค่า "ชื่อ" จาก URL เพื่อใช้เปรียบเทียบล็อคปุ่ม
    $urlSizeName  = request('size_name'); 
    $urlPrintName = request('print_name');
    $urlPartName  = request('part_name');
    $urlPartColor = request('part_color');

    $hasPrices = $product->prices->where('price_per_unit', '>', 0)->isNotEmpty();

    if(in_array($product->id, [6, 15])) {
        $hasPrices = false;
    }

    // กรองประเภทการสกรีนที่มีชื่อระบุไว้
    $validPrintings = $product->printings->filter(function($p) { return !empty(trim($p->printing_type)); });
    
    // ดึงรายการจำนวนขั้นต่ำทั้งหมดที่มี เพื่อทำเป็นแถวในตาราง
    $quantities = $product->prices->unique('quantity_min')->sortBy('quantity_min')->pluck('quantity_min');
@endphp

{{-- CSS & Style --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">

<style>
    .estimation-table th, .estimation-table td {
        vertical-align: middle;
        border-color: #ddd !important; 
    }
    
    .btn-estimate-action {
        background-color: #FFA726;
        color: white;
        border-radius: 8px;
        transition: 0.3s;
        border: none;
    }
    .btn-estimate-action:hover {
        background-color: #e69520;
        color: white;
    }
    
    .btn-update-action {
        background-color: #FFA726;
        color: #ffffff;
        border-radius: 8px;
        border: none;
        transition: 0.3s;
    }
    .btn-update-action:hover {
        background-color: #e69520;
    }
    
    .btn-quote {
        background-color: #FFA726;
        color: white;
        border-radius: 8px;
        border: none;
        transition: 0.3s;
    }
    .btn-quote:hover {
        background-color: #e69520;
        color: white;
    }
    .product-top-banner {
        width: 100%;
        overflow: hidden;
    }

    .product-top-banner img {
        width: 100%;
        aspect-ratio: 1240 / 300; 
        object-fit: cover;
        display: block;
    }

    /* ตารางราคาแบบ Dynamic */
    .price-table-wrapper { margin-top: 20px; border-radius: 12px; overflow: hidden; border: 1px solid #eee; }
    .price-table { margin-bottom: 0 !important; width: 100%; border-collapse: collapse; }
    .price-table thead th { background-color: #f8f9fa; color: #333; font-weight: bold; text-align: center; border: 1px solid #dee2e6; padding: 12px; }
    .price-table tbody td { text-align: center; border: 1px solid #dee2e6; padding: 12px; font-size: 14px; }
    .qty-column { background-color: #fcfcfc; font-weight: bold; width: 120px; }

    @media (max-width: 768px) {
        .product-top-banner {
            margin-bottom: 30px;
        }
        .product-top-banner img {
            aspect-ratio: auto; 
            max-height: 200px;
        }
    }
</style>

<div class="container-fluid product-detail-page py-4">
    <div class="container">
        
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb" class="mb-4 product-breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="{{ route('products.index') }}">สินค้าทั้งหมด</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
            </ol>
        </nav>

    <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
    {{-- ✅ ค้นหา Banner ที่ตรงกับสินค้าปัจจุบัน --}}
    @php
        $currentBanner = "";
        if(!empty($banners)) {
            foreach($banners as $value) {
                if (isset($value['product_key']) && $value['product_key'] == $product->slug) {
                    $currentBanner = $value['banner_img']; 
                    break; 
                }
            }
        }
    @endphp

    @if(!empty($currentBanner))
        <div class="product-info-banner mb-4">
            <img src="{{ $currentBanner }}" 
                    alt="Banner {{ $product->name }}" 
                    style="width: 100%; border-radius: 12px; box-shadow: 0 4px 15px rgba(0,0,0,0.05);">
        </div>
    @endif

    {{-- ================= SECTION 1: ข้อมูลสินค้า ================= --}}
    <div class="row g-5">
            
            <div class="row g-5">
                
                {{-- LEFT COLUMN: Gallery --}}
                <div class="col-lg-5">
                    
                    <h1 class="product-title d-lg-none mb-3 text-start">
                        {{ $product->name }}
                    </h1>

                    @php
                        $galleryImages = $product->images->where('is_main', 0); 
                        $firstImage = $galleryImages->first(); 
                        $initialSrc = $firstImage ? asset($firstImage->image_url) : asset('images/no-image.png');
                    @endphp

                    <div class="gallery-container">
                        <div class="thumbnails">
                            @foreach($galleryImages->values() as $index => $image)
                                <div class="thumb-item {{ $index == 0 ? 'active' : '' }}" 
                                     onclick="changeMainImage(this, '{{ asset($image->image_url) }}', {{ $index }})">
                                    <img src="{{ asset($image->image_url) }}" alt="{{ $image->alt_text }}">
                                </div>
                            @endforeach
                        </div>

                        <div class="main-image-wrapper rounded-3" onclick="openLightbox()">
                            <img id="mainProductImage" src="{{ $initialSrc }}" alt="{{ $product->name }}" class="img-fluid" style="cursor: zoom-in;">
                            <div class="zoom-icon"></div>
                        </div>
                    </div>

                    <div class="mt-4 text-end">
                        <a href="https://line.me/R/ti/p/@842kcbjl" target="_blank" class="btn btn-file-guide fw-bold py-2 px-5 rounded-3 shadow-sm d-inline-block text-decoration-none">
                            <i class="bi bi-file-earmark-text me-2"></i> กรุณาติดต่อพนักงานเพื่อขอไฟล์ Template
                        </a>
                    </div>
                </div>

                
                <div class="col-lg-7">

                    <h1 class="product-title d-none d-lg-block">{{ $product->name }}</h1>

                    <table class="table product-info-table">
                        <tbody>
                            <tr>
                                <td class="label">วัสดุ :</td>
                                <td class="value">
                                    @if($product->materials->isNotEmpty()) 
                                        {{ $product->materials->first()->material_name }} 
                                        @if(!empty($product->materials->first()->thickness) && $product->materials->first()->thickness != '-')
                                            (หนา {{ $product->materials->first()->thickness }}) 
                                        @endif
                                    @else 
                                        - 
                                    @endif
                                </td>
                            </tr>
                            
                            @if($product->sizes->isNotEmpty())
                            <tr>
                                <td class="label" style="white-space: nowrap; vertical-align: top;">ขนาด :</td>
                                <td class="value">
                                    @php
                                        $firstSize = $product->sizes->first();
                                        $hasNote = !empty($firstSize->note);
                                        $countSizes = $product->sizes->count();
                                        $shouldHideButtons = ($countSizes === 1 && $hasNote);
                                    @endphp

                                    @if($hasPrices && !$shouldHideButtons)
                                        <div class="d-inline-flex gap-2 flex-wrap" id="size-group">
                                            @foreach($product->sizes as $key => $size)
                                                @php $isActiveSize = $urlSizeName ? ($urlSizeName == $size->size_name) : ($key == 0); @endphp
                                                <button class="btn btn-spec {{ $isActiveSize ? 'active' : '' }} mb-1" 
                                                        data-group="size-group" 
                                                        onclick="selectSize(this, {{ $size->id }})">
                                                    {{ $size->size_name }}
                                                </button>
                                            @endforeach
                                        </div>
                                    @endif

                                    @if(!$hasPrices || $shouldHideButtons)
                                        <span class="text-dark">
                                            @foreach($product->sizes as $size)
                                                {{ $size->size_name }}{{ !$loop->last ? ', ' : '' }}
                                            @endforeach
                                            @if($hasNote)
                                                &nbsp;{!! nl2br(e($firstSize->note)) !!}
                                            @endif
                                        </span>
                                    @endif
                                </td>
                            </tr>
                            @endif
                            
                            @if($product->thickness_option)
                            <tr><td class="label">ความหนา :</td><td class="value">{{ $product->thickness_option }}</td></tr>
                            @endif

                            @if($product->backside_printing_text)
                            <tr><td class="label">การพิมพ์ด้านหลัง :</td><td class="value">{{ $product->backside_printing_text }}</td></tr>
                            @endif

                            @if($product->paper_option_text)
                            <tr><td class="label">กระดาษรอง :</td><td class="value">{!! nl2br(e($product->paper_option_text)) !!}</td></tr>
                            @endif

                            @if($product->free_sample_text)
                            <tr><td class="label" style="color: #000;">ตัวอย่างสินค้า :</td><td class="value" style="color: #333;">{{ $product->free_sample_text }}</td></tr>
                            @endif

                            <tr><td class="label">สั่งขั้นต่ำ :</td><td class="value">{{ $product->moq }}</td></tr>
                            <tr><td class="label">การบรรจุ :</td><td class="value">{{ $product->packing }}</td></tr>
                            
                            @if($product->special_features)
                            <tr><td class="label">คุณสมบัติพิเศษ :</td><td class="value">{!! nl2br(e($product->special_features)) !!}</td></tr>
                            @endif
                            
                            <tr><td class="label">ระยะเวลาผลิต :</td><td class="value">{{ $product->production_time }}</td></tr>

                            @php $extras = json_decode($product->custom_fields, true); @endphp
                            @if(!empty($extras))
                                @foreach($extras as $label => $detail)
                                    @if(!empty($detail))
                                    <tr>
                                        <td class="label">{{ $label }} :</td>
                                        <td class="value">{{ $detail }}</td>
                                    </tr>
                                    @endif
                                @endforeach
                            @endif
                                
                            @if($validPrintings->isNotEmpty())
                                <tr>
                                    <td class="label">การสกรีน :</td>
                                    <td class="value">
                                        @php 
                                            $currentPrint = $urlPrintName ? $validPrintings->where('printing_type', $urlPrintName)->first() : $validPrintings->first();
                                        @endphp
                                        <span id="printing-note">{{ $currentPrint->note ?? '-' }}</span>
                                        @if($hasPrices)
                                        <div class="d-flex gap-3 mt-2 flex-wrap" id="screen-group">
                                            @foreach($validPrintings as $key => $printing)
                                                @php $isActivePrint = $urlPrintName ? ($urlPrintName == $printing->printing_type) : ($loop->first); @endphp
                                                <button class="btn btn-spec {{ $isActivePrint ? 'active' : '' }} mb-1" 
                                                        data-group="screen-group" 
                                                        data-table-id="price-table-{{ $printing->id }}" 
                                                        data-note="{{ $printing->note ?? '-' }}" 
                                                        data-printing-id="{{ $printing->id }}" 
                                                        onclick="selectScreen(this)">
                                                    {{ $printing->printing_type }}
                                                </button>
                                            @endforeach
                                        </div>
                                        @endif
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>

                    {{-- 🔥 [DYNAMIC PRICE TABLE SECTION] 🔥 --}}
                    @if($hasPrices)
                        <div class="price-table-wrapper mt-4">
                            @foreach($validPrintings as $key => $printing)
                                @php
                                    // 1. ดึง ID ของขนาดเฉพาะที่ถูกบันทึกไว้ในเทคนิคการพิมพ์นี้เท่านั้น
                                    $thisPrintSizeIds = $product->prices->where('product_printing_id', $printing->id)
                                                                    ->pluck('product_size_id')
                                                                    ->unique();
                                    
                                    // 2. กรองข้อมูลขนาดจากตาราง sizes จริงๆ
                                    $currentSizes = $product->sizes->whereIn('id', $thisPrintSizeIds)->values();

                                    // 3. ดึงรายการจำนวน (Rows) เฉพาะที่มีการบันทึกราคาไว้ในเทคนิคนี้
                                    $thisPrintQtys = $product->prices->where('product_printing_id', $printing->id)
                                                                    ->where('quantity_min', '>', 0)
                                                                    ->pluck('quantity_min')
                                                                    ->unique()
                                                                    ->sort()
                                                                    ->values();
                                @endphp

                                <div id="price-table-{{ $printing->id }}" 
                                    class="price-table-item table-responsive" 
                                    style="{{ ($urlPrintName ? ($urlPrintName == $printing->printing_type) : $loop->first) ? '' : 'display: none;' }}">
                                    
                                    @if($currentSizes->isNotEmpty() && $thisPrintQtys->isNotEmpty())
                                        <table class="table table-bordered text-center align-middle mb-0 price-table">
                                            <thead>
                                                <tr>
                                                    <th style="background-color: #f8f9fa;">จำนวน</th>
                                                    @foreach($currentSizes as $size)
                                                        <th class="size-header" style="white-space: nowrap;">
                                                            <span style="color: #666; font-weight: normal;">ขนาดไม่เกิน</span> {{ $size->size_name }}
                                                        </th>
                                                    @endforeach
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($thisPrintQtys as $qty)
                                                    <tr class="price-row">
                                                        <td class="fw-bold bg-light">{{ number_format($qty) }}</td>
                                                        @foreach($currentSizes as $size)
                                                            @php 
                                                                $price = $product->prices->where('product_printing_id', $printing->id)
                                                                                        ->where('product_size_id', $size->id)
                                                                                        ->where('quantity_min', $qty)
                                                                                        ->first(); 
                                                            @endphp
                                                            <td class="size-col">
                                                                {{ ($price && $price->price_per_unit > 0) ? number_format($price->price_per_unit, 2) : '-' }}
                                                            </td>
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    @else
                                        {{-- กรณีตารางว่างเปล่า (ถูกลบเกลี้ยงจากหลังบ้าน) --}}
                                        <div class="p-5 text-center text-muted bg-light rounded-4 border border-dashed">
                                            <i class="bi bi-table mb-2 fs-3 d-block opacity-50"></i>
                                            <span class="fw-bold">ยังไม่มีข้อมูลตารางราคาสำหรับเทคนิค {{ $printing->printing_type }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>

                        {{-- หมายเหตุท้ายตาราง --}}
                        <div class="price-notes mt-4 text-secondary" style="font-size: 11px; line-height: 1.6;">
                            <p class="mb-1">1) ราคานี้เป็นราคาผลิตต่อหน่วย ไม่ใช่ราคารวมสินค้า</p>
                            <p class="mb-1">2) ราคานี้รวมค่าบรรจุใส่ถุง และฟรีค่าจัดส่งเมื่อสั่งซื้อตั้งแต่ 1,000 บาทขึ้นไป กรณียอดการสั่งซื้อน้อยกว่า 500 บาทจะมีค่าจัดส่ง 50 บาท</p>
                            <p class="mb-1">3) หากสินค้าที่ท่านสั่งผลิตมีจำนวนมากก็จะได้ราคาถูกมากขึ้นและทางเราจะส่งสินค้าตัวอย่างให้ตรวจสอบก่อนผลิตจริงฟรี</p>
                            <p class="mb-1">4) อาจมีค่าใช้จ่ายเพิ่มเติม สำหรับส่วนประกอบเพิ่มเติมบางรูปแบบ</p>
                            <p class="mb-1">5) ราคาสินค้าที่แสดงยังไม่รวมภาษีมูลค่าเพิ่ม</p>
                            <p class="mb-0">6) หากสั่งซื้อเป็นจำนวนมากกว่าในตารางราคาจะได้ราคาพิเศษ</p>
                        </div>
                    @endif
                    {{-- Parts --}}
                    @if($hasPrices && $product->parts->isNotEmpty()) 
                    <div class="mt-5">
                        <h3 class="mb-4">ส่วนประกอบเพิ่มเติม</h3>
                        <div class="row g-3 parts-grid">
                            @foreach($product->parts as $part)
                                @php
                                    $isActivePart = false;
                                    if ($urlPartName) {
                                        $isActivePart = ($urlPartName == $part->part_name && ($urlPartColor == $part->color || ($urlPartColor == '-' && !$part->color)));
                                    } else {
                                        $isActivePart = $part->is_default;
                                    }
                                @endphp
                                <div class="col-lg-3 col-md-3 col-4">
                                    <div class="part-box p-1 text-center {{ $isActivePart ? 'active' : '' }}"
                                         data-group="part-group" 
                                         onclick="selectSpec(this, 'part-group')" 
                                         data-part-id="{{ $part->id }}" 
                                         title="{{ $part->part_name }}">
                                    @if($part->image_url)
                                        <div class="part-img-box mb-0"><img src="{{ asset('/images/jp-attachments/attachments/' . $part->image_url) }}" alt="{{ $part->part_name }}"></div>
                                    @endif
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- [INPUT SECTION & BUTTONS] --}}
                    @if($hasPrices)
                        @php
                            $initSizeId = $product->sizes->where('size_name', $urlSizeName)->first()->id ?? ($product->sizes->first()->id ?? '');
                            $initPrintId = $validPrintings->where('printing_type', $urlPrintName)->first()->id ?? ($validPrintings->first()->id ?? '');
                            $initPartId = $product->parts->filter(function($p) use ($urlPartName, $urlPartColor) {
                                return $p->part_name == $urlPartName && ($p->color == $urlPartColor || (!$p->color && $urlPartColor == '-'));
                            })->first()->id ?? ($product->parts->where('is_default', 1)->first()->id ?? '');
                        @endphp

                        <input type="hidden" id="selected_product_id" value="{{ $product->id }}">
                        <input type="hidden" id="selected_size_id" value="{{ $initSizeId }}">
                        <input type="hidden" id="selected_printing_id" value="{{ $initPrintId }}">
                        <input type="hidden" id="selected_part_id" value="{{ $initPartId }}">

                        <div class="mt-4 d-flex justify-content-end align-items-center">
                            <label for="quantityInput" class="form-label fw-bold me-3 mb-0" style="font-size: 1.1rem;">จำนวน :</label>
                            <input type="number" class="form-control text-center fw-bold me-3" id="quantityInput" value="{{ $isEditMode ? $editQty : 1 }}" min="1" style="width: 120px; height: 45px; border-radius: 8px;">
                            <button class="btn btn-estimate-action fw-bold px-4 me-2" onclick="calculatePrice()" style="height: 45px; font-size: 1rem; min-width: 140px;">ประเมินราคา</button>
                        </div>

                        <div class="action-area-bottom mt-5">
                            <div class="row justify-content-center g-3">
                                <div class="col-md-6 col-lg-4">
                                    <button class="btn btn-quote w-100 py-2 fw-bold" onclick="requestQuotation()">ขอใบเสนอราคา</button>
                                </div>
                                <div class="col-md-6 col-lg-4">
                                    <button class="btn {{ $isEditMode ? 'btn-update-action' : 'btn-estimate-action' }} w-100 py-2 fw-bold" 
                                            onclick="{{ $isEditMode ? 'updateCart()' : 'addToCart()' }}">
                                        {{ $isEditMode ? 'อัปเดตตะกร้า' : 'เพิ่มใส่ตะกร้า' }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="alert alert-secondary mt-5 text-center py-4 rounded-4" style="background-color: #f8f9fa; border: 1px dashed #ccc;">
                            <p class="mb-0 text-muted">สินค้านี้ยังไม่เปิดระบบคำนวณราคาอัตโนมัติ กรุณาติดต่อสอบถามเจ้าหน้าที่เพื่อรับใบเสนอราคา</p>
                            <div class="mt-3">
                                <a href="https://line.me/R/ti/p/@842kcbjl" target="_blank" class="btn btn-success btn-sm rounded-pill px-4">
                                    <i class="bi bi-line me-1"></i> ติดต่อเจ้าหน้าที่ผ่าน LINE
                                </a>
                            </div>
                        </div>
                    @endif

                </div> {{-- End col-lg-7 --}}
            </div> {{-- End row g-5 --}}


            {{-- ================= SECTION 2: Result Area ================= --}}
            <div id="estimationResult" class="mt-5 pt-4 border-top" style="display: none;">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold text-center mb-3">ข้อมูล</h5>
                        <table class="table table-bordered estimation-table">
                            <tr><td class="bg-light fw-bold" width="40%">สินค้า</td><td>{{ $product->name }}</td></tr>
                            <tr><td class="bg-light fw-bold">ขนาด</td><td id="res_size">-</td></tr>
                            <tr><td class="bg-light fw-bold">การสกรีน</td><td id="res_print">-</td></tr>
                            <tr id="row_part_result">
                                <td class="bg-light fw-bold align-middle">ส่วนประกอบเพิ่มเติม</td>
                                <td id="part_result_cell"> 
                                    <div id="res_part_img_div" style="display:none; width: 50px; height: 50px; margin: 0 auto 5px auto;">
                                        <img id="res_part_img" src="" style="width:100%; height:100%; object-fit:contain;">
                                    </div>
                                    <span id="res_part_name">-</span>
                                </td>
                            </tr>
                            <tr><td class="bg-light fw-bold">จำนวน</td><td id="res_qty">-</td></tr>
                        </table>
                    </div>
                    <div class="col-md-6">
                        <h5 class="fw-bold text-center mb-3">ราคาประเมิน</h5>
                        <table class="table table-bordered estimation-table text-end">
                            <tr><td class="bg-light fw-bold text-start">ราคาสินค้า</td><td><span id="res_product_price">0</span> บาท</td></tr>
                            <tr><td class="bg-light fw-bold text-start">ส่วนประกอบ</td><td><span id="res_part_price">0</span> บาท</td></tr>
                            <tr><td class="bg-light fw-bold text-start">ราคาก่อนรวมภาษี</td><td><span id="res_subtotal">0</span> บาท</td></tr>
                            <tr><td class="bg-light fw-bold text-start">ภาษี (7%)</td><td><span id="res_vat">0</span> บาท</td></tr>
                            <tr>
                                <td class="bg-light fw-bold text-start fs-5">ราคาประเมินรวม</td>
                                <td class="fw-bold fs-5 text-danger"><span id="res_grand_total">0</span> บาท</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            {{-- Dynamic Content (Product 19, 12) --}}
            @if($product->id == 19)
                <div class="rubber-features-section mt-5 pt-4">
                    <div class="text-center mb-5">
                        <img src="{{ asset('images/Hotmobilyfile/poster/keychain.jpg') }}" alt="พวงกุญแจยาง" class="mb-4" style="width: 100vw; height: 372px; object-fit: cover; display: block; margin-left: -50vw; left: 50%; position: relative; right: 50%; margin-right: -50vw;">
                        <h3 class="fw-bold" style="color: #333; margin-top: 60px; font-size: 32px;">พวงกุญแจยาง</h3>
                        <p class="mx-auto" style="max-width: 700px; line-height: 1.6; font-size: 20px; margin-top: 40px;">พวงกุญแจยางทำจาก ATBC-PVC คุณภาพดี น้ำหนักเบา ทนทาน ป้องกันรอยขีดข่วน พร้อมสีสันและดีไซน์หลากหลาย เหมาะทั้งพกพาและตกแต่งให้โดดเด่น</p>
                    </div>
                    <div class="rubber-feature-container">
                        <div class="feature-column text-column left-text">
                            <div class="feature-item" style="top: 10%;">
                                <h5 class="fw-bold">ส่วนประกอบชิ้นงานที่หลากหลาย</h5>
                                <p>เรามีส่วนประกอบชิ้นงานให้คุณเลือกมากถึง 20 แบบ</p>
                                <div class="connector-line" style="width: 232px;right: -105px;"></div>
                            </div>
                            <div class="feature-item" style="top: 45%;">
                                <h5 class="fw-bold">กลิ่นยางและกลิ่นสีน้อยกว่า</h5>
                                <p>เราพยายามอย่างต่อเนื่องในการหาวัสดุที่ลดกลิ่นยาง และสี เพื่อให้คุณได้รับผลิตภัณฑ์ที่ดีที่สุด</p>
                                <div class="connector-line" style="width: 300px;right: -140px;"></div>
                            </div>
                            <div class="feature-item" style="top: 80%;">
                                <h5 class="fw-bold">ลงสีได้มากกว่า 18 สี</h5>
                                <p>คุณสามารถเลือกสีของชิ้นงานได้มากถึง 12 สีสำหรับชิ้นงานแบบมาตราฐาน และได้ถึง 18 สีสำหรับชิ้นงานแบบพรีเมียม</p>
                                <div class="connector-line" style="width: 370px;right: -152px;"></div>
                            </div>
                        </div>

                        <div class="feature-column image-column">
                            <div class="rubber-img-wrapper">
                                <img src="{{ asset('/images/Hotmobilyfile/poster/210-L.webp') }}" alt="Rubber Left" class="rubber-img">
                                <span class="dot-point" style="top: 15%; left: 56%;"></span>
                                <span class="dot-point" style="top: 50%; left: 74%;"></span>
                                <span class="dot-point" style="top: 85%;left: 80%;"></span>
                            </div>
                            <div class="rubber-img-wrapper">
                                <img src="{{ asset('/images/Hotmobilyfile/poster/210-R.webp') }}" alt="Rubber Right" class="rubber-img">
                                <span class="dot-point" style="top: 40%;right: 70%;"></span>
                                <span class="dot-point" style="top: 70%; right: 73%;"></span>
                            </div>
                        </div>

                        <div class="feature-column text-column right-text">
                            <div class="feature-item" style="top: 35%;">
                                <div class="connector-line" style="width: 143px;left: -140px;"></div>
                                <h5 class="fw-bold">การสกรีนที่มีคุณภาพ</h5>
                                <p>เราเลือกใช้การสกรีนด้านหลังแบบ UV ซึ่งสวยงามกว่าและมีโอกาสลอกออกน้อยกว่าการพิมพ์แบบปกติ</p>
                            </div>
                            <div class="feature-item" style="top: 65%;">
                                <div class="connector-line" style="width: 150px;left: -147px;"></div>
                                <h5 class="fw-bold">เลือกสีสกรีนได้ตามต้องการ</h5>
                                <p>การสกรีนด้านหลัง สามารถเลือกสีสกรีนได้ จะสีเดียวหรือหลายสี ก็สามารถทำได้</p>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($product->id == 12)
                <div class="acrylic-stand-section mt-5 pt-4">
                    <div class="acrylic-content text-center">
                        <h3 class="fw-bold acrylic-title">แท่นวางโทรศัพท์</h3>
                        <p class="mx-auto text-muted acrylic-desc">แท่นวางโทรศัพท์น้ำหนักเบา แข็งแรง ใช้งานสะดวก ปรับมุมมองได้ เหมาะสำหรับดูวิดีโอ ประชุมออนไลน์ หรือใช้งานมือถือโดยไม่ต้องถือให้เมื่อย</p>
                    </div>
                    <div class="acrylic-usage-wrapper d-flex justify-content-center">
                         <img src="{{ asset('images/Hotmobilyfile/poster/Group190.png') }}" alt="ตัวอย่าง" class="img-fluid acrylic-usage-img">
                    </div>
                </div>
            @endif

            {{-- ตัวอย่างผลงาน --}}
            @if(isset($productGalleries) && $productGalleries->isNotEmpty())
            <div class="product-gallery-section mt-5 border-top pt-5">
                <h2 class="product-gallery-title text-center mb-4">ตัวอย่างผลงาน</h2>
                <div class="product-example-grid">
                    @foreach($productGalleries as $gallery)
                        <div class="example-item">
                            <img src="{{ asset('images/gallery/' . $gallery->image_path) }}" alt="{{ $gallery->title ?? 'ตัวอย่างผลงาน' }}">
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div> {{-- End bg-white --}}
    </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // --- 1. ระบบรูปภาพและ Lightbox ---
    const productImages = [
        @foreach($galleryImages as $img)
            { 'href': '{{ asset($img->image_url) }}', 'type': 'image', 'title': '{{ $img->alt_text }}' },
        @endforeach
    ];
    let currentImageIndex = 0;
    const lightbox = GLightbox({ touchNavigation: true, loop: true, autoplayVideos: true });

    function changeMainImage(element, src, index) { 
        document.getElementById('mainProductImage').src = src; 
        document.querySelectorAll('.thumb-item').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        currentImageIndex = index;
    }
    
    function openLightbox() { 
        if(productImages.length > 0) {
            lightbox.setElements(productImages);
            lightbox.openAt(currentImageIndex);
        }
    }

    // --- 2. ฟังก์ชันการเลือก Options ---
    function selectSize(element, sizeId) { 
        document.querySelectorAll('[data-group="size-group"]').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('selected_size_id').value = sizeId;
    }

function selectScreen(element) { 
    // 1. สลับปุ่ม Active
    document.querySelectorAll('[data-group="screen-group"]').forEach(el => el.classList.remove('active'));
    element.classList.add('active');
    
    // 2. เก็บค่า ID ลง Hidden Input
    const printingId = element.getAttribute('data-printing-id');
    document.getElementById('selected_printing_id').value = printingId;
    
    // 3. สลับการแสดงตาราง (ซ่อนทั้งหมดก่อน แล้วเปิดเฉพาะที่เลือก)
    const tableIdToShow = element.dataset.tableId;
    document.querySelectorAll('.price-table-item').forEach(el => {
        el.style.display = 'none';
    });
    
    const tableToShow = document.getElementById(tableIdToShow);
    if(tableToShow) {
        tableToShow.style.display = 'block';
    }
    
    // 4. อัปเดตหมายเหตุใต้ชื่อเทคนิค
    const noteText = element.getAttribute('data-note');
    const noteElement = document.getElementById('printing-note');
    if(noteElement) {
        noteElement.innerText = noteText;
    }
}
    
    function selectSpec(element, groupName) { 
        document.querySelectorAll(`[data-group="${groupName}"]`).forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        const partId = element.getAttribute('data-part-id');
        document.getElementById('selected_part_id').value = partId;
    }

    // --- 3. ระบบคำนวณราคา ---
    function calculatePrice() { 
        const productId = document.getElementById('selected_product_id').value;
        const sizeId = document.getElementById('selected_size_id').value;
        const printingId = document.getElementById('selected_printing_id').value;
        const partId = document.getElementById('selected_part_id').value;
        const qty = document.getElementById('quantityInput').value;

        if(qty < 1) { 
            Swal.fire({ icon: 'warning', title: 'แจ้งเตือน', text: 'กรุณาระบุจำนวนอย่างน้อย 1 ชิ้น' });
            return; 
        }

        axios.post('{{ route("product.calculate") }}', {
            product_id: productId,
            size_id: sizeId,
            printing_id: printingId,
            part_id: partId,
            quantity: qty,
            _token: '{{ csrf_token() }}'
        })
        .then(function (response) {
            const data = response.data.data;
            document.getElementById('res_size').innerText = data.size_name;
            document.getElementById('res_print').innerText = data.print_name;
            document.getElementById('res_qty').innerText = data.quantity;

            if(data.part_info) {
                document.getElementById('part_result_cell').style.textAlign = 'center';
                document.getElementById('row_part_result').style.display = 'table-row';
                document.getElementById('res_part_name').innerText = data.part_info.name;

                if(data.part_info.image) {
                    var customPath = "{{ asset('/images/jp-attachments/attachments/') }}";
                    var filename = data.part_info.image.split('/').pop();
                    document.getElementById('res_part_img').src = customPath + '/' + filename;
                    document.getElementById('res_part_img_div').style.display = 'block';
                } else {
                    document.getElementById('res_part_img_div').style.display = 'none';
                }
            } else {
                document.getElementById('row_part_result').style.display = 'table-row'; 
                document.getElementById('res_part_name').innerText = '-';
                document.getElementById('res_part_img_div').style.display = 'none';
                document.getElementById('part_result_cell').style.textAlign = 'left';
            }

            document.getElementById('res_product_price').innerText = data.total_product_price;
            document.getElementById('res_part_price').innerText = data.total_part_price;
            document.getElementById('res_subtotal').innerText = data.subtotal;
            document.getElementById('res_vat').innerText = data.vat;
            document.getElementById('res_grand_total').innerText = data.grand_total;

            document.getElementById('estimationResult').style.display = 'block';
            document.getElementById('estimationResult').scrollIntoView({ behavior: 'smooth' });
        });
    }

    // --- 4. ระบบตะกร้าสินค้า ---
    function addToCart() {
        const qty = document.getElementById('quantityInput').value;
        const productId = document.getElementById('selected_product_id').value;
        
        if(qty < 1) { alert('กรุณาระบุจำนวนอย่างน้อย 1 ชิ้น'); return; }

        const data = {
            product_id: productId,
            quantity: qty,
            size_name: document.querySelector('[data-group="size-group"].active')?.innerText.trim() || '-',
            print_name: document.querySelector('[data-group="screen-group"].active')?.innerText.trim() || '-',
            part_name: document.querySelector('[data-group="part-group"].active')?.getAttribute('title') || '-',
            part_id: document.getElementById('selected_part_id').value,
            _token: '{{ csrf_token() }}'
        };

        axios.post('{{ route("cart.add") }}', data).then(function (response) {
            if (response.data.status === 'success') {
                window.location.href = '{{ route("cart.index") }}';
            }
        });
    }

    function updateCart() {
        const data = {
            row_id: '{{ $editRowId ?? "" }}',
            product_id: document.getElementById('selected_product_id').value,
            quantity: document.getElementById('quantityInput').value,
            size_name: document.querySelector('[data-group="size-group"].active')?.innerText.trim() || '-',
            print_name: document.querySelector('[data-group="screen-group"].active')?.innerText.trim() || '-',
            part_name: document.querySelector('[data-group="part-group"].active')?.getAttribute('title') || '-',
            part_id: document.getElementById('selected_part_id').value,
            _token: '{{ csrf_token() }}'
        };

        axios.post('{{ route("cart.update") }}', data).then(() => {
            window.location.href = '{{ route("cart.index") }}';
        });
    }

    // --- 5. ระบบขอใบเสนอราคา ---
    function requestQuotation() {
        const qty = document.getElementById('quantityInput').value;
        if(qty < 1) { alert('กรุณาระบุจำนวนอย่างน้อย 1 ชิ้น'); return; }

        const data = {
            product_id: document.getElementById('selected_product_id').value,
            quantity: qty,
            size_name: document.querySelector('[data-group="size-group"].active')?.innerText.trim() || '-',
            print_name: document.querySelector('[data-group="screen-group"].active')?.innerText.trim() || '-',
            part_name: document.querySelector('[data-group="part-group"].active')?.getAttribute('title') || '-',
            part_id: document.getElementById('selected_part_id').value,
            _token: '{{ csrf_token() }}'
        };

        axios.post('{{ route("cart.add") }}', data)
            .then(function (response) {
                if (response.data.status === 'success') {
                    window.location.href = '{{ route("quotation.index") }}?selected_items[]=' + response.data.row_id;
                }
            });
    }
</script>
@endsection