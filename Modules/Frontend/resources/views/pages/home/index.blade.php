@extends('frontend::layouts.master')

@section('content')
    @auth
        @if (!Auth::user()->email_verified_at)
            @include('frontend::layouts.getemail')
        @endif
    @endauth

    @include('frontend::pages.home.include.carousel-home')
    @include('frontend::pages.home.include.banner-grid')
    @include('frontend::pages.home.include.top-selling')
    @include('frontend::pages.home.include.highlight-product')
    @include('frontend::pages.home.include.new-products-section')
    @include('frontend::pages.home.include.logo-carousel')
 
    @include('frontend::pages.home.include.brand-product')
    @include('frontend::pages.home.include.news-section')
@endsection
