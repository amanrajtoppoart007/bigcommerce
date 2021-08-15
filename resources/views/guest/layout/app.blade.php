<!DOCTYPE html>
<html lang="en">

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

    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/css/select2.min.css" rel="stylesheet" />
    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/theme-color.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/about.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/contact.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/carrier.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/panjikaran.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/krishisamadhan.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/registration.css') }}">

    <!-- Slick Slider -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.css"
          integrity="sha512-wR4oNhLBHf7smjy0K4oqzdWumd+r5/+6QO/vDda76MW5iug4PT7v86FoEkySIJft3XA0Ae6axhIvHrqwm793Nw=="
          crossorigin="anonymous"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick-theme.css"
          integrity="sha512-6lLUdeQ5uheMFbWm3CP271l14RsX1xtx+J5x2yeIDkkiBpeVTNhTqijME7GgRKKi6hCqovwCoBTlRBEC20M8Mg=="
          crossorigin="anonymous"/>

    <!-- AOS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/aos/aos.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/toastr/toastr.min.css') }}">


    <!-- Website Title -->
    <title>Krishak Vikas | A One Stop Solution For All Your Farming Needs</title>
    @yield("styles")
</head>

<body>


<!-- ======= Header ======= -->
@include("guest.includes.navbar")
<section id="preloader-section">
    <div class="container">
        <div class="preloader"></div>
    </div>
</section>
@yield("content")

@include("guest.includes.footer")
<a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>


<!-- Vendor JS Files -->
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery.easing/jquery.easing.min.js')}}"></script>
<script src="{{asset('assets/vendor/php-email-form/validate.js')}}"></script>
<script src="{{asset('assets/vendor/waypoints/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('assets/vendor/isotope-layout/isotope.pkgd.min.js')}}"></script>
<script src="{{asset('assets/vendor/venobox/venobox.min.js')}}"></script>
<script src="{{asset('assets/vendor/owl.carousel/owl.carousel.min.js')}}"></script>
<script src="{{asset('assets/vendor/aos/aos.js')}}"></script>
<script src="{{asset('plugins/toast/jquery.toast.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.5/js/select2.full.min.js"></script>
<script src="{{asset('assets/vendor/toastr/toastr.min.js')}}"></script>
<script src="{{asset('js/function.js')}}"></script>


<!-- Template Main JS File -->
<script src="{{asset('assets/js/main.js')}}"></script>



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

</script>

<!-- AOS Script -->
<script src="{{asset('assets/vendor/aos/aos.js')}}"></script>

<script>
    AOS.init({
        offset: 150,
        duration: 700
    });
</script>


@yield("script")
</body>

</html>
