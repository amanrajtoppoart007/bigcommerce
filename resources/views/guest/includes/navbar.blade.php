<!-- Header (Start) -->
<header>
    <nav class="navbar navbar-expand-lg bg-white fixed-top" id="navbar">
        <div class="container justify-content-between">
            <!-- Brand Logo -->
            <a href="{{URL::to('/')}}" class="navbar-brand text-theme-1 font-weight-bolder"><img
                    src="{{ asset('assets/assets/images/logo-1.png') }}" alt="logo" class="logo img-fluid"></a>

            <!-- Toggler Button -->
            <button class="navbar-toggler" id="navbar-toggler" onclick="$('#navbar-collapse').toggle(300);">
                <img src="{{ asset('assets/assets/icons/menu.svg') }}" alt="toggler-menu">
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse ml-auto" id="navbar-collapse">
                <ul class="navbar-nav ml-auto" align="center">
                    <hr>
                    <li class="nav-item px-1"><a href="{{route('about')}}" class="nav-link text-theme-1">हमारे बारे
                            में</a></li>
                    <hr>
                    <li class="nav-item px-1 dropdown">
                        <a href="#" class="nav-link text-theme-1 dropdown-toggle">कृषि समाधान</a>
                        <div class="dropdown-menu shadow card-body">
                            <a href="{{route('solutions','farmer')}}" class="nav-link dropdown-item">किसान भाइयों के
                                लिए</a>
                            <a href="{{route('solutions','small-business')}}" class="nav-link dropdown-item">व्यवसायी
                                भाइयों के लिए</a>
                            <a href="{{route('solutions','institutions')}}" class="nav-link dropdown-item">संस्थागत
                                खरीददारों के लिए</a>
                        </div>
                    </li>
                    <hr>
                    <li class="nav-item px-1"><a href="{{ route('contact') }}" class="nav-link text-theme-1">संपर्क
                            करें</a></li>
                    <hr>
                    <li class="nav-item px-1"><a href="{{ route('career') }}" class="nav-link text-theme-1">कैरियर</a>
                    </li>
                    <hr>
                    <li class="nav-item px-1 dropdown">
                        <a href="#" class="btn shadow btn-theme-1 px-4 mx-2 py-2 nav-link dropdown-toggle">Login</a>
                        <div class="dropdown-menu shadow card-body">
                            <a href="{{route('helpCenter.login')}}" class="nav-link dropdown-item">Help Center</a>
                            <a href="{{route('franchisee.login')}}" class="nav-link dropdown-item">Franchisee</a>
                        </div>
                    </li>
                    <hr>
                    <li class="px-1"><a href="{{ route('register') }}" class="btn shadow btn-theme-1 px-4 mx-2 py-2">पंजीकरण<img
                                src="{{asset('assets/assets/icons/circle-arrow.svg')}}" class="btn-icon"
                                alt="arrow-right"></a></li>
                    <hr>
                </ul>
            </div>
        </div>
    </nav>
</header>
<!-- Header (End) -->
