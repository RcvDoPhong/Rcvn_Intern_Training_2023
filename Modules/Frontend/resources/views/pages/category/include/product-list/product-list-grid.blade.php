{{-- <div class="col-lg-9"> --}}
<div class="row small-gutters">

    @foreach ($products as $product)
        <div class="col-6 col-md-4 ">
            @component('frontend::components.product', [
                'product' => $product,
                'dateCount' => '2019/05/15',
            ])
            @endcomponent
            <!-- /grid_item -->
        </div>
    @endforeach

    @if ($products->count() == 0)
        <h4 class="text-center">No Products Found</h4>
    @endif




</div>
<!-- /col -->
@include('frontend::pages.category.include.paginate-section')
</div>
{{-- </div> --}}
