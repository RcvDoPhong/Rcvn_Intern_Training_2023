@extends('admin::layouts.master')

@php
    $iToValue = intval($brands->currentPage() * $brands->perPage());
    $iFromValue = $iToValue - $brands->perPage() + 1;
@endphp
@section('content')
    @if (session()->has('message'))
        <div class="mt-2 p-3 bg-{{ session()->get('alert-class') }} text-white rounded">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="{{ route('admin.brands.index') }}" method="get" id="searchForm">
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="name">Brand's name</label>
                    <input name="brand_name" type="text" class="form-control d-flex" id="brand_name"
                        value="{{ request()->input('brand_name') }}" placeholder="Type brand's name">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="fromDate">Founded from day</label>
                    <input name="fromDate" type="date" class="form-control d-flex" id="fromDate"
                        value="{{ request()->input('fromDate') }}" placeholder="Founded from day">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="toDate">Founded to day</label>
                    <input name="toDate" type="date" class="form-control d-flex" id="toDate"
                        value="{{ request()->input('toDate') }}" placeholder="Founded to day">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="updated_by">Updated By</label>
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
            <div class="col-md">
                @if (checkRoleHasPermission('brand.view'))
                    <a href="{{ route('admin.brands.create') }}" class="btn btn-primary text-white">
                        <i class="fas fa-edit mr-2"></i>
                        <span>Add new</span>
                    </a>
                @endif
            </div>
            <div class="row col-md d-flex justify-content-end">
                <div class="col-auto">
                    <button name="" type="submit" class="btn btn-primary">
                        <i class="fas fa-search mr-2"></i>
                        Search
                    </button>
                </div>
                <div class="col-auto">
                    <button name="clear" type="button" class="btn btn-success"
                        onclick="common.clearSearchResult('{{ route('admin.brands.index') }}')">
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
                        {{ $brands->links() }}
                    </ul>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    Display {{ $iFromValue }} ~ {{ $iToValue }} in total of {{ $brands->total() }} brands
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Name</th>
                        <th>Founded</th>
                        <th>Total products</th>
                        <th>Updated by</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody id="user-table" class="text-center">
                    @if ($brands->total() > 0)
                        @foreach ($brands as $brand)
                            <tr>
                                <td>{{ $brand->brand_id }}</td>
                                <td>
                                    <a href="#" class="text-decoration-none" data-modal="#modalGlobal"
                                        onclick="brands.renderModal(this, {{ $brand->brand_id }})">
                                        {{ $brand->brand_name }}
                                    </a>
                                </td>
                                <td>{{ date_format(date_create($brand->founded), 'd/m/Y') }}</td>
                                <td>{{ $brand->products->count() }}</td>
                                <td>{{ $brand->admin->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if (checkRoleHasPermission('brand.update'))
                                            <div>
                                                <a href="{{ route('admin.brands.edit', $brand->brand_id) }}"
                                                    class="btn btn-primary text-white">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        @endif
                                        @if (checkRoleHasPermission('brand.delete'))
                                            <form action="{{ route('admin.brands.destroy', $brand->brand_id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                <button name="delete" class="btn btn-danger ml-1"
                                                    onclick="common.sweetAlertWithButton(this, event, 'Delete brand','Are you sure?')">
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
                    {{ $brands->links() }}
                </ul>
            </div>
        </div>
    </div>
    <div>
        @include('admin::layouts.modal')
    </div>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/js/brands.js') }}"></script>
@endsection
