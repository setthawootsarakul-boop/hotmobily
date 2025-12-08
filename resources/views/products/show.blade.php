@extends('layouts.main')

@section('title', $product->name . ' | Hotmobily')

@section('content')

{{-- CSS & Style --}}
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<link rel="stylesheet" href="{{ asset('css/product-detail.css') }}">

<style>
    .estimation-table th, .estimation-table td {
        vertical-align: middle;
        border-color: #ddd !important; 
    }
    .btn-estimate-action {
        background-color: #b00020;
        color: white;
        border-radius: 8px;
        transition: 0.3s;
        border: none;
    }
    .btn-estimate-action:hover {
        background-color: #8a0019;
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
            
            {{-- ================= SECTION 1: ข้อมูลสินค้า (แบ่งซ้าย-ขวา) ================= --}}
            <div class="row g-5">
                
                {{-- LEFT COLUMN: Gallery --}}
                <div class="col-lg-5">
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
                    <h1 class="product-title mb-4">{{ $product->name }}</h1>

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
                                        {{-- สแตนดี้: ปุ่มขึ้นก่อน --}}
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
                                            <div class="text-dark mt-1" style="line-height: 1.6; font-size: 0.95rem;">
                                                {{ $firstSize->note }}
                                            </div>
                                        @endif
                                    @else
                                        {{-- ทั่วไป: Note ขึ้นก่อน --}}
                                        @if($hasNote)
                                            <span class="text-dark" style="line-height: 1.6; display: inline-block; margin-bottom: 5px;"> 
                                                {{ $firstSize->note }}
                                            </span>
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
                            <tr>
                                <td class="label">ความหนา :</td>
                                <td class="value">{{ $product->thickness_option }}</td>
                            </tr>
                            @endif

                            @if($product->backside_printing_text)
                            <tr>
                                <td class="label">การพิมพ์ด้านหลัง :</td>
                                <td class="value">{{ $product->backside_printing_text }}</td>
                            </tr>
                            @endif

                            @if($product->paper_option_text)
                            <tr>
                                <td class="label">กระดาษรอง :</td>
                                <td class="value">{!! nl2br(e($product->paper_option_text)) !!}</td>
                            </tr>
                            @endif

                            @if($product->free_sample_text)
                            <tr>
                                <td class="label" style="color: #000;">ตัวอย่างสินค้า :</td>
                                <td class="value" style="color: #333;">
                                    <i class=""></i> {{ $product->free_sample_text }}
                                </td>
                            </tr>
                            @endif

                            <tr><td class="label">สั่งขั้นต่ำ :</td><td class="value">{{ $product->moq }}</td></tr>
                            <tr><td class="label">การบรรจุ :</td><td class="value">{{ $product->packing }}</td></tr>
                            
                            @if($product->special_features)
                            <tr><td class="label">คุณสมบัติพิเศษ :</td><td class="value">{!! nl2br(e($product->special_features)) !!}</td></tr>
                            @endif
                            
                            <tr><td class="label">ระยะเวลาผลิต :</td><td class="value">{{ $product->production_time }}</td></tr>
                            
                            @if($product->printings->isNotEmpty())
                                
                                {{-- 1. จำนวนสี (แยกออกมาเช็คต่างหาก) --}}
                                @if(!empty($product->printings->first()->color_type))
                                <tr>
                                    <td class="label">จำนวนสี :</td>
                                    <td class="value">{{ $product->printings->first()->color_type }}</td>
                                </tr>
                                @endif

                                {{-- 2. ปุ่มเลือกการสกรีน (กรองเฉพาะที่มีชื่อ) --}}
                                @php
                                    $validPrintings = $product->printings->filter(function($p) {
                                        return !empty(trim($p->printing_type)); 
                                    });
                                @endphp

                                @if($validPrintings->isNotEmpty())
                                <tr>
                                    <td class="label">
                                        การสกรีน 
                                        @if($product->id == 12)
                                            <i class="bi bi-info-circle-fill text-danger" data-bs-toggle="modal" data-bs-target="#screenInfoModal"></i>
                                        @endif
                                        :
                                    </td>
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

                    {{-- [INPUT SECTION] --}}
                    <input type="hidden" id="selected_product_id" value="{{ $product->id }}">
                    <input type="hidden" id="selected_size_id" value="{{ $product->sizes->first()->id ?? '' }}">
                    <input type="hidden" id="selected_printing_id" value="{{ $product->printings->first()->id ?? '' }}">
                    <input type="hidden" id="selected_part_id" value="{{ $product->parts->where('is_default', 1)->first()->id ?? '' }}">

                    <div class="mt-4 d-flex justify-content-end align-items-center">
                        <label for="quantityInput" class="form-label fw-bold me-3 mb-0" style="font-size: 1.1rem;">จำนวน :</label>
                        <input type="number" class="form-control text-center fw-bold me-3" id="quantityInput" value="1" min="1" style="width: 120px; height: 45px; border-radius: 8px;">
                        <button class="btn btn-estimate-action fw-bold px-4" onclick="calculatePrice()" style="height: 45px; font-size: 1rem; min-width: 140px;">
                            ประเมินราคา
                        </button>
                    </div>

                </div> {{-- End col-lg-7 --}}
            </div> {{-- End row g-5 --}}


            {{-- ================= SECTION 2: Result & Actions ================= --}}
            <div id="estimationResult" class="mt-5 pt-4 border-top" style="display: none;">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold text-center mb-3">ข้อมูล</h5>
                        <table class="table table-bordered estimation-table">
                            <tr><td class="bg-light fw-bold" width="40%">สินค้า</td><td>{{ $product->name }}</td></tr>
                            <tr><td class="bg-light fw-bold">ขนาด</td><td id="res_size">-</td></tr>
                            <tr><td class="bg-light fw-bold">การสกรีน</td><td id="res_print">-</td></tr>
                            <tr>
                            <tr id="row_part_result">
                                <td class="bg-light fw-bold align-middle">ส่วนประกอบเพิ่มเติม</td>
                                
                                {{-- ✅ เติม id="part_result_cell" ตรงนี้ --}}
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
                        <div class="text-danger small mt-2 text-center">
                            *** ราคานี้เป็นการคำนวณคร่าวๆ เพื่ออ้างอิง หากต้องการราคาที่แน่นอน <br>
                            กรุณากรอกฟอร์ม/คลิกปุ่มขอใบเสนอราคา เพื่อรับใบเสนอราคาอย่างเป็นทางการ ***
                        </div>
                    </div>
                </div>
            </div>

            <div class="action-area-bottom mt-5">
                <div class="row justify-content-center g-3">
                    <div class="col-md-6 col-lg-4">
                        <button class="btn btn-quote w-100 py-2 fw-bold">ขอใบเสนอราคา</button>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <button class="btn btn-add-to-cart w-100 py-2 fw-bold">เพิ่มใส่ตะกร้า</button>
                    </div>
                </div>
            </div>

            @if($product->id == 19)
                <div class="rubber-features-section mt-5 pt-4">
                    

                {{-- ✅ ส่วนที่ 1: หัวข้อและคำบรรยาย (วางไว้ก่อน rubber-feature-container) --}}
            <div class="text-center mb-5">
                    
                    {{-- 🖼️ รูปภาพ Banner: ปรับให้เต็มความกว้างและสูง 372px --}}
                    <img src="{{ asset('images/Hotmobilyfile/poster/keychain.jpg') }}" 
                        alt="พวงกุญแจยาง" 
                        class="mb-4" {{-- เปลี่ยน mb-3 เป็น mb-4 เพื่อเพิ่มระยะห่างจากหัวข้ออีกนิด --}}
                        style="width: 100%; height: 372px; object-fit: cover; display: block;">

                    <h3 class="fw-bold mb-3" style="color: #333;">พวงกุญแจยาง</h3>
                    <p class="text-muted mx-auto" style="max-width: 700px; line-height: 1.6; font-size: 16px;">
                        พวงกุญแจยางทำจาก ATBC-PVC คุณภาพดี น้ำหนักเบา ทนทาน ป้องกันรอยขีดข่วน 
                        พร้อมสีสันและดีไซน์หลากหลาย เหมาะทั้งพกพาและตกแต่งให้โดดเด่น
                    </p>
                </div>

                <div class="rubber-feature-container">
                    
                    {{-- 🔸 ฝั่งซ้าย --}}
                    <div class="feature-column text-column left-text">
                        <div class="feature-item" style="top: 10%;">
                            <h5 class="fw-bold">ส่วนประกอบชิ้นงานที่หลากหลาย</h5>
                            <p>เรามีส่วนประกอบชิ้นงานให้คุณเลือกมากถึง 20 แบบ</p>
                            
                            {{-- ✏️ เส้นที่ 1: ปรับความยาวและตำแหน่งตรงนี้ --}}
                            <div class="connector-line" style="width: 232px;right: -105px;"></div>
                        </div>

                        <div class="feature-item" style="top: 45%;">
                            <h5 class="fw-bold">กลิ่นยางและกลิ่นสีน้อยกว่า</h5>
                            <p>เราพยายามอย่างต่อเนื่องในการหาวัสดุที่ลดกลิ่นยางและสี</p>
                            
                            {{-- ✏️ เส้นที่ 2 --}}
                            <div class="connector-line" style="width: 300px;right: -140px;"></div>
                        </div>

                        <div class="feature-item" style="top: 80%;">
                            <h5 class="fw-bold">ลงสีได้มากกว่า 18 สี</h5>
                            <p>เลือกสีได้มากถึง 12 สี (มาตรฐาน) และ 18 สี (พรีเมียม)</p>
                            
                            {{-- ✏️ เส้นที่ 3 --}}
                            <div class="connector-line" style="width: 370px;right: -152px;"></div>
                        </div>
                    </div>

                    {{-- 🔸 ตรงกลาง: รูปภาพ (เหมือนเดิม) --}}
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

                    {{-- 🔸 ฝั่งขวา --}}
                    <div class="feature-column text-column right-text">
                        <div class="feature-item" style="top: 35%;">
                            
                            {{-- ✏️ เส้นที่ 4 (ฝั่งขวาใช้ left ติดลบ) --}}
                            <div class="connector-line" style="width: 143px;left: -140px;"></div>
                            
                            <h5 class="fw-bold">การสกรีนที่มีคุณภาพ</h5>
                            <p>สกรีนด้านหลังแบบ UV สวยงามและโอกาสลอกน้อยกว่าปกติ</p>
                        </div>

                        <div class="feature-item" style="top: 65%;">
                            
                            {{-- ✏️ เส้นที่ 5 --}}
                            <div class="connector-line" style="width: 150px;left: -147px;"></div>
                            
                            <h5 class="fw-bold">เลือกสีสกรีนได้ตามต้องการ</h5>
                            <p>การสกรีนด้านหลัง สามารถเลือกสีสกรีนได้ จะสีเดียวหรือหลายสี</p>
                        </div>
                    </div>

                </div>
            </div>
            @endif

        </div> {{-- End bg-white (ปิดตรงนี้) --}}
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
        document.getElementById('selected_part_id').value = partId;
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
                // ✅ เพิ่ม 2 บรรทัดนี้: เพื่อ Reset ค่ากลับมาแสดงผลปกติ (ตรงกลาง)
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
                // ✅ กรณีไม่มีของ: สั่งชิดซ้าย
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
            alert('เกิดข้อผิดพลาดในการคำนวณราคา หรือ ข้อมูลไม่ครบถ้วน');
        });
    }
</script>

@endsection