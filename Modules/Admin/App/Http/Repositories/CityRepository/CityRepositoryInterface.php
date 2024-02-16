<?php

namespace Modules\Admin\App\Http\Repositories\CityRepository;

use App\Repositories\RepositoryInterface;

interface CityRepositoryInterface extends RepositoryInterface
{
    public function getList();
}
