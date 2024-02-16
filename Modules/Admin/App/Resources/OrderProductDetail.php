<?php

namespace Modules\Admin\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Modules\Admin\App\Enums\OrderPaymentEnum;

class OrderProductDetail extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'productThumbnail' => asset('storage/' . $this->product_thumbnail),
            'productInfo' => [
                'productName' => $this->formatField('Product name', $this->product_name),
                'productPrice' => $this->formatField('Price', $this->pivot->price),
                'productQuantity' => $this->formatField('Quantity', $this->pivot->quantity)
            ]
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
