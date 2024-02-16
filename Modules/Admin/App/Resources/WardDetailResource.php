<?php

namespace Modules\Admin\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WardDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->ward_id,
            'name' => $this->name
        ];
    }
}
