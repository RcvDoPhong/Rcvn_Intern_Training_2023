@extends('frontend::layouts.master')

@section('content')
    @auth
        @if (!Auth::user()->email_verified_at)
            @include('frontend::layouts.getemail')
        @endif
    @endauth
    <div id='user-info' class="container margin_60">
        <h2 class="new_client text-center mb-2">User Profile</h2>

        <div id='user-notice'>
        </div>


        <form id="user-info-form" class="form_container ">
            @include('frontend::pages.user.include.user-basic-info')
            <hr>
            @include('frontend::pages.user.include.user-delivery-address')
            <hr>
            @include('frontend::pages.user.include.user-billing-address')
            <div class="text-center"><input type="submit" value="Update" class="btn_1 full-width"></div>
        </form>
    </div>
@endsection

@section('js')
    <script src="{{ asset('js/frontend/user/user-update.js') }}"></script>
@endsection
