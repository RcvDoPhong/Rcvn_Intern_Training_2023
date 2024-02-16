<?php

namespace Modules\Admin\App\Http\Repositories\DistrictRepository;

use App\Repositories\RepositoryInterface;

interface DistrictRepositoryInterface extends RepositoryInterface
{
    public function getList();

    public function getDistricts(?int $cityId);
}
