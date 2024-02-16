@extends('frontend::layouts.master')
@section('content')
    <div class="container h-100 mt-5 mb-5">
        <div class="row  justify-content-center align-items-center">

            <div class="box_account  col col-md-6 mx-auto  ">
                <h3 class="new_client text-center">Register</h3> <small class="float-right pt-2">* Required Fields</small>
                <div class="form_container">
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" id="email" placeholder="Email*">
                        <div id="emailError" class="text-danger d-none">

                        </div>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" name="name" id="name" placeholder="FullName*">
                        <div id="nameError" class="text-danger d-none">

                        </div>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" value=""
                            placeholder="Password*">

                        <div id="passwordError" class="text-danger d-none">

                        </div>
                    </div>

                    <div class="form-group">
                        <input type="password" class="form-control" name="password_confirmation" id="password_confirmation"
                            value="" placeholder="Confirmation Password*">

                        <div id="password_confirmationError" class="text-danger d-none">

                        </div>
                    </div>
                    <div class="d-flex justify-content-end mb-3">
                        <a href="{{ route('frontend.auth.index') }}">
                            Already have an account? Login!</a>
                    </div>


                    <input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">



                    <div class="text-center"><input id="submit-register" type="submit" value="Register"
                            class="btn_1 full-width"></div>
                </div>
                <!-- /form_container -->
            </div>
            <!-- /box_account -->

        </div>
    </div>
@endsection

@section('js')
    <script type="module" src="{{ asset('js/frontend/auth/register.js') }}"></script>
@endsection
