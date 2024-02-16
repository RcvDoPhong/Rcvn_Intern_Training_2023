<?php

namespace Modules\Admin\App\Http\Repositories\WardRepository;

use App\Repositories\BaseRepository;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Resources\WardDetailResource;

class WardRepository extends BaseRepository implements WardRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\Ward::class;
    }

    public function getList()
    {
        return $this->model->getList();
    }

    public function getWards(?int $districtId)
    {
        $wards = $this->model->getWards($districtId);
        return !is_null($wards) ? WardDetailResource::collection($wards) : null;
    }
}
