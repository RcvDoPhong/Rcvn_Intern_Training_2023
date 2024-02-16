@extends('admin::layouts.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('admin/css/products.css') }}">
@endsection

@php
    $iToValue = intval($products->currentPage() * $products->perPage());
    $iFromValue = $iToValue - $products->perPage() + 1;
@endphp
@section('content')
    @if (session()->has('message'))
        <div class="mt-2 p-3 bg-{{ session()->get('alert-class') }} text-white rounded">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="{{ route('admin.products.index') }}" method="get" id="searchForm">
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="name">Product name</label>
                    <input name="product_name" type="text" class="form-control d-flex" id="product_name"
                        value="{{ request()->input('product_name') }}" placeholder="Type product name">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="name">Price from</label>
                    <input name="priceFrom" type="number" class="form-control d-flex" id="pricpriceFromeTo"
                        value="{{ request()->input('priceFrom') }}" placeholder="Type price from">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="name">Price to</label>
                    <input name="priceTo" type="number" class="form-control d-flex" id="priceTo"
                        value="{{ request()->input('priceTo') }}" placeholder="Type price to">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="category_id">Category</label>
                    <select name="category_id" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->category_id }}" @if (intval(request()->input('category_id')) === $category->category_id) selected @endif>
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="brand_id">Brand</label>
                    <select name="brand_id" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select brand</option>
                        @foreach ($brands as $brand)
                            <option value="{{ $brand->brand_id }}" @if (intval(request()->input('brand_id')) === $brand->brand_id) selected @endif>
                                {{ $brand->brand_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="sale_type">Sale price display based on</label>
                    <select name="sale_type" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select display method</option>
                        @foreach ($saleTypes as $type)
                            <option value="{{ $type['id'] }}" @if (is_numeric(request()->input('sale_type')) && intval(request()->input('sale_type')) === $type['id']) selected @endif>
                                {{ $type['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="status">Status</label>
                    <select name="status" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select status</option>
                        @foreach ($stats as $stat)
                            <option value="{{ $stat['id'] }}" @if (is_numeric(request()->input('status')) && intval(request()->input('status')) === $stat['id']) selected @endif>
                                {{ $stat['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="updated_by">Updated by</label>
                    <select name="updated_by" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select user</option>
                        @foreach (adminList() as $admin)
                            <option value="{{ $admin->admin_id }}" @if (intval(request()->input('updated_by')) === $admin->admin_id) selected @endif>
                                {{ $admin->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            @if (checkRoleHasPermission('product.create'))
                <div class="col-md">
                    <a href="{{ route('admin.products.create') }}" class="btn btn-primary text-white">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Add new</span>
                    </a>
                </div>
            @endif
            <div class="row col-md d-flex justify-content-end">
                <div class="col-auto">
                    <button name="" type="submit" class="btn btn-primary">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                </div>
                <div class="col-auto">
                    <button name="clear" type="button" class="btn btn-success"
                        onclick="common.clearSearchResult('{{ route('admin.products.index') }}')">
                        <i class="fas fa-window-close mr-2"></i>
                        Clear
                    </button>
                </div>
            </div>
        </div>
    </form>
    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-8 d-flex justify-content-start">
                    <ul class="pagination pagination-sm m-0">
                        {{ $products->links() }}
                    </ul>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    Display {{ $iFromValue }} ~ {{ $iToValue }} in total of {{ $products->total() }} product
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>UUID</th>
                        <th>Name</th>
                        <th>Brand</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Updated by</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody id="user-table" class="text-center">
                    @if ($products->total() > 0)
                        @foreach ($products as $product)
                            <tr id="productId{{ $product->product_id }}">
                                <td>{{ $product->product_id }}</td>
                                <td>{{ $product->product_uuid }}</td>
                                <td>
                                    <a href="#" class="text-decoration-none"
                                        onclick="productsIndex.renderModal(this, {{ $product->product_id }})">
                                        {{ $product->product_name }}
                                    </a>
                                </td>
                                <td>
                                    @if ($product->brand)
                                        {{ $product->brand->brand_name }}
                                    @else
                                        <span class="font-italic">NO BRAND</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($product->category)
                                        {{ $product->category->category_name }}
                                    @else
                                        <span class="font-italic">NO CATEGORY</span>
                                    @endif
                                </td>
                                <td>${{ number_format($product->base_price, 2) }}</td>
                                <td>
                                    @switch($product->status)
                                        @case(1)
                                            Selling
                                        @break

                                        @case(2)
                                            Out of stock
                                        @break

                                        @default
                                            Stop selling
                                        @break
                                    @endswitch
                                </td>
                                <td>{{ $product->admin->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if (checkRoleHasPermission('product.update'))
                                            <div>
                                                <a href="{{ route('admin.products.edit', $product->product_id) }}"
                                                    class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        @endif
                                        @if (checkRoleHasPermission('product.delete'))
                                            @if ($product->options->count() === 0)
                                                <form action="{{ route('admin.products.destroy', $product->product_id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    <button name="delete" class="btn btn-danger ml-1"
                                                        onclick="common.sweetAlertWithButton(this, event, 'Delete product','Are you sủe?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan=10>
                                <div class="text-center">
                                    No data found
                                </div>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
        <div class="card-footer">
            <div class="d-flex justify-content-end">
                <ul class="pagination pagination-sm m-0">
                    {{ $products->links() }}
                </ul>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modal_product" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Product info</h5>
                    <button type="button" class="btn-close" aria-label="Close"
                        onclick="productsIndex.hideModal()"></button>
                </div>
                <div class="modal-body">
                    <div id="productImages" class="carousel slide" data-ride="carousel">
                        <div class="carousel-inner" id="productImagesList">
                            <div class="carousel-item active">
                                <img id="product_thumbnail" class="d-block w-100 img-thumbnail mb-2" src=""
                                    alt="logoProduct">
                            </div>
                        </div>
                        <a class="carousel-control-prev" href="#productImages" role="button" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </a>
                        <a class="carousel-control-next" href="#productImages" role="button" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </a>
                    </div>
                    <hr class="dropdown-divider mt-3">
                    <div>
                        <h2 class="fw-bold" id="product_name"></h2>
                        <div class="mt-1">
                            <span>
                                <strong>Updated by:</strong>
                                <span class="user-select-auto" id="updated_by"></span>
                            </span>
                        </div>
                    </div>
                    <hr class="dropdown-divider mt-3">
                    <div id="bodyContent">
                        <div class="mt-1">
                            <span>
                                <strong>Product UUID:</strong>
                                <span class="user-select-auto" id="product_uuid"></span>
                            </span>
                        </div>
                        <div class="mt-1">
                            <span>
                                <strong>Brand:</strong>
                                <span class="user-select-auto" id="brand_name"></span>
                            </span>
                        </div>
                        <div class="mt-1">
                            <span>
                                <strong>Category:</strong>
                                <span class="user-select-auto" id="category_name"></span>
                            </span>
                        </div>
                        <div class="mt-1">
                            <span>
                                <strong>Option name:</strong>
                                <span class="user-select-auto" id="product_name"></span>
                            </span>
                        </div>
                        <div class="row mt-1">
                            <div class="col-auto">
                                <span>
                                    <strong>Price:</strong>
                                    <span class="user-select-auto" id="base_price"></span>
                                </span>
                            </div>
                            <div class="col-auto">
                                <span>
                                    <strong>Sale price:</strong>
                                    <span class="user-select-auto" id="sale_price"></span>
                                </span>
                            </div>
                            <div class="col-auto">
                                <span>
                                    <strong>Sale price (based on percent):</strong>
                                    <span class="user-select-auto" id="sale_price_percent"></span>
                                </span>
                            </div>
                        </div>
                        <div class="mt-1">
                            <span>
                                <strong>Sale price display method:</strong>
                                <span class="user-select-auto" id="sale_type"></span>
                            </span>
                        </div>
                        <div class="row mt-1">
                            <div class="col-auto">
                                <span>
                                    <strong>Stock:</strong>
                                    <span class="user-select-auto" id="stock"></span>
                                </span>
                            </div>
                            <div class="col-auto">
                                <span>
                                    <strong>Status:</strong>
                                    <span class="user-select-auto" id="status"></span>
                                </span>
                            </div>
                        </div>
                        <div class="mt-1">
                            <span>
                                <strong>Brief Description:</strong>
                                <span class="user-select-auto" id="brief_description"></span>
                            </span>
                        </div>
                        <div class="mt-1">
                            <span>
                                <strong>Description:</strong>
                                <span class="user-select-auto" id="description"></span>
                            </span>
                        </div>
                    </div>
                </div>
                @if (checkRoleHasPermission('product.update'))
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary"
                            onclick="productsIndex.hideModal()">Cancel</button>
                        <a href="#" id="update_product" class="btn btn-success">Update</a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/js/products-index.js') }}"></script>
@endsection
