@php

    $statusArray = ['Stop selling', 'Selling', 'Sold Out'];
    $statusClassArray = ['text-warning', 'text-success', 'text-danger'];
@endphp
@if (!empty($product))
    <div id="pane-A" class="card tab-pane fade active show" role="tabpanel" aria-labelledby="tab-A">
        <div class="card-header" role="tab" id="heading-A">
            <h5 class="mb-0">
                <a class="collapsed" data-bs-toggle="collapse" href="#collapse-A" aria-expanded="false"
                    aria-controls="collapse-A">
                    Description
                </a>
            </h5>
        </div>

        <div id="collapse-A" class="collapse" role="tabpanel" aria-labelledby="heading-A">
            <div class="card-body">
                <div class="row justify-content-between">
                    <div class="col-lg-6">
                        <h3 class="fw-bold">Details</h3>
                        <p>


                            {!! $product['product_description'] !!}

                        </p>
                    </div>
                    <div class="col-lg-5">
                        <h3 class="fw-bold">Specifications</h3>
                        <div class="table-responsive">
                            <table class="table table-sm table-striped">
                                <tbody>
                                    <tr>
                                        <td><strong>Product UUID</strong></td>
                                        <td>{{ $product['product_uuid'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Stock</strong></td>
                                        <td id='product_stock'>{{ $product['stock'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Brand</strong></td>
                                        <td>{{ $product['brand']['brand_name'] }}</td>
                                    </tr>
                                    <tr>
                                        <td><strong>Status</strong></td>
                                        <td class="{{ $statusClassArray[$product['status']] }}">
                                            {{ $statusArray[$product['status']] }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <!-- /table-responsive -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@endif
