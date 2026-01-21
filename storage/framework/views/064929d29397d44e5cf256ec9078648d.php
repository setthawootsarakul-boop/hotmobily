

<?php $__env->startSection('title', 'ใบเสนอราคา ' . $quotation->quotation_number); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <div class="action-wrapper">
        <div class="thank-you-box no-print">
                    <div class="thank-you-title">
                        <i class="fas fa-check-circle"></i> ขอบคุณสำหรับการขอใบเสนอราคา
                    </div>
                    <div class="thank-you-subtitle">
                        เราได้รับคำขอของคุณเรียบร้อยแล้ว <strong>ฝ่ายขายจะติดต่อกลับหาคุณภายใน 24 ชั่วโมง</strong><br>
                        หรือภายในวันทำการถัดไป หากท่านต้องการความช่วยเหลือด่วน โปรดโทร 064-604-5614
                    </div>
                </div>

        <div class="quotation-container">
            <div class="header-title-bar">ใบเสนอราคา</div>

            
            <div class="company-header">
                <div class="company-address">
                    <strong>YOU AND EARTH (THAILAND) CO., LTD.</strong><br>
                    23/34-35 The Prime Hua Lamphong, Building A, 3rd Floor, Room No. 404,<br>
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
                    
                    <?php if(!empty($quotation->fullname)): ?>
                        <div class="cust-name"><?php echo e($quotation->fullname); ?></div>
                    <?php endif; ?>
                    
                    <div class="cust-details">
                        
                        <?php if(!empty($quotation->company_name)): ?>
                            <div style="margin-bottom: 5px;"><?php echo e($quotation->company_name); ?></div>
                        <?php endif; ?>

                        
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

                        <?php if(!empty($addrLine1)): ?>
                            <div><?php echo e($addrLine1); ?></div>
                        <?php endif; ?>

                        <?php if(!empty($quotation->sub_district) || !empty($quotation->province)): ?>
                            <div>
                                <?php echo e($quotation->sub_district); ?><?php echo e($quotation->district ? ', ' . $quotation->district : ''); ?> 
                                <?php echo e($quotation->province); ?> <?php echo e($quotation->zipcode); ?>

                            </div>
                        <?php endif; ?>

                        <?php if(!empty($quotation->email)): ?>
                            <div><?php echo e($quotation->email); ?></div>
                        <?php endif; ?>

                        <?php if(!empty($quotation->phone)): ?>
                            <div><?php echo e($quotation->phone); ?></div>
                        <?php endif; ?>
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
                            <ul style="margin: 5px 0 0 0; padding-left: 18px; list-style-type: disc; font-size: 11px; color: #666;">
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

           
            <div class="footer-tables-wrapper">
                <div class="footer-left-box">
                    <div class="footer-title" style="font-weight: bold; margin-bottom: 10px;">PAYMENT METHOD</div>
                    <table class="footer-info-table">
                        <tr><td>Bank's name</td><td>ไทยพาณิชย์ (SCB)</td></tr>
                        <tr><td>Bank number</td><td>191-213953-5</td></tr>
                        <tr><td>Account name</td><td>บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</td></tr>
                        <tr><td>Branch name</td><td>ถนนสาทร</td></tr>
                    </table>
                </div>
                
                <?php if(!empty($quotation->tax_name)): ?>
                <div class="footer-right-box">
                    <div class="footer-title" style="font-weight: bold; margin-bottom: 10px;">TAX INVOICE INFO</div>
                    <table class="footer-info-table">
                        <tr><td>Tax Type</td><td><?php echo e($quotation->tax_person_type == 'individual' ? 'บุคคลธรรมดา' : 'นิติบุคคล'); ?></td></tr>
                        
                        <?php if($quotation->tax_person_type == 'juristic' && !empty($quotation->tax_company)): ?>
                            <tr><td>Company</td><td><?php echo e($quotation->tax_company); ?></td></tr>
                        <?php endif; ?>

                        <tr><td>Tax Name</td><td><?php echo e($quotation->tax_name); ?></td></tr>
                        <tr><td>Tax ID</td><td><?php echo e($quotation->tax_id); ?></td></tr>
                        <tr>
                            <td>Address</td>
                            <td>
                                <?php 
                                    // รวบที่อยู่ให้แสดงผลต่อเนื่องกัน ไม่บีบเป็นแนวตั้ง
                                    $fullTaxAddr = collect([
                                        $quotation->tax_address_no ? "เลขที่ " . $quotation->tax_address_no : null, 
                                        $quotation->tax_building ? "อาคาร/หมู่บ้าน " . $quotation->tax_building : null,
                                        $quotation->tax_floor ? "ชั้น " . $quotation->tax_floor : null, 
                                        $quotation->tax_moo ? "หมู่ " . $quotation->tax_moo : null, 
                                        $quotation->tax_village,
                                        $quotation->tax_soi ? "ซอย " . $quotation->tax_soi : null,
                                        $quotation->tax_road ? "ถนน " . $quotation->tax_road : null,
                                        $quotation->tax_sub_district,
                                        $quotation->tax_district,
                                        $quotation->tax_province,
                                        $quotation->tax_zipcode
                                    ])->filter()->implode(' ');
                                ?>
                                <?php echo e($fullTaxAddr); ?>

                            </td>
                        </tr>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            
            <div class="terms-detail">
                <div style="font-size: 10px; color: #000000; letter-spacing: 3px; margin-bottom: 10px; text-align: center;">T E R M S</div>
                <div class="terms-description">
                    ราคาด้านบนเป็นราคาที่รวมค่าจัดส่งเรียบร้อยแล้ว ระยะเวลาการจัดส่งจะเป็นไปตามที่ระบุอยู่บนเว็บไซต์<br>
                    หลังจากสั่งซื้อเรียบร้อยแล้วกรุณาโอนเงินภายใน 7 วัน สอบถามข้อมูลเพิ่มเติมที่ 
                    contact_hs@hotstrapthai.com
                </div>
            </div>
        </div>

        <div class="btn-print-wrapper no-print">
            <button onclick="window.print()" class="btn-print">พิมพ์ใบเสนอราคา</button>
        </div>

        <div class="text-center no-print">
            <a href="<?php echo e(route('home')); ?>" class="btn-home">กลับไปหน้าหลัก</a>
            <br>
            <a href="<?php echo e(route('products.index')); ?>" class="view-products-link">ดูสินค้าของเรา</a>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        Object.keys(localStorage).forEach(key => {
            if (key.startsWith('quote_') || key.startsWith('tax_')) {
                localStorage.removeItem(key);
            }
        });
        console.log('Quotation storage cleared successfully.');
    });
</script>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.main', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\project\hotmobily\resources\views/quotation/show.blade.php ENDPATH**/ ?>