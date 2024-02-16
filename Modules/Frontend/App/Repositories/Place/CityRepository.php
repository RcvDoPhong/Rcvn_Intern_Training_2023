<?php
namespace Modules\Frontend\App\Repositories\Place;


use Modules\Frontend\App\Models\City;
use Modules\Frontend\App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Place\CityRepositoryInterface;

/**
 * class City class for retrive city.
 *
 * 15/01/2024
 * version:1
 */
class CityRepository extends BaseRepository implements CityRepositoryInterface
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
        return City::class;
    }



    public function getCities(): Collection
    {

        return $this->model->getCities();
    }


}
