@extends('layouts.main')

@section('title', $pageTitle . ' | Hotmobily') 

@section('content')

<link rel="stylesheet" href="{{ asset('css/products.css') }}"> 

<div class="offcanvas offcanvas-end" tabindex="-1" id="filterOffcanvas" aria-labelledby="filterOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title" id="filterOffcanvasLabel">กรองสินค้า</h5>
        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <div class="sidebar-body">
            <ul class="list-unstyled">
                <li class="sidebar-link">
                    <a href="{{ route('products.index') }}" class="fs-6 fw-bold {{ (!request('category') && !request('material')) ? 'active' : '' }}">
                        สินค้าทั้งหมด
                    </a>
                </li>
                <li class="filter-group">
                    <button class="filter-toggle fs-6 {{ request('category') ? 'active-group' : '' }}" 
                            data-bs-toggle="collapse" data-bs-target="#catCollapseMob">
                        หมวดหมู่สินค้า <i class="bi bi-chevron-down caret-icon rotated"></i>
                    </button>
                    <div id="catCollapseMob" class="collapse show">
                        <div class="collapse-wrapper ps-2 mt-2">
                            <ul class="list-unstyled">
                                @foreach($categories as $cat)
                                    <li class="mb-1">
                                        <a href="{{ route('products.index', ['category' => $cat->id]) }}"
                                           class="{{ request('category') == $cat->id ? 'active' : '' }}">
                                            {{ $cat->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </li>
                <li class="filter-group"> 
                    <button class="filter-toggle fs-6 {{ request('material') ? 'active-group' : '' }}" 
                            data-bs-toggle="collapse" data-bs-target="#materialCollapseMob">
                        วัสดุ <i class="bi bi-chevron-down caret-icon rotated"></i>
                    </button>
                    <div id="materialCollapseMob" class="collapse show">
                        <div class="collapse-wrapper ps-2 mt-2">
                            <ul class="list-unstyled">
                                @php
                                    $materials = \App\Models\Product::select('base_material')->distinct()->pluck('base_material')->filter();
                                @endphp
                                @foreach($materials as $m)
                                    <li class="mb-1">
                                        <a href="{{ route('products.index', array_merge(request()->all(), ['material' => $m])) }}"
                                           class="{{ request('material') == $m ? 'active' : '' }}">
                                            {{ $m }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div>

<div class="container-fluid products-page py-0 py-lg-4"> 
    
    <div class="row align-items-start">
        
        <aside class="col-lg-3 d-none d-lg-block">
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" style="color: #333; text-decoration: none;">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page" style="color: #0d6efd; font-weight: 500;">{{ $pageTitle }}</li>
                </ol>
            </nav>

            <div class="sidebar-card shadow-sm">
                <div class="sidebar-header d-flex align-items-center gap-3">
                    <img src="{{ asset('images/logo.png') }}" alt="logo" class="sidebar-logo">
                    <h5 class="mb-0">กรองสินค้า</h5>
                </div>
                <hr class="sidebar-divider my-3">
                <div class="sidebar-body">
                    <ul class="list-unstyled">
                        <li class="sidebar-link">
                            <a href="{{ route('products.index') }}" 
                               class="fs-6 fw-bold {{ (!request('category') && !request('material')) ? 'active' : '' }}">
                                สินค้าทั้งหมด
                            </a>
                        </li>
                        <li class="filter-group">
                            <button class="filter-toggle fs-6 {{ request('category') ? 'active-group' : '' }}" 
                                    data-bs-toggle="collapse" data-bs-target="#catCollapse">
                                หมวดหมู่สินค้า <i class="bi bi-chevron-down caret-icon rotated"></i>
                            </button>
                            <div id="catCollapse" class="collapse show">
                                <div class="collapse-wrapper ps-2 mt-2">
                                    <ul class="list-unstyled">
                                        @foreach($categories as $cat)
                                            <li class="mb-1">
                                                <a href="{{ route('products.index', ['category' => $cat->id]) }}"
                                                   class="{{ request('category') == $cat->id ? 'active' : '' }}">
                                                    {{ $cat->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                        <li class="filter-group"> 
                            <button class="filter-toggle fs-6 {{ request('material') ? 'active-group' : '' }}" 
                                    data-bs-toggle="collapse" data-bs-target="#materialCollapse">
                                วัสดุ <i class="bi bi-chevron-down caret-icon rotated"></i>
                            </button>
                            <div id="materialCollapse" class="collapse show">
                                <div class="collapse-wrapper ps-2 mt-2">
                                    <ul class="list-unstyled">
                                        @foreach($materials as $m)
                                            <li class="mb-1">
                                                <a href="{{ route('products.index', array_merge(request()->all(), ['material' => $m])) }}"
                                                   class="{{ request('material') == $m ? 'active' : '' }}">
                                                    {{ $m }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <section class="col-lg-9 p-0 p-lg-3">
            
            <div class="d-block d-lg-none mobile-header-section">
                <div class="px-3 py-2 bg-light-mobile">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb m-0" style="font-size: 0.85rem;">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-dark text-decoration-none">หน้าหลัก</a></li>
                            <li class="breadcrumb-item active text-primary" aria-current="page">{{ $pageTitle }}</li>
                        </ol>
                    </nav>
                </div>

                <div class="mobile-page-banner d-flex align-items-center justify-content-center">
                    <h2>{{ $pageTitle }}</h2>
                </div>

                <div class="mobile-filter-bar">
                    <button class="btn w-100 d-flex align-items-center justify-content-center gap-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#filterOffcanvas">
                        <i class="bi bi-sliders"></i> 
                        <span>กรองสินค้า</span>
                    </button>
                </div>
            </div>
            <div class="d-none d-lg-flex align-items-center mb-3 gap-3">
                <div class="page-banner">
                    <h2>{{ $pageTitle }}</h2>
                </div>

                <div class="decor-blocks d-none d-md-flex ms-auto"style="margin-top: 45px;">
                    <span class="square"></span>
                    <span class="square"></span>
                    <span class="square"></span>
                </div>
            </div>
            <div class="cards-wrapper p-3 shadow-sm bg-white rounded mt-0 mt-lg-0">
                <div class="row g-3">
                    @forelse($products as $product)
                        <div class="col-6 col-md-4 col-xl-2-5">
                            <div class="product-card">
                                @php
                                    $img = $product->images->first();
                                    $src = $img ? $img->image_url : 'images/no-image.png'; 
                                @endphp
                                <div class="product-thumb" style="background-image: url('{{ asset($src) }}');"></div>
                                <div class="product-title">
                                    <a href="{{ $product->slug ? route('products.show', $product->slug) : '#' }}">
                                        {{ $product->name }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted text-center py-5">ไม่พบสินค้า</p>
                        </div>
                    @endforelse
                </div> 
            </div> 
        </section>
    </div>
</div>

<script>
// Script สำหรับหมุนลูกศร (Caret) เหมือนเดิม
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.filter-toggle');
    toggles.forEach(btn => {
        btn.addEventListener('click', () => {
            const caret = btn.querySelector('.caret-icon'); 
            if(caret) caret.classList.toggle('rotated');
        });
    });
    const collapses = document.querySelectorAll('.collapse');
    collapses.forEach(coll => {
        coll.addEventListener('shown.bs.collapse', (e) => {
            const btn = document.querySelector('[data-bs-target="#' + e.target.id + '"]');
            if (btn) btn.querySelector('.caret-icon')?.classList.add('rotated');
        });
        coll.addEventListener('hidden.bs.collapse', (e) => {
            const btn = document.querySelector('[data-bs-target="#' + e.target.id + '"]');
            if (btn) btn.querySelector('.caret-icon')?.classList.remove('rotated');
        });
    });
});
</script>

@endsection