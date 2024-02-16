<!DOCTYPE html>
<html lang="en">

<head>
    @include('frontend::layouts.head')
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">

        @include('frontend::layouts.navbar')

        <div class="content-wrapper ">
            @yield('content')
        </div>
        @include('frontend::layouts.footer')
    </div>
    <div id="toTop"></div><!-- Back to top button -->
    @yield('modal')
</body>
@include('frontend::layouts.js')
@yield('js')
@include('frontend::template.global-template')

</html>
