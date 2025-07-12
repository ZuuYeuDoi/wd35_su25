@extends('client.index')

@section('content')
<!-- Start main-content -->
<section class="page-title" style="background-image: url({{ asset('client/images/background/page-title-bg.png') }});">
  <div class="auto-container">
    <div class="title-outer text-center">
      <h1 class="title">Giới thiệu</h1>
      <ul class="page-breadcrumb">
        <li><a href="index.html">Trang Chủ</a></li>
        <li>Giới Thiệu</li>
      </ul>
    </div>
  </div>
</section>
<!-- end main-content -->

<!-- About Section -->
<section class="about-section">
  <div class="auto-container">
    <div class="row">
      <!-- Content Column -->
      <div class="content-column col-lg-6 order-lg-2 wow fadeInRight" data-wow-delay="600ms">
        <div class="inner-column">
          <div class="sec-title">
            <span class="sub-title style-two">Giới Thiệu</span>
            <h2>Chúng Tôi Cung Cấp <br />Hoạt Động Ngoài Trời Cho Mọi Người</h2>
            <div class="text-2">Chúng tôi tổ chức các hoạt động trên toàn thế giới trong nhiều lĩnh vực dịch vụ khách sạn khác nhau.</div>
            <div class="text">Với hơn 40 năm kinh nghiệm cung cấp giải pháp cho các doanh nghiệp lớn trên toàn cầu, chúng tôi mang đến dịch vụ hậu cần toàn diện phù hợp với từng thị trường cụ thể.</div>
          </div>
          <ul class="list-style-two">
            <li><i class="icon fa fa-circle-check"></i> Giới thiệu dịch vụ tốt nhất của Revauto.</li>
            <li><i class="icon fa fa-circle-check"></i> Nêu bật các dự án nổi bật của Revauto.</li>
            <li><i class="icon fa fa-circle-check"></i> Tuyên bố sứ mệnh và triết lý hoạt động của Revauto.</li>
          </ul>
          <div class="btn-box">
            <a href="page-about.html" class="theme-btn btn-style-four"><span class="btn-title">Khám Phá Thêm</span></a>
          </div>
        </div>
      </div>
      <!-- Image Column -->
      <div class="image-column col-md-8 col-lg-6">
        <div class="inner-column wow fadeInLeft">
          <figure class="image-1"><img src="{{ asset('client/images/resource/about1-1.jpg') }}" alt=""></figure>
          <figure class="image-2"><img src="{{ asset('client/images/resource/about1-2.jpg') }}" alt=""></figure>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End About Section -->

<!-- Marquee Section -->
<section class="marquee-section pt-0">
  <div class="marquee marquee-style-one">
    <div class="marquee-group">
      <div class="text text-style2" data-text="ĐẶT PHÒNG">Phòng & Suite</div>
      <span class="text divider "> <i class="icon fa fa-star"></i> </span>
      <div class="text" data-text="TOUR">Dịch vụ Khách sạn</div>
      <span class="text divider "> <i class="icon fa fa-star"></i> </span>
      <div class="text text-style2" data-text="TRỰC TUYẾN">Đặt phòng trực tuyến</div>
      <span class="text divider "> <i class="icon fa fa-star"></i> </span>
      <div class="text" data-text="ĐẶT TRƯỚC">Dịch vụ Đặt trước</div>
      <span class="text divider "> <i class="icon fa fa-star"></i> </span>
    </div>
  </div>
</section>
<!-- End Marquee Section -->

<!-- Features Section Two -->
<section class="feature-section-two pb-0">
    <div class="auto-container">
      <div class="row feature-row g-0">
        <div class="image-column col-lg-6">
          <div class="inner-column">
            <div class="image-box">
              <figure class="image overlay-anim wow reveal-right"><img src="{{ asset('client/images/resource/feature2-1.jpg') }}" alt=""></figure>
            </div>
          </div>
        </div>
        <div class="content-column col-lg-6" >
          <div class="inner-column">
            <div class="content-box">
              <div class="sec-title">
                <span class="sub-title">KHÁM PHÁ</span>
                <h2>Nhà Hàng</h2>
                <div class="text">Với hệ thống du thuyền sang trọng và dịch vụ cao cấp, chúng tôi cam kết mang đến trải nghiệm ẩm thực tuyệt vời nhất!</div>
              </div>
              <a href="room-details.html" class="theme-btn btn-style-two read-more">XEM THÊM</a>
            </div>
          </div>
        </div>
      </div>
      <div class="row feature-row g-0">
        <div class="content-column col-lg-6">
          <div class="inner-column">
            <div class="content-box">
              <div class="sec-title">
                <span class="sub-title">TRẢI NGHIỆM</span>
                <h2>Trung Tâm Spa</h2>
                <div class="text">Với đội ngũ chuyên nghiệp và không gian thư giãn, chúng tôi mang đến trải nghiệm spa đẳng cấp tại Santorini!</div>
              </div>
              <a href="room-details.html" class="theme-btn btn-style-two read-more">XEM THÊM</a>
            </div>
          </div>
        </div>
        <div class="image-column col-lg-6">
          <div class="inner-column">
            <div class="image-box">
              <figure class="image overlay-anim wow reveal-left"><img src="{{ asset('client/images/resource/feature2-2.jpg') }}" alt=""></figure>
            </div>
          </div>
        </div>
      </div>
      <div class="row feature-row g-0">
       <div class="image-column col-lg-6">
          <div class="inner-column">
            <div class="image-box">
              <figure class="image overlay-anim wow reveal-right"><img src="{{ asset('client/images/resource/feature2-3.jpg') }}" alt=""></figure>
            </div>
          </div>
        </div>
        <div class="content-column col-lg-6">
          <div class="inner-column">
            <div class="content-box">
              <div class="sec-title">
                <span class="sub-title">HIỆN ĐẠI</span>
                <h2>Phòng Tập Gym</h2>
                <div class="text">Với trang thiết bị hiện đại và không gian tập luyện lý tưởng, chúng tôi mang đến trải nghiệm thể thao tuyệt vời!</div>
              </div>
              <a href="room-details.html" class="theme-btn btn-style-two read-more">XEM THÊM</a>
            </div> 
          </div>
        </div> 
      </div>
    </div>
