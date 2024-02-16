<?php

namespace Modules\Admin\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\App\Enums\OrderPaymentEnum;

class OrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'orderUid' => $this->formatField('Order info', $this->order_uid),
            'deliveryAddress' => [
                'user' => $this->formatField('Customer', $this->user->name),
                'telephoneNumber' => $this->formatField('Phone number', $this->telephone_number),
                'address' => $this->formatField('Delivery address', $this->delivery_address),
                'district' => $this->formatField('District', $this->district->name),
                'ward' => $this->formatField('Ward',  $this->ward->name),
                'city' => $this->formatField('City', $this->city->name),
                'zipCode' => $this->formatField('Zipcode', $this->zip_code),
            ],
            'deliveryInfo' => [
                'paymentMethod' => $this->formatField('Payment method', OrderPaymentEnum::getStatusAttribute($this->payment_method)),
                'shippingMethod' => $this->formatField(
                    'Shipping method',
                    $this->shipping->shipping_method_name,
                    '(Estimated delivery days: ' . $this->shipping->estimate_shipping_days . ' days)'
                ),
                'couponCode' => $this->formatField('Coupon', $this->coupon_code ?? ''),
            ],
            'orderSummary' => [
                'subtotalPrice' => $this->formatField('Subtotal', $this->subtotal_price),
                'shippingPrice' => $this->formatField('Shipping fee', $this->shipping_price),
                'couponPrice' => $this->formatField('Discount', $this->coupon_price),
                'totalPrice' => $this->formatField('Total', $this->total_price, true),
            ],
            'updatedBy' => $this->formatField('Updated by', $this->admin ? $this->admin->name : null),
            'createdAt' => $this->formatField('Created at', date_format(date_create($this->created_at), 'd/m/Y')),
            'updatedAt' => $this->formatField('Updated at', date_format(date_create($this->updated_at), 'd/m/Y')),
        ];
    }

    public function formatField(string $title, ?string $value, ?string $subValue = '')
    {
        return [
            'title' => $title,
            'value' => $value,
            'subValue' => $subValue
        ];
    }
}
