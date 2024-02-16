@routes

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

<script src="{{ asset('plugins/sweetalert2/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('plugins/handlerbar/handlebars.min-v4.7.8.js') }}"></script>
<script src="{{ asset('frontend/js/common_scripts.min.js') }}"></script>
<script src="{{ asset('frontend/js/main.js') }}"></script>


<!-- SPECIFIC SCRIPTS -->
<script src="{{ asset('frontend/js/sticky_sidebar.min.js') }}"></script>
<script src="{{ asset('frontend/js/specific_listing.js') }}"></script>
<script src="{{ asset('frontend/js/carousel-home.min.js') }}"></script>
<script src="{{ asset('frontend/js/carousel-home.js') }}"></script>
<script src="{{ asset('frontend/js/carousel_with_thumbs.js') }}"></script>
<script src="{{ asset('frontend/js/search-navbar.js') }}"></script>


<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
</script>

<!-- Register SW -->
<script src="{{ asset('registerSW.js') }}"></script>

<!-- COMMON SCRIPTS -->
<script src="{{ asset('js/frontend/lib/handlebar/helper.js') }}"></script>
<script src="{{ asset('js/frontend/lib/sweet-alert.js') }}"></script>
<script src="{{ asset('js/frontend/auth/login.js') }}"></script>
<script src="{{ asset('js/frontend/cart/cart.js') }}"></script>
<script src="{{ asset('js/frontend/lib/format-number.js') }}"></script>
<script src="{{ asset('js/frontend/pwa/share/share.js') }}"></script>
<script src="{{ asset('js/frontend/pwa/install-app/install-app.js') }}"></script>
<script src="{{ asset('js/frontend/pwa/push-message/push-message.js') }}"></script>


<!-- Global template SCRIPTS -->
