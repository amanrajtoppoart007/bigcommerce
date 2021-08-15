@extends("guest.layout.app")
@section("content")

    <main data-aos="fade-in">

        <!-- Section First (Start) -->
        <section class="bg-light mt-4">
            <br>
            <div class="container">
                <div class="row justify-content-center my-5">
                    <div class="col-12 col-md-8 col-sm-8 col-lg-8 col-xl-8">
                        <div class="card border-0 shadow mt-3">
                            <div class="card-body">
                                <div class="text-theme-1" role="alert">
                                    <h4 class="alert-heading">Well done!</h4>
                                    <p>Welcome to KV PRO , you are successfully registered with us.</p>
                                    <p>Your login credential is as follows.</p>
                                    <p>Email    - <span>{{$user->email}}</span>.</p>
                                    <p>password - <span>{{$token}}</span></p>
                                    <hr>
                                    <span class="text-danger">Please do not share your login credentials with anyone for your account security,In case of password compromise please reset your password or contact us.</span>
                                    <p class="mb-0">Thank You For Joining Us.</p>
                                </div>
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
