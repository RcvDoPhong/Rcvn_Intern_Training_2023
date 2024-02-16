@extends('admin::layouts.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('admin/select2-4.1.0-rc.0/dist/css/select2.min.css') }}">
@endsection

@php
    $iToValue = intval($shippings->currentPage() * $shippings->perPage());
    $iFromValue = $iToValue - $shippings->perPage() + 1;
@endphp
@section('content')
    @if (session()->has('message'))
        <div class="mt-2 p-3 bg-{{ session()->get('alert-class') }} text-white rounded">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="{{ route('admin.shippings.index') }}" method="get" id="searchForm">
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="shipping_method_name">Vendor name</label>
                    <input name="shipping_method_name" type="text" class="form-control d-flex" id="shipping_method_name"
                        value="{{ request()->input('shipping_method_name') }}" placeholder="Type vendor name">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="priceFrom">Shipping fee from</label>
                    <input name="priceFrom" type="number" class="form-control d-flex" id="priceFrom"
                        value="{{ request()->input('priceFrom') }}" placeholder="Type shipping fee from">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="priceTo">Shipping fee to</label>
                    <input name="priceTo" type="number" class="form-control d-flex" id="priceTo"
                        value="{{ request()->input('priceTo') }}" placeholder="Type shipping fee to">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="dateFrom">Estimated day delivery from</label>
                    <input name="dateFrom" type="number" class="form-control d-flex" id="dateFrom"
                        value="{{ request()->input('dateFrom') }}" placeholder="Time day from">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="dateTo">Estimated day delivery to</label>
                    <input name="dateTo" type="number" class="form-control d-flex" id="dateTo"
                        value="{{ request()->input('dateTo') }}" placeholder="Type day to">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="nickname">Areas delivery</label>
                    <select name="shipping_type" class="custom-select"
                        aria-label="Default
                    select example">
                        <option value="">Select areas</option>
                        @foreach ($shippingTypes as $type)
                            <option value="{{ $type['id'] }}" @if (is_numeric(request()->input('shipping_type')) && intval(request()->input('shipping_type')) === $type['id']) selected @endif>
                                {{ $type['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            {{-- <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="nickname">Thành phố áp dụng</label>
                    <select id="city_id" name="city_id[]" class="custom-select"
                        aria-label="Default select example" multiple="multiple">
                        @foreach ($cities as $city)
                            <option value="{{ $city->city_id }}">
                                {{ $city->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div> --}}
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="updated_by">Updated by</label>
                    <select name="updated_by" class="custom-select" aria-label="Default
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
            @if (checkRoleHasPermission('vendor.create'))
                <div class="col-md">
                    <a href="{{ route('admin.shippings.create') }}" class="btn btn-primary text-white">
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
                        onclick="common.clearSearchResult('{{ route('admin.shippings.index') }}')">
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
                        {{ $shippings->links() }}
                    </ul>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    Display {{ $iFromValue }} ~ {{ $iToValue }} in total of {{ $shippings->total() }} vendors
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Shipping fee</th>
                        <th>Shipping sale fee</th>
                        <th>Shipping sale fee (based on percent)</th>
                        <th>Areas delivery</th>
                        <th>Estimated delivery time (days)</th>
                        <th>Updated by</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody id="user-table">
                    @if ($shippings->total() > 0)
                        @foreach ($shippings as $shipping)
                            <tr>
                                <td>{{ $shipping->shipping_method_id }}</td>
                                <td>
                                    @if (checkRoleHasPermission('vendor.update'))
                                        <a href="{{ route('admin.shippings.edit', $shipping->shipping_method_id) }}"
                                            class="text-decoration-none">
                                            {{ $shipping->shipping_method_name }}
                                        </a>
                                    @else
                                        {{ $shipping->shipping_method_name }}
                                    @endif
                                </td>
                                <td class="text-center">${{ number_format($shipping->shipping_price, 2) }}</td>
                                <td class="text-center">${{ number_format($shipping->shipping_sale_price, 2) }}</td>
                                <td class="text-center">{{ $shipping->shipping_sale_price_percent }} %</td>
                                <td data-toggle="tooltip" data-placement="top"
                                    title="
                                        @if ($cities = implode(', ', $shipping->cities->pluck('name')->toArray())) Cities: {{ $cities }}
                                        @else
                                            All areas @endif">
                                    @switch($shipping->shipping_type)
                                        @case(0)
                                            All Areas
                                        @break

                                        @case(1)
                                            Selected areas
                                        @break
                                    @endswitch
                                </td>
                                <td class="text-center">{{ $shipping->estimate_shipping_days }} days</td>
                                <td>{{ $shipping->admin->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if (checkRoleHasPermission('vendor.update'))
                                            <div>
                                                <a href="{{ route('admin.shippings.edit', $shipping->shipping_method_id) }}"
                                                    class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        @endif
                                        @if (checkRoleHasPermission('vendor.delete'))
                                            <form
                                                action="{{ route('admin.shippings.destroy', $shipping->shipping_method_id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                <button type="submit" name="delete"
                                                    class="btn btn-danger ml-1 show_confirm delete"
                                                    onclick="common.sweetAlertWithButton(this, event, 'Delete vendor','Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
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
                    {{ $shippings->links() }}
                </ul>
            </div>
        </div>
    </div>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/select2-4.1.0-rc.0/dist/js/select2.min.js') }}"></script>
@endsection
