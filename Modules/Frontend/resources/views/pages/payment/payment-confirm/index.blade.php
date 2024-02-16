@extends('frontend::layouts.master')

@section('content')
    <main class="bg_gray">
        <div class="container">
            <div class="row justify-content-center">
                @if (!$isSuccess)
                    <h3 style="height: 300px" class="text-center mt-5">

                        Not found !!
                    </h3>
                @else
                    <div class="col-md-5">
                        <div id="confirm">
                            <div class="icon icon--order-success svg add_bottom_15">
                                <svg xmlns="http://www.w3.org/2000/svg" width="72" height="72">
                                    <g fill="none" stroke="#8EC343" stroke-width="2">
                                        <circle cx="36" cy="36" r="35"
                                            style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                                        <path d="M17.417,37.778l9.93,9.909l25.444-25.393"
                                            style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                                    </g>
                                </svg>
                            </div>
                            <h2>Order completed!</h2>
                            <p>Your order UID is: {{ $orderUID }}</p>
                            <p>Thank you for your order</p>
                            <p>You will receive a confirmation email soon!</p>
                            <button class="btn btn-primary"><a class="text-white" href="{{ route('frontend.category.index') }}">Continue
                                    shopping</a></button>
                        </div>
                    </div>
                @endif

            </div>
            <!-- /row -->
        </div>
        <!-- /container -->

    </main>
@endsection
