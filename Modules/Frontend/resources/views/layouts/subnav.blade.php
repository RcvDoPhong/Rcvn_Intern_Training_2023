<div class="main_nav Sticky">
    <div class="container">
        <div class="row small-gutters">
            <div class="col-xl-3 col-lg-3 col-md-3">
                <nav class="categories">
                    <ul class="clearfix">
                        <li><span>
                                <a href="#">
                                    <span class="hamburger hamburger--spin">
                                        <span class="hamburger-box">
                                            <span class="hamburger-inner"></span>
                                        </span>
                                    </span>
                                    <a href="{{ route('frontend.category.index') }}">

                                        Categories
                                    </a>
                                </a>
                            </span>
                            <div id="menu">

                                @include('frontend::layouts.include.subnav-category')
                            </div>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="col-xl-6 col-lg-7 col-md-6 d-none d-md-block">
                <form class="custom-search-input" method="GET" id="searchInput" action="{{ route('frontend.category.index') }}">
                    {{-- @csrf --}}
                    {{-- <input name="searchName" value="{{ $searchName }}" type="text"
                        placeholder="Search over 1.000 products" onkeyup="search.searchNavbar(this)" />
                    <button type="submit"><i class="header-icon_like_custom" style="margin-right: 2rem !important"
                        onclick="search.searchElastic(this, event)"></i></button>
                    <button type="submit"><i class="header-icon_search_custom"
                        onclick="search.searchSQL(this, event)"></i></button>
                    <div id="search-suggest" class="bg-white d-none">
                    </div> --}}
                    <input name="searchName" value="{{ $searchName }}" type="text"
                        placeholder="Search over 1.000 products" onkeyup="search.searchNavbar(this)" />
                    <button type="submit" name="searchType" value="elastic"><i class="header-icon_like_custom"
                            style="margin-right: 2rem !important"></i></button>
                    <button type="submit" name="searchType" value="sql"><i
                            class="header-icon_search_custom"></i></button>
                    <div id="search-suggest" class="bg-white d-none">
                </form>
            </div>
            <div class="col-xl-3 col-lg-2 col-md-3">
                <ul class="top_tools">
                    <li>
                        @include('frontend::layouts.include.subnav-cart')
                        <!-- /dropdown-cart-->
                    </li>
                    <li>
                        <a href="#0" class="wishlist"><span>Wishlist</span></a>
                    </li>
                    <li>
                        <div class="dropdown dropdown-access">
                            @auth
                                <a href="{{ route('frontend.user.index') }}" class="access_link"><span>Account</span></a>

                            @endauth
                            @guest

                                <a href="{{ route('frontend.auth.index') }}" class="access_link"><span>Account</span></a>
                            @endguest
                            <div class="dropdown-menu">

                                @auth
                                    <div class="d-flex justify-content-center">
                                        <div id="logout-btn" onclick="authUserLogin.logout()" class="btn_1">Logout
                                        </div>
                                    </div>

                                @endauth
                                @guest
                                    <a href="{{ route('frontend.auth.index') }}" class="btn_1">Sign In or Sign Up</a>
                                @endguest

                                <ul>
                                    <li>
                                        <a href="track-order.html"><i class="ti-truck"></i>Track your Order</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('frontend.order-history.index') }}"><i
                                                class="ti-package"></i>My Orders</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('frontend.user.index') }}"><i class="ti-user"></i>My
                                            Profile</a>
                                    </li>
                                    <li>
                                        <a href="help.html"><i class="ti-help-alt"></i>Help and Faq</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!-- /dropdown-access-->
                    </li>
                    <li>
                        <a href="javascript:void(0);" class="btn_search_mob"><span>Search</span></a>
                    </li>
                    <li>
                        <a href="#menu" class="btn_cat_mob">
                            <div class="hamburger hamburger--spin" id="hamburger">
                                <div class="hamburger-box">
                                    <div class="hamburger-inner"></div>
                                </div>
                            </div>
                            Categories
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- /row -->
    </div>
    <div class="search_mob_wp">
        <input type="text" class="form-control" placeholder="Search over 10.000 products">
        <input type="submit" class="btn_1 full-width" value="Search">
    </div>
    <!-- /search_mobile -->
</div>
<!-- /main_nav -->
