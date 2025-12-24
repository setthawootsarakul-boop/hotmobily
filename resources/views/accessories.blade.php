@extends('layouts.main')

@section('content')
<div class="accessories-outer-wrapper">
    <div class="page-container">
        <h2 class="accessories-main-title">อุปกรณ์เสริม</h2>

        <div class="accessories-content-box">
            
            {{-- กลุ่มที่ 1: ตะขอมาตราฐาน --}}
            <div class="accessory-section">
                <h3 class="accessory-type-title">ตะขอมาตราฐาน</h3>
                <div class="accessory-grid">
                    @foreach($standardHooks as $item)
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        </div>
                        <p>{{ $item->name }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <hr class="design-divider">

            {{-- กลุ่มที่ 2: ตะขอแบบอื่นๆ --}}
            <div class="accessory-section">
                <h3 class="accessory-type-title">ตะขอแบบอื่นๆ</h3>
                <div class="accessory-grid">
                    @foreach($otherHooks as $item)
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        </div>
                        <p>{{ $item->name }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <hr class="design-divider">

            {{-- กลุ่มที่ 3: ฐานรองสแตนดี้ --}}
            <div class="accessory-section">
                <h3 class="accessory-type-title">ฐานรองสแตนดี้</h3>
                <div class="accessory-grid">
                    @foreach($standeeBases as $item)
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        </div>
                        <p>{{ $item->name }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <hr class="design-divider">

            {{-- กลุ่มที่ 4: คลิปหนีบ --}}
            <div class="accessory-section">
                <h3 class="accessory-type-title">คลิปหนีบ</h3>
                <div class="accessory-grid">
                    @foreach($clips as $item)
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        </div>
                        <p>{{ $item->name }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

            <hr class="design-divider">

            {{-- กลุ่มที่ 5: ส่วนประกอบอื่นๆ --}}
            <div class="accessory-section">
                <h3 class="accessory-type-title">ส่วนประกอบอื่นๆ</h3>
                <div class="accessory-grid">
                    @foreach($otherParts as $item)
                    <div class="accessory-item">
                        <div class="image-box">
                            <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                        </div>
                        <p>{{ $item->name }}</p>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</div>
@endsection