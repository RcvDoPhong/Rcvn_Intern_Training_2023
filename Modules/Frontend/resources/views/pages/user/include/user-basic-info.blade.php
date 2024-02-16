@php ['name' => $name, 'email' => $email, 'nickname' => $nickname, 'gender' => $gender, 'birthday' => $birthday, 'is_subscription' => $isSubscription, 'is_billing_address' => $isBilling] = $user; @endphp

<h4>Personal Information</h4>
<small class="float-right pt-2 pb-2">* Required Fields</small>

<div class="row no-gutters">
    <div class="col-md-6 col-12 pr-1">
        <div class="form-group">
            <label for="fullname"> Fullname* </label>
            <input type="text" id="fullname" value="{{ $name }}" name="name" class="form-control"
                placeholder="Full Name*" />
        </div>
        <p id="error-name" class="text-danger"></p>
    </div>
    <div class="col-md-6 col-12 pl-1">
        <div class="form-group">
            <label for="email"> Email* </label>
            <input type="text" id="email" value="{{ $email }}" name="email" class="form-control"
                disabled placeholder="Email*" />
        </div>
    </div>
    <div class="col-md-6 col-12">
        <div class="form-group">
            <label for="nickname"> Nickname </label>
            <input id="nickname" type="text" value="{{ $nickname }}" name="nickname" class="form-control"
                placeholder="Nickname" />
        </div>
        <p id="error-nickname" class="text-danger"></p>
    </div>
    <div class="col-md-6 col-12">
        <div class="form-group">
            <label for="birthday"> Birthday </label>
            <input type="date" id="birthday" value="{{ $birthday }}" name="birthday" class="form-control"
                placeholder="Birthday" />
        </div>
        <p id="error-birthday" class="text-danger"></p>
    </div>
    <div class="col-md-6 col-12">
        <div class="form-group">
            <label class="container_radio" style="display: inline-block; margin-right: 15px">Male <input type="radio"
                    name="gender" {{ $gender == 1 ? 'checked' : '' }} value="1">
                <span class="checkmark"></span>
            </label>
            <label class="container_radio" style="display: inline-block">Female <input type="radio"
                    {{ $gender == 0 ? 'checked' : '' }} name="gender" value="0">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>

    <div class="col-md-6 col-12">
        <div class="form-group">
            <label class="container_check">Register to the Newsletter. <input name="is_subscription"
                    {{ $isSubscription == 1 ? 'checked' : '' }} type="checkbox">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>

    <div class="col-md-6 col-12">
        <div class="d-flex align-items-center" style="gap: 0.8rem">
            <label class="">Password:</label>
            <a href="{{ route('frontend.user.change-password-page') }}">Change password here</a>
        </div>
    </div>

    <div class="col-md-6 col-12">
        <div class="form-group">
            <label class="container_check">Is same billing address. <input name="is_billing_address"
                    {{ $isBilling == 1 ? 'checked' : '' }} type="checkbox">
                <span class="checkmark"></span>
            </label>
        </div>
    </div>
</div>
