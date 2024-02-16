<div class="col-md-6">
    <div class="all">
        <div class="slider">
            <div class="owl-carousel owl-theme main prod_pics magnific-gallery">
                @if (count($images) == 0)
                    <a href="{{ asset('image/default-img-product.png') }}" title="Photo title" data-effect="mfp-zoom-in">

                        <div style="background-image: url(image/default-img-product.png'));" class="item-box">
                        </div>

                    </a>
                @else
                    @foreach ($images as $image)
                        <a href="{{ '/storage/' . $image['image_path'] }}" title="Photo title" data-effect="mfp-zoom-in">
                            <div style="background-image: url({{ '/storage/' . $image['image_path'] }}); background-size: 360px; background-repeat: no-repeat;"
                                class="item-box">
                            </div>
                        </a>
                    @endforeach

                @endif


            </div>
            <div class="left nonl"><i class="ti-angle-left"></i></div>
            <div class="right"><i class="ti-angle-right"></i></div>
        </div>
        <div class="slider-two">
            <div class="owl-carousel owl-theme thumbs">
                @foreach ($images as $image)
                    <div style="background-image: url({{ '/storage/' . $image['image_path'] }});" class="item active">
                    </div>
                @endforeach


            </div>
            <div class="left-t nonl-t"></div>
            <div class="right-t"></div>
        </div>
    </div>
</div>
