@extends("guest.layout.app")
@section("content")
    <!-- ======= About Us Section ======= -->
    <main data-aos="fade-in">

        <!-- Section First (Start) -->
        <section class="bg-light" id="about-section">
            <br>
            <div class="container">
                <!-- Introduction Title (Start) -->
                <div class="text-left page-title">
                    <h1 class="font-weight-bold display-4 text-theme-1 ml-3">Privacy Policy</h1>
                </div>
                <!-- Introduction Title (End) -->
                <div class="content">
                    @foreach($contents as $content)
                        {!! $content->page_text !!}
                    @endforeach
                    {!! $siteSetting->privacy_policy ?? '' !!}
                </div>
            </div>
            <br>
        </section>
        <!-- Section First (End) -->
    </main>
    <!-- End About Us Section -->
@endsection
