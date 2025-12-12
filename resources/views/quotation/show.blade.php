@extends('layouts.main')

@section('title', 'ใบเสนอราคา ' . $quotation->quotation_number)

@section('content')

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
    
    /* --- สไตล์ข้อมูลลูกค้าแบบใหม่ --- */
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

    .bg-light-gray { background-color: #fcfcfc; }
    .bg-summary { background-color: #e0e0e0; font-weight: bold; }

    .payment-section { margin-top: 30px; font-size: 12px; }
    .payment-title { font-weight: bold; margin-bottom: 10px; text-transform: uppercase; letter-spacing: 1px; }
    .payment-table { width: 50%; border-collapse: collapse; }
    .payment-table td { border: 1px solid #999; padding: 5px 10px; }
    .payment-table td:first-child { background-color: #f0f0f0; width: 35%; }

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
                <img src="{{ asset('images/Hotmobilyfile/logo-thai-s.jpg') }}" alt="HOT STRAP Logo"> 
            </div>
        </div>

        {{-- Section: ข้อมูลลูกค้า (ปรับตามคำขอ) --}}
        <div class="info-section">
            <div class="customer-info">
                <div class="cust-name">{{ $quotation->fullname }}</div>
                <div class="cust-details">
                    {{ $quotation->address_no }}
                    @if($quotation->moo) หมู่ {{ $quotation->moo }}, @endif 
                    @if($quotation->building) {{ $quotation->building }}, @endif
                    @if($quotation->floor) ชั้น {{ $quotation->floor }}, @endif
                    @if($quotation->village) {{ $quotation->village }}, @endif
                    
                    {{-- ลบคำว่า ซอย/ถนน ออกจากโค้ด เพราะปกติข้อมูลที่กรอกมักใส่คำว่าซอยมาอยู่แล้ว --}}
                    @if($quotation->soi) ซอย {{ $quotation->soi }}, @endif
                    @if($quotation->road) ถนน {{ $quotation->road }} @endif
                    <br>
                    
                    {{-- แสดงผลชื่อสถานที่ที่ Controller แปลงมาให้แล้ว --}}
                    {{ $quotation->sub_district }}, {{ $quotation->district }}, {{ $quotation->province }} {{ $quotation->zipcode }}
                    <br>
                    {{ $quotation->email }}
                    <br>
                    {{ $quotation->phone }}
                </div>

                @if($quotation->tax_name)
                    <div style="margin-top: 15px; padding-top: 10px; border-top: 1px dashed #eee;">
                        <strong style="color: #333; font-size: 13px;">Tax Invoice Details:</strong><br>
                        <span class="cust-details">{{ $quotation->tax_name }} (Tax ID: {{ $quotation->tax_id }})</span>
                    </div>
                @endif
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
                    <th class="col-item" style="text-align: left;">Item</th>
                    <th class="col-unit">Unit Cost</th>
                    <th class="col-qty">Quantity</th>
                    <th class="col-price">Price(baht)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($quotation->items as $index => $item)
                @php
                    $opt = $item->options ?? [];
                    $size = $opt['size_name'] ?? '-';
                    $print = $opt['print_name'] ?? '-';
                    $part = $opt['part_name'] ?? '-';
                    $color = $opt['part_color'] ?? '-';
                @endphp
                <tr>
                    <td class="col-no">{{ $index + 1 }}</td>
                    <td class="col-item">
                        <strong>{{ $item->product_name }}</strong>
                        <ul class="option-list">
                            @if($size != '-') <li>ขนาด: {{ $size }}</li> @endif
                            @if($print != '-') <li>การพิมพ์: {{ $print }}</li> @endif
                            @if($part != '-') <li>ส่วนประกอบเพิ่มเติม: {{ $part }} @if($color != '-' && $color != '') ({{ $color }}) @endif</li> @endif
                        </ul>
                    </td>
                    <td class="col-unit">{{ number_format($item->price_per_unit, 2) }}</td>
                    <td class="col-qty">{{ number_format($item->quantity) }}</td>
                    <td class="col-price">{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach

                @for($i = 0; $i < max(0, 5 - count($quotation->items)); $i++)
                <tr>
                    <td class="col-no" style="height: 30px;"></td>
                    <td class="col-item"></td>
                    <td class="col-unit"></td>
                    <td class="col-qty"></td>
                    <td class="col-price"></td>
                </tr>
                @endfor

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
            </tbody>
        </table>

        <div class="payment-section">
            <div class="payment-title">P A Y M E N T &nbsp; M E T H O D</div>
            <table class="payment-table">
                <tr><td>Bank's name</td><td>ไทยพาณิชย์ (SCB)</td></tr>
                <tr><td>Bank number</td><td>191-213953-5</td></tr>
                <tr><td>Account name</td><td>บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</td></tr>
                <tr><td>Branch name</td><td>ถนนสาทร</td></tr>
            </table>
        </div>
        <div class="text-center mt-5" style="font-size: 10px; color: #aaa; letter-spacing: 3px;">T E R M S</div>
    </div>

    <div class="no-print-area">
        <div class="btn-print-wrapper">
            <button onclick="window.print()" class="btn-print">พิมพ์ใบเสนอราคา</button>
        </div>
        <a href="{{ route('home') }}" class="btn-home">กลับไปหน้าหลัก</a>
        <a href="{{ route('products.index') }}" class="view-products">ดูสินค้าของเรา</a>
    </div>
</div>
@endsection