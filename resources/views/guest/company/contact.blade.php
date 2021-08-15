@extends("guest.layout.app")
@section("content")
    <!-- ======= Contact Section ======= -->
    <!-- Main (Start) -->
    <main data-aos="fade-in">

        <!-- Section First (Start) -->
        <section class="bg-light" id="contact-section">
            <br>
            <div class="container">


                <!-- Introduction Title (Start) -->
                <div class="text-left page-title">
                    <h1 class="font-weight-bold display-4 text-theme-1 ml-3">Contact us</h1>
                    <p class="description-1 ml-3 text-secondary">नीचे दिए गए फॉर्म को भरें और हमारे प्रतिनिधि आपसे बहुत
                        जल्द संपर्क करेंगे,या आप हमें कॉल कर सकते हैं या हमें एक ईमेल लिख सकते हैं, हम आपसे संपर्क
                        करेंगे</p>
                </div>
                <!-- Introduction Title (End) -->

                <div class="row mt-5">

                    <!-- Left Side (Start) -->
                    <div class="col-lg-7 col-md-12 col-sm-12">

                        <!-- Contact From (Start) -->
                        <div class="card border-0 shadow" id="contact-from-card">
                            <div class="card-body">
                                <form class="form-group" action="{{route('store.guest.enquiry')}}" method="post">
                                    @csrf
                                    <div class="row">
                                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                            <label class="font-weight-bolder" for="name">Your Name</label>
                                            <input type="text" name="name"
                                                   class="input-group-text bg-transparent w-100 text-left">
                                        </div>
                                        <div class="col-lg-6 col-md-6 col-sm-12 mt-3">
                                            <label class="font-weight-bolder" for="email">Your Email</label>
                                            <input type="email" name="email"
                                                   class="input-group-text bg-transparent w-100 text-left">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label class="font-weight-bolder" for="subject">Subject</label>
                                            <input type="text" name="subject"
                                                   class="input-group-text w-100 bg-transparent text-left">
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-12 col-md-12 col-sm-12">
                                            <label class="font-weight-bolder" for="message">Message</label>
                                            <textarea rows="5" name="message"
                                                      class="input-group-text w-100 bg-transparent text-left"></textarea>
                                        </div>
                                    </div>
                                    <button class="btn btn-lg btn-theme-1 w-100 rounded mt-3">Send Message<img
                                            src="{{ asset('assets/assets/icons/circle-arrow.svg') }}" class="btn-icon"
                                            alt="arrow-right">
                                    </button>
                                </form>
                            </div>
                        </div>
                        <!-- Contact From (End) -->

                        <!-- Map (Start) -->
                        <div class="card border-0 shadow mt-3">
                            <div class="card-body">
                                <div class="card">
                                    <iframe class="map-iframe"
                                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1859.796696388102!2d81.35160357087418!3d21.20830559887367!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x0!2zMjHCsDEyJzI5LjkiTiA4McKwMjEnMDguMCJF!5e0!3m2!1sen!2sin!4v1613104881088!5m2!1sen!2sin"
                                            frameborder="0" allowfullscreen></iframe>
                                </div>
                            </div>
                        </div>
                        <!-- Map (End) -->

                        <br>
                    </div>
                    <!-- Left Side (End) -->


                    <!-- Right Side (Start) -->
                    <div class="col-lg-5 col-md-12 col-sm-12">

                        <!-- Location Card (Start) -->
                        <a target="_blank"
                           href="https://www.google.com/maps?ll=21.208306,81.352222&z=17&t=m&hl=en&gl=IN&mapclient=embed"
                           class="card-link">
                            <div class="card border-0 shadow contact-card" align="center">
                                <div class="card-body">
                                    <div class="contact-img-div">
                                        <img src="{{asset('assets/assets/icons/location.svg')}}" alt="location"
                                             class="img-fluid contact-img">
                                    </div>
                                    <h4 class="font-weight-bolder mt-2 text-theme-1">Location</h4>
                                    <p class="text-secondary">
                                        Creatrix Health Private Limited,
                                        2nd Floor, Satish Tower, Above Kamla Medicose,
                                        Near Gharhi Chowk, Supela, Bhilai Nagar, 490023
                                    </p>
                                </div>
                            </div>
                        </a>
                        <!-- Location Card (End) -->

                        <!-- Mail Card (Start) -->
                        <a href="mailto: info@krishakvikas.com" class="card-link">
                            <div class="card border-0 shadow contact-card" align="center">
                                <div class="card-body">
                                    <div class="contact-img-div">
                                        <img src="{{asset('assets/assets/icons/mail.svg')}}" alt="mail"
                                             class="img-fluid contact-img">
                                    </div>
                                    <h4 class="font-weight-bolder mt-2 text-theme-1">E-Mail</h4>
                                    <p class="text-secondary">
                                        info@krishakvikas.com
                                    </p>
                                </div>
                            </div>
                        </a>
                        <!-- Mail Card (End) -->

                        <!-- Phone Card (Start) -->
                        <a href="tel: +918815752022" class="card-link">
                            <div class="card border-0 shadow contact-card" align="center">
                                <div class="card-body">
                                    <div class="contact-img-div">
                                        <img src="{{asset('assets/assets/icons/call.svg')}}" alt="call"
                                             class="img-fluid contact-img">
                                    </div>
                                    <h4 class="font-weight-bolder mt-2 text-theme-1">Phone</h4>
                                    <p class="text-secondary">
                                        +918815752022
                                    </p>
                                </div>
                            </div>
                        </a>
                        <!-- Phone Card (End) -->

                    </div>
                    <!-- Right Side (End) -->

                </div>


            </div>
            <br>
        </section>
        <!-- Section First (End) -->

    </main>
    <!-- Main (End) -->
    <!-- End Contact Section -->
@endsection
