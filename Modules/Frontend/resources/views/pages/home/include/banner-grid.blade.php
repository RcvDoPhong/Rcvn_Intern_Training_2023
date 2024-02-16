@php
    $categoryImg = asset('image/category-background.png');

@endphp

<ul id="banners_grid" class="clearfix">
    @foreach ($categories['parent'] as $category)
        <li>
            <a href="{{ route('frontend.category.index') }}" class="img_container">
                <img src="{{ $categoryImg }}" data-src="{{ $categoryImg }}" alt="men clothes" class="lazy">
                <div class="short_info opacity-mask" data-opacity-mask="rgba(0, 0, 0, 0.5)">
                    <h3>{{ $category['category_name'] }} Category</h3>
                    <div>

                        <span class="btn_1">Shop Now</span>
                    </div>
                </div>
            </a>
        </li>
    @endforeach

</ul>
