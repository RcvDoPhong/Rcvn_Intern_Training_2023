@extends('admin::layouts.master')

@section('body')
    <div class="hold-transition login-page">
        <div class="login-box">
            <!-- /.login-logo -->
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="{{ route('admin.auth.login') }}" class="h1"><b>Admin</b>LTE</a>
                </div>
                <div class="card-body">
                    <p class="login-box-msg">Sign in to start you session</p>

                    <form method="post" action="{{ route('admin.auth.process') }}" name="loginForm">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="email" value="{{ old('email') }}"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                placeholder="Email">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-envelope"></span>
                                </div>
                            </div>
                            @error('email')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="input-group mb-3">
                            <input type="password" class="form-control @error('password') is-invalid @enderror"
                                name="password" placeholder="Password">
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                            @error('password')
                                <span class="error invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>
                        <div>
                            <div class="col-8">
                                <div class="icheck-primary">
                                    <input type="checkbox" name="remember" id="remember">
                                    <label for="remember">
                                        Remember
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="text-center mt-2 mb-3">
                            <button type="submit" class="btn btn-block btn-primary" id="loginBtn">
                                Login
                            </button>
                        </div>
                    </form>
                    @if ($errors->has('message'))
                        <div class="mt-2 p-3 bg-danger text-white rounded">
                            {!! $errors->first('message') !!}
                        </div>
                    @endif
                    <p class="mb-1">
                        <a href="forgot-password.html">Recovery password</a>
                    </p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->
        </div>
    </div>
@endsection
