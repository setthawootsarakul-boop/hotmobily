

<?php $__env->startSection('title', $product->name . ' | Hotmobily'); ?>

<?php $__env->startSection('content'); ?>


<?php
    $isEditMode = request('mode') == 'edit';
    $editRowId = request('row_id');
    $editQty = request('qty', 1);

    // 🔥 ส่วนที่เพิ่ม: เช็คราคาจากฐานข้อมูล (ต้องมีแถวราคา และราคาต้อง > 0)
    $hasPrices = $product->prices->where('price_per_unit', '>', 0)->isNotEmpty();

    if(in_array($product->id, [6, 15])) {
        $hasPrices = false;
    }
?>


<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/glightbox/dist/css/glightbox.min.css" />
<link rel="stylesheet" href="<?php echo e(asset('css/product-detail.css')); ?>">

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
        
        
        <nav aria-label="breadcrumb" class="mb-4 product-breadcrumb">
            <ol class="breadcrumb bg-transparent p-0 mb-0">
                <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">หน้าหลัก</a></li>
                <li class="breadcrumb-item"><a href="<?php echo e(route('products.index')); ?>">สินค้าทั้งหมด</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?php echo e($product->name); ?></li>
            </ol>
        </nav>

        <div class="bg-white rounded-4 shadow-sm p-4 p-lg-5">
            
            
            <div class="row g-5">
                
                
                <div class="col-lg-5">
                    
                    
                    <h1 class="product-title d-lg-none mb-3 text-start">
                        <?php echo e($product->name); ?>

                    </h1>

                    <?php
                        $galleryImages = $product->images->where('is_main', 0); 
                        $firstImage = $galleryImages->first(); 
                        $initialSrc = $firstImage ? asset($firstImage->image_url) : asset('images/no-image.png');
                    ?>

                    <div class="gallery-container">
                        <div class="thumbnails">
                            <?php $__currentLoopData = $galleryImages->values(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="thumb-item <?php echo e($index == 0 ? 'active' : ''); ?>" 
                                     onclick="changeMainImage(this, '<?php echo e(asset($image->image_url)); ?>', <?php echo e($index); ?>)">
                                    <img src="<?php echo e(asset($image->image_url)); ?>" alt="<?php echo e($image->alt_text); ?>">
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>

                        <div class="main-image-wrapper rounded-3" onclick="openLightbox()">
                            <img id="mainProductImage" src="<?php echo e($initialSrc); ?>" alt="<?php echo e($product->name); ?>" class="img-fluid" style="cursor: zoom-in;">
                            <div class="zoom-icon"></div>
                        </div>
                    </div>

                    <div class="mt-4 text-center">
                        <button class="btn btn-file-guide fw-bold py-2 px-5 rounded-3 shadow-sm">
                            <i class="bi bi-file-earmark-text me-2"></i> รูปแบบไฟล์งาน
                        </button>
                    </div>
                </div>

                
                <div class="col-lg-7">
                    
                    
                    <h1 class="product-title d-none d-lg-block"><?php echo e($product->name); ?></h1>

                    <table class="table product-info-table">
                        <tbody>
                            <tr>
                                <td class="label">วัสดุ :</td>
                                <td class="value">
                                    <?php if($product->materials->isNotEmpty()): ?> 
                                        <?php echo e($product->materials->first()->material_name); ?> 
                                        <?php if(!empty($product->materials->first()->thickness) && $product->materials->first()->thickness != '-'): ?>
                                            (หนา <?php echo e($product->materials->first()->thickness); ?>) 
                                        <?php endif; ?>
                                    <?php else: ?> 
                                        - 
                                    <?php endif; ?>
                                </td>
                            </tr>
                            
                            <?php if($product->sizes->isNotEmpty()): ?>
                            <tr>
                                <td class="label">ขนาด :</td>
                                <td class="value">
                                    <?php
                                        $firstSize = $product->sizes->first();
                                        $hasNote = !empty($firstSize->note);
                                        $countSizes = $product->sizes->count();
                                        $shouldHideButtons = ($countSizes === 1 && $hasNote);
                                        $isStandee = ($product->id == 13);
                                    ?>

                                    <?php if($isStandee): ?>
                                        
                                        <?php if($hasPrices && !$shouldHideButtons): ?> 
                                            <div class="d-inline-flex gap-2 flex-wrap" id="size-group" style="vertical-align: top;">
                                                <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <button class="btn btn-spec <?php echo e($key == 0 ? 'active' : ''); ?> mb-1" 
                                                            data-group="size-group" 
                                                            onclick="selectSize(this, <?php echo e($size->id); ?>)">
                                                        <?php echo e($size->size_name); ?>

                                                    </button>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                        <?php if($hasNote): ?>
                                            <div class="text-dark mt-1" style="line-height: 1.6; font-size: 0.95rem;"><?php echo e($firstSize->note); ?></div>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        
                                        <?php if($hasNote): ?>
                                            <span class="text-dark" style="line-height: 1.6; display: inline-block; margin-bottom: 5px;"><?php echo e($firstSize->note); ?></span>
                                            <?php if($hasPrices && !$shouldHideButtons): ?> <br> <?php endif; ?>
                                        <?php endif; ?>
                                        <?php if($hasPrices && !$shouldHideButtons): ?> 
                                            <div class="d-inline-flex gap-2 flex-wrap" id="size-group">
                                                <?php $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <button class="btn btn-spec <?php echo e($key == 0 ? 'active' : ''); ?> mb-1" 
                                                            data-group="size-group" 
                                                            onclick="selectSize(this, <?php echo e($size->id); ?>)">
                                                        <?php echo e($size->size_name); ?>

                                                    </button>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </div>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endif; ?>
                            
                            <?php if($product->thickness_option): ?>
                            <tr><td class="label">ความหนา :</td><td class="value"><?php echo e($product->thickness_option); ?></td></tr>
                            <?php endif; ?>

                            <?php if($product->backside_printing_text): ?>
                            <tr><td class="label">การพิมพ์ด้านหลัง :</td><td class="value"><?php echo e($product->backside_printing_text); ?></td></tr>
                            <?php endif; ?>

                            <?php if($product->paper_option_text): ?>
                            <tr><td class="label">กระดาษรอง :</td><td class="value"><?php echo nl2br(e($product->paper_option_text)); ?></td></tr>
                            <?php endif; ?>

                            <?php if($product->free_sample_text): ?>
                            <tr><td class="label" style="color: #000;">ตัวอย่างสินค้า :</td><td class="value" style="color: #333;"><?php echo e($product->free_sample_text); ?></td></tr>
                            <?php endif; ?>

                            <tr><td class="label">สั่งขั้นต่ำ :</td><td class="value"><?php echo e($product->moq); ?></td></tr>
                            <tr><td class="label">การบรรจุ :</td><td class="value"><?php echo e($product->packing); ?></td></tr>
                            
                            <?php if($product->special_features): ?>
                            <tr><td class="label">คุณสมบัติพิเศษ :</td><td class="value"><?php echo nl2br(e($product->special_features)); ?></td></tr>
                            <?php endif; ?>
                            
                            <tr><td class="label">ระยะเวลาผลิต :</td><td class="value"><?php echo e($product->production_time); ?></td></tr>
                            
                            <?php if($product->printings->isNotEmpty()): ?>
                                <?php if(!empty($product->printings->first()->color_type)): ?>
                                <tr><td class="label">จำนวนสี :</td><td class="value"><?php echo e($product->printings->first()->color_type); ?></td></tr>
                                <?php endif; ?>

                                <?php
                                    $validPrintings = $product->printings->filter(function($p) { return !empty(trim($p->printing_type)); });
                                ?>

                                <?php if($validPrintings->isNotEmpty()): ?>
                                <tr>
                                    <td class="label">การสกรีน <?php if($product->id == 12): ?> <i class="bi bi-info-circle-fill text-danger" data-bs-toggle="modal" data-bs-target="#screenInfoModal"></i> <?php endif; ?> :</td>
                                    <td class="value">
                                        <span id="printing-note"><?php echo e($validPrintings->first()->note ?? '-'); ?></span>
                                        <?php if($hasPrices): ?> 
                                        <div class="d-flex gap-3 mt-2 flex-wrap" id="screen-group">
                                            <?php $__currentLoopData = $validPrintings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $printing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <button class="btn btn-spec <?php echo e($loop->first ? 'active' : ''); ?> mb-1" 
                                                        data-group="screen-group" 
                                                        data-table-id="price-table-<?php echo e($printing->id); ?>" 
                                                        data-note="<?php echo e($printing->note ?? '-'); ?>" 
                                                        data-printing-id="<?php echo e($printing->id); ?>" 
                                                        onclick="selectScreen(this)">
                                                    <?php echo e($printing->printing_type); ?>

                                                </button>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    
                    
                    <?php if($hasPrices && $product->prices->isNotEmpty()): ?> 
                    <div class="price-table-wrapper mt-4">
                        <?php $__currentLoopData = $product->printings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $printing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div id="price-table-<?php echo e($printing->id); ?>" class="price-table table-responsive" style="<?php echo e($key == 0 ? '' : 'display: none;'); ?>">
                            <table class="table table-bordered text-center align-middle mb-0">
                                <thead>
                                    <tr>
                                        <th style="background-color: #f8f9fa;">จำนวน</th>
                                        <?php $__empty_1 = true; $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <th class="size-header" style="white-space: nowrap;">
                                                <span style="color: #666; font-weight: normal;">ขนาดไม่เกิน</span> <?php echo e($size->size_name); ?>

                                            </th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <th>ราคา / ชิ้น</th>
                                        <?php endif; ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $quantities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $qty): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr class="price-row">
                                        <td class="fw-bold bg-light"><?php echo e(number_format($qty)); ?></td>
                                        <?php $__empty_1 = true; $__currentLoopData = $product->sizes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $size): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                            <?php $price = $product->prices->where('product_printing_id', $printing->id)->where('product_size_id', $size->id)->where('quantity_min', $qty)->first(); ?>
                                            <td class="size-col"><?php echo e(($price && $price->price_per_unit > 0) ? number_format($price->price_per_unit) : '-'); ?></td>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                            <?php $price = $product->prices->where('quantity_min', $qty)->first(); ?>
                                            <td class="size-col"><?php echo e(($price && $price->price_per_unit > 0) ? number_format($price->price_per_unit) : '-'); ?></td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                    <div class="price-notes mt-4 text-secondary" style="font-size: 11px; line-height: 1.6;">
                        <p class="mb-1">1) ราคานี้เป็นราคาผลิตต่อหน่วย ไม่ใช่ราคารวมสินค้า</p>
                        <p class="mb-1">2) ราคานี้รวมค่าบรรจุใส่ถุง และฟรีค่าจัดส่งเมื่อสั่งซื้อตั้งแต่ 1,000 บาทขึ้นไป</p>
                        <p class="mb-0">3) หากสั่งซื้อเป็นจำนวนมากกว่าในตารางราคาจะได้ราคาพิเศษ</p>
                    </div>
                    <?php endif; ?>
                    
                    
                    <?php if($hasPrices && $product->parts->isNotEmpty()): ?> 
                    <div class="mt-5">
                        <h3 class="mb-4">ส่วนประกอบเพิ่มเติม</h3>
                        <div class="row g-3 parts-grid">
                            <?php $__currentLoopData = $product->parts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $part): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-lg-3 col-md-3 col-4">
                                    <div class="part-box p-1 text-center <?php echo e($part->is_default ? 'active' : ''); ?>"
                                         data-group="part-group" 
                                         onclick="selectSpec(this, 'part-group')" 
                                         data-part-id="<?php echo e($part->id); ?>" 
                                         title="<?php echo e($part->part_name); ?>">
                                    <?php if($part->image_url): ?>
                                        <div class="part-img-box mb-0"><img src="<?php echo e(asset('/images/jp-attachments/attachments/' . $part->image_url)); ?>" alt="<?php echo e($part->part_name); ?>"></div>
                                    <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                    <?php endif; ?>

                    
                    <?php if($hasPrices): ?> 
                    <input type="hidden" id="selected_product_id" value="<?php echo e($product->id); ?>">
                    <input type="hidden" id="selected_size_id" value="<?php echo e($product->sizes->first()->id ?? ''); ?>">
                    <input type="hidden" id="selected_printing_id" value="<?php echo e($product->printings->first()->id ?? ''); ?>">
                    <input type="hidden" id="selected_part_id" value="<?php echo e($product->parts->where('is_default', 1)->first()->id ?? ''); ?>">

                    <div class="mt-4 d-flex justify-content-end align-items-center">
                        <label for="quantityInput" class="form-label fw-bold me-3 mb-0" style="font-size: 1.1rem;">จำนวน :</label>
                        <input type="number" class="form-control text-center fw-bold me-3" id="quantityInput" value="<?php echo e($isEditMode ? $editQty : 1); ?>" min="1" style="width: 120px; height: 45px; border-radius: 8px;">
                        
                        <button class="btn btn-estimate-action fw-bold px-4 me-2" onclick="calculatePrice()" style="height: 45px; font-size: 1rem; min-width: 140px;">
                            ประเมินราคา
                        </button>
                    </div>

                    
                    <div class="action-area-bottom mt-5">
                        <div class="row justify-content-center g-3">
                            <div class="col-md-6 col-lg-4">
                                <button class="btn btn-quote w-100 py-2 fw-bold" onclick="requestQuotation()">
                                    ขอใบเสนอราคา
                                </button>
                            </div>
                            <div class="col-md-6 col-lg-4">
                                <button class="btn <?php echo e($isEditMode ? 'btn-update-action' : 'btn-estimate-action'); ?> w-100 py-2 fw-bold" 
                                        onclick="<?php echo e($isEditMode ? 'updateCart()' : 'addToCart()'); ?>">
                                    <?php echo e($isEditMode ? 'อัปเดตตะกร้า' : 'เพิ่มใส่ตะกร้า'); ?>

                                </button>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                        
                        <div class="alert alert-secondary mt-5 text-center py-4 rounded-4" style="background-color: #f8f9fa; border: 1px dashed #ccc;">
                            <p class="mb-0 text-muted">สินค้านี้ยังไม่เปิดระบบคำนวณราคาอัตโนมัติ กรุณาติดต่อสอบถามเจ้าหน้าที่เพื่อรับใบเสนอราคา</p>
                            <div class="mt-3">
                                <a href="https://line.me/R/ti/p/@842kcbjl" target="_blank" class="btn btn-success btn-sm rounded-pill px-4">
                                    <i class="bi bi-line me-1"></i> ติดต่อเจ้าหน้าที่ผ่าน LINE
                                </a>
                            </div>
                        </div>
                    <?php endif; ?>

                </div> 
            </div> 


            
            <div id="estimationResult" class="mt-5 pt-4 border-top" style="display: none;">
                <div class="row g-4">
                    <div class="col-md-6">
                        <h5 class="fw-bold text-center mb-3">ข้อมูล</h5>
                        <table class="table table-bordered estimation-table">
                            <tr><td class="bg-light fw-bold" width="40%">สินค้า</td><td><?php echo e($product->name); ?></td></tr>
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

            
            <?php if($product->id == 19): ?>
                <div class="rubber-features-section mt-5 pt-4">
                    
                    <div class="text-center mb-5">
                        <img src="<?php echo e(asset('images/Hotmobilyfile/poster/keychain.jpg')); ?>" 
                             alt="พวงกุญแจยาง" class="mb-4" style="width: 100vw; height: 372px; object-fit: cover; display: block; margin-left: -50vw; left: 50%; position: relative; right: 50%; margin-right: -50vw;">
                        <h3 class="fw-bold" style="color: #333; margin-top: 60px; font-size: 32px;">พวงกุญแจยาง</h3>
                        <p class="mx-auto" style="max-width: 700px; line-height: 1.6; font-size: 20px; margin-top: 40px;">พวงกุญแจยางทำจาก ATBC-PVC คุณภาพดี น้ำหนักเบา ทนทาน ป้องกันรอยขีดข่วน พร้อมสีสันและดีไซน์หลากหลาย เหมาะทั้งพกพาและตกแต่งให้โดดเด่น</p>
                    </div>
                    
                </div>
            <?php elseif($product->id == 12): ?>
                <div class="acrylic-stand-section mt-5 pt-4">
                    <div class="acrylic-poster-wrapper mb-5 text-center">
                        <img src="<?php echo e(asset('images/Hotmobilyfile/poster/Rectangle118.png')); ?>" alt="แท่นวางโทรศัพท์" class="img-fluid rounded-4">
                    </div>
                </div>
            <?php endif; ?>

            
            <?php if(isset($productGalleries) && $productGalleries->isNotEmpty()): ?>
            <div class="product-gallery-section mt-5">
                <h2 class="product-gallery-title text-center mb-4">ตัวอย่างผลงาน</h2>
                <div class="product-example-grid">
                    <?php $__currentLoopData = $productGalleries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $gallery): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="example-item">
                            <img src="<?php echo e(asset('images/gallery/' . $gallery->image_path)); ?>" alt="<?php echo e($gallery->title ?? 'ตัวอย่างผลงาน'); ?>">
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
            <?php endif; ?>

        </div> 
    </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/glightbox/dist/js/glightbox.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const productImages = [
        <?php $__currentLoopData = $galleryImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            { 'href': '<?php echo e(asset($img->image_url)); ?>', 'type': 'image', 'title': '<?php echo e($img->alt_text); ?>' },
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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

        axios.post('<?php echo e(route("product.calculate")); ?>', {
            product_id: productId,
            size_id: sizeId,
            printing_id: printingId,
            part_id: partId,
            quantity: qty,
            _token: '<?php echo e(csrf_token()); ?>'
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
                    var customPath = "<?php echo e(asset('/images/jp-attachments/attachments/')); ?>";
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

        axios.post('<?php echo e(route("cart.add")); ?>', { ...data, _token: '<?php echo e(csrf_token()); ?>' })
        .then(function (response) {
            if (response.data.status === 'success') {
                Swal.fire({
                    icon: 'success', title: 'สำเร็จ', text: response.data.message, showConfirmButton: false, timer: 1500
                }).then(() => {
                    window.location.href = '<?php echo e(route("cart.index")); ?>';
                });
            } else {
                Swal.fire({ icon: 'warning', title: 'ไม่สามารถเพิ่มได้', text: response.data.message, confirmButtonColor: '#FFA726' });
            }
        });
    }

    function updateCart() {
        const qty = document.getElementById('quantityInput').value;
        const productId = document.getElementById('selected_product_id').value;
        const rowId = '<?php echo e($editRowId ?? ""); ?>'; 
        const activeSizeBtn = document.querySelector('[data-group="size-group"].active');
        const sizeName = activeSizeBtn ? activeSizeBtn.innerText.trim() : '-';
        const activePrintBtn = document.querySelector('[data-group="screen-group"].active');
        const printName = activePrintBtn ? activePrintBtn.innerText.trim() : '-';
        const activePartDiv = document.querySelector('[data-group="part-group"].active');
        const partName = activePartDiv ? activePartDiv.getAttribute('title') : '-';
        const partId = document.getElementById('selected_part_id').value;

        axios.post('<?php echo e(route("cart.update")); ?>', { 
            row_id: rowId, product_id: productId, quantity: qty, size_name: sizeName, print_name: printName, part_name: partName, part_id: partId, _token: '<?php echo e(csrf_token()); ?>' 
        })
        .then(() => {
            Swal.fire({ icon: 'success', title: 'อัปเดตเรียบร้อย', showConfirmButton: false, timer: 1500 }).then(() => {
                window.location.href = '<?php echo e(route("cart.index")); ?>';
            });
        });
    }

    function requestQuotation() {
        const qty = document.getElementById('quantityInput').value;
        const productId = document.getElementById('selected_product_id').value;
        const activeSizeBtn = document.querySelector('[data-group="size-group"].active');
        const sizeName = activeSizeBtn ? activeSizeBtn.innerText.trim() : '-';
        const activePrintBtn = document.querySelector('[data-group="screen-group"].active');
        const printName = activePrintBtn ? activePrintBtn.innerText.trim() : '-';
        const activePartDiv = document.querySelector('[data-group="part-group"].active');
        const partName = activePartDiv ? activePartDiv.getAttribute('title') : '-';
        const partId = document.getElementById('selected_part_id').value;

        axios.post('<?php echo e(route("cart.add")); ?>', { 
            product_id: productId, quantity: qty, size_name: sizeName, print_name: printName, part_name: partName, part_id: partId, _token: '<?php echo e(csrf_token()); ?>' 
        })
        .then((response) => {
            if (response.data.status === 'success') {
                window.location.href = '<?php echo e(route("quotation.index")); ?>?selected_items[]=' + response.data.row_id;
            }
        });
    }
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/products/show.blade.php ENDPATH**/ ?>