</section>

<!-- End Features Section -->

<!-- Funfact Section -->
<section class="funfact-section-two">
  <div class="outer-box">
    <div class="auto-container">
      <div class="fact-counter">
        <div class="row">
          <div class="counter-block-two col-lg-3 col-sm-6">
            <div class="inner-box">
              <div class="count-box"><span class="count-text" data-speed="3000" data-stop="20">0</span></div>
              <div class="counter-text">Năm <br/> Kinh Nghiệm</div>
            </div>
          </div>
          <div class="counter-block-two col-lg-3 col-sm-6">
            <div class="inner-box">
              <div class="count-box"><span class="count-text" data-speed="3000" data-stop="10">0</span></div>
              <div class="counter-text">Lượt Đặt <br/> Trực Tuyến</div>
            </div>
          </div>
          <div class="counter-block-two col-lg-3 col-sm-6">
            <div class="inner-box">
              <div class="count-box"><span class="count-text" data-speed="3000" data-stop="40">0</span></div>
              <div class="counter-text">Nhân Viên <br/> Dày Dạn</div>
            </div>
          </div>
          <div class="counter-block-two col-lg-3 col-sm-6">
            <div class="inner-box">
              <div class="count-box"><span class="count-text" data-speed="3000" data-stop="30">0</span></div>
              <div class="counter-text">Giải Thưởng <br/> Khách Sạn</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Funfact Section -->

<!-- Testimonial Section -->
<section class="testimonial-section-five pt-0">
  <div class="auto-container">
    <div class="sec-title text-center">
      <span class="sub-title">Phản Hồi Khách Hàng</span>
      <h2>Khách Hàng Nói Gì?</h2>
    </div>
    <div class="row">
      <div class="testimonial-block-five col-lg-4 col-sm-6">
        <div class="inner-box">
          <div class="content-box">
            <span class="icon fa fa-quote-right"></span>
            <div class="text">“Tôi rất hài lòng với chất lượng dịch vụ và đội ngũ nhân viên thân thiện tại đây.”</div>
          </div>
          <div class="info-box">
            <figure class="thumb"><img src="{{asset('client/images/resource/testi2-thumb1.png') }}" alt=""></figure>
            <div>
              <span class="designation">Nhà Sáng Lập</span>
              <div class="name">Nguyễn Văn Toản</div>
            </div>
          </div>
        </div>
      </div>
      <div class="testimonial-block-five col-lg-4 col-sm-6">
        <div class="inner-box">
          <div class="content-box">
            <span class="icon fa fa-quote-right"></span>
            <div class="text">“Dịch vụ chuyên nghiệp, trải nghiệm tuyệt vời và đáng nhớ.”</div>
          </div>
          <div class="info-box">
            <figure class="thumb"><img src="{{ asset('client/images/resource/testi2-thumb2.png') }}" alt=""></figure>
            <div>
              <span class="designation">Kỹ Sư</span>
              <div class="name">Trần Thị Nhung</div>
            </div>
          </div>
        </div>
      </div>
      <div class="testimonial-block-five col-lg-4 col-sm-6">
        <div class="inner-box">
          <div class="content-box">
            <span class="icon fa fa-quote-right"></span>
            <div class="text">“Spa và Gym đều rất tuyệt vời. Tôi sẽ quay lại lần sau!”</div>
          </div>
          <div class="info-box">
            <figure class="thumb"><img src="{{ asset('client/images/resource/testi2-thumb1.png') }}" alt=""></figure>
            <div>
              <span class="designation">Kiến Trúc Sư</span>
              <div class="name">Lê Minh Quang</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!-- End Testimonial Section -->

@endsection
