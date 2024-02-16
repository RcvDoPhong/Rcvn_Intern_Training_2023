   @php
       ['delivery_fullname' => $deliveryFullname, 'delivery_phone_number' => $deliveryPhoneNumber, 'delivery_address' => $deliveryAddress, 'delivery_city_id' => $deliveryCityID, 'delivery_district_id' => $deliveryDistrictID, 'delivery_ward_id' => $deliveryWardID] = $user;
   @endphp

   <div class="private box">
       <h4>
           Delivery Address
       </h4>
       <div class="private box">
           <div class="row no-gutters">
               <div class="col-12 pr-1">
                   <div class="form-group">
                       <label for="delivery-fullname">
                           Delivery Fullname*
                       </label>
                       <input type="text" class="form-control" value="{{ $deliveryFullname }}" id="delivery-fullname"
                           name="delivery_fullname" placeholder="FullName*">
                       <p id="error-delivery_fullname" class="text-danger">

                       </p>
                   </div>

               </div>


               <div class="col-md-4 col-12 pr-1">
                   <div class="form-group">
                       <label for="delivery-city">Delivery City/Province</label>
                       <div class="">
                           <select class="p-2 rounded" id="delivery-city" class="" name="delivery_city_id">
                               @foreach ($cities as $city)
                                   <option {{ $deliveryCityID == $city['city_id'] ? 'selected' : '' }}
                                       value="{{ $city['city_id'] }}">{{ $city['name'] }}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
               </div>

               <div class="col-md-4 col-12 pr-1">
                   <div class="form-group">
                       <label for="delivery-district">Delivery District</label>
                       <div class="">

                           <select class="p-2 rounded" id="delivery-district" class=""
                               name="delivery_district_id">
                               @foreach ($districts as $district)
                                   <option {{ $deliveryDistrictID == $district['district_id'] ? 'selected' : '' }}
                                       value="{{ $district['district_id'] }}">{{ $district['name'] }}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
               </div>

               <div class="col-md-4 col-12 pr-1">
                   <div class="form-group">
                       <label for="delivery-ward">
                           Delivery Ward
                       </label>
                       <div class="">
                           <select class="p-2 rounded" id="delivery-ward" class="" name="delivery_ward_id">
                               @foreach ($wards as $ward)
                                   <option {{ $deliveryWardID == $ward['ward_id'] ? 'selected' : '' }}
                                       value="{{ $ward['ward_id'] }}">{{ $ward['name'] }}</option>
                               @endforeach
                           </select>
                       </div>
                   </div>
               </div>
               <div class="col-12 pr-1">
                   <div class="form-group">
                       <label for="delivery-address">
                           Delivery Address*
                       </label>
                       <input id="delivery-address" name="delivery_address" value="{{ $deliveryAddress }}"
                           type="text" class="form-control" placeholder="Delivery Address*">


                       <p id="error-delivery_address" class="text-danger">

                       </p>
                   </div>
               </div>

               <div class="col-12 pr-1">
                   <div class="form-group">
                       <label for="delivery-phone-number">
                           Delivery Phone Number*
                       </label>
                       <input value="{{ $deliveryPhoneNumber }}" name="delivery_phone_number"
                           id="delivery-phone-number" type="text" class="form-control"
                           placeholder="Delivery Phone Number*">

                       <p id="error-delivery_phone_number" class="text-danger">

                       </p>
                   </div>
               </div>


           </div>

       </div>



   </div>
