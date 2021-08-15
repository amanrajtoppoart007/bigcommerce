@extends("guest.layout.app")
@section("content")
    <!-- Main (Start) -->
    <main data-aos="fade-in">

        <!-- Section First (Start) -->
        <section class="bg-light krishisamadhan-section">
            <br>
            <div class="container" align="center">

                <!-- Introduction Title (Start) -->
                <div>
                    <img src="{{ asset('assets/assets/icons/white-house.svg') }}" alt="white-house" class="img-fluid">
                    <hr class="w-50">
                    <h2 class="font-weight-bolder text-theme-1">संस्थागत खरीददारों के लिए</h2>
                    <hr class="w-50">
                    <a href="{{route('helpCenter.register')}}" class="btn btn-theme-1 py-2 px-4 shadow m-2">फ्रेंचाइजी के रूप में हमसे जुड़ें<img src="{{ asset('assets/assets/icons/circle-arrow.svg') }}" class="btn-icon" alt="arrow-right"></a>
                    <br>
                </div>
                <!-- Introduction Title (End) -->

            </div>
            <br>
        </section>
        <!-- Section First (End) -->

    </main>
    <!-- Main (End) -->
@endsection
