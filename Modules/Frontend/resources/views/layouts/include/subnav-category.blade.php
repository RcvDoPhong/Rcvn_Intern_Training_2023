 <ul style="min-height: 250px">

     @foreach ($parentCategories as $parent)
         <li><span><a href="#0">{{ $parent['category_name'] }}</a></span>
             <ul>


                 @foreach ($childCategories as $child)
                     @if ($child['parent_categories_id'] == $parent['category_id'])
                         <li><a
                                 href="{{ route('frontend.category.index', ['category_id' => $child['category_id']]) }}">{{ $child['category_name'] }}</a>
                         </li>
                     @endif
                 @endforeach
             </ul>
         </li>
     @endforeach

 </ul>
