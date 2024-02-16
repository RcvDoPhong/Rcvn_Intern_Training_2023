<?php
namespace Modules\Frontend\App\Repositories\Place;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface WardRepositoryInterface extends RepositoryInterface
{

    public function getWardsByDistrict(int $districtID): Collection;
}
