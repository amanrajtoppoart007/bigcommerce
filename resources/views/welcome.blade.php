@extends("user.layout.app")
@section("content")
    <section id="hero" class="d-flex align-items-center">
        <div class="container">

            <div class="row">
                <div class="col-lg-6 d-flex flex-column justify-content-center pt-4 pt-lg-0 order-2 order-lg-1"
                     data-aos="fade-up" data-aos-delay="200">
                    <h2>आपकी सभी कृषि जरूरतों का एक समाधान</h2>
                    <h3>हम किसानों की सभी खेती की जरूरतों के लिए व्यापक समाधान प्रदान करते हैं। हम खेती के क्षेत्र में
                        छोटे व्यवसाय के मालिक के लिए भी शानदार अवसर प्रदान करते हैं</h3>
                    <div class="d-lg-flex">
                        <a href="#about" class="btn-get-started scrollto">हमसे जुड़ें</a>
                        <a href="https://www.youtube.com/watch?v=jDDaplaOz7Q" class="venobox btn-watch-video"
                           data-vbtype="video" data-autoplay="true"> वीडियो देखें <i class="icofont-play-alt-2"></i></a>
                    </div>
                </div>
                <div class="col-lg-6 order-1 order-lg-2 hero-img" data-aos="zoom-in" data-aos-delay="200">
                    <img src="{{asset('assets/img/farmer.png')}}" class="img-fluid animated" alt="">
                </div>
            </div>
        </div>
    </section>
@endsection
