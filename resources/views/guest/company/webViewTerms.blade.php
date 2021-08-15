<!-- ======= About Us Section ======= -->

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


    <!-- Stylesheets -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/index.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/theme-color.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/assets/css/about.css') }}">


    <!-- AOS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/aos/aos.css') }}">


    <!-- Website Title -->
    <title>Krishak Vikas | A One Stop Solution For All Your Farming Needs</title>
</head>

<body>
<section id="preloader-section">
    <div class="container">
        <div class="preloader"></div>
    </div>
</section>
<main data-aos="fade-in">

    <!-- Section First (Start) -->
    <section class="bg-light" id="about-section">
        <br>
        <div class="container">
            <!-- Introduction Title (Start) -->
            <div class="text-left page-title">
                <h5 class="font-weight-bold display-5 text-theme-1 ml-3">Terms & Condition Of Service</h5>
            </div>
            <!-- Introduction Title (End) -->
            <div class="content mt-2">
                @foreach($contents as $content)
                    {!! $content->page_text !!}
                @endforeach

                {!! $siteSetting->t_and_c ?? '' !!}
            </div>
        </div>
        <br>
    </section>
    <!-- Section First (End) -->
</main>
<!-- End About Us Section -->
<a href="#" class="back-to-top"><i class="ri-arrow-up-line"></i></a>


<!-- Vendor JS Files -->
<script src="{{asset('assets/js/popper.min.js')}}"></script>
<script src="{{asset('assets/vendor/bootstrap/js/bootstrap.min.js')}}"></script>
<script src="{{asset('assets/vendor/jquery/jquery.min.js')}}"></script>




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
</body>

</html>
