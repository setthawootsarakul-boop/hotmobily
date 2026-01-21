@extends('layouts.main')

@section('title', 'ตะกร้าสินค้า')

@section('content')


<div class="container py-5">
    
    <h1 class="cart-title">ตะกร้าสินค้า</h1>

    {{-- 🔥 Alert แจ้งเตือนเมื่อครบ 10 ชิ้น 🔥 --}}
    @if(isset($cartItems) && count($cartItems) >= 10)
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4" role="alert" style="background-color: #fff3cd; color: #856404; border-left: 5px solid #FFA726 !important;">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-warning"></i>
            <div>
                <strong>ตะกร้าสินค้าเต็ม (10/10 รายการ)</strong><br>
                <small>คุณสามารถเพิ่มสินค้าได้สูงสุด 10 รายการ หากต้องการเพิ่มรายการใหม่ กรุณาลบรายการที่ไม่ต้องการออกก่อน</small>
            </div>
        </div>
    @endif

    @if(isset($cartItems) && count($cartItems) > 0)
        
        {{-- Header Row (Desktop) --}}
        <div class="row d-none d-md-flex"> 
            <div class="col-md-4 header-product">สินค้า</div> 
            <div class="col-md-8 header-detail">รายละเอียด</div>
        </div>
        <hr class="d-none d-md-block text-secondary opacity-25">
        
        {{-- Form ส่งข้อมูลไปหน้าทำใบเสนอราคา --}}
        <form id="quotationForm" action="{{ route('quotation.index') }}" method="GET">
            <div class="cart-list">
                @foreach($cartItems as $index => $item)
                    @php
                        // 1. ดึงข้อมูลสินค้าจาก Database
                        $pId = is_object($item) ? $item->product_id : $item['product_id'];
                        $product = $products[$pId] ?? null;
                        
                        // 2. หารูปภาพ
                        $imgSrc = ($product && $product->images && $product->images->first()) 
                                    ? asset($product->images->first()->image_url) 
                                    : asset('images/no-image.png');
                        
                        $productName = $product ? $product->name : 'สินค้า (ไม่พบข้อมูล)';
                        $productSlug = $product ? $product->slug : '#'; 
                        
                        // 3. ดึง Options
                        $opt = is_object($item) ? ($item->options ?? []) : ($item['options'] ?? []);
                        
                        $sizeName = $opt['size_name'] ?? '-'; 
                        $printName = $opt['print_name'] ?? '-';
                        $partName = $opt['part_name'] ?? '-';
                        $partColor = $opt['part_color'] ?? '-';

                        // 🔥 4. Logic การแสดงผลรายละเอียด
                        $displayParts = [];
                        $displayParts[] = $productName;

                        if ($sizeName !== '-' && $sizeName !== '' && $sizeName !== null) {
                            $displayParts[] = $sizeName;
                        }

                        if ($printName !== '-' && $printName !== '' && $printName !== null) {
                            $displayParts[] = $printName;
                        }

                        if ($partName !== '-' && $partName !== '' && $partName !== null) {
                            if ($partColor !== '-' && $partColor !== '' && $partColor !== null) {
                                $displayParts[] = "{$partName} ({$partColor})";
                            } else {
                                $displayParts[] = $partName;
                            }
                        }

                        $qty = is_object($item) ? $item->quantity : $item['quantity'];
                        $displayParts[] = "จำนวน " . number_format($qty) . " ชิ้น";

                        $detailString = implode(' > ', $displayParts);

                        $itemId = is_object($item) ? $item->id : $item['row_id'];
                    @endphp

                    <div class="row cart-item-row align-items-start" id="row-{{ $itemId }}">
                        
                        <div class="col-md-4 col-img-wrapper mb-3 mb-md-0">
                            <div class="custom-checkbox cart-checkbox" onclick="toggleCheck(this)">
                                <i class="bi bi-check-lg"></i>
                                <input type="checkbox" name="selected_items[]" value="{{ $itemId }}" class="d-none">
                            </div>

                            <div class="product-img-frame">
                                <img src="{{ $imgSrc }}" alt="{{ $productName }}" class="product-thumb">
                            </div>
                        </div>

                        <div class="col-md-8 col-detail-wrapper">
                            <div class="product-name-header">{{ $productName }}</div>
                            
                            <div class="d-flex align-items-center flex-wrap flex-md-nowrap justify-content-between w-100">
                                <div class="detail-box">
                                    {{ $detailString }}
                                </div>
                                
                                <div class="action-group ms-md-3 mt-2 mt-md-0">
                                    {{-- 🔥 ล็อคด้วย "ชื่อ" ตามฐานข้อมูลของคุณ 🔥 --}}
                                    <a href="{{ route('products.show', $productSlug) }}?mode=edit&row_id={{ $itemId }}&qty={{ $qty }}&size_name={{ urlencode($sizeName) }}&print_name={{ urlencode($printName) }}&part_name={{ urlencode($partName) }}&part_color={{ urlencode($partColor) }}" class="btn-edit text-decoration-none me-2">
                                        <i class="bi bi-pencil-square me-1"></i> แก้ไข
                                    </a>
                                    
                                    <a href="javascript:void(0)" class="btn-delete text-decoration-none text-danger" onclick="removeItem('{{ $itemId }}')">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="d-md-none text-secondary opacity-10 my-3">
                @endforeach
            </div>
        </form>

        <div class="cart-footer">
            <div class="total-items-text">
                สินค้าในตะกร้า (<span id="total-count">{{ count($cartItems) }}</span>/10 รายการ)
            </div>
            
            <button class="btn btn-request-quote" onclick="submitQuotation()">
                ขอใบเสนอราคา (<span id="selected-count">0</span>)
            </button>
        </div>

    @else
        <div class="empty-cart-container text-center py-5">
            <img src="{{ asset('images/Hotmobilyfile/poster/cart1.png') }}" alt="Empty Cart" class="empty-cart-icon mb-4" style="max-width: 360px;">
            <h3 class="empty-cart-text text-muted mb-4">ยังไม่มีสินค้าในตะกร้าของคุณ</h3>
            <a href="{{ route('products.index') }}" class="btn btn-shop-now btn-primary px-4 py-2" style="background-color: #FFA726; border: none;">
                เลือกซื้อสินค้า
            </a>
        </div>
    @endif

