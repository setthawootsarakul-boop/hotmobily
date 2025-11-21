<section class="product-showcase-section py-5" style="background-color: #F6F1E9;">
    <div class="container">
        
        <div class="text-center mb-5">
            <h2 class="fw-bold section-title">สินค้าของเรา</h2>
            <div class="title-underline mx-auto"></div>
        </div>

        <div class="row g-4">

            <div class="col-12 col-md-4 text-center">
                <a href="{{ route('products.index', ['category' => 1]) }}" class="d-block text-decoration-none product-showcase-item">
                    <div class="showcase-box mb-3">
                        <div class="img-wrapper">
                            <img src="{{ asset('images/Hotmobilyfile/Top-page/357-04.jpg') }}" alt="พวงกุญแจ" class="img-fluid showcase-img">
                        </div>
                    </div>
                    <h5 class="showcase-title mt-2">พวงกุญแจ</h5>
                    <p class="showcase-desc text-muted small">
                        พวงกุญแจอะคริลิค พวงกุญแจยาง พวงกุญแจสะท้อนแสง
                    </p>
                </a>
            </div>

            <div class="col-12 col-md-4 text-center">
                <a href="{{ route('products.index', ['category' => 7]) }}" class="d-block text-decoration-none product-showcase-item">
                    <div class="showcase-box mb-3">
                        <div class="img-wrapper">
                            <img src="{{ asset('images/Hotmobilyfile/Top-page/357-02.jpg') }}" alt="ที่รองแก้ว" class="img-fluid showcase-img">
                        </div>
                    </div>
                    <h5 class="showcase-title mt-2">ที่รองแก้ว</h5>
                    <p class="showcase-desc text-muted small">
                        ที่รองแก้วอะคริลิค ที่รองแก้วยาง
                    </p>
                </a>
            </div>

            <div class="col-12 col-md-4 text-center">
                <a href="{{ route('products.index', ['category' => 9]) }}" class="d-block text-decoration-none product-showcase-item">
                    <div class="showcase-box mb-3">
                        <div class="img-wrapper">
                            <img src="{{ asset('images/Hotmobilyfile/Top-page/357-08.jpg') }}" alt="สแตนดี้" class="img-fluid showcase-img">
                        </div>
                    </div>
                    <h5 class="showcase-title mt-2">สแตนดี้</h5>
                    <p class="showcase-desc text-muted small">
                        สแตนดี้อะคริลิค
                    </p>
                </a>
            </div>

            {{-- <div class="col-12 col-md-4 text-center">
                <a href="{{ route('products.index', ['category' => 8]) }}" class="d-block text-decoration-none product-showcase-item">
                    <div class="showcase-box mb-3">
                        <div class="img-wrapper">
                            <img src="{{ asset('images/Hotmobilyfile/Top-page/.jpg') }}" alt="แท่นวางโทรศัพท์" class="img-fluid showcase-img">
                        </div>
                    </div>
                    <h5 class="showcase-title mt-2">แท่นวางโทรศัพท์</h5>
                    <p class="showcase-desc text-muted small">
                        แท่นวางโทรศัพท์อะคริลิค
                    </p>
                </a>
            </div> --}}

            <div class="col-12 col-md-4 text-center">
                <a href="{{ route('products.index', ['category' => 2]) }}" class="d-block text-decoration-none product-showcase-item">
                    <div class="showcase-box mb-3">
                        <div class="img-wrapper">
                            <img src="{{ asset('images/Hotmobilyfile/Top-page/357-06.jpg') }}" alt="เข็มกลัด" class="img-fluid showcase-img">
                        </div>
                    </div>
                    <h5 class="showcase-title mt-2">เข็มกลัด</h5>
                    <p class="showcase-desc text-muted small">
                        เข็มกลัดอะคริลิค
                    </p>
                </a>
            </div>

            <div class="col-12 col-md-4 text-center">
                <a href="{{ route('products.index', ['category' => 3]) }}" class="d-block text-decoration-none product-showcase-item">
                    <div class="showcase-box mb-3">
                        <div class="img-wrapper">
                            <img src="{{ asset('images/Hotmobilyfile/Top-page/357-05.jpg') }}" alt="ยางรัดผม" class="img-fluid showcase-img">
                        </div>
                    </div>
                    <h5 class="showcase-title mt-2">ยางรัดผม</h5>
                    <p class="showcase-desc text-muted small">
                        ยางรัดผมอะคริลิค
                    </p>
                </a>
            </div>

            <div class="col-12 col-md-4 text-center">
                <a href="{{ route('products.index', ['category' => 4]) }}" class="d-block text-decoration-none product-showcase-item">
                    <div class="showcase-box mb-3">
                        <div class="img-wrapper">
                            <img src="{{ asset('images/Hotmobilyfile/Top-page/griptok-3b.jpg') }}" alt="กริ๊บต๊อก" class="img-fluid showcase-img">
                        </div>
                    </div>
                    <h5 class="showcase-title mt-2">กริ๊บต๊อก</h5>
                    <p class="showcase-desc text-muted small">
                        กริ๊บต๊อกติดโทรศัพท์อะคริลิค
                    </p>
                </a>
            </div>

            <div class="col-12 col-md-4 text-center">
                <a href="{{ route('products.index', ['category' => 5]) }}" class="d-block text-decoration-none product-showcase-item">
                    <div class="showcase-box mb-3">
                        <div class="img-wrapper">
                            <img src="{{ asset('images/Hotmobilyfile/Top-page/357-01.jpg') }}" alt="ยางหุ้มกุญแจ" class="img-fluid showcase-img">
                        </div>
                    </div>
                    <h5 class="showcase-title mt-2">ยางหุ้มกุญแจ</h5>
                    <p class="showcase-desc text-muted small">
                        ยางหุ้มหัวกุญแจ
                    </p>
                </a>
            </div>

            <div class="col-12 col-md-4 text-center">
                <a href="{{ route('products.index', ['category' => 6]) }}" class="d-block text-decoration-none product-showcase-item">
                    <div class="showcase-box mb-3">
                        <div class="img-wrapper">
                            <img src="{{ asset('images/Hotmobilyfile/Top-page/357-03.jpg') }}" alt="สติ๊กเกอร์" class="img-fluid showcase-img">
                        </div>
                    </div>
                    <h5 class="showcase-title mt-2">สติ๊กเกอร์</h5>
                    <p class="showcase-desc text-muted small">
                        สติ๊กเกอร์สะท้อนแสง
                    </p>
                </a>
            </div>

        </div>
    </div>
</section>