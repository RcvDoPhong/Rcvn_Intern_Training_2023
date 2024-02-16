<?php

namespace Modules\Admin\App\Http\Repositories\CityRepository;

use App\Repositories\BaseRepository;
use Modules\Admin\App\Constructs\Constants;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\City::class;
    }

    public function getList()
    {
        return $this->model->getList();
    }
}