</div>

<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function toggleCheck(element) {
        element.classList.toggle('checked');
        const checkbox = element.querySelector('input[type="checkbox"]');
        if (checkbox) { checkbox.checked = !checkbox.checked; }
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const count = document.querySelectorAll('.custom-checkbox.checked').length;
        document.getElementById('selected-count').innerText = count;
    }

    function submitQuotation() {
        const selectedCount = document.querySelectorAll('.custom-checkbox.checked').length;
        if (selectedCount === 0) {
            Swal.fire({ icon: 'warning', title: 'กรุณาเลือกสินค้า', text: 'โปรดเลือกสินค้าอย่างน้อย 1 รายการเพื่อขอใบเสนอราคา', confirmButtonColor: '#FFA726' });
            return;
        }
        document.getElementById('quotationForm').submit();
    }

    function removeItem(rowId) {
        Swal.fire({
            title: 'ยืนยันการลบ?',
            text: "คุณต้องการลบสินค้านี้ออกจากตะกร้าใช่ไหม",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'ลบ',
            cancelButtonText: 'ยกเลิก'
        }).then((result) => {
            if (result.isConfirmed) {
                axios.post('{{ route("cart.remove") }}', { row_id: rowId, _token: '{{ csrf_token() }}' })
                .then(response => { location.reload(); })
                .catch(error => { Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถลบสินค้าได้', 'error'); });
            }
        });
    }
</script>
@endsection