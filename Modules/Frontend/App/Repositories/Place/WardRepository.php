<?php
namespace Modules\Frontend\App\Repositories\Place;



use Modules\Frontend\App\Models\Ward;
use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Place\WardRepositoryInterface;

/**
 * class WardRepository class for retrieve ward.
 *
 * 15/01/2024
 * version:1
 */
class WardRepository extends BaseRepository implements WardRepositoryInterface
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
        return Ward::class;
    }


    public function getWardsByDistrict(int $districtID): Collection
    {

        return $this->model->getWardsByDistrict($districtID);
    }


}
