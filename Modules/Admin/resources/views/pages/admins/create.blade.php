@extends('admin::layouts.master')

@section('content')
    @if ($errors->has('message'))
        <div class="mt-2 p-3 bg-danger text-white rounded">
            {!! $errors->first('message') !!}
        </div>
    @endif
    <form action="{{ route('admin.admin.store') }}" method="post" id="handleFormInfo" class="pl-md-5 pr-md-5">
        <div class="row">
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="mt-2 d-flex">Name</label>
                    <input name="name" type="text" class="form-control d-flex" value="" placeholder="Type name">
                    <span name="name" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Nickname</label>
                    <input name="nickname" type="text" class="form-control d-flex" placeholder="Type nickname">
                    <span name="nickname" class="error invalid-feedback"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2 d-flex">Email</label>
                    <input name="email" type="text" class="form-control d-flex" value=""
                        placeholder="Type Email">
                    <span name="email" class="error invalid-feedback"></span>
                </div>
                {{-- <div class="form-group">
                    <label class="mt-2 d-flex">Mật khẩu</label>
                    <input name="password" type="password"
                        class="form-control d-flex @error('password') is-invalid @enderror" value=""
                        placeholder="Nhập mật khẩu">
                    @error('password')
                        <span class="error invalid-feedback">{{ $message }}</span>
                    @enderror
                </div> --}}
                <div class="form-group">
                    <label class="mt-2 d-flex">Birthday</label>
                    <input name="birthday" type="date" class="form-control d-flex">
                    <span name="birthday" class="error invalid-feedback"></span>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="form-group">
                    <label class="mt-2">Gender</label>
                    <select name="gender" class="custom-select" aria-label="Default select example">
                        <option value="" selected>Select gender</option>
                        @foreach ($genderList as $gender)
                            <option value="{{ $gender['id'] }}">
                                {{ $gender['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <span name="gender" class="text-danger" style="font-size:80% !important"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2">Status</label>
                    <select name="is_active" class="custom-select" aria-label="Default select example">
                        <option value="" selected>Select status</option>
                        @foreach ($activeList as $active)
                            <option value="{{ $active['id'] }}">
                                {{ $active['name'] }}
                            </option>
                        @endforeach
                    </select>
                    <span name="is_active" class="text-danger" style="font-size:80% !important"></span>
                </div>
                <div class="form-group">
                    <label class="mt-2">Role</label>
                    <select name="role_id" class="custom-select" aria-label="Default select example">
                        <option value="" selected>Role</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role['role_id'] }}">
                                {{ ucfirst($role['role_name']) }}
                            </option>
                        @endforeach
                    </select>
                    <span class="text-danger" style="font-size:80% !important"></span>
                </div>
            </div>
        </div>
        <div class="mt-2 row justify-content-end">
            <div class="col-auto">
                <a href="{{ route('admin.admin.index') }}" class="btn btn-danger text-white">
                    <i class="fas fa-window-close mr-2"></i>
                    <span>Cancel</span>
                </a>
            </div>
            <div class="col-auto">
                <button class="btn btn-primary" onclick="common.handleCreateUpdate(event, this)">
                    <i class="fas fa-check mr-2"></i>
                    Save
                </button>
            </div>
        </div>
    </form>
@endsection
