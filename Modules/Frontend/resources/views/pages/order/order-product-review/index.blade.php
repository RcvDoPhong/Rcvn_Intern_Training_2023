@extends('frontend::layouts.master')

@section('content')
    <main>


        <div class="container margin_60_35">
            @if ($isExistReview)
                <h4 style="height: 300px">
                    You have already reviewed this product
                </h4>
            @else
                @if ($orderHistory['order']['user_id'] !== Auth::user()->user_id)
                    <h4 style="height: 300px">
                        You can't review this product
                    </h4>
                @else
                    @if ($orderHistory['orderStatus']['order_status_id'] > 5)
                        <h4 style="height: 300px">
                            This product can't be reviewed

                        </h4>
                    @else
                        <form id="review-form" class="row justify-content-center" enctype="multipart/form-data">
                            <input type="hidden" name="product_id" value="{{ $product['product_id'] }}">

                            <input type="hidden" name="order_history_id" value="{{ $orderHistory['order_history_id'] }}">


                            <div class="col-lg-8">
                                <div class="write_review">
                                    <h1>Write a review for {{ $product['product_name'] }}</h1>
                                    <div class="rating_submit">
                                        <div class="form-group">
                                            <label class="d-block">Overall rating</label>
                                            <span class="rating mb-0">
                                                <input type="radio" checked class="rating-input" id="5_star"
                                                    name="rating" value="5"><label for="5_star"
                                                    class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="4_star" name="rating"
                                                    value="4"><label for="4_star" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="3_star" name="rating"
                                                    value="3"><label for="3_star" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="2_star" name="rating"
                                                    value="2"><label for="2_star" class="rating-star"></label>
                                                <input type="radio" class="rating-input" id="1_star" name="rating"
                                                    value="1"><label for="1_star" class="rating-star"></label>
                                            </span>
                                        </div>
                                    </div>
                                    <!-- /rating_submit -->
                                    <div class="form-group">
                                        <label>Title of your review</label>
                                        <input name="title" id="title" class="form-control"
                                            value="Review for {{ $product['product_name'] }}" type="text"
                                            placeholder="If you could say it in one sentence, what would you say?">
                                        <p id="error-title" class=" text-danger"></p>
                                    </div>
                                    <div class="form-group">
                                        <label>Your review</label>
                                        <textarea id="comment" name="comment" class="form-control" style="height: 180px;"
                                            placeholder="Write your review to help others learn about this online business"></textarea>
                                        <p id="error-comment" class=" text-danger">

                                        </p>
                                    </div>
                                    <div class="form-group">
                                        <label for="review-images">Add your photo (optional)</label>
                                        <input type="file" name="review-images" id="review-images" multiple
                                            accept="image/*">
                                    </div>





                                    <div id="image-preview-container" class="form-group"></div>
                                    <p id="error-review-images" class="text-danger"></p>

                                    <div id="error-review-images-0" class="text-danger"></div>
                                    <div id="error-review-images-1" class="text-danger"></div>
                                    <div id="error-review-images-2" class="text-danger"></div>
                                    <div id="error-review-images-3" class="text-danger"></div>


                                </div>

                                <button id="review-btn" type="submit" class="btn_1">Submit review</button>
                            </div>
                        </form>
                    @endif
                @endif
            @endif





            <!-- /row -->
        </div>
        <!-- /container -->
    </main>
    <!--/main-->
@endsection
@section('js')
    <script src="{{ asset('js/frontend/order-history/order-review.js') }}"></script>
@endsection
