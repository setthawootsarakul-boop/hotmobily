

<?php $__env->startSection('title', 'ตะกร้าสินค้า'); ?>

<?php $__env->startSection('content'); ?>


<link rel="stylesheet" href="<?php echo e(asset('css/cart.css')); ?>">

<div class="container py-5">
    
    <h1 class="cart-title">ตะกร้าสินค้า</h1>

    
    <?php if(isset($cartItems) && count($cartItems) >= 10): ?>
        <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4" role="alert" style="background-color: #fff3cd; color: #856404; border-left: 5px solid #FFA726 !important;">
            <i class="bi bi-exclamation-triangle-fill fs-4 me-3 text-warning"></i>
            <div>
                <strong>ตะกร้าสินค้าเต็ม (10/10 รายการ)</strong><br>
                <small>คุณสามารถเพิ่มสินค้าได้สูงสุด 10 รายการ หากต้องการเพิ่มรายการใหม่ กรุณาลบรายการที่ไม่ต้องการออกก่อน</small>
            </div>
        </div>
    <?php endif; ?>

    <?php if(isset($cartItems) && count($cartItems) > 0): ?>
        
        
        <div class="row d-none d-md-flex"> 
            <div class="col-md-4 header-product">สินค้า</div> 
            <div class="col-md-8 header-detail">รายละเอียด</div>
        </div>
        <hr class="d-none d-md-block text-secondary opacity-25">
        
        
        <form id="quotationForm" action="<?php echo e(route('quotation.index')); ?>" method="GET">
            <div class="cart-list">
                <?php $__currentLoopData = $cartItems; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        // 1. ดึงข้อมูลสินค้าจาก Database (รองรับทั้ง Object และ Array)
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
                        $partColor = $opt['part_color'] ?? '-'; // ✅ รับค่าสี

                        // 🔥 4. Logic การแสดงผล: เก็บลง Array แล้วเชื่อมด้วย " > " 🔥
                        $displayParts = [];
                        
                        // 4.1 ชื่อสินค้า
                        $displayParts[] = $productName;

                        // 4.2 ขนาด (ถ้ามี)
                        if ($sizeName !== '-' && $sizeName !== '' && $sizeName !== null) {
                            $displayParts[] = $sizeName;
                        }

                        // 4.3 การพิมพ์ (ถ้ามี)
                        if ($printName !== '-' && $printName !== '' && $printName !== null) {
                            $displayParts[] = $printName;
                        }

                        // 4.4 ส่วนประกอบ (ชื่อ + สี)
                        if ($partName !== '-' && $partName !== '' && $partName !== null) {
                            if ($partColor !== '-' && $partColor !== '' && $partColor !== null) {
                                // ถ้ามีสี ให้แสดง "ชื่อ (สี)"
                                $displayParts[] = "{$partName} ({$partColor})";
                            } else {
                                // ถ้าไม่มีสี แสดงแค่ชื่อ
                                $displayParts[] = $partName;
                            }
                        }

                        // 4.5 จำนวน
                        $qty = is_object($item) ? $item->quantity : $item['quantity'];
                        $displayParts[] = "จำนวน " . number_format($qty) . " ชิ้น";

                        // เชื่อมทุกอย่างด้วยเครื่องหมาย " > "
                        $detailString = implode(' > ', $displayParts);

                        // ดึง ID ของรายการ (cart_items.id)
                        $itemId = is_object($item) ? $item->id : $item['row_id'];
                    ?>

                    <div class="row cart-item-row align-items-start" id="row-<?php echo e($itemId); ?>">
                        
                        
                        <div class="col-md-4 col-img-wrapper mb-3 mb-md-0">
                            
                            <div class="custom-checkbox cart-checkbox" onclick="toggleCheck(this)">
                                <i class="bi bi-check-lg"></i>
                                <input type="checkbox" name="selected_items[]" value="<?php echo e($itemId); ?>" class="d-none">
                            </div>

                            
                            <div class="product-img-frame">
                                <img src="<?php echo e($imgSrc); ?>" alt="<?php echo e($productName); ?>" class="product-thumb">
                            </div>
                        </div>

                        
                        <div class="col-md-8 col-detail-wrapper">
                            <div class="product-name-header"><?php echo e($productName); ?></div>
                            
                            <div class="d-flex align-items-center flex-wrap flex-md-nowrap justify-content-between w-100">
                                
                                <div class="detail-box">
                                    <?php echo e($detailString); ?>

                                </div>
                                
                                
                                <div class="action-group ms-md-3 mt-2 mt-md-0">
                                    <a href="<?php echo e(route('products.show', $productSlug)); ?>?mode=edit&row_id=<?php echo e($itemId); ?>&qty=<?php echo e($qty); ?>" class="btn-edit text-decoration-none me-2">
                                        <i class="bi bi-pencil-square me-1"></i> แก้ไข
                                    </a>
                                    
                                    <a href="javascript:void(0)" class="btn-delete text-decoration-none text-danger" onclick="removeItem('<?php echo e($itemId); ?>')">
                                        <i class="bi bi-trash3"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="d-md-none text-secondary opacity-10 my-3">
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </form>

        
        <div class="cart-footer">
            <div class="total-items-text">
                สินค้าในตะกร้า (<span id="total-count"><?php echo e(count($cartItems)); ?></span>/10 รายการ)
            </div>
            
            <button class="btn btn-request-quote" onclick="submitQuotation()">
                ขอใบเสนอราคา (<span id="selected-count">0</span>)
            </button>
        </div>

    <?php else: ?>
        
        <div class="empty-cart-container text-center py-5">
            <img src="<?php echo e(asset('images/Hotmobilyfile/poster/cart1.png')); ?>" alt="Empty Cart" class="empty-cart-icon mb-4" style="max-width: 350px;">
            <h3 class="empty-cart-text text-muted mb-4">ยังไม่มีสินค้าในตะกร้าของคุณ</h3>
            <a href="<?php echo e(route('products.index')); ?>" class="btn btn-shop-now btn-primary px-4 py-2" style="background-color: #FFA726; border: none;">
                เลือกซื้อสินค้า
            </a>
        </div>
    <?php endif; ?>

</div>


<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function toggleCheck(element) {
        element.classList.toggle('checked');
        const checkbox = element.querySelector('input[type="checkbox"]');
        if (checkbox) {
            checkbox.checked = !checkbox.checked;
        }
        updateSelectedCount();
    }

    function updateSelectedCount() {
        const count = document.querySelectorAll('.custom-checkbox.checked').length;
        document.getElementById('selected-count').innerText = count;
    }

    function submitQuotation() {
        const selectedCount = document.querySelectorAll('.custom-checkbox.checked').length;
        
        if (selectedCount === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'กรุณาเลือกสินค้า',
                text: 'โปรดเลือกสินค้าอย่างน้อย 1 รายการเพื่อขอใบเสนอราคา',
                confirmButtonColor: '#FFA726'
            });
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
                axios.post('<?php echo e(route("cart.remove")); ?>', {
                    row_id: rowId,
                    _token: '<?php echo e(csrf_token()); ?>'
                })
                .then(response => {
                    location.reload(); 
                })
                .catch(error => {
                    console.error(error);
                    Swal.fire('เกิดข้อผิดพลาด', 'ไม่สามารถลบสินค้าได้', 'error');
                });
            }
        });
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/cart.blade.php ENDPATH**/ ?>