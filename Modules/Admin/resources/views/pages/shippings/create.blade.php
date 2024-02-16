@extends('admin::layouts.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('admin/select2-4.1.0-rc.0/dist/css/select2.min.css') }}">
@endsection

@section('content')
    @if ($errors->has('message'))
        <div class="mt-2 p-3 bg-danger text-white rounded">
            {!! $errors->first('message') !!}
        </div>
    @endif
    <form action="{{ route('admin.shippings.store') }}" method="post" id="handleFormInfo" class="pl-md-5 pr-md-5">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="mt-2 d-flex">Vendor name</label>
                    <input name="shipping_method_name" type="text" class="form-control" value=""
                        placeholder="Type vendor name">
                    <span name="shipping_method_name" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Shipping fee</label>
                    <input name="shipping_price" type="number" class="form-control d-flex" value=""
                        placeholder="Type shipping fee" oninput="shippings.handleSalePercentInput()">
                    <span name="shipping_price" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Shipping sale fee</label>
                    <input name="shipping_sale_price" type="number" class="form-control d-flex" value=""
                        placeholder="Type shipping sale fee" oninput="shippings.handleSalePercentInput()">
                    <span name="shipping_sale_price" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Shipping sale fee (based on percent)</label>
                    <input name="shipping_sale_price_percent" type="number"
                        class="form-control d-flex"placeholder="Type shipping sale fee percent">
                    <span name="shipping_sale_price_percent" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Estimated delivery time (days)</label>
                    <input name="estimate_shipping_days" type="number" min="1" max="60"
                        class="form-control d-flex" value="1" placeholder="Type estimated time">
                    <span name="estimate_shipping_days" class="error invalid-feedback"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="mt-2">Areas delivery</label>
                    <select name="shipping_type" class="custom-select" aria-label="Default select example"
                        onchange="shippings.displayAreaShipping(this)">
                        <option value="0">All areas</option>
                        <option value="1">Selected areas</option>
                    </select>
                    <span name="shipping_type" class="text-danger" style="font-size:80% !important"></span>
                </div>
                <div class="form-group d-none" id="city_id">
                    <label class="mt-2 d-flex">Cities apply</label>
                    <select id="city_id" class="custom-select" style="width:100%!important" name="city_id[]"
                        multiple="multiple">
                        @foreach ($cities as $city)
                            <option value="{{ $city->city_id }}">{{ $city->name }}</option>
                        @endforeach
                    </select>
                    <span name="city_id" class="error invalid-feedback d-flex"></span>
                </div>
            </div>
        </div>
        <div class="mt-5 row justify-content-end">
            <div class="col-auto">
                <a href="{{ route('admin.shippings.index') }}" class="btn btn-danger text-white">
                    <i class="fas fa-window-close mr-2"></i>
                    Cancel
                </a>
            </div>
            <div class="col-auto">
                <button type="button" class="btn btn-primary" onclick="shippings.handleCreateUpdate(event, this)">
                    <i class="fas fa-check mr-2"></i>
                    Save
                </button>
            </div>
        </div>
    </form>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('admin/js/shippings.js') }}"></script>
@endsection
