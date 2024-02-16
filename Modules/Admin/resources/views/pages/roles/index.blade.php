@extends('admin::layouts.master')

@php
    $iToValue = intval($roles->currentPage() * $roles->perPage());
    $iFromValue = $iToValue - $roles->perPage() + 1;
    $permissionGroups = Modules\Admin\App\Constructs\Constants::PERMISSION_GROUP;
@endphp
@section('content')
    @if (session()->has('message'))
        <div class="mt-2 p-3 bg-{{ session()->get('alert-class') }} text-white rounded">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="{{ route('admin.roles.index') }}" method="get" id="searchForm">
        <div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex ml-1" for="role_name">Role name</label>
                    <div class="row">
                        <div class="col-auto">
                            <input name="role_name" type="text" class="form-control d-flex" id="role_name"
                                value="{{ request()->input('role_name') }}" placeholder="Type role name">
                        </div>
                        <div class="col-auto">
                            <button name="" type="submit" class="btn btn-primary">
                                <i class="fas fa-search mr-2"></i>
                                Search
                            </button>
                        </div>
                        <div class="col-auto">
                            <button name="clear" type="button" class="btn btn-success"
                                onclick="common.clearSearchResult('{{ route('admin.roles.index') }}')">
                                <i class="fas fa-window-close mr-2"></i>
                                Clear
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mb-3 mt-5">
            @if (checkRoleHasPermission('role.create'))
                <div class="col-4">
                    <a href="{{ route('admin.roles.create') }}" class="btn btn-primary text-white">
                        <i class="fas fa-plus mr-2"></i>
                        <span>Add new</span>
                    </a>
                </div>
            @endif
        </div>
    </form>
    <div class="row">
        <div class="col-12" id="roleList">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-8 d-flex justify-content-start">
                            <ul class="pagination pagination-sm m-0">
                                {{ $roles->links() }}
                            </ul>
                        </div>
                        <div class="col-4 d-flex justify-content-end">
                            Display {{ $iFromValue }} ~ {{ $iToValue }} in total of {{ $roles->total() }} roles
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th class="text-center">Name</th>
                                <th>Updated by</th>
                                <th class="text-center">Options</th>
                            </tr>
                        </thead>
                        <tbody id="user-table">
                            @if ($roles->total() > 0)
                                @foreach ($roles as $role)
                                    <tr>
                                        <td>{{ $role->role_id }}</td>
                                        <td class="text-center">
                                            <a href="#" data-id="{{ $role->role_id }}"
                                                id="role_name_{{ $role->role_id }}" class="text-decoration-none"
                                                onclick="roles.displayRolePermission(this)">
                                                {{ $role->role_name }}
                                            </a>
                                        </td>
                                        <td id="updated_by_{{ $role->role_id }}">
                                            {{ $role->admin ? $role->admin->name : null }}
                                        </td>
                                        <td class="text-center">
                                            <div class="btn-group">
                                                @if (checkRoleHasPermission('role.update'))
                                                    <div>
                                                        <a href="#" class="btn btn-primary"
                                                            data-id="{{ $role->role_id }}"
                                                            onclick="roles.displayRoleName(this)">
                                                            <i class="fas fa-edit"></i>
                                                        </a>
                                                    </div>
                                                @endif
                                                @if (checkRoleHasPermission('role.delete'))
                                                    @if ($role->role_id !== 1)
                                                        <form action="{{ route('admin.roles.destroy', $role->role_id) }}"
                                                            method="POST">
                                                            @method('DELETE')
                                                            <button name="delete"
                                                                class="btn btn-danger ml-1 show_confirm delete"
                                                                data-id="{{ $role->role_id }}"
                                                                onclick="common.sweetAlertWithButton(this, event, 'Delete role','Are you sure you want to delete this role?')">
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
                                            No data
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
                            {{ $roles->links() }}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div id="routeList" class="col-6 card d-none">
            <div class="modal-header">
                <h5 class="modal-title">View permission</h5>
                <button type="button" class="btn-close" data-hide="#routeList"
                    onclick="roles.hideRouteList(this)"></button>
            </div>
            <div class="modal-body ml-2" id="permissionListContent">
                <form action="#" method="POST" id="formPermissionList">
                    @foreach ($permissionGroups as $index => $permissions)
                        <label>{{ ucfirst($index) }}</label>
                        <div class="mb-3">
                            @foreach ($permissions as $permission)
                                @php
                                    $permissionFormat = formatPermissionName($permission);
                                    $inputId = str_replace('.', '_', $permission);
                                @endphp
                                <div class="ml-2 form-check">
                                    <input class="form-check-input" type="checkbox"
                                        value="{{ $permissionFormat['id'] + 1 }}"
                                        data-id="{{ $permissionFormat['id'] + 1 }}" id="{{ $inputId }}"
                                        @if (!checkRoleHasPermission('role.update')) disabled @endif>
                                    <label class="form-check-label" for="{{ $inputId }}">
                                        {{ $permissionFormat['name'] }}
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </form>
                @if (checkRoleHasPermission('role.update'))
                    <button class="btn btn-primary btn-lg float-right" data-id="" type="button" id="routeListBtn"
                        onclick="roles.savePermission(this)">
                        Save
                    </button>
                @endif
            </div>
        </div>
    </div>
    <div id="roleInfoModal">
    </div>
    <div>
        @include('admin::layouts.modal')
    </div>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/js/roles.js') }}"></script>
@endsection
