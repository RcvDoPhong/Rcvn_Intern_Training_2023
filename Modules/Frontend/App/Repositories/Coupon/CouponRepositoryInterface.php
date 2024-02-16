<?php
namespace Modules\Frontend\App\Repositories\Coupon;

use Modules\Frontend\App\Models\Coupon;

use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Models\ShippingMethod;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface CouponRepositoryInterface extends RepositoryInterface
{
    public function getCouponByCode(string $code = ""): array;

}
