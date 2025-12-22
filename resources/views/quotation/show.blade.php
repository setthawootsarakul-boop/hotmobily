@extends('layouts.main')

@section('title', 'ใบเสนอราคา ' . $quotation->quotation_number)

@section('content')


<div class="container-fluid py-4">
    <div class="action-wrapper">
        
        
        <div class="thank-you-header no-print">
            ขอบคุณสำหรับการทำใบเสนอราคา
        </div>

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
                    <img src="{{ asset('images/Hotmobilyfile/logo-thai-s.jpg') }}" alt="Logo"> 
                </div>
            </div>

            <div class="info-section">
                <div class="customer-info">
                    <div class="cust-name">{{ $quotation->fullname }}</div>
                    <div class="cust-details">
                        @php 
                            $addrLine1 = collect([
                                $quotation->address_no ? "เลขที่ " . $quotation->address_no : null,
                                $quotation->moo ? "หมู่ " . $quotation->moo : null,
                                $quotation->building,
                                $quotation->floor ? "ชั้น " . $quotation->floor : null,
                                $quotation->village,
                                $quotation->soi ? "ซอย " . $quotation->soi : null,
                                $quotation->road ? "ถนน " . $quotation->road : null
                            ])->filter()->implode(', '); 
                        @endphp
                        {{ $addrLine1 }}<br>
                        {{ $quotation->sub_district }}, {{ $quotation->district }}, {{ $quotation->province }} {{ $quotation->zipcode }}<br>
                        {{ $quotation->email }}<br>{{ $quotation->phone }}
                    </div>
                </div>
                <table class="doc-info-table">
                    <tr><td>Quotation #</td><td>{{ $quotation->quotation_number }}</td></tr>
                    <tr><td>Date</td><td>{{ $quotation->created_at->format('M d, Y') }}</td></tr>
                    <tr><td>Amount Due</td><td>{{ number_format($quotation->grand_total, 2) }} baht</td></tr>
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
                    @foreach($quotation->items as $index => $item)
                    @php $opt = $item->options ?? []; @endphp
                    <tr>
                        <td class="col-no">{{ $index + 1 }}</td>
                        <td>
                            <strong>{{ $item->product_name }}</strong>
                            <ul style="margin: 5px 0 0 0; padding-left: 18px; list-style-type: disc; font-size: 11px; color: #666;">
                                @if(($opt['size_name'] ?? '-') != '-') <li>ขนาด: {{ $opt['size_name'] }}</li> @endif
                                @if(($opt['print_name'] ?? '-') != '-') <li>การพิมพ์: {{ $opt['print_name'] }}</li> @endif
                                @if(($opt['part_name'] ?? '-') != '-') <li>ส่วนประกอบเพิ่มเติม: {{ $opt['part_name'] }}</li> @endif
                            </ul>
                        </td>
                        <td style="text-align: right;">{{ number_format($item->price_per_unit, 2) }}</td>
                        <td style="text-align: center;">{{ number_format($item->quantity) }}</td>
                        <td class="col-price">{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                    @endforeach
                    @for($i = 0; $i < max(0, 5 - count($quotation->items)); $i++)
                    <tr><td style="height: 30px;"></td><td></td><td></td><td></td><td></td></tr>
                    @endfor
                </tbody>
                <tfoot style="display: table-footer-group;">
                    <tr>
                        <td colspan="2" style="border: none;"></td>
                        <td colspan="2" class="bg-light-gray" style="text-align: right; font-weight: bold; border: 1px solid #999;">Subtotal</td>
                        <td class="col-price" style="border: 1px solid #999;">{{ number_format($quotation->subtotal, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: none;"></td>
                        <td colspan="2" class="bg-light-gray" style="text-align: right; font-weight: bold; border: 1px solid #999;">Express fee</td>
                        <td class="col-price" style="border: 1px solid #999;">{{ number_format($quotation->express_fee, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" style="border: none;"></td>
                        <td colspan="2" class="bg-summary" style="text-align: right; border: 1px solid #999;">Balance Due</td>
                        <td class="col-price bg-summary" style="border: 1px solid #999;">{{ number_format($quotation->grand_total, 2) }} baht</td>
                    </tr>
                </tfoot>
            </table>

            <div class="footer-tables-container">
                <div class="footer-table-box">
                    <div style="font-weight: bold; margin-bottom: 8px; text-transform: uppercase; font-size: 12px;">P A Y M E N T &nbsp; M E T H O D</div>
                    <table class="footer-data-table">
                        <tr><td>Bank's name</td><td>ไทยพาณิชย์ (SCB)</td></tr>
                        <tr><td>Bank number</td><td>191-213953-5</td></tr>
                        <tr><td>Account name</td><td>บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</td></tr>
                        <tr><td>Branch name</td><td>ถนนสาทร</td></tr>
                    </table>
                </div>
                @if($quotation->tax_name)
                <div class="footer-table-box">
                    <div style="font-weight: bold; margin-bottom: 8px; text-transform: uppercase; font-size: 12px;">T A X &nbsp; I N V O I C E &nbsp; I N F O</div>
                    <table class="footer-data-table">
                        <tr><td>Tax Type</td><td>{{ $quotation->tax_person_type == 'individual' ? 'บุคคลธรรมดา' : 'นิติบุคคล' }}</td></tr>
                        <tr><td>Tax Name</td><td>{{ $quotation->tax_name }}</td></tr>
                        <tr><td>Tax ID</td><td>{{ $quotation->tax_id }}</td></tr>
                        <tr><td>Address</td><td>
                            @php $taxAddr = collect([$quotation->tax_address_no, $quotation->tax_moo ? "หมู่ " . $quotation->tax_moo : null, $quotation->tax_building, $quotation->tax_floor ? "ชั้น " . $quotation->tax_floor : null, $quotation->tax_village, $quotation->tax_soi, $quotation->tax_road])->filter()->implode(' '); @endphp
                            {{ $taxAddr }}<br>{{ $quotation->tax_sub_district }}, {{ $quotation->tax_district }}<br>{{ $quotation->tax_province }} {{ $quotation->tax_zipcode }}
                        </td></tr>
                    </table>
                </div>
                @endif
            </div>

            <div class="text-center mt-5" style="font-size: 10px; color: #aaa; letter-spacing: 3px;">T E R M S</div>
            
            {{-- 🔥 เพิ่มข้อความรายละเอียดใต้ TERMS --}}
            <div class="text-center terms-detail">
                ราคาด้านบนเป็นราคาที่รวมค่าจัดส่งเรียบร้อยแล้ว ระยะเวลาการจัดส่งจะเป็นไปตามที่ระบุอยู่บนเว็บไซต์<br>
                หลังจากสั่งซื้อเรียบร้อยแล้วกรุณาโอนเงินภายใน 7 วัน สอบถามข้อมูลเพิ่มเติมที่ 
                contact_hs@hotstrapthai.com
            </div>

        </div>

        <div class="btn-print-wrapper no-print">
            <button onclick="window.print()" class="btn-print">พิมพ์ใบเสนอราคา</button>
        </div>

        <div class="text-center no-print">
            <a href="{{ route('home') }}" class="btn-home">กลับไปหน้าหลัก</a>
            <br>
            <a href="{{ route('products.index') }}" class="view-products-link">ดูสินค้าของเรา</a>
        </div>

    </div>
</div>
@endsection