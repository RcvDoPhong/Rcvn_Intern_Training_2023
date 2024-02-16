<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title }}</title>
    @include('admin::layouts.head')
    @yield('head')
</head>

<body @auth class="hold-transition sidebar-mini layout-fixed" @endauth>
    @if (auth()->guard('admin')->check())
        <div class="wrapper">
            <!-- Left side column. contains the logo and sidebar -->
            @include('admin::layouts.sidebar')
            @include('admin::layouts.navbar')
            @include('admin::layouts.breadcrumb')

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper px-4 py-2">
                @yield('content')
            </div>

            @include('admin::layouts.footer')
        </div>
    @else
        @yield('body')
    @endif
</body>

@include('admin::layouts.script')
@include('admin::layouts.plugins')
@yield('main-scripts')

</html>
