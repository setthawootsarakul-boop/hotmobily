<?php $__env->startSection('title', 'ใบเสนอราคา ' . $quotation->quotation_number); ?>

<?php $__env->startSection('content'); ?>

<style>
    body { background-color: #f3f4f6; }
    
    .quotation-container {
        background: #fff;
        max-width: 210mm;
        margin: 40px auto;
        padding: 40px;
        box-shadow: 0 0 15px rgba(0,0,0,0.1);
        font-family: 'Sarabun', sans-serif;
        color: #333;
    }

    .header-title-bar {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 5px 0;
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .company-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }
    .company-address { font-size: 12px; line-height: 1.5; width: 60%; }
    .company-logo img { height: 60px; }

    .info-section { display: flex; justify-content: space-between; margin-bottom: 20px; }
    
    .customer-info { width: 55%; }
    .cust-name { font-size: 18px; font-weight: bold; color: #000; margin-bottom: 5px; }
    .cust-details { color: #777; line-height: 1.6; font-size: 13px; }
    
    .doc-info-table {
        width: 40%;
        border-collapse: collapse;
        font-size: 13px;
    }
    .doc-info-table td { border: 1px solid #999; padding: 5px 10px; }
    .doc-info-table td:first-child { background-color: #f0f0f0; font-weight: bold; width: 40%; }
    .doc-info-table td:last-child { text-align: right; }

    /* --- ตารางสินค้า --- */
    .product-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        table-layout: fixed;
    }
    .product-table th {
        background-color: #f0f0f0;
        text-align: center;
        font-weight: bold;
        border: 1px solid #999;
        padding: 8px;
        white-space: nowrap; 
    }
    .product-table td {
        border: 1px solid #999;
        padding: 8px;
        vertical-align: top;
    }

    .col-no    { width: 45px;  text-align: center; }
    .col-item  { width: auto; }
    .col-unit  { width: 100px; text-align: right; }
    .col-qty   { width: 85px;  text-align: center; } 
    .col-price { width: 120px; text-align: right; }

    .option-list {
        margin: 5px 0 0 0;
        padding-left: 18px;
        list-style-type: disc;
        font-size: 11px;
        color: #666;
    }
    .option-list li { margin-bottom: 2px; }

    .bg-light-gray { background-color: #fcfcfc; }
    .bg-summary { background-color: #e0e0e0; font-weight: bold; }

    /* --- ส่วนตารางข้อมูลด้านล่าง --- */
    .footer-sections {
        display: flex;
        justify-content: space-between;
        margin-top: 30px;
        gap: 20px;
    }
    .footer-column { flex: 1; }
    
    .info-title { font-weight: bold; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; font-size: 12px; }
    .footer-table { width: 100%; border-collapse: collapse; font-size: 12px; }
    .footer-table td { border: 1px solid #999; padding: 5px 10px; vertical-align: top; }
    .footer-table td:first-child { background-color: #f0f0f0; width: 35%; font-weight: bold; }

    .no-print-area { margin: 40px auto; max-width: 210mm; text-align: center; position: relative; }
    .btn-print-wrapper { position: absolute; right: 0; top: 0; }
    .btn-print { background-color: #b00020; color: white; border: none; padding: 8px 20px; border-radius: 4px; font-weight: bold; cursor: pointer; }
    .btn-home { background-color: #FFA726; color: white; text-decoration: none; padding: 12px 40px; border-radius: 6px; font-weight: bold; display: inline-block; margin-top: 50px; }
    .view-products { color: #FFA726; text-decoration: none; display: block; margin-top: 15px; font-weight: bold; font-size: 14px; }

    @media print {
        body { background: #fff; }
        .quotation-container { box-shadow: none; margin: 0; padding: 0; width: 100%; }
        .no-print, nav, footer, .no-print-area { display: none !important; }
        @page { margin: 1cm; }
    }
</style>

<div class="container-fluid py-4">
    
    <div class="quotation-container">
        <div class="header-title-bar">ใบเสนอราคา</div>

        <div class="company-header">
            <div class="company-address">
                <strong>YOU AND EARTH (THAILAND) CO., LTD.</strong><br>
                23/34-35 The Prime Hua Lamphong, Building A, 3rd Floor, Room No. 303,<br>
                Soi Sukorn, Trimit Road, Talat Noi, Samphanthawong, Bangkok 10100<br>
                Tel : 064-604-5614<br>
                TAX ID: 010-556-3086-07-0, Head Office
            </div>
            <div class="company-logo">
                <img src="<?php echo e(asset('images/Hotmobilyfile/logo-thai-s.jpg')); ?>" alt="HOT STRAP Logo"> 
            </div>
        </div>

        <div class="info-section">
            <div class="customer-info">
                <div class="cust-name"><?php echo e($quotation->fullname); ?></div>
                <div class="cust-details">
                    <?php
                        $addrLine1 = collect([
                            $quotation->address_no,
                            $quotation->moo ? "หมู่ " . $quotation->moo : null,
                            $quotation->building,
                            $quotation->floor ? "ชั้น " . $quotation->floor : null,
                            $quotation->village,
                            $quotation->soi,
                            $quotation->road
                        ])->filter()->implode(', ');
                    ?>
                    <?php echo e($addrLine1); ?>

                    <br>
                    <?php echo e($quotation->sub_district); ?>, <?php echo e($quotation->district); ?>, <?php echo e($quotation->province); ?> <?php echo e($quotation->zipcode); ?>

                    <br>
                    <?php echo e($quotation->email); ?>

                    <br>
                    <?php echo e($quotation->phone); ?>

                </div>
            </div>

            <table class="doc-info-table">
                <tr><td>Quotation #</td><td><?php echo e($quotation->quotation_number); ?></td></tr>
                <tr><td>Date</td><td><?php echo e($quotation->created_at->format('M d, Y')); ?></td></tr>
                <tr><td>Amount Due</td><td><?php echo e(number_format($quotation->grand_total, 2)); ?> baht</td></tr>
            </table>
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th class="col-no">No.</th>
                    <th class="col-item" style="text-align: left;">Item</th>
                    <th class="col-unit">Unit Cost</th>
                    <th class="col-qty">Quantity</th>
                    <th class="col-price">Price(baht)</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $quotation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $opt = $item->options ?? [];
                    $size = $opt['size_name'] ?? '-';
                    $print = $opt['print_name'] ?? '-';
                    $part = $opt['part_name'] ?? '-';
                    $color = $opt['part_color'] ?? '-';
                ?>
                <tr>
                    <td class="col-no"><?php echo e($index + 1); ?></td>
                    <td class="col-item">
                        <strong><?php echo e($item->product_name); ?></strong>
                        <ul class="option-list">
                            <?php if($size != '-'): ?> <li>ขนาด: <?php echo e($size); ?></li> <?php endif; ?>
                            <?php if($print != '-'): ?> <li>การพิมพ์: <?php echo e($print); ?></li> <?php endif; ?>
                            <?php if($part != '-'): ?> <li>ส่วนประกอบเพิ่มเติม: <?php echo e($part); ?> <?php if($color != '-' && $color != ''): ?> (<?php echo e($color); ?>) <?php endif; ?></li> <?php endif; ?>
                        </ul>
                    </td>
                    <td class="col-unit"><?php echo e(number_format($item->price_per_unit, 2)); ?></td>
                    <td class="col-qty"><?php echo e(number_format($item->quantity)); ?></td>
                    <td class="col-price"><?php echo e(number_format($item->total_price, 2)); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                <?php for($i = 0; $i < max(0, 5 - count($quotation->items)); $i++): ?>
                <tr>
                    <td class="col-no" style="height: 30px;"></td>
                    <td class="col-item"></td>
                    <td class="col-unit"></td>
                    <td class="col-qty"></td>
                    <td class="col-price"></td>
                </tr>
                <?php endfor; ?>

                <tr>
                    <td colspan="2" style="border: none;"></td>
                    <td colspan="2" class="bg-light-gray" style="text-align: right; font-weight: bold;">Subtotal</td>
                    <td class="col-price"><?php echo e(number_format($quotation->subtotal, 2)); ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none;"></td>
                    <td colspan="2" class="bg-light-gray" style="text-align: right; font-weight: bold;">Express fee</td>
                    <td class="col-price"><?php echo e(number_format($quotation->express_fee, 2)); ?></td>
                </tr>
                <tr>
                    <td colspan="2" style="border: none;"></td>
                    <td colspan="2" class="bg-summary" style="text-align: right;">Balance Due</td>
                    <td class="col-price bg-summary"><?php echo e(number_format($quotation->grand_total, 2)); ?> baht</td>
                </tr>
            </tbody>
        </table>

        
        <div class="footer-sections">
            
            <div class="footer-column">
                <div class="info-title">P A Y M E N T &nbsp; M E T H O D</div>
                <table class="footer-table">
                    <tr><td>Bank's name</td><td>ไทยพาณิชย์ (SCB)</td></tr>
                    <tr><td>Bank number</td><td>191-213953-5</td></tr>
                    <tr><td>Account name</td><td>บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</td></tr>
                    <tr><td>Branch name</td><td>ถนนสาทร</td></tr>
                </table>
            </div>

            
            <?php if($quotation->tax_invoice_req == '1'): ?>
            <div class="footer-column">
                <div class="info-title">T A X &nbsp; I N V O I C E &nbsp; I N F O</div>
                <table class="footer-table">
                    <tr><td>Tax Name</td><td><?php echo e($quotation->tax_name); ?></td></tr>
                    <tr><td>Tax ID</td><td><?php echo e($quotation->tax_id); ?></td></tr>
                    <tr><td>Address</td><td>
                        <?php
                            $taxAddr = collect([
                                $quotation->tax_address_no,
                                $quotation->tax_moo ? "หมู่ " . $quotation->tax_moo : null,
                                $quotation->tax_building,
                                $quotation->tax_soi,
                                $quotation->tax_road
                            ])->filter()->implode(' ');
                        ?>
                        <?php echo e($taxAddr); ?><br>
                        <?php echo e($quotation->tax_sub_district); ?>, <?php echo e($quotation->tax_district); ?><br>
                        <?php echo e($quotation->tax_province); ?> <?php echo e($quotation->tax_zipcode); ?>

                    </td></tr>
                </table>
            </div>
            <?php endif; ?>
        </div>

        <div class="text-center mt-5" style="font-size: 10px; color: #aaa; letter-spacing: 3px;">T E R M S</div>
    </div>

    <div class="no-print-area">
        <div class="btn-print-wrapper">
            <button onclick="window.print()" class="btn-print">พิมพ์ใบเสนอราคา</button>
        </div>
        <a href="<?php echo e(route('home')); ?>" class="btn-home">กลับไปหน้าหลัก</a>
        <a href="<?php echo e(route('products.index')); ?>" class="view-products">ดูสินค้าของเรา</a>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Hotmobily\hotmobily\resources\views/contact-full.blade.php ENDPATH**/ ?>