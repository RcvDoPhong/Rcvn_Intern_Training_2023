@extends('frontend::layouts.master')

@section('content')
    @if (Auth::user()->email_verified_at)
        <div class="container h-100 mx-auto my-5">
            <h1 class=" text-center text-success">
                Congratulations
            </h1>
            <h2 class="text-center text-secondary">
                Your email already verified 😁
            </h2>
        </div>
    @else
        <div class="container h-100 mx-auto my-5">
            <h1 class=" text-center text-success">
                Our link has been sent to your email!
            </h1>
            <h2 class="text-center text-secondary">
                Please check your email 😁
            </h2>
        </div>
    @endif
@endsection
