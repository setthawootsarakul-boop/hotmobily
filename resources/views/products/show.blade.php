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
                    <h1 class="product-title fw-bold mb-4">{{ $product->name }}</h1>

                    {{-- Info Table --}}
                    <table class="table product-info-table">
                        <tbody>
                            <tr>
                                <td class="label">วัสดุ :</td>
                                <td class="value">@if($product->materials->isNotEmpty()) {{ $product->materials->first()->material_name }} (หนา {{ $product->materials->first()->thickness }}) @else - @endif</td>
                            </tr>
                            
                            @if($product->sizes->isNotEmpty())
                            <tr>
                                <td class="label">ขนาด :</td>
                                <td class="value">
                                    @if($product->sizes->first()->note)
                                        <div class="text-dark" style="line-height: 1.6;">
                                            {{ $product->sizes->first()->note }}
                                        </div>
                                        <div class="d-none">
                                             @foreach($product->sizes as $key => $size)
                                                <button class="btn btn-spec {{ $key == 0 ? 'active' : '' }}" data-group="size-group" onclick="selectSize(this, {{ $size->id }})">{{ $size->size_name }}</button>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="d-flex gap-2 flex-wrap" id="size-group">
                                            @foreach($product->sizes as $key => $size)
                                                <button class="btn btn-spec {{ $key == 0 ? 'active' : '' }} mb-1" data-group="size-group" onclick="selectSize(this, {{ $size->id }})">{{ $size->size_name }}</button>
                                            @endforeach
                                        </div>
                                    @endif
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
                                @if($product->printings->first()->color_type)
                                <tr><td class="label">จำนวนสี :</td><td class="value">{{ $product->printings->first()->color_type }}</td></tr>
                                @endif
                                
                                <tr>
                                    <td class="label">
                                        การสกรีน 
                                        @if($product->id == 12)
                                            <i class="bi bi-info-circle-fill text-danger" data-bs-toggle="modal" data-bs-target="#screenInfoModal"></i>
                                        @endif
                                        :
                                    </td>
                                    <td class="value">
                                        <span id="printing-note">{{ $product->printings->first()->note ?? '-' }}</span>
                                        <div class="d-flex gap-3 mt-2 flex-wrap" id="screen-group">
                                            @foreach($product->printings as $key => $printing)
                                                <button class="btn btn-spec {{ $key == 0 ? 'active' : '' }} mb-1" 
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

                            @if($product->free_sample_text)
                            <tr>
                                <td class="label" style="color: #000;">ตัวอย่างสินค้า :</td>
                                <td class="value" style="color: #333;">
                                    <i class=""></i> {{ $product->free_sample_text }}
                                </td>
                            </tr>
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
                                            <td class="size-col">{{ $price ? number_format($price->price_per_unit) : '-' }}</td>
                                        @empty
                                            @php $price = $product->prices->where('quantity_min', $qty)->first(); @endphp
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
                                         data-part-id="{{ $part->id }}" 
                                         title="{{ $part->part_name }}">
                                    @if($part->image_url)
                                        <div class="part-img-box mb-0"><img src="{{ asset($part->image_url) }}" alt="{{ $part->part_name }}"></div>
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
                                <td class="bg-light fw-bold align-middle">ส่วนประกอบเพิ่มเติม</td>
                                <td class="text-center">
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
                document.getElementById('res_part_name').innerText = data.part_info.name;
                if(data.part_info.image) {
                    document.getElementById('res_part_img').src = data.part_info.image;
                    document.getElementById('res_part_img_div').style.display = 'block';
                } else {
                    document.getElementById('res_part_img_div').style.display = 'none';
                }
            } else {
                document.getElementById('res_part_name').innerText = '-';
                document.getElementById('res_part_img_div').style.display = 'none';
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