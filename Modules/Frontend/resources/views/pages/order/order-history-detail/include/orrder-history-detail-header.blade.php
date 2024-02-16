   @php
       $paymentMethodName = $order['payment_method'] == 0 ? 'COD' : 'Paypal';
   @endphp

   <div class=" bg-light  border w-100 rounded ">

       <div class=" row w-100 p-4 gx-3">

           <div class="col-sm-4 d-md-flex  flex-column align-items-start" style="gap: 1rem">
               <h6>
                   User Information:
               </h6>
               <div>
                   <strong>
                       Full name:
                   </strong>
                   {{ $user['delivery_fullname'] }}
               </div>

               <div>
                   <strong>
                       State/Province:
                   </strong>
                   {{ $order['city']['name'] }}
               </div>
               <div>
                   <strong>
                       District:
                   </strong>
                   {{ $order['district']['name'] }}
               </div>
               <div>
                   <strong>
                       Ward:
                   </strong>
                   {{ $order['ward']['name'] }}
               </div>

               <div>
                   <strong>
                       Address:
                   </strong>
                   {{ $user['delivery_address'] }}
               </div>

           </div>


           <div class="col-sm-4 d-md-flex  flex-column align-items-start" style="gap: 1rem">
               <h6>
                   Payment Method:
               </h6>
               <div>
                   <strong>
                       Name:
                   </strong>
                   {{ $paymentMethodName }}
               </div>

               <h6>
                   Shipping Method:
               </h6>
               <div>
                   <strong>
                       Name:
                   </strong>
                   {{ $shippingMethod['shipping_method_name'] }}
               </div>

           </div>


           <div class="col-sm-4 d-md-flex  flex-column align-items-start" style="gap: 1rem">
               <h6>
                   Order Summary:
               </h6>
               <div>
                   <strong>
                       Subtotal price:
                   </strong>
                   ${{ number_format($order['subtotal_price'], 0, ',', '.') }}
               </div>
               <div>
                   <strong>
                       Shipping price:
                   </strong>
                   ${{ number_format($order['shiping_price'], 0, ',', '.') }}
               </div>
               <div>
                   <strong>
                       Coupon price:
                   </strong>
                   ${{ number_format($order['coupon_price'], 0, ',', '.') }}
               </div>
               <div>
                   <strong>
                       Total Amount:
                   </strong>
                   ${{ number_format($order['total_price'], 0, ',', '.') }}
               </div>


               <div>
                   <strong>
                       Order UID:
                   </strong>
                   {{ explode('.', $order['order_uid'])[0] }}
               </div>
           </div>







       </div>

   </div>
