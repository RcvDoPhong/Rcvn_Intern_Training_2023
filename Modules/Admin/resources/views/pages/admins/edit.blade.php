@extends('admin::layouts.master')

@section('content')
    @if ($errors->has('message'))
        <div class="mt-2 p-3 bg-danger text-white rounded">
            {!! $errors->first('message') !!}
        </div>
    @endif
    @if (session()->has('message'))
        <div class="mt-2 p-3 bg-{{ session()->get('alert-class') }} text-white rounded">
            {{ session()->get('message') }}
        </div>
    @endif
    <div class="form-group ml-5 mt-2 mb-2">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                onchange="admins.switchInputState(this, '#handleFormInfo', '#hidShowAdminInfoWrapper')">
            <label class="form-check-label" for="flexSwitchCheckChecked">Update info</label>
        </div>
    </div>
    <form action="{{ route('admin.admin.update', request()->id) }}" id="handleFormInfo" method="post"
        class="pl-md-5 pr-md-5">
        @method('PUT')
        <div class="row mt-2">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="mt-2 d-flex">Name</label>
                    <input name="name" type="text" class="form-control d-flex" value="{{ $admin->name }}"
                        placeholder="Type name" disabled="disabled">
                    <span name="name" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Nickname</label>
                    <input name="nickname" type="text" class="form-control d-flex" value="{{ $admin->nickname }}"
                        placeholder="Type nickname" disabled="disabled">
                    <span name="nickname" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Email</label>
                    <input name="email" type="text" class="form-control d-flex" value="{{ $admin->email }}"
                        placeholder="Type email" disabled="disabled">
                    <span name="email" class="error invalid-feedback"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="mt-2 d-flex">Birthday</label>
                    <input name="birthday" type="date" class="form-control d-flex" value="{{ $admin->birthday }}"
                        disabled="disabled">
                    <span name="birthday" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2">Gender</label>
                    <select name="gender" class="custom-select" disabled="disabled">
                        <option value="">Select gender</option>
                        @foreach ($genderList as $gender)
                            <option value="{{ $gender['id'] }}" @if ($admin->gender === $gender['id']) selected @endif>
                                {{ $gender['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <span name="gender" class="text-danger" style="font-size:80% !important"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2">Status</label>
                    <select name="is_active" class="custom-select" disabled="disabled">
                        <option value="">Select status</option>
                        @foreach ($activeList as $active)
                            <option value="{{ $active['id'] }}" @if ($admin->is_active === $active['id']) selected @endif>
                                {{ $active['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <span name="is_active" class="text-danger" style="font-size:80% !important"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2">Role</label>
                    <select name="role_id" class="custom-select" disabled="disabled">
                        <option value="">Select role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role['role_id'] }}" @if ($admin->role_id === $role['role_id']) selected @endif>
                                {{ ucfirst($role['role_name']) }}
                            </option>
                        @endforeach
                    </select>
                    <span name="role_id" class="text-danger" style="font-size:80% !important"></span>
                </div>
            </div>
        </div>
        <div class="mt-2 row justify-content-end d-none" id="hidShowAdminInfoWrapper">
            <div class="col-auto">
                <button class="btn btn-primary" onclick="common.handleCreateUpdate(event, this)">
                    <i class="fas fa-check mr-2"></i>
                    Save
                </button>
            </div>
        </div>
    </form>
    <div class="form-group ml-5 mt-2 mb-3">
        <div class="form-check form-switch">
            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                onchange="admins.switchInputState(this, '#handleFormPassword', '#hidShowPasswordWrapper')">
            <label class="form-check-label" for="flexSwitchCheckChecked">Update password</label>
        </div>
    </div>
    <form action="{{ route('admin.admin.password', request()->id) }}" id="handleFormPassword" class="pl-md-5 pr-md-5"
        method="POST">
        @method('PUT')
        <div>
            <div class="form-group">
                <label class="mt-2 d-flex">Old password</label>
                <input name="old_password" type="password" class="form-control d-flex" value=""
                    placeholder="Type old password" disabled="disabled">
                <span name="old_password" class="error invalid-feedback"></span>
            </div>
        </div>
        <div>
            <div class="form-group">
                <label class="mt-2 d-flex">New password</label>
                <input name="new_password" type="password" class="form-control d-flex" value=""
                    placeholder="Type new password" disabled="disabled">
                <span name="new_password" class="error invalid-feedback"></span>
            </div>
        </div>
        <div>
            <div class="form-group">
                <label class="mt-2 d-flex">Confirm new password</label>
                <input name="confirm_new_password" type="password" class="form-control d-flex" value=""
                    placeholder="Type new password" disabled="disabled">
                <span name="confirm_new_password" class="error invalid-feedback"></span>
            </div>
        </div>
        <div class="mt-2 row justify-content-end d-none mb-5" id="hidShowPasswordWrapper">
            <div class="col-auto">
                <button class="btn btn-primary" onclick="common.handleCreateUpdate(event, this, '#handleFormPassword')">
                    <i class="fas fa-check mr-2"></i>
                    Save
                </button>
            </div>
        </div>
    </form>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/js/admins.js') }}"></script>
@endsection
