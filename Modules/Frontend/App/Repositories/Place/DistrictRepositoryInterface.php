<?php
namespace Modules\Frontend\App\Repositories\Place;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface DistrictRepositoryInterface extends RepositoryInterface
{

    public function getDistrictsByCity(int $cityID): Collection;
}
