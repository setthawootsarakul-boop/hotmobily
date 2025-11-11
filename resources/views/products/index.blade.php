@extends('layouts.main')

@section('title', 'สินค้าทั้งหมด | Hotmobily')

@section('content')

<link rel="stylesheet" href="{{ asset('css/products.css') }}">

<div class="container-fluid products-page py-4">
    <div class="row">
        
        <aside class="col-lg-3 mb-4">
            
            <nav aria-label="breadcrumb" class="mb-3">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">หน้าหลัก</a></li>
                    <li class="breadcrumb-item active" aria-current="page">สินค้าทั้งหมด</li>
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
                            <a href="{{ route('products.index') }}" class="{{ request()->is('products') && !request('category') ? 'active' : '' }}">สินค้าทั้งหมด</a>
                        </li>

                        <li class="filter-group">
                            <button class="filter-toggle" data-bs-toggle="collapse" data-bs-target="#catCollapse" aria-expanded="true">
                                หมวดหมู่สินค้า
                                <i class="bi bi-chevron-down caret-icon rotated"></i>
                            </button>
                            <div id="catCollapse" class="collapse show">
                                <ul class="list-unstyled ps-2 mt-2">
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
                        </li>

                        <li class="filter-group mt-3"> 
                            <button class="filter-toggle" data-bs-toggle="collapse" data-bs-target="#materialCollapse" aria-expanded="true">
                                วัสดุ
                                <i class="bi bi-chevron-down caret-icon rotated"></i>
                            </button>
                            <div id="materialCollapse" class="collapse show">
                                <ul class="list-unstyled ps-2 mt-2">
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
                        </li>
                    </ul>
                </div>
            </div>
        </aside>

        <section class="col-lg-9">
            
            <nav aria-label="breadcrumb" class="mb-3 invisible">
                <ol class="breadcrumb bg-transparent p-0">
                    <li class="breadcrumb-item"><a href="#">&nbsp;</a></li>
                    <li class="breadcrumb-item active" aria-current="page">&nbsp;</li>
                </ol>
            </nav>

            <div class="d-flex align-items-center mb-3 gap-3">
                <div class="page-banner">
                    <h2>สินค้าทั้งหมด</h2>
                </div>

                <div class="decor-blocks d-none d-md-flex ms-auto">
                    <span class="square"></span>
                    <span class="square"></span>
                    <span class="square"></span>
                </div>
            </div>

            <div class="cards-wrapper p-3 shadow-sm bg-white rounded">
                <div class="row g-4">
                    @forelse($products as $product)
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <div class="product-card">
                                <div class="product-thumb">
                                    @php
                                    $img = $product->images->first();
                                    $src = $img ? $img->image_url : asset('images/no-image.png');
                                    @endphp
                                    <img src="{{ asset($src) }}" alt="{{ $img->alt_text ?? $product->name }}" class="product-image">
                                </div>

                                <div class="product-title">
                                    <a href="{{ route('products.show', $product->id ?? '#') ?? '#' }}">{{ $product->name }}</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="col-12">
                            <p class="text-muted">ไม่พบสินค้า</p>
                        </div>
                    @endforelse
                </div> </div> </section>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggles = document.querySelectorAll('.filter-toggle');
    toggles.forEach(btn => {
        btn.addEventListener('click', () => {
            const caret = btn.querySelector('.caret-icon'); 
            caret.classList.toggle('rotated');
        });
    });

    // ensure caret state matches collapse shown
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