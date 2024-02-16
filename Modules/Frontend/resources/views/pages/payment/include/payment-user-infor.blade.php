<div class="col-lg-4 col-md-6">
    <div class="step first">
        <h3>1. User Info and Billing address</h3>

        <form id="user-infor-form" class="bg-white p-4 mt-2 checkout">
            <div>

                <div class="form-group">
                    <label for="couponCode" class="mb-1">Apply Coupon</label>
                    <input id="coupon" type="text" class="form-control" placeholder="Coupon code" name="coupon_code"
                        id="couponCode">
                    <div id="coupon-notice" class="text-left text-info">

                    </div>
                </div>

                <hr>
                <div class="d-flex ">

                    <label class="mb-1">Delivery Address</label>
                    <a href="{{ route('frontend.user.index') }}" class="ms-2 fw-bold">
                        <p class=" text-success">

                            Edit
                        </p>
                    </a>
                </div>
                <div style="gap: 0.8rem" class="form-group d-flex align-items-center justify-content-between ">
                    <input type="text" class="form-control" value="{{ $deliveryAddress }}" disabled
                        placeholder="Delivery Address" name="delivery_address">

                </div>
                <div class="form-group">
                    <input disabled type="text" name="telephone_number" class="form-control"
                        placeholder="Telephone number" value="{{ $user['delivery_phone_number'] }}">
                </div>
                <hr>
                <div class="form-group">
                    <label class="container_check" >Billing address is the same as shipping address
                        <input type="checkbox" id="is_billing_address" name="is_billing_address"
                            {{ $user['is_billing_address'] === 1 ? 'checked' : '' }}>
                        <span class="checkmark"></span>
                    </label>
                </div>
                <div id="other_addr_c" class="pt-2">

                    <!-- /row -->
                    <div class="form-group">
                        <input disabled type="text" class="form-control" placeholder="Billing address"
                            value="{{ $billingAddress }}" name="billing_address">
                    </div>

                    <!-- /row -->
                </div>
                <!-- /other_addr_c -->
                <hr>
            </div>

        </form>
    </div>
    <!-- /step -->
</div>
