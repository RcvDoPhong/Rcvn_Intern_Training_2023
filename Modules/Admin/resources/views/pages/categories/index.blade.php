@extends('admin::layouts.master')

@php
    $iToValue = intval($categories->currentPage() * $categories->perPage());
    $iFromValue = $iToValue - $categories->perPage() + 1;
@endphp
@section('content')
    @if (session()->has('message'))
        <div class="mt-2 p-3 bg-{{ session()->get('alert-class') }} text-white rounded">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="{{ route('admin.categories.index') }}" method="get" id="searchForm">
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="name">Cateogory's name</label>
                    <input name="category_name" type="text" class="form-control d-flex" id="category_name"
                        value="{{ request()->input('category_name') }}" placeholder="Type category's name">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="updated_by">Type of categories</label>
                    <select name="parent_flag" class="custom-select" aria-label="Default select example">
                        @foreach ($hierarchies as $tier)
                            <option value="{{ $tier['id'] }}" @if (intval(request()->input('parent_flag')) === $tier['id']) selected @endif>
                                {{ $tier['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="updated_by">Updated by</label>
                    <select name="updated_by" class="custom-select" aria-label="Default select example">
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
            @if (checkRoleHasPermission('category.create'))
                <div class="col-md">
                    <a href="{{ route('admin.categories.create') }}" class="btn btn-primary text-white">
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
                        onclick="common.clearSearchResult('{{ route('admin.categories.index') }}')">
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
                        {{ $categories->links() }}
                    </ul>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    Display {{ $iFromValue }} ~ {{ $iToValue }} in total of {{ $categories->total() }} categories
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr class="text-center">
                        <th>#</th>
                        <th>Parent categories</th>
                        <th>Name</th>
                        <th>Updated by</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody id="user-table" class="text-center">
                    @if ($categories->total() > 0)
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $category->category_id }}</td>
                                <td>{{ is_null($category->category) ? '' : ucfirst($category->category->category_name) }}
                                </td>
                                <td>{{ $category->category_name }}</td>
                                <td>{{ $category->admin->name }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if (checkRoleHasPermission('category.update'))
                                            <div>
                                                <a href="{{ route('admin.categories.edit', $category->category_id) }}"
                                                    class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        @endif
                                        @if (checkRoleHasPermission('category.delete'))
                                            @if ($category->categories->count() === 0)
                                                <form
                                                    action="{{ route('admin.categories.destroy', $category->category_id) }}"
                                                    method="POST">
                                                    @method('DELETE')
                                                    <button name="delete" class="btn btn-danger ml-1"
                                                        onclick="common.sweetAlertWithButton(this, event, 'Delete product','Are you sure?')">
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
                    {{ $categories->links() }}
                </ul>
            </div>
        </div>
    </div>
@endsection
