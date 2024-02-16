@extends('admin::layouts.master')

@section('head')
    <link rel="stylesheet" href="{{ asset('admin/css/orders.css') }}">
@endsection
@php
    $iToValue = intval($orders->currentPage() * $orders->perPage());
    $iFromValue = $iToValue - $orders->perPage() + 1;
@endphp
@section('content')
    @if (session()->has('message'))
        <div class="mt-2 p-3 bg-{{ session()->get('alert-class') }} text-white rounded">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="{{ route('admin.orders.index') }}" method="get" id="searchForm">
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="order_uid">Order UID</label>
                    <input name="order_uid" type="text" class="form-control d-flex" id="order_uid"
                        value="{{ request()->input('order_uid') }}" placeholder="Type Order UID">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="priceFrom">Order's total price from</label>
                    <input name="priceFrom" type="number" class="form-control d-flex" id="priceFrom"
                        value="{{ request()->input('priceFrom') }}" placeholder="Type total price from">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="priceTo">Order's total price to</label>
                    <input name="priceTo" type="number" class="form-control d-flex" id="priceTo"
                        value="{{ request()->input('priceTo') }}" placeholder="Type total price to">
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="shipping_method_id">Shipping method</label>
                    <select id="shipping_method_id" name="shipping_method_id" class="custom-select"
                        aria-label="Default select example">
                        <option value="">Select shipping method</option>
                        @foreach ($shippings as $shipping)
                            <option value="{{ $shipping->shipping_method_id }}"
                                @if (request()->input('shipping_method_id') === $shipping->shipping_method_id) selected @endif>
                                {{ $shipping->shipping_method_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="payment_method">Payment method</label>
                    <select name="payment_method" class="custom-select"
                        aria-label="Default
                    select example">
                        <option value="">Select payment method</option>
                        @foreach ($payments as $payment)
                            <option value="{{ $payment['id'] }}" @if (is_numeric(request()->input('payment_method')) && intval(request()->input('payment_method')) === $payment['id']) selected @endif>
                                {{ $payment['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="payment_method">Status</label>
                    <select name="status" class="custom-select">
                        <option value="">Select status</option>
                        @foreach ($statuses as $status)
                            <option value="{{ $status->order_status_id }}"
                                @if (is_numeric(request()->input('payment_method')) &&
                                        intval(request()->input('payment_method')) === $status->order_status_id) selected @endif>
                                {{ ucfirst($status->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
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
        <div class="mb-3 w-100">
            <div class="d-flex justify-content-end">
                <div class="col-auto">
                    <button name="" type="submit" class="btn btn-primary">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                </div>
                <div class="col-auto">
                    <button name="clear" type="button" class="btn btn-success"
                        onclick="common.clearSearchResult('{{ route('admin.orders.index') }}')">
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
                        {{ $orders->links() }}
                    </ul>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    Display {{ $iFromValue }} ~ {{ $iToValue }} in total of {{ $orders->total() }} orders
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Order UID</th>
                        <th class="text-center">Shipping method</th>
                        <th class="text-center">Payment method</th>
                        <th class="text-center">Total price</th>
                        <th class="text-center">Address</th>
                        <th>Phone number</th>
                        <th>Status</th>
                        <th>Updated by</th>
                    </tr>
                </thead>
                <tbody id="user-table">
                    @if ($orders->total() > 0)
                        @foreach ($orders as $order)
                            <tr>
                                <td>{{ $order->order_id }}</td>
                                <td>
                                    <a href="#" class="text-decoration-none" data-modal="#modalGlobal"
                                        onclick="orders.renderModal(this, {{ $order->order_id }})">
                                        {{ $order->order_uid }}
                                    </a>
                                </td>
                                <td class="text-center">{{ $order->shipping->shipping_method_name }}</td>
                                <td class="text-center">
                                    @switch($order->payment_method)
                                        @case(0)
                                            COD
                                        @break

                                        @case(1)
                                            Banking
                                        @break
                                    @endswitch
                                </td>
                                <td class="text-center">${{ number_format($order->total_price, 2) }}</td>
                                <td class="text-center">
                                    {{ $order->delivery_address .
                                        ' ' .
                                        $order->ward->name .
                                        ' ' .
                                        $order->district->name .
                                        ', ' .
                                        $order->city->name }}
                                </td>
                                <td>
                                    {{ $order->telephone_number }}
                                </td>
                                <td>
                                    <input type="hidden" value="{{ checkRoleHasPermission() }}" id="changeStatus">
                                    @if (checkRoleHasPermission('order.update'))
                                        <div class="form-group">
                                            <select name="status" class="custom-select"
                                                data-id="{{ $order->order_id }}"
                                                onchange="orders.changeOrderStatus(this)">
                                                @foreach ($statuses as $status)
                                                    <option value="{{ $status->order_status_id }}"
                                                        @if ($order->status->pluck('order_status_id')[0] === $status->order_status_id) selected @endif>
                                                        {{ ucfirst($status->name) }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $admin = $order->admin;

                                        if (!is_null($admin)) {
                                            $admin = $admin->name;
                                        }
                                    @endphp
                                    {{ $admin }}
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
                    {{ $orders->links() }}
                </ul>
            </div>
        </div>
    </div>
    <div>
        @include('admin::layouts.modal')
    </div>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/js/orders.js') }}"></script>
@endsection
