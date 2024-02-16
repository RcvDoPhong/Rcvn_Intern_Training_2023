<h3 data-bs-target="#collapse_5">Sharing the app</h3>

<div class="collapse dont-collapse-sm" id="collapse_5">
    <div class="mt-2">
        <button onclick="shareApp.share()" class="btn btn-primary btn-sm">Share here</button>
    </div>
    <div class="mt-2">
        <button id="installApp" class="btn btn-primary btn-sm">Install</button>

    </div>
    <div class="mt-2">
        <button id="pushMessBtn" data-bs-toggle="modal" data-bs-target="#pushMessModal"
            class="btn btn-primary btn-sm">Push Message</button>

    </div>

    <div class="mt-2">
        <button id="registerProtocolHandler" class="btn btn-primary btn-sm">Register Protocol Handlers</button>

    </div>
    <div class="mt-2">
        <a href="web+category://%s=1">

            <button class="btn btn-primary btn-sm">Test Protocol Handlers</button>
        </a>


    </div>
    <a href="{{ route('admin.auth.login') }}">

        <div class="mt-2">
            <button class="btn btn-primary btn-sm">Go to Admin Page</button>
        </div>
    </a>

</div>


@section('modal')
    <form id="pushMessForm">



        <div class="modal fade mt-5" id="pushMessModal" tabindex="-1" aria-labelledby="pushMessModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pushMessModalLabel">Test Push Notify</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        @auth
                            <div class="input-group">
                                <p>
                                    Your ID: {{ Auth::user()->user_id }}
                                </p>

                            </div>
                            <div class="input-group mb-3">

                                <input name="receive_user_id" id="receive_user_id" type="number" class="form-control"
                                    placeholder="Receive User ID" aria-label="Receive User" aria-describedby="basic-addon1">
                            </div>

                            <div class="input-group mb-3">
                                <input name="body" id="body" type="text" class="form-control"
                                    placeholder="Body message">

                            </div>
                        @endauth

                        @guest
                            <h5>
                                Please login to test
                            </h5>
                        @endguest

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" data-bs-dismiss="modal" class="btn btn-primary">Push 😁</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
