<footer class="footer-section text-light pt-5"> 
  <div class="footer-box">
    <div class="container pb-4">
      <div class="row gy-4 align-items-stretch">
        
        <div class="col-md-4 text-center text-md-start footer-company">
          <img src="{{ asset('images/logo.png') }}" alt="Hotmobily Logo" class="footer-logo mb-3">
          
          <p class="mb-2">บริษัท ยู แอนด์ เอิร์ธ (ไทยแลนด์) จำกัด</p>
          <p class="mb-2">(จันทร์ - ศุกร์ 8.30 - 17.30)</p>
          
          <p class="mb-2">
            ที่อยู่ : 23/34-35<br>
            อาคารโครงการเดอะโฟร์ม หัวลำโพง<br>
            อาคาร A ห้องเลขที่ 303 ชั้นที่ 3<br>
            ซอยสุกร แขวงตลาดน้อย<br>
            เขตสัมพันธวงศ์ กรุงเทพมหานคร<br>
            10100
          </p>
          
          <p class="mt-2">
            โทร : <a href="tel:0646045614">064-604-5614</a>
          </p>
        </div>

        <div class="col-md-4 text-center text-md-start footer-subscribe">
          <h5 class="fw-bold mb-3">สมัครสมาชิกเพื่อรับข่าวสาร</h5>
          <p class="small mb-3">รับโปรโมชั่นลับพิเศษและข่าวสารใหม่ๆ จากเราได้ก่อนใคร</p>
          <form class="d-flex">
            <input type="email" class="form-control me-2" placeholder="ระบุอีเมลของคุณ" required>
            <button type="submit" class="btn btn-warning fw-semibold px-3">สมัครเลย</button>
          </form>
        </div>

        <div class="col-md-4 text-center text-md-start footer-social">
          <div class="social-icons">
            <a href="#"><img src="{{ asset('images/fb.png') }}" class="social-img" alt="Facebook"></a>
            <a href="#"><img src="{{ asset('images/line.png') }}" class="social-img" alt="LINE"></a>
            <a href="#"><img src="{{ asset('images/x.jpg') }}" class="social-img" alt="X"></a>
            <a href="#"><img src="{{ asset('images/gmail.jpg') }}" class="social-img" alt="Gmail"></a>
          </div>
          <p>Line : <span>hotstrapthai</span></p>
          <img src="{{ asset('images/line-qr.png') }}" alt="Line QR Code" class="qr-code">
        </div>

      </div>
    </div>

    <div class="footer-links-section py-3"> 
      <div class="container text-center">
        <div class="footer-links d-flex flex-wrap justify-content-center align-items-center">
          
          <a href="#">สินค้าทั้งหมด</a> <span class="divider">|</span>
          <a href="#">วิธีการสั่งสินค้า</a> <span class="divider">|</span>
          <a href="#">วิธีการชำระเงิน</a> <span class="divider">|</span>
          <a href="#">วิธีการออกแบบ</a> <span class="divider">|</span>
          <a href="#">วิธีการยกเลิกสินค้า</a> <span class="divider">|</span>
          <a href="#">ระยะเวลาการจัดส่ง</a> <span class="divider">|</span>
          <div class="w-100 d-none d-lg-block my-1"></div>
          <a href="#">แจ้งชำระเงิน</a> <span class="divider">|</span>
          <a href="#">อุปกรณ์เสริม</a> <span class="divider">|</span>
          <a href="#">แคตตาล็อก</a> <span class="divider">|</span>
          <a href="#">ติดต่อเรา</a> <span class="divider">|</span>
          <a href="#">คำถามที่พบบ่อย</a> <span class="divider">|</span>
          <a href="#">นโยบายคุกกี้</a>

        </div>
      </div>
    </div>

    <div class="footer-bottom-section">
      <p>Copyright © 2025 YOU AND EARTH (THAILAND) CO., LTD.</p>
    </div>
  </div>

  <button type="button" class="btn btn-warning btn-back-to-top" id="btn-back-to-top">
    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-arrow-up" viewBox="0 0 16 16">
      <path fill-rule="evenodd" d="M8 15a.5.5 0 0 0 .5-.5V2.707l3.146 3.147a.5.5 0 0 0 .708-.708l-4-4a.5.5 0 0 0-.708 0l-4 4a.5.5 0 1 0 .708.708L7.5 2.707V14.5a.5.5 0 0 0 .5.5z"/>
    </svg>
  </button>

</footer>

<style>
  .btn-back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    display: none; /* ซ่อนไว้ก่อน */
    z-index: 9999; /* อยู่บนสุด */
    border-radius: 50%; /* ปุ่มกลม */
    width: 50px;
    height: 50px;
    box-shadow: 0 4px 6px rgba(0,0,0,0.3);
    color: #333; /* สีไอคอน */
    transition: transform 0.3s ease;
  }

  .btn-back-to-top:hover {
    transform: translateY(-5px); /* ขยับขึ้นเล็กน้อยเมื่อชี้ */
    color: #000;
  }
</style>

<script>
  // ดึงปุ่มมาเก็บในตัวแปร
  let mybutton = document.getElementById("btn-back-to-top");

  // เมื่อมีการ Scroll ให้ทำงานฟังก์ชัน
  window.onscroll = function () {
    scrollFunction();
  };

  function scrollFunction() {
    // ถ้าเลื่อนลงมามากกว่า 300px ให้แสดงปุ่ม
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
      mybutton.style.display = "block";
    } else {
      mybutton.style.display = "none";
    }
  }

  // เมื่อกดปุ่ม ให้เลื่อนขึ้นบนสุด
  mybutton.addEventListener("click", backToTop);

  function backToTop() {
    window.scrollTo({
      top: 0,
      behavior: "smooth" // เลื่อนแบบนุ่มนวล
    });
  }
</script>