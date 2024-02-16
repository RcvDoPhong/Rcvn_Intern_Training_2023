@extends('frontend::layouts.master')

@section('content')
    <main class="bg_gray" id="product-detail-page">
        <div class="container  margin_30">

            <div class="row">
                @include('frontend::pages.product-detail.include.product-display-images')
                @include('frontend::pages.product-detail.include.product-basic-information')
            </div>

        </div>
        <div>

        </div>


        @include('frontend::pages.product-detail.include.tab-product')

        <div class="tab_content_wrapper">
            <div class="container">
                <div class="tab-content" role="tablist">
                    @include('frontend::pages.product-detail.include.description-product')

                    @include('frontend::pages.product-detail.include.review-product')

                </div>
            </div>
        </div>

        @include('frontend::pages.product-detail.include.related-product')


    </main>
@endsection

@section('modal')
    @include('frontend::pages.product-detail.include.modal-product')
@endsection

@section('js')
    <script src="{{ asset('js/frontend/product/product.js') }}"></script>
@endsection
