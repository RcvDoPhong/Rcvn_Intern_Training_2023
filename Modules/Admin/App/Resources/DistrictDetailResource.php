<?php

namespace Modules\Admin\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DistrictDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'id' => $this->district_id,
            'name' => $this->name
        ];
    }
}
