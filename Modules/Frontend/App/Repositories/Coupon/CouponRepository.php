<?php
namespace Modules\Frontend\App\Repositories\Coupon;


use Modules\Frontend\App\Models\Coupon;
use Modules\Frontend\App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Models\ShippingMethod;
use Modules\Frontend\App\Repositories\BaseRepository;
use Modules\Frontend\App\Repositories\Shipping\ShippingRepositoryInterface;

/**
 * class CouponRepository for retrieve the coupon code and more.
 *
 * 16/1/2024
 * version:1
 */
class CouponRepository extends BaseRepository implements CouponRepositoryInterface
{

    const MAX_PRICE = 1000000000;


    public function getModel()
    {
        return Coupon::class;
    }



    public function getCouponByCode(string $code = ""): array
    {
        $data = $this->model->getCouponByCode($code);

        if (is_string($data)) {
            return [
                "message" => $data,
                "coupon" => null,
            ];
        }

        return [
            "coupon" => $data,
            "message" => "success",
        ];
    }



}

