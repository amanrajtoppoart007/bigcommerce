<style>
    .c-sidebar-nav-link{
        color: #008000 !important;
    }
    .c-sidebar .c-sidebar-nav-dropdown-toggle{
        color: #008000 !important;
    }
    .c-sidebar .c-sidebar-nav-dropdown-toggle:hover{
        color: white !important;
        background-color: #008000 !important;
    }
    .c-sidebar .c-sidebar-nav-dropdown-toggle:hover .c-sidebar-nav-icon{
        color: white !important;
    }
    .c-sidebar-nav-link:hover{
        color: white !important;
        background-color: #008000 !important;
    }
    .c-sidebar-nav-link:hover .c-sidebar-nav-icon{
        color: white !important;
    }
    .c-sidebar-nav-icon{
        color: #008000 !important;

    }
    .c-active{
        background-color: rgba(83, 193, 83, 0.85) !important;
        color: white !important;
    }
    .c-active .c-sidebar-nav-icon{
        color: white !important;
    }
    .c-sidebar .c-sidebar-nav-dropdown.c-show{
        background-color: rgba(127, 187, 127, 0.34) !important;
    }
</style>
<div id="sidebar" class="c-sidebar c-sidebar-fixed c-sidebar-lg-show bg-white">

    <div class="c-sidebar-brand d-md-down-none bg-white">
        <a class="c-sidebar-brand-full" href="{{ route("helpCenter.dashboard") }}">
            <img
                style="height: 80px"
                src="{{ asset('assets/assets/images/logo-1.png') }}" alt="logo">
        </a>
    </div>

    <ul class="c-sidebar-nav">

        <li class="c-sidebar-nav-item">
            <a href="{{ route("helpCenter.dashboard") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fas fa-fw fa-tachometer-alt">

                </i>
                {{ trans('global.dashboard') }}
            </a>
        </li>

        <li class="c-sidebar-nav-item">
            <a href="{{ route("helpCenter.products.index") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fa-fw fas fa-folder">

                </i>
                {{ trans('cruds.product.title') }}
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("helpCenter.carts") }}" class="c-sidebar-nav-link">
                <i class="c-sidebar-nav-icon fa-fw fas fa-shopping-cart">

                </i>
                {{ trans('cruds.cart.title') }}
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("helpCenter.orders.index") }}" class="c-sidebar-nav-link {{ request()->is("help-center/orders/*") ? "c-active" : "" }}">
                <i class="c-sidebar-nav-icon fa-fw fas fa-shopping-cart">

                </i>
                {{ trans('cruds.order.title') }}
            </a>
        </li>

        <li class="c-sidebar-nav-item">
            <a href="{{ route("helpCenter.users.index") }}" class="c-sidebar-nav-link {{ request()->is("help-center/users/*") ? "c-active" : "" }}">
                <i class="c-sidebar-nav-icon fas fa-fw fa-users">

                </i>
                {{ trans('global.farmer') }}
            </a>
        </li>

        <li class="c-sidebar-nav-item">
            <a href="{{ route("helpCenter.profile") }}" class="c-sidebar-nav-link {{ request()->is("help-center/profile") || request()->is("help-center/upload-documents") ? "c-active" : "" }}">
                <i class="c-sidebar-nav-icon fas fa-fw fa-user">

                </i>
                {{ trans('global.profile') }}
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="{{ route("helpCenter.show.change.password.form") }}" class="c-sidebar-nav-link {{ request()->is("franchisee/change-password") ? "c-active" : "" }}">
                <i class="c-sidebar-nav-icon fas fa-fw fa-asterisk">

                </i>
                {{ trans('global.change_password') }}
            </a>
        </li>
        <li class="c-sidebar-nav-item">
            <a href="#" class="c-sidebar-nav-link" onclick="event.preventDefault(); document.getElementById('logoutform').submit();">
                <i class="c-sidebar-nav-icon fas fa-fw fa-sign-out-alt">

                </i>
                {{ trans('global.logout') }}
            </a>
        </li>
    </ul>

</div>
