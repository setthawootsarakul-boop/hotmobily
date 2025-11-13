<section id="steps" class="py-5" style="background-color: #F6F1E9;">
  <div class="container text-center">
    
    

    <div class="row justify-content-center g-4">

      <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-center">
        <a href="{{ url('/contact-full') }}" class="contact-btn-wrapper">
          <img src="{{ asset('images/Hotmobily file/Top page/btn-quote.png') }}" 
               alt="ขอใบเสนอราคา" 
               class="img-fluid contact-btn-img">
        </a>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-center">
        <div class="contact-btn-wrapper" 
             style="cursor: pointer;"
             data-bs-toggle="modal" 
             data-bs-target="#callModal">
          <img src="{{ asset('images/Hotmobily file/Top page/call.png') }}" 
               alt="โทรหาเรา" 
               class="img-fluid contact-btn-img">
        </div>
      </div>

      <div class="col-lg-4 col-md-4 col-sm-12 d-flex justify-content-center">
        <div class="contact-btn-wrapper" 
             style="cursor: pointer;"
             data-bs-toggle="modal" 
             data-bs-target="#lineModal">
          <img src="{{ asset('images/Hotmobily file/Top page/line.png') }}" 
               alt="แอดไลน์" 
               class="img-fluid contact-btn-img">
        </div>
      </div>

    </div>
  </div>

  <div class="modal fade" id="callModal" tabindex="-1" aria-labelledby="callModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-4 shadow-lg p-3" style="border-radius: 20px;">
        <div class="modal-header border-0">
          <h3 class="fw-bold w-100 text-center mb-0" id="callModalLabel">โทรหาเรา</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <p class="text-muted mb-4">คุณสามารถติดต่อเราได้ที่เบอร์ :</p>
          <div class="d-grid gap-3 justify-content-center">
            <a href="tel:0646045614" class="btn btn-outline-success d-flex align-items-center justify-content-center fw-semibold" style="width: 250px; border-radius: 8px;">
              <i class="bi bi-telephone-fill me-2"></i> 064-604-5614
            </a>
            <a href="tel:026378995" class="btn btn-outline-success d-flex align-items-center justify-content-center fw-semibold" style="width: 250px; border-radius: 8px;">
              <i class="bi bi-telephone-fill me-2"></i> 02-637-8995
            </a>
            <a href="tel:026378997" class="btn btn-outline-success d-flex align-items-center justify-content-center fw-semibold" style="width: 250px; border-radius: 8px;">
              <i class="bi bi-telephone-fill me-2"></i> 02-637-8997
            </a>
          </div>
          <button type="button" class="btn fw-bold mt-4 text-white px-5" style="background: linear-gradient(to right, #b07f27, #7b5b10); border-radius: 10px;" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

  <div class="modal fade" id="lineModal" tabindex="-1" aria-labelledby="lineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content border-0 rounded-4 shadow-lg p-3" style="border-radius: 20px;">
        <div class="modal-header border-0">
          <h3 class="fw-bold w-100 text-center mb-0" id="lineModalLabel">สแกน QR</h3>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body text-center">
          <p class="text-muted mb-4">สแกนรหัส QR เพื่อเชื่อมต่อกับเรา</p>
          <img src="{{ asset('images/line-qr.png') }}" alt="Line QR" class="img-fluid mb-3" style="max-width: 220px; border-radius: 8px;">
          <p class="fw-semibold mb-3">Line : <span class="text-success">hotstrapthai</span></p>
          <button type="button" class="btn fw-bold text-white px-5" style="background: linear-gradient(to right, #b07f27, #7b5b10); border-radius: 10px;" data-bs-dismiss="modal">ปิด</button>
        </div>
      </div>
    </div>
  </div>

</section>