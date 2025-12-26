@extends('layouts.main')

{{-- 1. เพิ่ม CSS สำหรับ Lightbox2 --}}
@push('styles')
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/css/lightbox.min.css" rel="stylesheet">
<style>
    .gallery-grid a {
        text-decoration: none;
        display: block;
        cursor: zoom-in;
    }
    .gallery-item {
        transition: transform 0.3s ease;
    }
    .gallery-item:hover {
        transform: scale(1.02);
    }
    /* ปรับแต่งตำแหน่งคำอธิบายใต้รูปใน Lightbox */
    .lb-caption {
        font-family: 'Prompt', sans-serif;
        font-size: 16px;
        font-weight: 400;
    }
</style>
@endpush

@section('content')
<div class="gallery-outer-wrapper">
    <div class="page-container">
        
        <h2 class="gallery-main-title">ผลงานผลิตและออกแบบ</h2>

        {{-- Dropdown ด้านบน --}}
        <div class="filter-section-top">
            <div class="custom-gallery-dropdown" id="galleryDropdown">
                <div class="dropdown-trigger">
                    <span>
                        @if(request('product'))
                            {{ $products_list->firstWhere('id', request('product'))->name }}
                        @else
                            สินค้าทั้งหมด
                        @endif
                    </span>
                    <i class="fas fa-chevron-down"></i>
                </div>
                <ul class="dropdown-menu-list">
                    <li class="{{ !request('product') ? 'active' : '' }}">
                        <a href="{{ route('gallery.index') }}">สินค้าทั้งหมด</a>
                        @if(!request('product')) <span class="check-icon">✓</span> @endif
                    </li>
                    @foreach($products_list as $prod)
                        <li class="{{ request('product') == $prod->id ? 'active' : '' }}">
                            <a href="{{ route('gallery.index', ['product' => $prod->id]) }}">{{ $prod->name }}</a>
                            @if(request('product') == $prod->id) <span class="check-icon">✓</span> @endif
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="gallery-content-box">
            <div class="gallery-grid">
                @foreach($galleries as $item)
                    {{-- 2. เปลี่ยนมาใช้ data-lightbox สำหรับระบบ Lightbox2 --}}
                    <a href="{{ asset('images/gallery/' . $item->image_path) }}" 
                       data-lightbox="product-gallery" 
                       data-title="{{ $item->title ?? 'ผลงานจาก Hotmobily' }}">
                        <div class="gallery-item">
                            <img src="{{ asset('images/gallery/' . $item->image_path) }}" alt="{{ $item->title }}">
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="gallery-pagination-wrapper mt-5">
                {{ $galleries->links('pagination::bootstrap-4') }}
            </div>
        </div>

        {{-- ปุ่มหมวดหมู่แบ่ง 3 บรรทัด --}}
        <div class="gallery-category-nav">
            <div class="nav-row">
                <a href="{{ route('gallery.index') }}" class="cat-btn {{ !request('product') ? 'active' : '' }}">แสดงทั้งหมด</a>
                @foreach($products_list->whereIn('id', [3, 19, 20, 21]) as $prod)
                    <a href="{{ route('gallery.index', ['product' => $prod->id]) }}" class="cat-btn {{ request('product') == $prod->id ? 'active' : '' }}">{{ $prod->name }}</a>
                @endforeach
            </div>
            <div class="nav-row">
                @foreach($products_list->whereIn('id', [15, 11, 13, 12, 4]) as $prod)
                    <a href="{{ route('gallery.index', ['product' => $prod->id]) }}" class="cat-btn {{ request('product') == $prod->id ? 'active' : '' }}">{{ $prod->name }}</a>
                @endforeach
            </div>
            <div class="nav-row">
                @foreach($products_list->whereIn('id', [5, 6, 7, 8]) as $prod)
                    <a href="{{ route('gallery.index', ['product' => $prod->id]) }}" class="cat-btn {{ request('product') == $prod->id ? 'active' : '' }}">{{ $prod->name }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
{{-- 3. โหลด JS ของ Lightbox2 (อาศัย jQuery จากหน้าแม่) --}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.4/js/lightbox.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // JS สำหรับเปิด-ปิด Dropdown เดิมของคุณ
        const dropdown = document.getElementById('galleryDropdown');
        if (dropdown) {
            dropdown.addEventListener('click', function(e) {
                this.classList.toggle('active');
                e.stopPropagation();
            });
            document.addEventListener('click', () => dropdown.classList.remove('active'));
        }

        // ตั้งค่า Option สำหรับ Lightbox2
        lightbox.option({
          'resizeDuration': 200,
          'wrapAround': true,
          'albumLabel': "ภาพที่ %1 จาก %2",
          'alwaysShowNavOnTouchDevices': true,
          'fadeDuration': 300,
          'imageFadeDuration': 300
        });
    });
</script>
@endpush