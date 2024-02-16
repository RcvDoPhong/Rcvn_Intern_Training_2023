  @php
      $displayPrice = $product['sale_type'] === 0 ? (float) $product['sale_price'] : $product['base_price'] - $product['base_price'] * $product['sale_price_percent'];

  @endphp
  <div class="col-sm-2">
      <figure>

          <a href="{{ route('frontend.product.index', ['id' => $product['product_id']]) }}">
              <img height="100" class="img-fluid lazy" src="{{ asset('storage/' . $product['product_thumbnail']) }}"
                  alt="{{ $product['product_thumbnail'] }}">
          </a>
      </figure>
  </div>
  <div class="col-sm-8">

      <a href="{{ route('frontend.product.index', ['id' => $product['product_id']]) }}">
          <h3>{{ $product['product_name'] }}</h3>
      </a>
      <p>
          {{ $product['brief_description'] }}
      </p>
      <div class="price_box">
          <div class="new_price">
              ${{ number_format($product['pivot']['quantity'] * $product['pivot']['price'], 0, ',', '.') }}
          </div>
          <em>
              <strong>
                  <div class="">Quantity: {{ $product['pivot']['quantity'] }} *<span>
                          ${{ $product['pivot']['price'] }}
                      </span></div>
              </strong>

          </em>


      </div>
      <div>

      </div>

  </div>
