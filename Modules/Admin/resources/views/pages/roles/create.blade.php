@extends('admin::layouts.master')

@php
    $permissionGroups = Modules\Admin\App\Constructs\Constants::PERMISSION_GROUP;
@endphp
@section('content')
    <form action="{{ route('admin.roles.store') }}" method="post" id="handleFormInfo" class="pl-md-5 pr-md-5">
        <div class="row">
            <div class="col-6">
                <div class="border rounded bg-white pl-md-5 pr-md-5" style="">
                    <div class="mt-3 pr-4">
                        <div class="row form-group">
                            <div class="col-2">
                                <label class="mt-2">Role name</label>
                            </div>
                            <div class="col-10">
                                <input name="role_name" id="role_name" type="text" class="form-control" value=""
                                    placeholder="Type role name">
                                <span name="role_name" class="error invalid-feedback d-flex"></span>
                            </div>
                        </div>
                    </div>
                    <div class="form-group mt-2 mb-2">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked"
                                onchange="rolesCreate.customPermissions(this)">
                            <label class="form-check-label" for="flexSwitchCheckChecked">Customize Permissions</label>
                        </div>
                    </div>
                    <div id="permissions" class="mb-5">
                        <div id="permissionList" class="d-none">
                            <h2>Permissions</h2>
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
                                                checked>
                                            <label class="form-check-label" for="{{ $inputId }}">
                                                {{ $permissionFormat['name'] }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-3 d-grid">
                    <button class="btn btn-primary btn-lg" onclick="rolesCreate.createNew(event, this)">
                        <i class="fas fa-check mr-2"></i>
                        CREATE
                    </button>
                </div>
            </div>
        </div>
    </form>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/js/roles-create-new.js') }}"></script>
@endsection
