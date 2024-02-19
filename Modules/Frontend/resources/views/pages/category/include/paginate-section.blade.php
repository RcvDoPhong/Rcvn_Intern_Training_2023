<div class="pagination__wrapper d-flex justify-content-center" id="pagination-category">
    @if (isset($products->links))
        {!! $products->links !!}
    @else
        {!! $products->links() !!}
    @endif
</div>
