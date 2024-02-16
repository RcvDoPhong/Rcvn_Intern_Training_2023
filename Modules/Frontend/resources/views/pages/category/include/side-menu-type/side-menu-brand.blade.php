 <div class="filter_type version_2">
     <h4><a href="#filter_brands" data-bs-toggle="collapse" class="closed">Brands</a></h4>
     <div class="collapse" id="filter_brands">
         <ul>

             @foreach ($brands as $brand)
                 <li>
                     <label class="container_check">{{ $brand['brand_name'] }}
                         <input name="brand" value="{{ $brand['brand_id'] }}" type="checkbox">
                         <span class="checkmark"></span>
                     </label>
                 </li>
             @endforeach

         </ul>
     </div>
 </div>
