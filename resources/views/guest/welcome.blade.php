<!DOCTYPE html>
<html>

<head>
    <!-- Meta Tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Krishak Vikas">
    <meta name="theme-color" content="#38b000">

    <!-- Google Fonts Poppins light -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Glegoo:wght@400;700&display=swap" rel="stylesheet">

    <!-- Bootstrap CDN -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css"
          integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/bootstrap/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/assets/css/index.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('assets/assets/css/theme-color.css')}}">

    <!-- Slick Slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"
          integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css"
          integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg=="
          crossorigin="anonymous"/>

    <!-- AOS -->
    <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css"/>
    <!-- Website Title -->
    <title>Krishak Vikas | A One Stop Solution For All Your Farming Needs</title>

</head>

<body>
<!-- Header (Start) -->
@include('guest.includes.navbar')
<!-- Header (End) -->
<section id="preloader-section">
    <div class="container">
        <div class="preloader"></div>
    </div>
</section>

<!-- Main (Start) -->
<main data-aos="fade-in">

    <!-- Section First (Start) -->
    <section id="home-section">
        <br>
        <div class="container">


            <!-- Introduction Title (Start) -->
            <div class="text-center" data-aos="zoom-in">
                <h1 class="font-weight-bold display-4 text-white">एक दुकान सम्पूर्ण समाधान</h1>
                <p class="description-1 text-light mt-3 font-weight-bolder">किसान भाइयों की सभी आवश्यकता एवं समस्या का
                    त्वरित निदान मोबाइल के एक क्लिक से </p>
                <a href="{{ route('register') }}" class="btn btn-lg btn-theme-1 shadow px-4 py-2 mt-3">हमसे जुड़ें<img
                        src="{{asset('assets/assets/icons/circle-arrow.svg')}}" class="btn-icon" alt="arrow-right"></a>
            </div>
            <!-- Introduction Title (End) -->

            <!-- Services Carousel (Start) -->
            <div class="services-slider mt-5">

                <!-- Card 1 -->
                <div class="card services-card m-3" data-aos="zoom-in">
                    <div class="card-body text-center" align="center">
                        <img src="{{asset('assets/assets/icons/services-icon/chemical.svg')}}" alt="chemical"
                             class="img-fluid mx-auto service-img">
                        <h5 class="text-theme-1 font-weight-bolder mt-3">मिट्टी को पहचानिये</h5>
                        <a href="{{route('solutions','farmer#knowTheSoil')}}"
                           class="btn btn-sm btn-theme-1 shadow px-4 py-2 mt-2">मिट्टी जाँच एवं स्कोर कार्ड<img
                                src="{{asset('assets/assets/icons/circle-arrow.svg')}}" class="btn-icon d-inline-block"
                                alt="arrow-right"></a>
                    </div>
                </div>

                <!-- Card 2 -->
                <div class="card services-card m-3" data-aos="zoom-in">
                    <div class="card-body text-center" align="center">
                        <img src="{{asset('assets/assets/icons/services-icon/atom.svg')}}" alt="atom"
                             class="img-fluid mx-auto service-img">
                        <h5 class="text-theme-1 font-weight-bolder mt-3">कृषि विज्ञान का चमत्कार</h5>
                        <a href="{{route('solutions','farmer#AgriScienceMagic')}}"
                           class="btn btn-sm btn-theme-1 shadow px-4 py-2 mt-2">कम्प्यूटरीकृत विश्लेषण<img
                                src="{{asset('assets/assets/icons/circle-arrow.svg')}}" class="btn-icon d-inline-block"
                                alt="arrow-right"></a>
                    </div>
                </div>

                <!-- Card 3 -->
                <div class="card services-card m-3" data-aos="zoom-in">
                    <div class="card-body text-center" align="center">
                        <img src="{{asset('assets/assets/icons/services-icon/support.svg')}}" alt="support"
                             class="img-fluid mx-auto service-img">
                        <h5 class="text-theme-1 font-weight-bolder mt-3">कृषि परामर्श एक क्लिक में</h5>
                        <a href="{{route('solutions','farmer#knowTheSoil')}}"
                           class="btn btn-sm btn-theme-1 shadow px-4 py-2 mt-2">हेल्पलाइन तथा सहायता<img
                                src="{{asset('assets/assets/icons/circle-arrow.svg')}}" class="btn-icon d-inline-block"
                                alt="arrow-right"></a>
                    </div>
                </div>

                <!-- Card 4 -->
                <div class="card services-card m-3" data-aos="zoom-in">
                    <div class="card-body text-center" align="center">
                        <img src="{{asset('assets/assets/icons/services-icon/cart.svg')}}" alt="cart"
                             class="img-fluid mx-auto service-img">
                        <h5 class="text-theme-1 font-weight-bolder mt-3">कृषि उत्पाद मंगाइये</h5>
                        <a href="{{route('solutions','farmer#knowTheSoil')}}"
                           class="btn btn-sm btn-theme-1 shadow px-4 py-2 mt-2">बीज, खाद, दवाइयां<img
                                src="{{asset('assets/assets/icons/circle-arrow.svg')}}" class="btn-icon d-inline-block"
                                alt="arrow-right"></a>
                    </div>
                </div>

                <!-- Card 5 -->
                <div class="card services-card m-3" data-aos="zoom-in">
                    <div class="card-body text-center" align="center">
                        <img src="{{asset('assets/assets/icons/services-icon/finance.svg')}}" alt="finance"
                             class="img-fluid mx-auto service-img">
                        <h5 class="text-theme-1 font-weight-bolder mt-3">कृषि फाइनैंसिंग</h5>
                        <a href="{{route('solutions','farmer#knowTheSoil')}}"
                           class="btn btn-sm btn-theme-1 shadow px-4 py-2 mt-2">बीमा तथा लोन<img
                                src="{{asset('assets/assets/icons/circle-arrow.svg')}}" class="btn-icon d-inline-block"
                                alt="arrow-right"></a>
                    </div>
                </div>

                <!-- Card 6 -->
                <div class="card services-card m-3" data-aos="zoom-in">
                    <div class="card-body text-center" align="center">
                        <img src="{{asset('assets/assets/icons/services-icon/rupee.svg')}}" alt="rupee"
                             class="img-fluid mx-auto service-img">
                        <h5 class="text-theme-1 font-weight-bolder mt-3">कृषि बाज़ार</h5>
                        <a href="{{route('solutions','farmer#Benefit')}}"
                           class="btn btn-sm btn-theme-1 shadow px-4 py-2 mt-2">उपज का ज्यादा मूल्य<img
                                src="{{asset('assets/assets/icons/circle-arrow.svg')}}" class="btn-icon d-inline-block"
                                alt="arrow-right"></a>
                    </div>
                </div>

            </div>
            <!-- Services Carousel (End) -->

        </div>
        <br>
    </section>
    <!-- Section First (End) -->

</main>
<!-- Main (End) -->

@include('guest.includes.footer')
<!-- Jquery (Start) -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"
        integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ=="
        crossorigin="anonymous"></script>
<script>
    $(document).ready(function () {

        $('#preloader-section').hide();

    });
</script>
<!-- Jquery (End) -->

<!-- Slick Slider -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
        integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
        crossorigin="anonymous"></script>
<script>
    $('.services-slider').slick({
        arrows: true,
        autoplay: true,
        autoplaySpeed: 2000,
        infinite: true,
        speed: 700,
        slidesToShow: 3,
        slidesToScroll: 3,
        responsive: [
            {
                breakpoint: 1024,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2,
                    infinite: true,
                    dots: true
                }
            },
            {
                breakpoint: 600,
                settings: {
                    slidesToShow: 2,
                    slidesToScroll: 2
                }
            },
            {
                breakpoint: 480,
                settings: {
                    slidesToShow: 1,
                    slidesToScroll: 1
                }
            }]
    });

</script>

<!-- AOS Script -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>
<script>
    AOS.init({
        offset: 150,
        duration: 700
    });
</script>

</body>
</html>
