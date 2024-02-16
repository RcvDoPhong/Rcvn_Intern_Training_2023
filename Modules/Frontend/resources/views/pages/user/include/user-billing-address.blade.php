  @php
      ['billing_fullname' => $billingFullname, 'billing_phone_number' => $billingPhoneNumber, 'billing_city_id' => $billingCityID, 'billing_district_id' => $billingDistrictID, 'billing_ward_id' => $billingWardID, 'billing_address' => $billingAddress, 'billing_tax_id_number' => $billingTaxIDNumber] = $user;
  @endphp

  <div class="private box">
      <h4>
          Billing Address
      </h4>

      <div class="private box">
          <div class="row no-gutters">
              <div class="col-md-12 col-12 pr-1">
                  <div class="form-group">
                      <label for="billing-fullname">
                          Billing Fullname
                      </label>
                      <input id="billing-fullname" value="{{ $billingFullname }}" type="text" class="form-control"
                          name="billing_fullname" placeholder="FullName*">
                      <p id="error-billing_fullname" class="text-danger">

                      </p>
                  </div>
              </div>


              <div class="col-md-4 col-12 pr-1">
                  <div class="form-group">
                      <label for="billing-city">
                          Billing City/Proivince
                      </label>
                      <div class="">
                          <select class="p-2 rounded" name="billing_city_id" id="billing-city">
                              @foreach ($cities as $city)
                                  <option {{ $billingCityID == $city['city_id'] ? 'selected' : '' }}
                                      value="{{ $city['city_id'] }}">{{ $city['name'] }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 col-12 pr-1">
                  <div class="form-group">
                      <label for="billing-district">
                          Billing District
                      </label>
                      <div class="">
                          <select id='billing-district' class="p-2 rounded" name="billing_district_id">
                              @foreach ($districts as $district)
                                  <option {{ $billingDistrictID == $district['district_id'] ? 'selected' : '' }}
                                      value="{{ $district['district_id'] }}">{{ $district['name'] }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              </div>
              <div class="col-md-4 col-12 pr-1">
                  <div class="form-group">
                      <label for="billing-ward">
                          Billing Ward
                      </label>
                      <div class="">
                          <select id="billing-ward" class="p-2 rounded" name="billing_ward_id">
                              @foreach ($wards as $ward)
                                  <option {{ $billingWardID == $ward['ward_id'] ? 'selected' : '' }}
                                      value="{{ $ward['ward_id'] }}">{{ $ward['name'] }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
              </div>
              <div class=" col-12 pr-1">
                  <div class="form-group">
                      <label for="billing-address">
                          Billing Address
                      </label>
                      <input id="billing-address" type="text" value="{{ $billingAddress }}" class="form-control"
                          name="billing_address" placeholder="Billing Address">
                      <p id="error-billing_address" class="text-danger">

                      </p>
                  </div>
              </div>


              <div class="col-12 pr-1">
                  <div class="form-group">
                      <label for="billing-phone-number">
                          Billing Phone Number*
                      </label>
                      <input type="text" id="billing-phone-number" value="{{ $billingPhoneNumber }}"
                          class="form-control" name="billing_phone_number" placeholder="Billing Phone Number*">
                  </div>
                  <p id="error-billing_phone_number" class="text-danger">

                  </p>
              </div>

              <div class="col-12 pr-1">
                  <div class="form-group">
                      <label for="billing-tax-id-number">
                          Billing Tax ID Number
                      </label>
                      <input type="text" value="{{ $billingTaxIDNumber }}" class="form-control"
                          name="billing_tax_id_number" id="billing-tax-id-number" placeholder="Tax ID Number">
                  </div>
                  <p id="error-billing_tax_id_number" class="text-danger">

                  </p>
              </div>


          </div>

      </div>

  </div>
