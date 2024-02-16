<?php
namespace Modules\Frontend\App\Repositories\Place;


use Modules\Frontend\App\Models\District;
use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Place\DistrictRepositoryInterface;

/**
 * class DistrictRepository class for retrieve district.
 *
 * 15/01/2024
 * version:1
 */
class DistrictRepository extends BaseRepository implements DistrictRepositoryInterface
{

    /**
     * Retrieves the model class for the function.
     *
     * @return string The fully qualified class name of the model.
     * version:1
     * 08/01/2024
     */
    public function getModel()
    {
        return District::class;
    }



    public function getDistrictsByCity(int $cityID): Collection
    {
        return $this->model->getDistrictsByCity($cityID);
    }


}
