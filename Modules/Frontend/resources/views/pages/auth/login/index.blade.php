@extends('frontend::layouts.master')

@section('content')
    <div class="container h-100 mt-5 mb-5">
        <div class="row  justify-content-center align-items-center">

            <div class="box_account  col col-md-6 mx-auto  ">

                {{-- @if (Session::has('register-success'))
                    <div class=" text-success">
                        {{ session()->get('register-success') }}
                    </div>
                @endif --}}
                <div>

                </div>
                <h3 class="new_client text-center">Login</h3> <small class="float-right pt-2">* Required Fields</small>
                <div class="form_container">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email*">
                        <div id="emailError" class="text-danger d-none">

                        </div>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" value=""
                            placeholder="Password*">

                        <div id="passwordError" class="text-danger d-none">

                        </div>
                    </div>
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <div class="checkboxes float-start">
                            <label class="container_check">Remember me
                                <input id="remember" name="remember" type="checkbox">
                                <span class="checkmark"></span>
                            </label>
                        </div>
                        <a href="{{ route('frontend.auth.create') }}">
                            Doesn't have an account? Register!</a>
                    </div>




                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">



                    <div class="text-center"><input onclick="authUserLogin.login()" id="submit-login" type="submit"
                            value="Login" class="btn_1 full-width"></div>
                </div>
                <!-- /form_container -->
            </div>
            <!-- /box_account -->

        </div>
    </div>
@endsection

