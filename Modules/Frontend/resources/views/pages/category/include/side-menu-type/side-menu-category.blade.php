 <div class="filter_type version_2">

     <h4><a href="#filter_1123123" data-bs-toggle="collapse" class="opened">Categories</a></h4>
     <div class="collapse show" id="filter_1123123">
         <ul>
             <li>
                 <div class="filter_type version_2">
                     @foreach ($parentCategories as $parent)
                         <h4 style="font-size: 13px !important"><a href="#filter_{{ $parent['category_id'] }}"
                                 data-bs-toggle="collapse" class="show"> {{ $parent['category_name'] }}</a></h4>


                         <ul class="collapse show" id="filter_{{ $parent['category_id'] }}">
                             @foreach ($childCategories as $child)
                                 @if ($child['parent_categories_id'] == $parent['category_id'])
                                     <li>
                                         <label class="container_check">{{ $child['category_name'] }}
                                             <input name="category"
                                                 {{ $checkCategory == $child['category_id'] ? 'checked' : '' }}
                                                 value="{{ $child['category_id'] }}" type="checkbox">
                                             <span class="checkmark"></span>
                                         </label>
                                     </li>
                                 @endif
                             @endforeach
                         </ul>
                     @endforeach

                 </div>





             </li>




         </ul>
     </div>
     <!-- /filter_type -->
 </div>
