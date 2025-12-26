@extends('layouts.main')

@section('title', $product->name . ' | Hotmobily')

@section('content')

{{-- 1. รับค่าโหมดแก้ไขจาก Query String --}}
@php
    $isEditMode = request('mode') == 'edit';
    $editRowId = request('row_id');
    $editQty = request('qty', 1);
@endphp

{{-- CSS & Style --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">

<style>
    .estimation-table th, .estimation-table td {
        vertical-align: middle;
        border-color: #ddd !important; 
    }
    
    /* ปุ่มประเมินราคา (สีแดง) */
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
    
    /* ปุ่มอัปเดต (สีเหลือง) เมื่ออยู่ในโหมดแก้ไข */
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
    
    /* ปุ่มขอใบเสนอราคา (สีส้ม) */
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
            
            {{-- ================= SECTION 1: ข้อมูลสินค้า ================= --}}
            <div class="row g-5">
                
                {{-- LEFT COLUMN: Gallery --}}
                <div class="col-lg-5">
                    
                    {{-- ชื่อสินค้า Mobile --}}
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

                    <div class="mt-4 text-center">
                        <button class="btn btn-file-guide fw-bold py-2 px-5 rounded-3 shadow-sm">
                            <i class="bi bi-file-earmark-text me-2"></i> รูปแบบไฟล์งาน
                        </button>
                    </div>
                </div>

                {{-- RIGHT COLUMN: Info & Options --}}
                <div class="col-lg-7">
                    
                    {{-- ชื่อสินค้า Desktop --}}
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
                                <td class="label">ขนาด :</td>
                                <td class="value">
                                    @php
                                        $firstSize = $product->sizes->first();
                                        $hasNote = !empty($firstSize->note);
                                        $countSizes = $product->sizes->count();
                                        $shouldHideButtons = ($countSizes === 1 && $hasNote);
                                        $isStandee = ($product->id == 13);
                                    @endphp

                                    @if($isStandee)
                                        {{-- สแตนดี้ --}}
                                        @if(!$shouldHideButtons)
                                            <div class="d-inline-flex gap-2 flex-wrap" id="size-group" style="vertical-align: top;">
                                                @foreach($product->sizes as $key => $size)
                                                    <button class="btn btn-spec {{ $key == 0 ? 'active' : '' }} mb-1" 
                                                            data-group="size-group" 
                                                            onclick="selectSize(this, {{ $size->id }})">
                                                        {{ $size->size_name }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
                                        @if($hasNote)
                                            <div class="text-dark mt-1" style="line-height: 1.6; font-size: 0.95rem;">{{ $firstSize->note }}</div>
                                        @endif
                                    @else
                                        {{-- ทั่วไป --}}
                                        @if($hasNote)
                                            <span class="text-dark" style="line-height: 1.6; display: inline-block; margin-bottom: 5px;">{{ $firstSize->note }}</span>
                                            @if(!$shouldHideButtons) <br> @endif
                                        @endif
                                        @if(!$shouldHideButtons)
                                            <div class="d-inline-flex gap-2 flex-wrap" id="size-group">
                                                @foreach($product->sizes as $key => $size)
                                                    <button class="btn btn-spec {{ $key == 0 ? 'active' : '' }} mb-1" 
                                                            data-group="size-group" 
                                                            onclick="selectSize(this, {{ $size->id }})">
                                                        {{ $size->size_name }}
                                                    </button>
                                                @endforeach
                                            </div>
                                        @endif
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
                            
                            @if($product->printings->isNotEmpty())
                                @if(!empty($product->printings->first()->color_type))
                                <tr><td class="label">จำนวนสี :</td><td class="value">{{ $product->printings->first()->color_type }}</td></tr>
                                @endif

                                @php
                                    $validPrintings = $product->printings->filter(function($p) { return !empty(trim($p->printing_type)); });
                                @endphp

                                @if($validPrintings->isNotEmpty())
                                <tr>
                                    <td class="label">การสกรีน @if($product->id == 12) <i class="bi bi-info-circle-fill text-danger" data-bs-toggle="modal" data-bs-target="#screenInfoModal"></i> @endif :</td>
                                    <td class="value">
                                        <span id="printing-note">{{ $validPrintings->first()->note ?? '-' }}</span>
                                        <div class="d-flex gap-3 mt-2 flex-wrap" id="screen-group">
                                            @foreach($validPrintings as $key => $printing)
                                                <button class="btn btn-spec {{ $loop->first ? 'active' : '' }} mb-1" 
                                                        data-group="screen-group" 
                                                        data-table-id="price-table-{{ $printing->id }}" 
                                                        data-note="{{ $printing->note ?? '-' }}" 
                                                        data-printing-id="{{ $printing->id }}" 
                                                        onclick="selectScreen(this)">
                                                    {{ $printing->printing_type }}
                                                </button>
                                            @endforeach
                                        </div>
                                    </td>
                                </tr>
                                @endif
                            @endif
                        </tbody>
                    </table>
                    
                    {{-- Price Tables --}}
                    @if($product->prices->isNotEmpty())
                    <div class="price-table-wrapper mt-4">
                        @foreach($product->printings as $key => $printing)
                        <div id="price-table-{{ $printing->id }}" class="price-table table-responsive" style="{{ $key == 0 ? '' : 'display: none;' }}">
                            <table class="table table-bordered text-center align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="background-color: #f8f9fa;">จำนวน</th>
                                        @forelse($product->sizes as $size)
                                            <th class="size-header" style="white-space: nowrap;">
                                                <span style="color: #666; font-weight: normal;">ขนาดไม่เกิน</span> {{ $size->size_name }}
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
                                            @php $price = $product->prices->where('product_printing_id', $printing->id)->where('product_size_id', $size->id)->where('quantity_min', $qty)->first(); @endphp
                                            <td class="size-col">{{ ($price && $price->price_per_unit > 0) ? number_format($price->price_per_unit) : '-' }}</td>
                                        @empty
                                            @php $price = $product->prices->where('quantity_min', $qty)->first(); @endphp
                                            <td class="size-col">{{ ($price && $price->price_per_unit > 0) ? number_format($price->price_per_unit) : '-' }}</td>
                                        @endforelse
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        @endforeach
                    </div>
                    <div class="price-notes mt-4 text-secondary" style="font-size: 11px; line-height: 1.6;">
                        <p class="mb-1">1) ราคานี้เป็นราคาผลิตต่อหน่วย ไม่ใช่ราคารวมสินค้า</p>
                        <p class="mb-1">2) ราคานี้รวมค่าบรรจุใส่ถุง และฟรีค่าจัดส่งเมื่อสั่งซื้อตั้งแต่ 1,000 บาทขึ้นไป</p>
                        <p class="mb-0">3) หากสั่งซื้อเป็นจำนวนมากกว่าในตารางราคาจะได้ราคาพิเศษ</p>
                    </div>
                    @endif
                    
                    {{-- Parts --}}
                    @if($product->parts->isNotEmpty())
                    <div class="mt-5">
                        <h3 class="mb-4">ส่วนประกอบเพิ่มเติม</h3>
                        <div class="row g-3 parts-grid">
                            @foreach($product->parts as $part)
                                <div class="col-lg-3 col-md-3 col-4">
                                    <div class="part-box p-1 text-center {{ $part->is_default ? 'active' : '' }}"
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
                    <input type="hidden" id="selected_product_id" value="{{ $product->id }}">
                    <input type="hidden" id="selected_size_id" value="{{ $product->sizes->first()->id ?? '' }}">
                    <input type="hidden" id="selected_printing_id" value="{{ $product->printings->first()->id ?? '' }}">
                    {{-- Default part_id --}}
                    <input type="hidden" id="selected_part_id" value="{{ $product->parts->where('is_default', 1)->first()->id ?? '' }}">

                    <div class="mt-4 d-flex justify-content-end align-items-center">
                        <label for="quantityInput" class="form-label fw-bold me-3 mb-0" style="font-size: 1.1rem;">จำนวน :</label>
                        {{-- ถ้าเป็นโหมดแก้ไข ให้ใส่ค่าจำนวนเดิม --}}
                        <input type="number" class="form-control text-center fw-bold me-3" id="quantityInput" value="{{ $isEditMode ? $editQty : 1 }}" min="1" style="width: 120px; height: 45px; border-radius: 8px;">
                        
                        {{-- ✅ 1. ปุ่มประเมินราคา --}}
                        <button class="btn btn-estimate-action fw-bold px-4 me-2" onclick="calculatePrice()" style="height: 45px; font-size: 1rem; min-width: 140px;">
                            ประเมินราคา
                        </button>
                    </div>

                </div> {{-- End col-lg-7 --}}
            </div> {{-- End row g-5 --}}


            {{-- ================= SECTION 2: Result & Actions ================= --}}
            <div id="estimationResult" class="mt-5 pt-4 border-top" style="display: none;">
                {{-- (ส่วนแสดงผลราคา) --}}
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

            {{-- ✅ ปุ่ม Action ด้านล่าง --}}
            <div class="action-area-bottom mt-5">
                <div class="row justify-content-center g-3">
                    <div class="col-md-6 col-lg-4">
                        <button class="btn btn-quote w-100 py-2 fw-bold" onclick="requestQuotation()">
                            ขอใบเสนอราคา
                        </button>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        {{-- ✅ ปุ่มเพิ่ม/อัปเดต ด้านล่าง --}}
                        <button class="btn {{ $isEditMode ? 'btn-update-action' : 'btn-estimate-action' }} w-100 py-2 fw-bold" 
                                onclick="{{ $isEditMode ? 'updateCart()' : 'addToCart()' }}">
                            {{ $isEditMode ? 'อัปเดตตะกร้า' : 'เพิ่มใส่ตะกร้า' }}
                        </button>
                    </div>
                </div>
            </div>

            {{-- Dynamic Sections (Product 19, 12, ...) --}}
            @if($product->id == 19)
                <div class="rubber-features-section mt-5 pt-4">
                    {{-- Banner --}}
                    <div class="text-center mb-5">
                        <img src="{{ asset('images/Hotmobilyfile/poster/keychain.jpg') }}" 
                             alt="พวงกุญแจยาง" class="mb-4" style="width: 100vw; height: 372px; object-fit: cover; display: block; margin-left: -50vw; left: 50%; position: relative; right: 50%; margin-right: -50vw;">
                        <h3 class="fw-bold" style="color: #333; margin-top: 60px; font-size: 32px;">พวงกุญแจยาง</h3>
                        <p class="mx-auto" style="max-width: 700px; line-height: 1.6; font-size: 20px; margin-top: 40px;">พวงกุญแจยางทำจาก ATBC-PVC คุณภาพดี น้ำหนักเบา ทนทาน ป้องกันรอยขีดข่วน พร้อมสีสันและดีไซน์หลากหลาย เหมาะทั้งพกพาและตกแต่งให้โดดเด่น</p>
                    </div>
                    
                    {{-- Feature Grid --}}
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

                    {{-- Thickness Section --}}
                    <div class="rubber-thickness-container">
                        <div class="thickness-img-wrapper left-img">
                            <img src="{{ asset('images/Hotmobilyfile/product/Rubber(3)/base_3mm.webp') }}" alt="Base 3mm" class="thickness-img">
                        </div>
                        <div class="thickness-content text-center px-4">
                            <h4 class="fw-bold mb-3">ความหนาของฐาน</h4>
                            <p class="text-muted mb-0">
                                คุณสามารถเลือกได้ระหว่างรุ่นมาตรฐาน 3 มม. และรุ่น 5 มม. ที่หนาและหนักกว่าได้
                            </p>
                        </div>
                        <div class="thickness-img-wrapper right-img">
                            <img src="{{ asset('images/Hotmobilyfile/product/Rubber(3)/base_5mm.webp') }}" alt="Base 5mm" class="thickness-img">
                        </div>
                    </div>

                    {{-- Special Material --}}
                    <div class="special-material-section mt-5">
                        <div class="rubber-section-header text-center mb-5">
                            <h2 class="rubber-section-title">วัสดุพิเศษ</h2>
                        </div>
                        <div class="material-grid-container">
                            <div class="material-item">
                                <div class="material-images">
                                    <img src="{{ asset('images/Hotmobilyfile/Material/image49.png') }}" alt="ชิ้นงานเรืองแสง 1">
                                    <img src="{{ asset('images/Hotmobilyfile/Material/image51.png') }}" alt="ชิ้นงานเรืองแสง 2">
                                </div>
                                <div class="material-name">ชิ้นงานเรืองแสง</div>
                            </div>
                            <div class="material-item">
                                <div class="material-images">
                                    <img src="{{ asset('images/Hotmobilyfile/Material/image53.png') }}" alt="ฟลูออเรสเซนต์ 1">
                                    <img src="{{ asset('images/Hotmobilyfile/Material/image54.png') }}" alt="ฟลูออเรสเซนต์ 2">
                                </div>
                                <div class="material-name">ฟลูออเรสเซนต์</div>
                            </div>
                            <div class="material-item">
                                <div class="material-images">
                                    <img src="{{ asset('images/Hotmobilyfile/Material/image55.png') }}" alt="กลิตเตอร์ 1">
                                    <img src="{{ asset('images/Hotmobilyfile/Material/image56.png') }}" alt="กลิตเตอร์ 2">
                                </div>
                                <div class="material-name">กลิตเตอร์</div>
                            </div>
                            <div class="material-item">
                                <div class="material-images">
                                    <img src="{{ asset('images/Hotmobilyfile/Material/image57.png') }}" alt="Golden Silver 1">
                                    <img src="{{ asset('images/Hotmobilyfile/Material/image58.png') }}" 
                                         alt="Golden Silver 2" 
                                         style="width: 30% !important; max-width: 120px; height: auto;">
                                </div>
                                <div class="material-name">Golden Silver</div>
                            </div>
                        </div>
                    </div>
                </div>
            @elseif($product->id == 12)
                <div class="acrylic-stand-section mt-5 pt-4">
                    <div class="acrylic-poster-wrapper mb-5">
                        <img src="{{ asset('images/Hotmobilyfile/poster/Rectangle118.png') }}" alt="แท่นวางโทรศัพท์" class="acrylic-poster-img">
                    </div>
                    <div class="acrylic-content text-center">
                        <h3 class="fw-bold acrylic-title">แท่นวางโทรศัพท์</h3>
                        <p class="mx-auto text-muted acrylic-desc">แท่นวางโทรศัพท์น้ำหนักเบา แข็งแรง ใช้งานสะดวก ปรับมุมมองได้ เหมาะสำหรับดูวิดีโอ ประชุมออนไลน์ หรือใช้งานมือถือโดยไม่ต้องถือให้เมื่อย</p>
                    </div>
                    <div class="acrylic-usage-wrapper d-flex justify-content-center">
                         <img src="{{ asset('images/Hotmobilyfile/poster/Group190.png') }}" alt="ตัวอย่าง" class="img-fluid acrylic-usage-img">
                    </div>
                </div>
            @endif
                {{-- ================= SECTION 3: ตัวอย่างผลงาน ================= --}}
                @if(isset($productGalleries) && $productGalleries->isNotEmpty())
                <div class="product-gallery-section mt-5">
                    <div class="container">
                        <h2 class="product-gallery-title">ตัวอย่างผลงาน</h2>

                        <div class="product-example-grid">
                            @foreach($productGalleries as $gallery)
                                <div class="example-item">
                                    {{-- ดึงรูปจากโฟลเดอร์ images/gallery ตามที่คุณกำหนด --}}
                                    <img src="{{ asset('images/gallery/' . $gallery->image_path) }}" 
                                        alt="{{ $gallery->title ?? 'ตัวอย่างผลงาน' }}">
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                @endif
        </div> {{-- End bg-white --}}
    </div>
