<?php

namespace Modules\Frontend\App\Repositories\Shipping;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Models\ShippingMethod;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Shipping\ShippingRepositoryInterface;

/**
 * class ShippingRepository for retrive shipping method.
 *
 * 14/1/2024
 * version:1
 */
class ShippingRepository extends BaseRepository implements ShippingRepositoryInterface
{

    const MAX_PRICE = 1000000000;


    public function getModel()
    {
        return ShippingMethod::class;
    }


    /**
     * Get all methods.
     *
     * @return Collection
     */
    public function getAllMethod(): Collection
    {

        $methods = $this->model->getAllMethod();
        if (Auth::check()) {
            $user = Auth::user();
            if ($user['delivery_city_id']) {
                $methods = $this->getMethodByCity($user['delivery_city_id']);
            }
        }
        return $methods;
    }

    /**
     * Get a shipping method by its ID.
     *
     * @param int $id The ID of the shipping method
     * @return ShippingMethod|null The shipping method, or null if not found
     */
    public function getMethodByID(int $id): ?ShippingMethod
    {
        return $this->model->getMethodByID($id);
    }

    /**
     * Retrieve method by city ID.
     *
     * @param int $cityID The ID of the city
     * @return Collection
     */
    public function getMethodByCity(int $cityID): Collection
    {

        return $this->model->getMethodByCity($cityID);
    }

    /**
     * Get the current shipping method from the request.
     *
     * @param Request $request The request object
     * @return ShippingMethod|null The current shipping method, or null if not found
     */
    public function getCurrentMethod(Request $request): ?ShippingMethod
    {
        $currentChooseMethodFromSession = Session::get('methodCartID', 1);
        $currentChooseMethod = $request->input('methodID', $currentChooseMethodFromSession);
        Session::put('methodCartID', $currentChooseMethod);
        return $this->getMethodByID((int) $currentChooseMethod);
    }
}
