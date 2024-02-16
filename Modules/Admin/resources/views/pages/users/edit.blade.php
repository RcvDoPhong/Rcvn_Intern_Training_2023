@extends('admin::layouts.master')

@section('head')
    @yield('sub-head')
@endsection

@section('content')
    <div class="mb-3">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link @if (str_contains(Request::path(), 'info')) active pe-none @endif"
                    href="{{ route('admin.users.edit', request()->id) }}">Customer's info</a>
            </li>
            @if (checkRoleHasPermission('order.view'))
                <li class="nav-item">
                    <a class="nav-link @if (str_contains(Request::path(), 'order')) active pe-none @endif"
                        href="{{ route('admin.users.orders', request()->id) }}">Customer's orders</a>
                </li>
            @endif
        </ul>
    </div>
    @yield('user-info')
@endsection

@section('main-scripts')
    @yield('sub-scripts')
@endsection