</div>

{{-- Modal --}}
<div class="modal fade" id="screenInfoModal" tabindex="-1" aria-labelledby="screenInfoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content" style="border-radius: 16px;">
      <div class="modal-header border-0 pb-0">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body pt-0 pb-4 px-4">
        <h4 class="fw-bold mb-4 text-center" id="screenInfoModalLabel">การสกรีน</h4>
        <div class="mb-3">
            <h6 class="fw-bold" style="color: #FFC107; font-size: 1.1rem;">สกรีน UV ฟูลคัลเลอร์ + เคลือบหมึกขาว คือ</h6>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">การสกรีนแบบอิงค์เจ็ทยูวีฟูลคัลเลอร์ + ทาทับด้วยหมึกสีขาว</p>
        </div>
        <div>
            <h6 class="fw-bold" style="color: #0d6efd; font-size: 1.1rem;">สกรีน UV ด้านเดียว + เคลือบหมึกขาว คือ</h6>
            <p class="text-muted mb-0" style="font-size: 0.95rem;">การสกรีนยูวี + ทาทับด้วยหมึกสีขาว</p>
        </div>
      </div>
    </div>
  </div>
</div>

{{-- Scripts --}}
<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
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

    function selectSize(element, sizeId) { 
        document.querySelectorAll('[data-group="size-group"]').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        document.getElementById('selected_size_id').value = sizeId;
    }

    function selectScreen(element) { 
        document.querySelectorAll('[data-group="screen-group"]').forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        const printingId = element.getAttribute('data-printing-id');
        document.getElementById('selected_printing_id').value = printingId;
        const tableIdToShow = element.dataset.tableId;
        document.querySelectorAll('.price-table').forEach(el => el.style.display = 'none');
        const tableToShow = document.getElementById(tableIdToShow);
        if(tableToShow) tableToShow.style.display = 'block';
        const noteText = element.getAttribute('data-note');
        const noteElement = document.getElementById('printing-note');
        if(noteElement) noteElement.innerText = noteText;
    }
    
    function selectSpec(element, groupName) { 
        document.querySelectorAll(`[data-group="${groupName}"]`).forEach(el => el.classList.remove('active'));
        element.classList.add('active');
        const partId = element.getAttribute('data-part-id');
        document.getElementById('selected_part_id').value = partId; // ✅ ส่ง ID เพื่อให้ Controller หา color ได้
    }

    function calculatePrice() { 
        const productId = document.getElementById('selected_product_id').value;
        const sizeId = document.getElementById('selected_size_id').value;
        const printingId = document.getElementById('selected_printing_id').value;
        const partId = document.getElementById('selected_part_id').value;
        const qty = document.getElementById('quantityInput').value;

        if(qty < 1) { alert('กรุณาระบุจำนวนอย่างน้อย 1 ชิ้น'); return; }

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
        })
        .catch(function (error) {
            console.error(error);
            alert('เกิดข้อผิดพลาดในการคำนวณราคา');
        });
    }

    // ✅ ฟังก์ชันเพิ่มลงตะกร้า (โหมดปกติ)
    function addToCart() {
        const qty = document.getElementById('quantityInput').value;
        const productId = document.getElementById('selected_product_id').value;
        if(qty < 1) { alert('กรุณาระบุจำนวนอย่างน้อย 1 ชิ้น'); return; }

        const activeSizeBtn = document.querySelector('[data-group="size-group"].active');
        const sizeName = activeSizeBtn ? activeSizeBtn.innerText.trim() : '-';
        const activePrintBtn = document.querySelector('[data-group="screen-group"].active');
        const printName = activePrintBtn ? activePrintBtn.innerText.trim() : '-';
        const activePartDiv = document.querySelector('[data-group="part-group"].active');
        const partName = activePartDiv ? activePartDiv.getAttribute('title') : '-';
        
        // ✅ รับ part_id ที่เลือกไว้
        const partId = document.getElementById('selected_part_id').value;

        const data = {
            product_id: productId,
            quantity: qty,
            size_name: sizeName,
            print_name: printName,
            part_name: partName,
            part_id: partId, // 🔥 ส่ง part_id ไปด้วย เพื่อให้ Controller หา color ได้
            details_text: "" 
        };

        axios.post('{{ route("cart.add") }}', { ...data, _token: '{{ csrf_token() }}' })
        .then(function (response) {
            // 🔥 ตรวจสอบสถานะ response
            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'สำเร็จ',
                    text: response.data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = '{{ route("cart.index") }}';
                });
            } else if (response.data.status === 'error') {
                // 🔥 แจ้งเตือนเมื่อตะกร้าเต็ม (หรือ Error อื่นๆ ที่ส่งมาแบบนี้)
                Swal.fire({
                    icon: 'warning',
                    title: 'ไม่สามารถเพิ่มได้',
                    text: response.data.message, 
                    confirmButtonColor: '#FFA726'
                });
            }
        })
        .catch(function (error) {
            console.error(error);
            Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้' });
        });
    }

    // ✅ ฟังก์ชันอัปเดตตะกร้า (โหมดแก้ไข)
    function updateCart() {
        const qty = document.getElementById('quantityInput').value;
        const productId = document.getElementById('selected_product_id').value;
        const rowId = '{{ $editRowId ?? "" }}'; 

        if(qty < 1) { alert('กรุณาระบุจำนวนอย่างน้อย 1 ชิ้น'); return; }

        const activeSizeBtn = document.querySelector('[data-group="size-group"].active');
        const sizeName = activeSizeBtn ? activeSizeBtn.innerText.trim() : '-';
        const activePrintBtn = document.querySelector('[data-group="screen-group"].active');
        const printName = activePrintBtn ? activePrintBtn.innerText.trim() : '-';
        const activePartDiv = document.querySelector('[data-group="part-group"].active');
        const partName = activePartDiv ? activePartDiv.getAttribute('title') : '-';
        const partId = document.getElementById('selected_part_id').value;

        const data = {
            row_id: rowId,
            product_id: productId,
            quantity: qty,
            size_name: sizeName,
            print_name: printName,
            part_name: partName,
            part_id: partId,
            details_text: "" 
        };

        axios.post('{{ route("cart.update") }}', { ...data, _token: '{{ csrf_token() }}' })
        .then(function (response) {
            Swal.fire({
                icon: 'success',
                title: 'อัปเดตตะกร้าเรียบร้อย',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                window.location.href = '{{ route("cart.index") }}';
            });
        })
        .catch(function (error) {
            console.error(error);
            Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถอัปเดตสินค้าได้' });
        });
    }

    // ✅ ฟังก์ชันสำหรับปุ่ม "ขอใบเสนอราคา" (ซื้อเลย)
    function requestQuotation() {
        const qty = document.getElementById('quantityInput').value;
        const productId = document.getElementById('selected_product_id').value;

        if(qty < 1) { alert('กรุณาระบุจำนวนอย่างน้อย 1 ชิ้น'); return; }

        const activeSizeBtn = document.querySelector('[data-group="size-group"].active');
        const sizeName = activeSizeBtn ? activeSizeBtn.innerText.trim() : '-';
        
        const activePrintBtn = document.querySelector('[data-group="screen-group"].active');
        const printName = activePrintBtn ? activePrintBtn.innerText.trim() : '-';
        
        const activePartDiv = document.querySelector('[data-group="part-group"].active');
        const partName = activePartDiv ? activePartDiv.getAttribute('title') : '-';
        const partId = document.getElementById('selected_part_id').value;

        const data = {
            product_id: productId,
            quantity: qty,
            size_name: sizeName,
            print_name: printName,
            part_name: partName,
            part_id: partId,
            details_text: "" 
        };

        axios.post('{{ route("cart.add") }}', { ...data, _token: '{{ csrf_token() }}' })
            .then(function (response) {
                if (response.data.status === 'success') {
                    // ✅ รับ row_id ที่เพิ่งสร้างมาจาก Controller
                    const newRowId = response.data.row_id; 

                    // 3. Redirect ไปหน้า quotation.index พร้อมส่ง row_id ไปด้วย
                    window.location.href = '{{ route("quotation.index") }}?selected_items[]=' + newRowId;
                } else if (response.data.status === 'error') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'ไม่สามารถทำรายการได้',
                        text: response.data.message,
                        confirmButtonColor: '#FFA726'
                    });
                }
            })
            .catch(function (error) {
                console.error(error);
                Swal.fire({ icon: 'error', title: 'เกิดข้อผิดพลาด', text: 'ไม่สามารถดำเนินการได้' });
            });
    }
</script>

@endsection