<aside class="col-lg-3" id="sidebar_fixed">


    <div class="filter_col">
        <div class="inner_bt"><a href="#" class="open_filters"><i class="ti-close"></i></a></div>
        <form id="category-form">




            @include('frontend::pages.category.include.side-menu-type.side-menu-category')
            <!-- /filter_type -->
            @include('frontend::pages.category.include.side-menu-type.side-menu-rating')
            <!-- /filter_type -->
            @include('frontend::pages.category.include.side-menu-type.side-menu-brand')
            <!-- /filter_type -->
            @include('frontend::pages.category.include.side-menu-type.side-menu-price')
            <!-- /filter_type -->
            <div class="buttons">
                <button type="submit" id="filter_btn"  class="btn_1">Filter</button>
                <button type="reset" class="btn_1 gray">Reset</button>
            </div>
        </form>
    </div>
</aside>


