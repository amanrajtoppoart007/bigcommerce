@extends("guest.layout.app")
@section("content")
    <style>

    </style>
    <div class="container mt-5">
        <div class="row d-flex justify-content-center">
           <div class="col-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
               <div class="card" style="width: 50rem;">
                   <div class="card-header border-0">
                       <div class="row d-flex justify-content-between">
                           <div class="">
                               <h5 class="fw-bold text-warning">अपनी आवश्यकता के बारे में  बताएं?</h5>
                                <h6 class="fw-bold text-success">हमसे जुड़ें</h6>
                           </div>
                       </div>

                   </div>
             <div class="card-body">
                  <h4 class="heading mb-4 pb-1">Join us and start good</h4>
                 <div class="row justify-content-center">
                     <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                         <div class="card text-center card-block border-1">
                             <div class="card-header text-center">
                                 <a href="">
                                    <img style="width:50%" class="card-img-top"src="{{asset('assets/img/register/farmer.png')}}" alt="">
                                 </a>
                             </div>
                             <div class="card-body">
                                 <a href="">
                                    <h4 class="card-title">किसान पंजीकरण</h4>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                         <div class="card text-center card-block border-1">
                             <div class="card-header text-center">
                                 <a href="">
                                    <img style="width:50%" class="card-img-top"src="{{asset('assets/img/register/business.png')}}" alt="">
                                 </a>
                             </div>
                             <div class="card-body">
                                 <a href="">
                                    <h4 class="card-title">व्यापार पंजीकरण</h4>
                                 </a>
                             </div>
                         </div>
                     </div>
                     <div class="col-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                         <div class="card text-center card-block border-1">
                             <div class="card-header text-center">
                                 <a href="">
                                    <img style="width:50%" class="card-img-top"src="{{asset('assets/img/register/building.png')}}" alt="">
                                 </a>
                             </div>
                             <div class="card-body">
                                 <a href="">
                                    <h4 class="card-title">संस्था पंजीकरण</h4>
                                 </a>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>

                   <div class="card-footer text-center">
                       <div class="d-grid gap-1 col-4 mx-auto mt-5">
                           <button class="btn btn-primary" type="button">Next<span class="fa fa-long-arrow-right">-></span></button>
                       </div>
                   </div>
         </div>
           </div>
        </div>

    </div>
@endsection
