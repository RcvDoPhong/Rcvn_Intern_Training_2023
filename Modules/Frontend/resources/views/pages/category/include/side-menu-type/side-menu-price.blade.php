<div class="filter_type version_2">
    <h4><a href="#filter_price" data-bs-toggle="collapse" class="closed">Price</a></h4>
    <div class="collapse" id="filter_price">
        <ul>
            <li>
                <label class="fw-semibold me-1" for="minPrice">Min Price</label>
                <input value="0" min="0" max="100000000" id="minPrice" class="rounded-pill px-2" name="minPrice"
                    type="number">

            </li>
            <li>
                <label class="fw-semibold me-1" for="maxPrice">Max Price</label>
                <input value="100000" min="0" max="100000000" class="rounded-pill px-2" id="maxPrice" name="maxPrice"
                    type="number">

            </li>

            <li id="min-price-error" class="text-danger"></li>
            <li id="max-price-error" class="text-danger"></li>

        </ul>
    </div>
</div>
