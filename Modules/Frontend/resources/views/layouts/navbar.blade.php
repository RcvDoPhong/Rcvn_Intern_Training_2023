<header class="version_1">
    <div class="layer"></div><!-- Mobile menu overlay mask -->
    <div class="main_header">
        <div class="container">
            <div class="row small-gutters">
                <div class="col-xl-3 col-lg-3 d-lg-flex align-items-center">
                    <div id="logo">
                        <a href="/"><img src="{{ asset('image/logo.jpg') }}" alt="logo image" width="100"
                                height="45"></a>
                    </div>
                </div>
                <nav class="col-xl-6 col-lg-7">
                    <a class="open_close" href="javascript:void(0);">
                        <div class="hamburger hamburger--spin">
                            <div class="hamburger-box">
                                <div class="hamburger-inner"></div>
                            </div>
                        </div>
                    </a>
                    <!-- Mobile menu button -->
                    <div class="main-menu">
                        <div id="header_menu">
                            <a href="index.html"><img src="img/logo_black.svg" alt="" width="100"
                                    height="35"></a>
                            <a href="#" class="open_close" id="close_in"><i class="ti-close"></i></a>
                        </div>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Home</a>
                                <ul>
                                    <li><a href="index.html">Slider</a></li>
                                    <li><a href="index-2.html">Video Background</a></li>
                                    <li><a href="index-3.html">Vertical Slider</a></li>
                                    <li><a href="index-4.html">GDPR Cookie Bar</a></li>
                                </ul>
                            </li>

                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">User</a>
                                <ul>
                                    @auth
                                        <div class="d-flex justify-content-center">
                                            <div id="logout-btn" onclick="authUserLogin.logout()" class="btn_1">Logout
                                            </div>
                                        </div>

                                    @endauth
                                    @guest
                                        <a href="{{ route('frontend.auth.index') }}" class="btn_1">Sign In or Sign Up</a>
                                    @endguest

                                    <li>
                                        <a href="track-order.html"><i class="ti-truck me-2"></i>Track your Order</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('frontend.order-history.index') }}"><i
                                                class="ti-package me-2"></i>My Orders</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('frontend.user.index') }}"><i class="ti-user me-2"></i>My
                                            Profile</a>
                                    </li>
                                    <li>
                                        <a href="help.html"><i class="ti-help-alt me-2"></i>Help and Faq</a>
                                    </li>

                                </ul>
                            </li>




                            <li class="megamenu submenu">
                                <a href="javascript:void(0);" class="show-submenu-mega">Pages</a>
                                <div class="menu-wrapper">
                                    <div class="row small-gutters">
                                        <div class="col-lg-3">
                                            <h3>Listing grid</h3>
                                            <ul>
                                                <li><a href="listing-grid-1-full.html">Grid Full Width</a></li>
                                                <li><a href="listing-grid-2-full.html">Grid Full Width 2</a></li>
                                                <li><a href="listing-grid-3.html">Grid Boxed</a></li>
                                                <li><a href="listing-grid-4-sidebar-left.html">Grid Sidebar Left</a>
                                                </li>
                                                <li><a href="listing-grid-5-sidebar-right.html">Grid Sidebar Right</a>
                                                </li>
                                                <li><a href="listing-grid-6-sidebar-left.html">Grid Sidebar Left 2</a>
                                                </li>
                                                <li><a href="listing-grid-7-sidebar-right.html">Grid Sidebar Right 2</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3">
                                            <h3>Listing row &amp; Product</h3>
                                            <ul>
                                                <li><a href="listing-row-1-sidebar-left.html">Row Sidebar Left</a></li>
                                                <li><a href="listing-row-2-sidebar-right.html">Row Sidebar Right</a>
                                                </li>
                                                <li><a href="listing-row-3-sidebar-left.html">Row Sidebar Left 2</a>
                                                </li>
                                                <li><a href="listing-row-4-sidebar-extended.html">Row Sidebar
                                                        Extended</a></li>
                                                <li><a href="product-detail-1.html">Product Large Image</a></li>
                                                <li><a href="product-detail-2.html">Product Carousel</a></li>
                                                <li><a href="product-detail-3.html">Product Sticky Info</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3">
                                            <h3>User</h3>
                                            <ul>
                                                <li><a href="cart.html">Cart Page</a></li>
                                                <li><a href="checkout.html">Check Out Page</a></li>
                                                <li><a href="confirm.html">Confirm Purchase Page</a></li>
                                                <li><a href="account.html">Create Account Page</a></li>
                                                <li><a href="track-order.html">Track Order</a></li>
                                                <li><a href="help.html">Help Page</a></li>
                                                <li><a href="help-2.html">Help Page 2</a></li>
                                                <li><a href="leave-review.html">Leave a Review</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-lg-3 d-xl-block d-lg-block d-md-none d-sm-none d-none">
                                            <div class="banner_menu">
                                                <a href="#0">
                                                    <img src="data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw=="
                                                        data-src="img/banner_menu.jpg" width="400" height="550"
                                                        alt="" class="img-fluid lazy">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /row -->
                                </div>
                                <!-- /menu-wrapper -->
                            </li>
                            <li class="submenu">
                                <a href="javascript:void(0);" class="show-submenu">Extra Pages</a>
                                <ul>
                                    <li><a href="header-2.html">Header Style 2</a></li>
                                    <li><a href="header-3.html">Header Style 3</a></li>
                                    <li><a href="header-4.html">Header Style 4</a></li>
                                    <li><a href="header-5.html">Header Style 5</a></li>
                                    <li><a href="404.html">404 Page</a></li>
                                    <li><a href="sign-in-modal.html">Sign In Modal</a></li>
                                    <li><a href="contacts.html">Contact Us</a></li>
                                    <li><a href="about.html">About 1</a></li>
                                    <li><a href="about-2.html">About 2</a></li>
                                    <li><a href="modal-advertise.html">Modal Advertise</a></li>
                                    <li><a href="modal-newsletter.html">Modal Newsletter</a></li>
                                </ul>
                            </li>
                            <li>
                                <a href="blog.html">Blog</a>
                            </li>
                            <li>
                                <a href="#0">About</a>
                            </li>
                        </ul>
                    </div>
                    <!--/main-menu -->
                </nav>
                <div class="col-xl-3 col-lg-2 d-lg-flex align-items-center justify-content-end text-end">
                    @guest
                        <a class="phone_top" href="tel://9438843343"><strong><span>Need Help?</span>+94
                                423-23-221</strong></a>
                    @endguest

                    @auth
                        <div class="phone_top"><strong class="text-white">
                                <div>Hello</div>{{ Auth::user()->name }}
                            </strong>
                        </div>
                    @endauth

                </div>
            </div>
            <!-- /row -->
        </div>
    </div>
    <!-- /main_header -->
    @include('frontend::layouts.subnav')

</header>
