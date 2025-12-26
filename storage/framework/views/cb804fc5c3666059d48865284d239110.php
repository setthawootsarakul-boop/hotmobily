<?php $__env->startSection('title', 'ใบเสนอราคา ' . $quotation->quotation_number); ?>


<?php $__env->startPush('styles'); ?>
    <link rel="stylesheet" href="<?php echo e(asset('css/quotation.css')); ?>">
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>

<div class="container-fluid py-4">
    <div class="action-wrapper">
        
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
                    <img src="<?php echo e(asset('images/Hotmobilyfile/logo-thai-s.jpg')); ?>" alt="Logo"> 
                </div>
            </div>

            <div class="info-section">
                <div class="customer-info">
                    <div class="cust-name"><?php echo e($quotation->fullname); ?></div>
                    <div class="cust-details">
                        <?php 
                            $addrLine1 = collect([
                                $quotation->address_no ? "เลขที่ " . $quotation->address_no : null,
                                $quotation->moo ? "หมู่ " . $quotation->moo : null,
                                $quotation->building,
                                $quotation->floor ? "ชั้น " . $quotation->floor : null,
                                $quotation->village,
                                $quotation->soi ? "ซอย " . $quotation->soi : null,
                                $quotation->road ? "ถนน " . $quotation->road : null
                            ])->filter()->implode(', '); 
                        ?>
                        <?php echo e($addrLine1); ?><br>
                        <?php echo e($quotation->sub_district); ?>, <?php echo e($quotation->district); ?>, <?php echo e($quotation->province); ?> <?php echo e($quotation->zipcode); ?><br>
                        <?php echo e($quotation->email); ?><br><?php echo e($quotation->phone); ?>

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
                        <th style="text-align: left;">Item</th>
                        <th style="width: 100px;">Unit Cost</th>
                        <th style="width: 85px;">Quantity</th>
                        <th class="col-price">Price(baht)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $quotation->items; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php $opt = $item->options ?? []; ?>
                    <tr>
                        <td class="col-no"><?php echo e($index + 1); ?></td>
                        <td>
                            <strong><?php echo e($item->product_name); ?></strong>
                            <ul class="option-list">
                                <?php if(($opt['size_name'] ?? '-') != '-'): ?> <li>ขนาด: <?php echo e($opt['size_name']); ?></li> <?php endif; ?>
                                <?php if(($opt['print_name'] ?? '-') != '-'): ?> <li>การพิมพ์: <?php echo e($opt['print_name']); ?></li> <?php endif; ?>
                                <?php if(($opt['part_name'] ?? '-') != '-'): ?> <li>ส่วนประกอบเพิ่มเติม: <?php echo e($opt['part_name']); ?></li> <?php endif; ?>
                            </ul>
                        </td>
                        <td style="text-align: right;"><?php echo e(number_format($item->price_per_unit, 2)); ?></td>
                        <td style="text-align: center;"><?php echo e(number_format($item->quantity)); ?></td>
                        <td class="col-price"><?php echo e(number_format($item->total_price, 2)); ?></td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php for($i = 0; $i < max(0, 5 - count($quotation->items)); $i++): ?>
                    <tr><td style="height: 30px;"></td><td></td><td></td><td></td><td></td></tr>
                    <?php endfor; ?>
                </tbody>
                <tfoot style="display: table-footer-group;">
                    <tr>
                        <td colspan="2" style="border: none;"></td>
                        <td colspan="2" class="bg-light-gray" style="text-align: right; font-weight: bold; border: 1px solid #999;">Subtotal</td>
                        <td class="col-price" style="border: 1px solid #999;"><?php echo e(number_format($quotation->subtotal, 2)); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: none;"></td>
                        <td colspan="2" class="bg-light-gray" style="text-align: right; font-weight: bold; border: 1px solid #999;">Express fee</td>
                        <td class="col-price" style="border: 1px solid #999;"><?php echo e(number_format($quotation->express_fee, 2)); ?></td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: none;"></td>
                        <td colspan="2" class="bg-summary" style="text-align: right; border: 1px solid #999;">Balance Due</td>
                        <td class="col-price bg-summary" style="border: 1px solid #999;"><?php echo e(number_format($quotation->grand_total, 2)); ?> baht</td>
                    </tr>
                </tfoot>
            </table>

            <div class="footer-tables-container">
                <div class="footer-table-box">
                    <div class="footer-info-title">P A Y M E N T &nbsp; M E T H O D</div>
                    <table class="footer-data-table">
                        <tr><td>Bank's name</td><td>ไทยพาณิชย์ (SCB)</td></tr>
                        <tr><td>Bank number</td><td>191-213953-5</td></tr>
                        <tr><td>Account name</td><td>บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</td></tr>
                        <tr><td>Branch name</td><td>ถนนสาทร</td></tr>
                    </table>
                </div>
                <?php if($quotation->tax_name): ?>
                <div class="footer-table-box">
                    <div class="footer-info-title">T A X &nbsp; I N V O I C E &nbsp; I N F O</div>
                    <table class="footer-data-table">
                        <tr><td>Tax Type</td><td><?php echo e($quotation->tax_person_type == 'individual' ? 'บุคคลธรรมดา' : 'นิติบุคคล'); ?></td></tr>
                        <tr><td>Tax Name</td><td><?php echo e($quotation->tax_name); ?></td></tr>
                        <tr><td>Tax ID</td><td><?php echo e($quotation->tax_id); ?></td></tr>
                        <tr><td>Address</td><td>
                            <?php $taxAddr = collect([$quotation->tax_address_no, $quotation->tax_moo ? "หมู่ " . $quotation->tax_moo : null, $quotation->tax_building, $quotation->tax_floor ? "ชั้น " . $quotation->tax_floor : null, $quotation->tax_village, $quotation->tax_soi, $quotation->tax_road])->filter()->implode(' '); ?>
                            <?php echo e($taxAddr); ?><br><?php echo e($quotation->tax_sub_district); ?>, <?php echo e($quotation->tax_district); ?><br><?php echo e($quotation->tax_province); ?> <?php echo e($quotation->tax_zipcode); ?>

                        </td></tr>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            <div class="text-center mt-5" style="font-size: 10px; color: #aaa; letter-spacing: 3px;">T E R M S</div>
        </div>

        <div class="btn-print-wrapper no-print">
            <button onclick="window.print()" class="btn-print">พิมพ์ใบเสนอราคา</button>
        </div>

        <div class="text-center no-print">
            <a href="<?php echo e(route('home')); ?>" class="btn-home-view">กลับไปหน้าหลัก</a>
            <br>
            
            <a href="<?php echo e(route('products.index')); ?>" class="view-products-link">ดูสินค้าของเรา</a>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Hotmobily\hotmobily\resources\views/quotation/show.blade.php ENDPATH**/ ?>