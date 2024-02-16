<div class=" bg-warning text-white">
    <form method="GET" class="d-flex w-100 justify-content-between align-items-center py-2 px-1"
        action="{{ route('send.verification.email') }}">
        @csrf
        <div>
            You still not verified your email.
        </div>
        <button type="submit" class="btn btn-primary">Send Verification Email</button>
    </form>
</div>
