<?php

namespace Modules\Frontend\App\Repositories\Shipping;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Modules\Frontend\App\Models\ShippingMethod;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface ShippingRepositoryInterface extends RepositoryInterface
{
    public function getAllMethod(): Collection;

    public function getMethodByID(int $id): ?ShippingMethod;

    public function getMethodByCity(int $cityID): Collection;

    public function getCurrentMethod(Request $request): ?ShippingMethod;
}
