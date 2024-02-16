@extends('admin::layouts.master')

@php
    $isParent = $product->parent_product_id === null;
    $count = 0;
@endphp

@section('head')
    {{-- <link rel="stylesheet" href="{{ asset('admin/select2-4.1.0-rc.0/dist/css/select2.min.css') }}"> --}}
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
    <style>
        .ck-editor__editable_inline:not(.ck-comment__input *) {
            height: 300px;
            overflow-y: auto;
        }
    </style>
@endsection

@section('content')
    @if ($errors->has('message'))
        <div class="mt-2 p-3 bg-danger text-white rounded">
            {!! $errors->first('message') !!}
        </div>
    @endif
    <form enctype="multipart/form-data" action="{{ route('admin.products.update', $product->product_id) }}" method="post"
        id="handleFormInfo" class="pl-md-5 pr-md-5">
        @method('PUT')
        <div class="pl-md-5 pr-md-5 mt-3">
            <div class="form-group">
                <label class="mt-2 d-flex">Product name</label>
                <input name="product_name" type="text" class="form-control" value="{{ $product->product_name }}"
                    placeholder="Type product name">
                <span name="product_name" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label class="mt-2 d-flex">Stock</label>
                <input name="stock" type="number" class="form-control d-flex" value="{{ $product->stock }}"
                    placeholder="Type stock">
                <span name="stock" class="error invalid-feedback"></span>
            </div>
            <div class="form-group" id="brand_id">
                <label class="mt-2">Brand</label>
                <select name="brand_id" class="custom-select" aria-label="Default select example">
                    <option value="" selected>Select brand</option>
                    @foreach ($brands as $brand)
                        <option value="{{ $brand->brand_id }}" @if ($product->brand_id === $brand->brand_id) selected @endif>
                            {{ ucfirst($brand->brand_name) }}
                        </option>
                    @endforeach
                </select>
                <span name="brand_id" class="text-danger" style="font-size:80% !important"></span>
            </div>
            <div class="form-group" id="category_id">
                <label class="mt-2">Category</label>
                <select name="category_id" class="custom-select" aria-label="Default select example">
                    <option value="" selected>Select category</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->category_id }}" @if ($product->category_id === $category->category_id) selected @endif>
                            {{ ucfirst($category->category_name) }}
                        </option>
                    @endforeach
                </select>
                <span name="category_id" class="text-danger" style="font-size:80% !important"></span>
            </div>
            <div class="form-group" id="status">
                <label class="mt-2">Status</label>
                <select name="status" class="custom-select" aria-label="Default select example">
                    <option value="" selected>Select status</option>
                    @foreach ($stats as $stat)
                        <option value="{{ $stat['id'] }}" @if ($product->status === $stat['id']) selected @endif>
                            {{ ucfirst($stat['name']) }}
                        </option>
                    @endforeach
                </select>
                <span name="status" class="text-danger" style="font-size:80% !important"></span>
            </div>
            <div class="form-group">
                <label class="mt-2 d-flex">Brief description</label>
                <input name="brief_description" type="text" class="form-control"
                    value="{{ $product->brief_description }}" placeholder="Type brief descriptioin">
                <span name="brief_description" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
                <label class="mt-2 d-flex">Price</label>
                <input name="base_price" type="number" class="form-control d-flex" value="{{ $product->base_price }}"
                    placeholder="Type price">
                <span name="base_price" class="error invalid-feedback"></span>
            </div>
            <div class="form-group">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" id="is_sale"
                        onchange="products.switchPriceState(this, '#sale_price_state')"
                        @if ($product->is_sale === 1) checked @endif>
                    <label class="form-check-label" for="is_sale">Product on sale</label>
                </div>
                <div id="sale_price_state" @if ($product->is_sale !== 1) class="d-none" @endif>
                    <div class="form-group" id="sale_type">
                        <label class="mt-2">Display sale price based on</label>
                        <div class="row">
                            @foreach ($saleTypes as $type)
                                <div class="col-auto">
                                    <input type="radio" id="sale_type_{{ $type['id'] }}" name="sale_type"
                                        value="{{ $type['id'] }}" onclick="products.displaySalePriceInput(this)"
                                        @if ($product->sale_type === $type['id']) checked @endif>
                                    <label for="sale_type_{{ $type['id'] }}">{{ $type['name'] }}</label>
                                </div>
                            @endforeach
                        </div>
                        <span name="sale_type" class="error invalid-feedback d-flex"></span>
                    </div>
                    <div>
                        <div class="form-group @if ($product->sale_type !== 0) d-none @endif" id="sale_price">
                            <label class="mt-2 d-flex">Sale price</label>
                            <input id="sale_price" name="sale_price" type="number" class="form-control d-flex"
                                value="{{ $product->sale_price }}" placeholder="Type sale price">
                            <span name="sale_price" class="error invalid-feedback"></span>
                        </div>
                        <div class="form-group @if ($product->sale_type !== 1) d-none @endif" id="sale_price_percent">
                            <label class="mt-2 d-flex">Sale price (based on percent)</label>
                            <input id="sale_price_percent" name="sale_price_percent" type="number"
                                class="form-control d-flex" placeholder="Type sale price percent"
                                value="{{ $product->sale_price_percent }}">
                            <span name="sale_price_percent" class="error invalid-feedback"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Thumbnail</label>
                    <div class="row">
                        <div class="d-flex" style="height:300px">
                            <img name="preview" class="rounded float-right img-thumbnail img-fluid"
                                src="{{ asset("storage/$product->product_thumbnail") }}" alt="">
                        </div>
                        <div class="input-group">
                            <div class="input-group-append">
                                <button value="" class="btn btn-danger rounded" type="button"
                                    onclick="imageValidate.clearImage('product_thumbnail', 'product')">
                                    Remove image
                                </button>
                            </div>
                            <input class="form-control" type="file" name="product_thumbnail"
                                accept="image/png, image/jpg, image/jpeg" onchange="imageValidate.displayImage(this)">
                        </div>
                        <span name="product_thumbnail" class="text-danger" style="font-size:80% !important"></span>
                    </div>
                </div>
                <div>
                    <label>Add more product's images</label>
                    <div class="dropzone rounded-3" id="imageDropzone" data-id="{{ $product->product_id }}"
                        style="border-style: dashed solid;">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="mt-2 d-flex">Description</label>
                <textarea id="product_description">
                    {{ $product->product_description }}
                </textarea>
                <span name="product_description" class="error invalid-feedback d-flex"></span>
            </div>
            <div class="row form-group">
                <div class="col-2">
                    <label class="mt-2 d-flex">Type of product</label>
                </div>
                <div class="col-2">
                    <select name="parent_flag" id="parent_flag" class="custom-select"
                        onchange="products.displayOptions(this)">
                        <option value="">Select type</option>
                        <option value="1" @if ($isParent) selected @endif>Parent</option>
                        <option value="2" @if (!$isParent) selected @endif>Child</option>
                    </select>
                    <span id="parent_flag" name="parent_flag" class="error invalid-feedback d-flex text-break"></span>
                </div>
                <div class="col-2 ml-5 mt-1 form-check form-switch @if (!$isParent) d-none @endif"
                    id="has_product_options">
                    <input class="form-check-input" type="checkbox" role="switch" id="has_children"
                        onchange="products.switchPriceState(this, '#parent_option_products')"
                        @if ($product->options->count() > 0) checked @endif>
                    <label class="form-check-label" for="has_children">Add options</label>
                </div>
            </div>
            <div id="child_option_products" @if ($isParent) class="d-none" @endif>
                <div id="option_child_product" class="row form-group">
                    <div class="col-3">
                        <select id="option_id" class="custom-select" style="width:100%!important" name="option_id"
                            data-option="#option_child_product" onchange="products.getProductInfo(this)">
                            <option value="" selected>Select product</option>
                            @foreach ($optionParents as $option)
                                <option value="{{ $option->product_id }}"
                                    @if ($product->parent && $product->parent->product_id === $option->product_id) selected @endif>
                                    {{ $option->product_id }}
                                </option>
                            @endforeach
                        </select>
                        <span id="option_id" name="option_id" class="error invalid-feedback d-flex text-break"></span>
                    </div>
                    <div class="col-3">
                        <input type="text" id="option_name" class="form-control" placeholder="Option name"
                            value="@if ($product->parent) {{ $product->option_name }} @endif">
                        <span id="option_name" name="option_name"
                            class="error invalid-feedback d-flex text-break"></span>
                    </div>
                    <div class="col-3">
                        <input type="text" id="option_price" disabled class="form-control"
                            value="@if ($product->parent) {{ $product->parent->base_price }} @endif"
                            placeholder="Option price">
                    </div>
                </div>
            </div>
            <div id="parent_option_products" @if (!$isParent || $product->options->count() === 0) class="d-none" @endif>
                @php
                    $temp = [
                        [
                            'product_id' => '',
                        ],
                    ];
                    $optionsChildren = $product->options->count() === 0 ? $temp : $product->options->toArray();
                @endphp
                @foreach ($optionsChildren as $index => $children)
                @php
                    $indexValue = $index !== 0 ? '_' . $index + 1 : '';
                @endphp
                    <div id="option_parent_product{{ $indexValue }}" class="row form-group">
                        <div class="col-3">
                            <select id="option_id{{ $indexValue }}" class="custom-select"
                                style="width:100%!important" name="option_id"
                                data-option="#option_parent_product{{ $indexValue }}" data-prev=""
                                onchange="products.getProductInfo(this)">
                                <option value="" selected>Select product</option>
                                @foreach ($optionChildren as $option)
                                    <option id="{{ $option->product_id }}" value="{{ $option->product_id }}"
                                        @if (data_get($children, 'product_id') === $option->product_id) selected
                                        @php
                                            $count += 1;
                                        @endphp @endif>
                                        {{ $option->product_id }}
                                    </option>
                                @endforeach
                            </select>
                            <span id="option_id" name="option_id"
                                class="error invalid-feedback d-flex text-break"></span>
                        </div>
                        <div class="col-3">
                            <input type="text" id="option_name" class="form-control" placeholder="Option name"
                                value="{{ data_get($children, 'option_name') }}">
                            <span id="option_name" name="option_name"
                                class="error invalid-feedback d-flex text-break"></span>
                        </div>
                        <div class="col-3">
                            <input type="text" id="option_price" disabled class="form-control"
                                value="{{ data_get($children, 'base_price') }}" placeholder="Option price">
                        </div>
                        <div class="col-3" id="option_button">
                            <button type="button" class="btn btn-primary" data-type="#parent_option_products"
                                data-option="#option_parent_product" onclick="products.addMore(this)"
                                data-select="#option_id">
                                <i class="fas fa-plus"></i>
                            </button>
                            @if ($count > 1)
                                <button id="removeButton" type="button" class="btn btn-danger"
                                    data-type="#parent_option_products"
                                    data-option="#option_parent_product{{ $indexValue }}"
                                    onclick="products.removeOption(this)">
                                    <i class="fas fa-window-close"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mt-5 row mb-5">
                <div class="col-6 d-grid">
                    <a href="{{ route('admin.products.index') }}" class="btn btn-danger text-white btn-lg">
                        <i class="fas fa-window-close mr-2"></i>
                        Cancel
                    </a>
                </div>
                <div class="col-6 d-grid">
                    <button class="btn btn-primary btn-lg" id="saveButton"
                        onclick="products.handleCreateAndUpdate(event, this)">
                        <i class="fas fa-check mr-2"></i>
                        Save
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/js/images.js') }}"></script>
    <script src="{{ asset('admin/ckeditor5-build-classic/ckeditor.js') }}"></script>
    {{-- <script src="{{ asset('admin/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script> --}}
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <script src="{{ asset('admin/js/update-product-dropzone.js') }}"></script>
    <script src="{{ asset('admin/js/products.js') }}"></script>
@endsection
