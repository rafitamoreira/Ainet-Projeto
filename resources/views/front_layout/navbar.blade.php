<div id="preloder">
    <div class="loader"></div>
</div>

<!-- Offcanvas Menu Begin -->
<div class="offcanvas-menu-overlay"></div>
<div class="offcanvas-menu-wrapper">
    <div class="offcanvas__close">+</div>
    <ul class="offcanvas__widget">
        <li><span class="icon_search search-switch"></span></li>
        <li><a href="#"><span class="icon_heart_alt"></span>
                <div class="tip">2</div>
            </a></li>
        <li><a href="#"><span class="icon_bag_alt"></span>
                <div class="tip">2</div>
            </a></li>
    </ul>
    <div class="offcanvas__logo">
        <a href="./index.html"><img src="{{ asset('img/logotipo.png') }}" alt=""></a>
    </div>
    <div id="mobile-menu-wrap"></div>
    <div class="offcanvas__auth">
        <a href="#">Login</a>
        <a href="#">Register</a>
    </div>
</div>
<header class="header">
    <div class="container-fluid">
        <div class="row">
            <div class="col-xl-3 col-lg-2">
                <div class="header__logo">
                    <a href="/"><img src="{{ asset('img/logotipo.png') }}" alt=""></a>
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <nav class="header__menu">
                    <ul>
                        <li><a href="/product">Products</a></li>
                        <li><a href="/contact">Contact</a></li>
                        @if (Auth::check() && Auth::user()->user_type == 'A')
                            <li><a href="./admin">Painel Administrador</a></li>
                        @endif
                </nav>
            </div>
            <div class="col-lg-3">
                <div class="header__right">
                    <div class="row">
                        <div class="col-lg-8">
                            @guest
                                <div class="header__right__auth">
                                    <a href="{{ route('login') }}">{{ __('Login') }}</a>
                                    <a href="{{ route('register') }}">{{ __('Register') }}</a>
                                </div>
                            @else
                                <div class="nav-item dropdown">
                                    <div>
                                        @if (Auth::user()->photo_url != null && file_exists(public_path('storage/photos/' . Auth::user()->photo_url)))
                                            <img src="{{ asset('storage/photos/' . Auth::user()->photo_url) }}"
                                                class="rounded-circle" style="width: 35px;" alt="Avatar"
                                                style="float: left;" />
                                        @else
                                            <img src="https://icon-library.com/images/default-user-icon/default-user-icon-13.jpg"
                                                class="rounded-circle" style="width: 35px;" alt="Avatar"
                                                style="float: left;" />
                                        @endif
                                        <a class="nav-link dropdown-toggle" href="#" role="button"
                                            data-bs-toggle="dropdown" aria-expanded="false"
                                            style="float: right; position: relative;top: 3px;left: 10px;">
                                            {{ Auth::user()->name }}
                                        </a>
                                        <ul class="dropdown-menu">
                                            @if ((Auth::check() && Auth::user()->user_type == 'A') || Auth::user()->user_type == 'C')
                                                <li><a class="dropdown-item" href="/profile">Profile</a></li>
                                            @endif
                                            <li><a class="dropdown-item" href="/minhasencomendas">Minhas Encomendas</a>
                                            <li><a class="dropdown-item" href="/minhasEstampas">Estampas Privadas</a>
                                            <li><a class="dropdown-item" href="/criarEstampa">Criar Estampa</a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li><a class="dropdown-item" href="{{ route('logout') }}"
                                                    onclick="event.preventDefault();
                                            document.getElementById('logout-form').submit();">
                                                    {{ __('Logout') }}
                                                </a>
                                                <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                                    class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                        </ul>
                                    </div>

                                </div>
                            @endguest
                        </div>
                        <div class="col-lg-4">
                            <ul class="header__right__widget">
                                <li><span class="icon_search search-switch"></li>
                                <li><a href="/shoppingcart"><span class="icon_bag_alt"></span>
                                        <div class="tip">
                                            {{ Session::has('cart') ? Session::get('cart')->totalQty() : '0' }}</div>
                                    </a></li>
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <div class="canvas__open">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</header>
