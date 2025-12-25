@extends('layouts.main')

@section('content')
<div class="accessories-outer-wrapper">
    <div class="page-container">
        <h2 class="accessories-main-title">อุปกรณ์เสริม</h2>

        <div class="accessories-content-box">
            
            {{-- กลุ่มที่ 1 --}}
            @if($standardHooks->isNotEmpty())
            <div class="accessory-section">
                <h3 class="accessory-type-title">ตะขอมาตราฐาน</h3>
                <div class="accessory-grid">
                    @foreach($standardHooks as $item)
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="{{ asset('images/jp-attachments/attachments/' . $item->image_url) }}" alt="{{ $item->part_name }}">
                        </div>
                        <p>{{ $item->part_name }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <hr class="design-divider">
            @endif

            {{-- กลุ่มที่ 2 --}}
            @if($otherHooks->isNotEmpty())
            <div class="accessory-section">
                <h3 class="accessory-type-title">ตะขอแบบอื่นๆ</h3>
                <div class="accessory-grid">
                    @foreach($otherHooks as $item)
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="{{ asset('images/jp-attachments/attachments/' . $item->image_url) }}" alt="{{ $item->part_name }}">
                        </div>
                        <p>
                            {{ $item->part_name }}@if($item->part_name == 'ห่วงไข่ปลา' && $item->color){{ $item->color }}@endif
                        </p>
                    </div>
                    @endforeach
                </div>
            </div>
            <hr class="design-divider">
            @endif

            {{-- กลุ่มที่ 3 --}}
            @if($standeeBases->isNotEmpty())
            <div class="accessory-section">
                <h3 class="accessory-type-title">ฐานรองสแตนดี้</h3>
                <div class="accessory-grid">
                    @foreach($standeeBases as $item)
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="{{ asset('images/jp-attachments/attachments/' . $item->image_url) }}" alt="{{ $item->part_name }}">
                        </div>
                        <p>{{ $item->part_name }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <hr class="design-divider">
            @endif

            {{-- กลุ่มที่ 4 --}}
            @if($clips->isNotEmpty())
            <div class="accessory-section">
                <h3 class="accessory-type-title">คลิปหนีบ</h3>
                <div class="accessory-grid">
                    @foreach($clips as $item)
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="{{ asset('images/jp-attachments/attachments/' . $item->image_url) }}" alt="{{ $item->part_name }}">
                        </div>
                        <p>{{ $item->part_name }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            <hr class="design-divider">
            @endif

            {{-- กลุ่มที่ 5 --}}
            @if($otherParts->isNotEmpty())
            <div class="accessory-section">
                <h3 class="accessory-type-title">ส่วนประกอบอื่นๆ</h3>
                <div class="accessory-grid">
                    @foreach($otherParts as $item)
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="{{ asset('images/jp-attachments/attachments/' . $item->image_url) }}" alt="{{ $item->part_name }}">
                        </div>
                        <p>{{ $item->part_name }}</p>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>
@endsection