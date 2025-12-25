@extends('layouts.main')

@section('content')
<div class="gallery-outer-wrapper">
    <div class="page-container">
        
        <h2 class="gallery-main-title">ผลงานผลิตและออกแบบ</h2>

        {{-- Dropdown ด้านบนนอกกล่อง --}}
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
                    <div class="gallery-item">
                        <img src="{{ asset('images/gallery/' . $item->image_path) }}" alt="{{ $item->title }}">
                    </div>
                @endforeach
            </div>
            <div class="gallery-pagination">
                {{ $galleries->appends(request()->query())->links() }}
            </div>
        </div>

        {{-- ปุ่มหมวดหมู่แบ่ง 3 บรรทัด (ตามโครงสร้างใหม่ของคุณ) --}}
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

<script>
// JS สำหรับเปิด-ปิด Dropdown
document.addEventListener('DOMContentLoaded', function() {
    const dropdown = document.getElementById('galleryDropdown');
    dropdown.addEventListener('click', function(e) {
        this.classList.toggle('active');
        e.stopPropagation();
    });
    document.addEventListener('click', () => dropdown.classList.remove('active'));
});
</script>
@endsection