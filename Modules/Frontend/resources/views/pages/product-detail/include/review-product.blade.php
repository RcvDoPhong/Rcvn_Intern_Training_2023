@if (!empty($reviews))
    <div id="pane-B" class="card tab-pane fade" role="tabpanel" aria-labelledby="tab-B">
        <div class="card-header" role="tab" id="heading-B">
            <h5 class="mb-0">
                <a class="collapsed" data-bs-toggle="collapse" href="#collapse-B" aria-expanded="false"
                    aria-controls="collapse-B">
                    Reviews
                </a>
            </h5>
        </div>
        <div id="collapse-B" class="collapse" role="tabpanel" aria-labelledby="heading-B">
            <div class="card-body">


                @include('frontend::pages.product-detail.section.review-section')

                <!-- /card-body -->
            </div>
            <div class="d-flex justify-content-center" id="review-pagination">
                {{ $reviews->links() }}
            </div>
        </div>
@endif
