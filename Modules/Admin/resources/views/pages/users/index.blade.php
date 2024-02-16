@extends('admin::layouts.master')

@php
    $iToValue = intval($users->currentPage() * $users->perPage());
    $iFromValue = $iToValue - $users->perPage() + 1;
@endphp
@section('content')
    @if (session()->has('message'))
        <div class="mt-2 p-3 bg-{{ session()->get('alert-class') }} text-white rounded">
            {{ session()->get('message') }}
        </div>
    @endif
    <form action="{{ route('admin.users.index') }}" method="get" id="searchForm">
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="name">Name</label>
                    <input name="name" type="text" class="form-control d-flex" id="name"
                        value="{{ request()->input('name') }}" placeholder="Type customer name">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="nickname">Nickname</label>
                    <input name="nickname" type="text" class="form-control d-flex" id="nickname"
                        value="{{ request()->input('nickname') }}" placeholder="Type Nickname">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="email">Email</label>
                    <input name="email" type="text" class="form-control d-flex" id="email"
                        value="{{ request()->input('email') }}" placeholder="Type email">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="nickname">Gender</label>
                    <select name="gender" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select gender</option>
                        @foreach ($genderList as $gender)
                            <option value="{{ $gender['id'] }}" @if (is_numeric(request()->input('gender')) && intval(request()->input('gender')) === $gender['id']) selected @endif>
                                {{ $gender['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="is_active">Status</label>
                    <select name="is_active" class="custom-select"
                        aria-label="Default
                        select example">
                        <option value="">Select status</option>
                        @foreach ($statList as $stat)
                            <option value="{{ $stat['id'] }}" @if (is_numeric(request()->input('is_active')) && intval(request()->input('is_active')) === $stat['id']) selected @endif>
                                {{ $stat['name'] }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="fromDate">BOD from day</label>
                    <input name="fromDate" type="date" class="form-control d-flex"
                        value="{{ request()->input('fromDate') }}">
                </div>
            </div>
            <div class="col-auto">
                <div class="form-group">
                    <label class="mt-2 d-flex" for="toDate">BOD to day</label>
                    <input name="toDate" type="date" class="form-control d-flex"
                        value="{{ request()->input('toDate') }}">
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
                        onclick="common.clearSearchResult('{{ route('admin.users.index') }}')">
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
                        {{ $users->links() }}
                    </ul>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    Display {{ $iFromValue }} ~ {{ $iToValue }} in total of {{ $users->total() }} customers
                </div>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Nickname</th>
                        <th>Email</th>
                        <th>Birthday</th>
                        <th>Gender</th>
                        <th>Status</th>
                        <th>Updated by</th>
                        <th>Options</th>
                    </tr>
                </thead>
                <tbody id="user-table">
                    @if ($users->total() > 0)
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $user->user_id }}</td>
                                <td>
                                    @if (checkRoleHasPermission('customer.update'))
                                        <a href="{{ route('admin.users.edit', $user->user_id) }}"
                                            class="text-decoration-none">
                                            {{ $user->name }}
                                        </a>
                                    @else
                                        {{ $user->name }}
                                    @endif
                                </td>
                                <td>{{ $user->nickname }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ date_format(date_create($user->birthday), 'd/m/Y') }}</td>
                                <td>
                                    @switch($user->gender)
                                        @case(0)
                                            Female
                                        @break

                                        @case(1)
                                            Male
                                        @break
                                    @endswitch
                                </td>
                                <td>
                                    @switch($user->is_active)
                                        @case(1)
                                            <span class="text-success">
                                                Active
                                            </span>
                                        @break

                                        @case(0)
                                            <span class="text-danger">
                                                Locked
                                            </span>
                                        @break
                                    @endswitch
                                </td>
                                <td>{{ $user->admin ? $user->admin->name : null }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if (checkRoleHasPermission('customer.update'))
                                            <div>
                                                <a href="{{ route('admin.users.edit', $user->user_id) }}"
                                                    class="btn btn-primary">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </div>
                                        @endif
                                        @if (checkRoleHasPermission('customer.delete'))
                                            <form action="{{ route('admin.users.destroy', $user->user_id) }}"
                                                method="POST">
                                                @method('DELETE')
                                                <button type="submit" name="delete"
                                                    class="btn btn-danger ml-1 show_confirm delete"
                                                    onclick="common.sweetAlertWithButton(this, event, 'Delete user','Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        @endif
                                        @if (checkRoleHasPermission('customer.update'))
                                            @if ($user->is_active)
                                                <form action="{{ route('admin.users.lock', $user->user_id) }}"
                                                    method="POST">
                                                    @method('PUT')
                                                    <button type="submit" name="lock"
                                                        class="btn btn-dark ml-1 show_confirm lock"
                                                        onclick="common.sweetAlertWithButton(this, event, 'Lock user','Are you sure?')">
                                                        <i class="fas fa-lock"></i>
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
                    {{ $users->links() }}
                </ul>
            </div>
        </div>
    </div>
@endsection
