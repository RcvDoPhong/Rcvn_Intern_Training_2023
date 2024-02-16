<?php

namespace Modules\Admin\App\Http\Repositories\DistrictRepository;

use App\Repositories\BaseRepository;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Resources\DistrictDetailResource;

class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\District::class;
    }

    public function getList()
    {
        return $this->model->getList();
    }

    public function getDistricts(?int $cityId)
    {
        $districts = $this->model->getDistricts($cityId);
        return !is_null($districts) ? DistrictDetailResource::collection($districts) : null;
    }
}
