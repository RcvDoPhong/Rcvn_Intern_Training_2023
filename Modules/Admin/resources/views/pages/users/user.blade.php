@extends('admin::pages.users.edit')

@section('user-info')
    <form action="{{ route('admin.users.update', request()->id) }}" method="post" id="handleFormInfo" class="pl-md-5 pr-md-5">
        @method('PUT')
        <div class="border rounded bg-white pl-md-5 pr-md-5" style="">
            <div class="fs-3 fw-bold mt-3">Customer's info</div>
            <div class="mt-3 pr-4">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Email</label>
                        <sup class="text-danger fw-bold">*</sup>
                    </div>
                    <div class="col-10">
                        <input name="email" type="email" class="form-control" value="{{ $user->email }}"
                            placeholder="Type email">
                        <span name="email" class="error invalid-feedback d-flex"></span>
                    </div>
                </div>
            </div>
            <div class="mt-3 pr-4">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Customer name</label>
                        <sup class="text-danger fw-bold">*</sup>
                    </div>
                    <div class="col-10">
                        <input name="name" type="text" class="form-control" value="{{ $user->name }}"
                            placeholder="Type customer name">
                        <span name="name" class="error invalid-feedback d-flex"></span>
                    </div>
                </div>
            </div>
            <div class="mt-3 pr-4">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Nickname</label>
                        <sup class="text-danger fw-bold">*</sup>
                    </div>
                    <div class="col-10">
                        <input name="nickname" type="text" class="form-control" value="{{ $user->nickname }}"
                            placeholder="Type nickname">
                        <span name="nickname" class="error invalid-feedback d-flex"></span>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Birthday</label>
                        <sup class="text-danger fw-bold">*</sup>
                    </div>
                    <div class="row col-10">
                        <div class="col-md">
                            <input name="birthday" type="date" class="form-control" value="{{ $user->birthday }}">
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Gender</label>
                        <sup class="text-danger fw-bold">*</sup>
                    </div>
                    <div class="col-10 mt-2">
                        <div class="row ml-2">
                            @foreach ($genderList as $gender)
                                <div class="col-auto">
                                    <input class="form-check-input" name="gender" type="radio"
                                        id="gender_{{ $gender['id'] }}" value="{{ $gender['id'] }}"
                                        @if ($user->gender === $gender['id']) checked @endif>
                                    <label class="form-check-label mr-2"
                                        for="gender_{{ $gender['id'] }}">{{ ucfirst($gender['name']) }}</label>
                                </div>
                            @endforeach
                        </div>
                        <span name="gender" class="text-danger" style="font-size:80% !important"></span>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Password</label>
                    </div>
                    <div class="col-10 mt-2">
                        <a href="#" class="text-decoration-none" data-id="{{ request()->id }}"
                            data-modal="#modalGlobal" onclick="users.renderModal(this)">
                            Change password
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3 border rounded bg-white pl-md-5 pr-md-5" style="">
            <div class="fs-3 fw-bold mt-3">Delivery Address</div>
            <div class="mt-3 pr-4">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Fullname</label>
                        <sup class="text-danger fw-bold">*</sup>
                    </div>
                    <div class="col-10">
                        <input name="delivery_fullname" type="text" class="form-control"
                            value="{{ $user->delivery_fullname }}" placeholder="Type fullname">
                        <span name="delivery_fullname" class="error invalid-feedback d-flex"></span>
                    </div>
                </div>
            </div>
            <div class="mt-3 pr-4">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Address</label>
                        <sup class="text-danger fw-bold">*</sup>
                    </div>
                    <div class="col-10">
                        <input name="delivery_address" type="text" class="form-control"
                            value="{{ $user->delivery_address }}" placeholder="Type address">
                        <span name="delivery_address" class="error invalid-feedback d-flex"></span>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">City/ District/ Ward</label>
                        <sup class="text-danger fw-bold">*</sup>
                    </div>
                    <div class="row col-10">
                        <div class="col-md">
                            <select class="form-control" name="delivery_city_id" id="delivery_city_id"
                                onchange="users.displayDistrictsWardsList(this, 'delivery', 'district')">
                                <option value="">Select city</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->city_id }}"
                                        @if ($city->city_id === $user->delivery_city_id) selected @endif>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span name="delivery_city_id" class="error invalid-feedback d-flex"></span>
                        </div>
                        <div class="col-md">
                            <select class="form-control" name="delivery_district_id" id="delivery_district_id"
                                onchange="users.displayDistrictsWardsList(this, 'delivery', 'ward')">
                                <option value="">Select district</option>
                                @if (!is_null($districtsDelivery))
                                    @foreach ($districtsDelivery as $district)
                                        <option value="{{ $district->district_id }}"
                                            @if ($user->delivery_district_id === $district->district_id) selected @endif>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span name="delivery_district_id" class="error invalid-feedback d-flex"></span>
                        </div>
                        <div class="col-md">
                            <select class="form-control" name="delivery_ward_id" id="delivery_ward_id">
                                <option value="">Select ward</option>
                                @if (!is_null($wardsDelivery))
                                    @foreach ($wardsDelivery as $ward)
                                        <option value="{{ $ward->ward_id }}"
                                            @if ($user->delivery_ward_id === $ward->ward_id) selected @endif>
                                            {{ $ward->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span name="delivery_ward_id" class="error invalid-feedback d-flex"></span>
                        </div>
                        <div class="col-md">
                            <input name="delivery_zipcode" type="text" class="form-control"
                                value="{{ $user->delivery_zipcode }}" placeholder="Nhập mã bưu điện">
                            <span name="delivery_zipcode" class="error invalid-feedback d-flex"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 pr-4">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Phone number</label>
                        <sup class="text-danger fw-bold">*</sup>
                    </div>
                    <div class="col-10">
                        <input name="delivery_phone_number" type="text" class="form-control"
                            value="{{ $user->delivery_phone_number }}" placeholder="Type phone number">
                        <span name="delivery_phone_number" class="error invalid-feedback d-flex"></span>
                    </div>
                </div>
            </div>
            <div class="mt-3 mb-3">
                <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_billing_address" id="is_billing_address">
                    <label class="form-check-label" for="is_billing_address">Use as billing address</label>
                </div>
            </div>
        </div>
        <div class="mt-3 border rounded bg-white pl-md-5 pr-md-5" style="">
            <div class="fs-3 fw-bold mt-3">Billing address</div>
            <div class="mt-3 pr-4">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Full name</label>
                    </div>
                    <div class="col-10">
                        <input name="billing_fullname" type="text" class="form-control"
                            value="{{ $user->billing_fullname }}" placeholder="Type fullname">
                        <span name="billing_fullname" class="error invalid-feedback d-flex"></span>
                    </div>
                </div>
            </div>
            <div class="mt-3 pr-4">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Address</label>
                    </div>
                    <div class="col-10">
                        <input name="billing_address" type="text" class="form-control"
                            value="{{ $user->billing_address }}" placeholder="Type address">
                        <span name="billing_address" class="error invalid-feedback d-flex"></span>
                    </div>
                </div>
            </div>
            <div class="mt-3">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">City/ District/ Ward</label>
                    </div>
                    <div class="row col-10">
                        <div class="col-md">
                            <select class="form-control" name="billing_city_id" id="billing_city_id"
                                onchange="users.displayDistrictsWardsList(this, 'billing', 'district')">
                                <option value="">Select city</option>
                                @foreach ($cities as $city)
                                    <option value="{{ $city->city_id }}"
                                        @if ($city->city_id === $user->billing_city_id) selected @endif>
                                        {{ $city->name }}
                                    </option>
                                @endforeach
                            </select>
                            <span name="billing_city_id" class="error invalid-feedback d-flex"></span>
                        </div>
                        <div class="col-md">
                            <select class="form-control" name="billing_district_id" id="billing_district_id"
                                onchange="users.displayDistrictsWardsList(this, 'billing', 'ward')">
                                <option value="">Select district</option>
                                @if (!is_null($districtsBilling))
                                    @foreach ($districtsBilling as $district)
                                        <option value="{{ $district->district_id }}"
                                            @if ($user->billing_district_id === $district->district_id) selected @endif>
                                            {{ $district->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span name="billing_district_id" class="error invalid-feedback d-flex"></span>
                        </div>
                        <div class="col-md">
                            <select class="form-control" name="billing_ward_id" id="billing_ward_id">
                                <option value="">Select ward</option>
                                @if (!is_null($wardsBilling))
                                    @foreach ($wardsBilling as $ward)
                                        <option value="{{ $ward->ward_id }}"
                                            @if ($user->billing_ward_id === $ward->ward_id) selected @endif>
                                            {{ $ward->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <span name="billing_ward_id" class="error invalid-feedback d-flex"></span>
                        </div>
                        <div class="col-md">
                            <input name="billing_zipcode" type="text" class="form-control"
                                value="{{ $user->billing_zipcode }}" placeholder="Nhập mã bưu điện">
                            <span name="billing_zipcode" class="error invalid-feedback d-flex"></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-3 pr-4">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Phone number</label>
                    </div>
                    <div class="col-10">
                        <input name="billing_phone_number" type="text" class="form-control"
                            value="{{ $user->billing_phone_number }}" placeholder="Type phone number">
                        <span name="billing_phone_number" class="error invalid-feedback d-flex"></span>
                    </div>
                </div>
            </div>
            <div class="mt-3 pr-4">
                <div class="row form-group">
                    <div class="col-2">
                        <label class="mt-2">Tax ID Number</label>
                    </div>
                    <div class="col-10">
                        <input name="billing_tax_id_number" type="text" class="form-control"
                            value="{{ $user->billing_tax_id_number }}" placeholder="Type tax id number">
                        <span name="billing_tax_id_number" class="error invalid-feedback d-flex"></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-3 d-grid">
            <button class="btn btn-primary btn-lg" onclick="common.handleCreateUpdate(event, this)">
                <i class="fas fa-check mr-2"></i>
                Update
            </button>
        </div>
    </form>
    <div>
        @include('admin::layouts.modal')
    </div>
@endsection

@section('main-scripts')
    <script src="{{ asset('admin/js/users.js') }}"></script>
@endsection
