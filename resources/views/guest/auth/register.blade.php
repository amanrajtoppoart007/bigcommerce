@extends("guest.layout.app")
@section("content")
    <!-- Main (Start) -->
    <main data-aos="fade-in">

        <!-- Section First (Start) -->
        <section class="bg-light" id="panjikaran-section">
            <br>
            <div class="container">

                <div class="card border-0 shadow">
                    <div class="card-body text-center">
                        <h4 class="font-weight-bolder text-theme-1">हमसे जुड़ें</h4>
                        <p class="description-1 text-secondary">अपनी आवश्यकता के बारे में बताएं?</p>
                        <hr>
                        <h5 class="text-theme-1 font-weight-bolder">Join us and start good</h5>

                        <div class="row mt-3">

                            <div class="col-lg-4 col-md-2 col-sm-12">
                                <a href="{{route('farmer.register')}}" class="card-link">
                                    <div class="card panjikaran-card">
                                        <div class="card-body">
                                            <img src="{{ asset('assets/assets/icons/panjikaran/farmer.svg') }}"
                                                 alt="farmer" class="img-fluid img-thumbnail p-3 bg-white shadow">
                                            <h5 class="font-weight-bolder text-theme-1 mt-4">किसान पंजीकरण</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-4 col-md-2 col-sm-12">
                                <a href="{{route('helpCenter.register')}}" class="card-link">
                                    <div class="card panjikaran-card">
                                        <div class="card-body">
                                            <img src="{{ asset('assets/assets/icons/panjikaran/helpcenter.svg') }}"
                                                 alt="helpcenter" class="img-fluid img-thumbnail p-3 bg-white shadow">
                                            <h5 class="font-weight-bolder text-theme-1 mt-4">सहायता केंद्र पंजीकरण</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-lg-4 col-md-2 col-sm-12">
                                <a href="{{route('franchisee.register')}}" class="card-link">
                                    <div class="card panjikaran-card">
                                        <div class="card-body">
                                            <img src="{{ asset('assets/assets/icons/panjikaran/franchise.svg') }}"
                                                 alt="franchise" class="img-fluid img-thumbnail p-3 bg-white shadow">
                                            <h5 class="font-weight-bolder text-theme-1 mt-4">फ्रेंचाइजी पंजीकरण</h5>
                                        </div>
                                    </div>
                                </a>
                            </div>

                        </div>

                    </div>
                </div>

            </div>
            <br>
        </section>
        <!-- Section First (End) -->

    </main>
    <!-- Main (End) -->
@endsection
