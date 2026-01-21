@extends('layouts.admin')

@section('title', 'ใบเสนอราคา ' . $quotation->quotation_number)

@section('content')
<style>
    /* --- UI ปกติบนหน้าจอ --- */
    .quotation-container {
        max-width: 900px;
        margin: 20px auto;
        background: #fff;
        padding: 40px;
        border: 1px solid #eee;
        box-shadow: 0 0 20px rgba(0,0,0,0.05);
        position: relative;
    }
    .header-title-bar {
        background-color: #000;
        color: #fff;
        text-align: center;
        padding: 10px;
        font-weight: bold;
        text-transform: uppercase;
        letter-spacing: 5px;
        margin-bottom: 30px;
    }
    .company-header {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
    }
    .company-address { font-size: 12px; line-height: 1.6; color: #333; }
    .company-logo img { max-width: 140px; }
    
    .info-section {
        display: flex;
        justify-content: space-between;
        margin-bottom: 30px;
        gap: 20px;
    }
    .customer-info { flex: 1; }
    .cust-name { font-weight: bold; font-size: 16px; margin-bottom: 10px; text-decoration: underline; }
    .cust-details { font-size: 13px; line-height: 1.6; }
    
    .doc-info-table { border-collapse: collapse; font-size: 13px; }
    .doc-info-table td { padding: 4px 8px; border: 1px solid #ccc; }
    .doc-info-table td:first-child { background: #f4f4f4 !important; font-weight: bold; width: 120px; }

    .product-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
    .product-table th { background: #000 !important; color: #fff !important; padding: 10px; font-size: 13px; border: 1px solid #000; -webkit-print-color-adjust: exact; }
    .product-table td { padding: 10px; border: 1px solid #ccc; vertical-align: top; font-size: 13px; }
    .col-no { text-align: center; width: 40px; }
    .col-price { text-align: right; width: 120px; }
    
    .bg-light-gray { background-color: #f9f9f9 !important; -webkit-print-color-adjust: exact; }
    .bg-summary { background-color: #eee !important; font-weight: bold; -webkit-print-color-adjust: exact; }

    .footer-tables-wrapper { display: flex; justify-content: space-between; gap: 20px; margin-top: 30px; }
    .footer-left-box, .footer-right-box { flex: 1; }
    .footer-title { font-size: 12px; border-bottom: 1px solid #000; padding-bottom: 5px; margin-bottom: 10px; font-weight: bold; }
    .footer-info-table { width: 100%; font-size: 11px; }
    .footer-info-table td { padding: 3px 0; vertical-align: top; }
    .footer-info-table td:first-child { width: 90px; color: #666; }

    .terms-detail { margin-top: 40px; border-top: 1px solid #eee; padding-top: 20px; }
    .terms-description { font-size: 10px; text-align: center; color: #777; line-height: 1.8; }

    .attachment-section {
        margin-top: 30px;
        padding: 20px;
        background: #f8f9fa;
        border: 2px dashed #ddd;
        border-radius: 10px;
    }

    /* --- 🖨️ แก้ไข UI สำหรับการพิมพ์ (Print Mode) --- */
    @media print {
        @page {
            size: A4;
            margin: 1cm;
        }
        body { background: #fff !important; margin: 0; padding: 0; }
        .no-print, .app-header, .app-sidebar, .main-footer, .btn { display: none !important; }
        .content-wrapper, .app-main { margin: 0 !important; padding: 0 !important; background: none !important; }
        .quotation-container {
            max-width: 100% !important;
            width: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            border: none !important;
            box-shadow: none !important;
        }
        .container-fluid { padding: 0 !important; }
        /* บังคับให้สีพื้นหลังในตารางแสดงผล */
        .header-title-bar { -webkit-print-color-adjust: exact; background-color: #000 !important; color: #fff !important; }
        .doc-info-table td:first-child { background-color: #f4f4f4 !important; }
        .product-table th { background-color: #000 !important; color: #fff !important; }
        .bg-light-gray { background-color: #f9f9f9 !important; }
        .bg-summary { background-color: #eee !important; }
    }
</style>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between mb-4 no-print">
        <a href="{{ url()->previous() }}" class="btn btn-light border rounded-pill px-4 shadow-sm">
            <i class="bi bi-arrow-left me-1"></i> กลับหน้าจัดการ
        </a>
        <button onclick="window.print()" class="btn btn-danger rounded-pill px-4 shadow-sm">
            <i class="bi bi-printer me-1"></i> พิมพ์ใบเสนอราคา (PDF)
        </button>
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
                <img src="{{ asset('images/Hotmobilyfile/logo-thai-s.jpg') }}" alt="Logo"> 
            </div>
        </div>

        <div class="info-section">
            <div class="customer-info">
                @if(!empty($quotation->fullname))
                    <div class="cust-name">{{ $quotation->fullname }}</div>
                @endif
                
                <div class="cust-details">
                    @if(!empty($quotation->company_name))
                        <div style="margin-bottom: 5px;">{{ $quotation->company_name }}</div>
                    @endif

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

                    @if(!empty($addrLine1)) <div>{{ $addrLine1 }}</div> @endif

                    @if(!empty($quotation->sub_district))
                        <div>
                            {{ $quotation->sub_district }}{{ $quotation->district ? ', ' . $quotation->district : '' }} 
                            {{ $quotation->province }} {{ $quotation->zipcode }}
                        </div>
                    @endif

                    @if(!empty($quotation->email)) <div>{{ $quotation->email }}</div> @endif
                    @if(!empty($quotation->phone)) <div>{{ $quotation->phone }}</div> @endif
                </div>
            </div>

            <table class="doc-info-table">
                <tr><td>Quotation #</td><td>{{ $quotation->quotation_number }}</td></tr>
                <tr><td>Date</td><td>{{ \Carbon\Carbon::parse($quotation->created_at)->format('M d, Y') }}</td></tr>
                <tr><td>Amount Due</td><td>{{ number_format($quotation->grand_total, 2) }} baht</td></tr>
            </table>
        </div>

        <table class="product-table">
            <thead>
                <tr>
                    <th class="col-no">No.</th>
                    <th style="text-align: left;">Item</th>
                    <th style="width: 100px; text-align: right;">Unit Cost</th>
                    <th style="width: 85px; text-align: center;">Quantity</th>
                    <th class="col-price">Price(baht)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($items as $index => $item)
                @php $opt = json_decode($item->options, true) ?? []; @endphp
                <tr>
                    <td class="col-no">{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $item->product_name }}</strong>
                        <ul style="margin: 5px 0 0 0; padding-left: 18px; list-style-type: disc; font-size: 11px; color: #666;">
                            @if(($opt['size_name'] ?? '-') != '-') <li>ขนาด: {{ $opt['size_name'] }}</li> @endif
                            @if(($opt['print_name'] ?? '-') != '-') <li>การพิมพ์: {{ $opt['print_name'] }}</li> @endif
                            @if(($opt['part_name'] ?? '-') != '-') <li>อุปกรณ์: {{ $opt['part_name'] }}</li> @endif
                        </ul>
                    </td>
                    <td style="text-align: right;">{{ number_format($item->price_per_unit, 2) }}</td>
                    <td style="text-align: center;">{{ number_format($item->quantity) }}</td>
                    <td class="col-price">{{ number_format($item->total_price, 2) }}</td>
                </tr>
                @endforeach
                @for($i = 0; $i < max(0, 4 - count($items)); $i++)
                <tr><td style="height: 35px;"></td><td></td><td></td><td></td><td></td></tr>
                @endfor
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" style="border: none;"></td>
                    <td colspan="2" class="bg-light-gray" style="text-align: right; font-weight: bold;">Subtotal</td>
                    <td class="col-price">{{ number_format($quotation->subtotal, 2) }}</td>
                </tr>
                @if($quotation->express_fee > 0)
                <tr>
                    <td colspan="2" style="border: none;"></td>
                    <td colspan="2" class="bg-light-gray" style="text-align: right; font-weight: bold;">Express fee</td>
                    <td class="col-price">{{ number_format($quotation->express_fee, 2) }}</td>
                </tr>
                @endif
                <tr>
                    <td colspan="2" style="border: none;"></td>
                    <td colspan="2" class="bg-summary" style="text-align: right;">Balance Due</td>
                    <td class="col-price bg-summary">{{ number_format($quotation->grand_total, 2) }} baht</td>
                </tr>
            </tfoot>
        </table>

        <div class="footer-tables-wrapper">
            <div class="footer-left-box">
                <div class="footer-title">PAYMENT METHOD</div>
                <table class="footer-info-table">
                    <tr><td>Bank's name</td><td>ไทยพาณิชย์ (SCB)</td></tr>
                    <tr><td>Bank number</td><td>191-213953-5</td></tr>
                    <tr><td>Account name</td><td>บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</td></tr>
                    <tr><td>Branch name</td><td>ถนนสาทร</td></tr>
                </table>
            </div>
            
            @if($quotation->tax_invoice_required)
            <div class="footer-right-box">
                <div class="footer-title">TAX INVOICE INFO</div>
                <table class="footer-info-table">
                    <tr><td>Tax Type</td><td>{{ $quotation->tax_person_type == 'individual' ? 'บุคคลธรรมดา' : 'นิติบุคคล' }}</td></tr>
                    @if($quotation->tax_person_type == 'juristic' && !empty($quotation->tax_company))
                        <tr><td>Company</td><td>{{ $quotation->tax_company }}</td></tr>
                    @endif
                    <tr><td>Tax Name</td><td>{{ $quotation->tax_name }}</td></tr>
                    <tr><td>Tax ID</td><td>{{ $quotation->tax_id }}</td></tr>
                    <tr>
                        <td>Address</td>
                        <td>
                            @php 
                                $fullTaxAddr = collect([
                                    $quotation->tax_address_no, 
                                    $quotation->tax_building,
                                    $quotation->tax_floor ? "ชั้น " . $quotation->tax_floor : null, 
                                    $quotation->tax_moo ? "หมู่ " . $quotation->tax_moo : null, 
                                    $quotation->tax_village,
                                    $quotation->tax_soi,
                                    $quotation->tax_road,
                                    $quotation->tax_sub_district,
                                    $quotation->tax_district,
                                    $quotation->tax_province,
                                    $quotation->tax_zipcode
                                ])->filter()->implode(' ');
                            @endphp
                            {{ $fullTaxAddr }}
                        </td>
                    </tr>
                </table>
            </div>
            @endif
        </div>

        <div class="terms-detail">
            <div style="font-size: 10px; color: #000; letter-spacing: 3px; margin-bottom: 10px; text-align: center;">T E R M S</div>
            <div class="terms-description">
                ราคาด้านบนเป็นราคาที่รวมค่าจัดส่งเรียบร้อยแล้ว ระยะเวลาการจัดส่งจะเป็นไปตามที่ระบุอยู่บนเว็บไซต์<br>
                หลังจากสั่งซื้อเรียบร้อยแล้วกรุณาโอนเงินภายใน 7 วัน สอบถามข้อมูลเพิ่มเติมที่ contact_hs@hotstrapthai.com
            </div>
        </div>
        
        @if(!empty($quotation->attachments))
        <div class="attachment-section no-print">
            <div class="footer-title">CUSTOMER ATTACHMENTS (ไฟล์แนบจากลูกค้า)</div>
            <div class="d-flex flex-wrap gap-2 mt-2">
                @php $files = json_decode($quotation->attachments, true) ?? []; @endphp
                @foreach($files as $file)
                    <a href="{{ asset('storage/'.$file) }}" target="_blank" class="btn btn-sm btn-outline-dark rounded-pill">
                        <i class="bi bi-file-earmark-arrow-down"></i> {{ basename($file) }}
                    </a>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>
@endsection