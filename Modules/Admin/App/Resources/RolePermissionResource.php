<?php

namespace Modules\Admin\App\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class RolePermissionResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray($request): array
    {
        return [
            'permissionId' => $this->permission_id,
            'rawName' => $this->name,
            'permission' => $this->pivot->allow,
            'checked' => $this->pivot->allow ? 'checked' : '',
        ];
    }
}
