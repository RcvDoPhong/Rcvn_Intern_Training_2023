@extends('frontend::layouts.master')

@section('content')
    @include('frontend::pages.category.include.hero-section')
    @include('frontend::pages.category.include.tool-box')
    <div class="container margin_30" style="transform: none;">
        <div class="row">

            @include('frontend::pages.category.include.side-menu')

            <div class="col-lg-9" id="product-list-container">
                @if ($executionTime)
                    <div>
                        <h2>Query Time: {{ $executionTime }}</h2>
                    </div>
                @endif
                @include('frontend::pages.category.include.product-list.product-list-grid')
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('js/frontend/category/category.js') }}"></script>
@endsection
