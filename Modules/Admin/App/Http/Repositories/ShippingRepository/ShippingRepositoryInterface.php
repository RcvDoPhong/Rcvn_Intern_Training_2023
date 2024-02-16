<?php

namespace Modules\Admin\App\Http\Repositories\ShippingRepository;

use App\Repositories\RepositoryInterface;

interface ShippingRepositoryInterface extends RepositoryInterface
{
    public function getList();

    public function getCitiesList();

    public function getPaginatedList(array $arrSearchData);

    public function getDetail(int $id);

    public function createNewUpdate(array $arrShippingData, string $method = "POST", int $id = 0);

    public function destroy(int $id);
}
