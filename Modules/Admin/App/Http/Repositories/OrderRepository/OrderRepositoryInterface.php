<?php

namespace Modules\Admin\App\Http\Repositories\OrderRepository;

use App\Repositories\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getList();

    public function getOrderStatues();

    public function getShippingsList();

    public function getWardsList();

    public function getCitiesList();

    public function getDistrictsList();

    public function getPaginatedList(array $arrSearchData);

    public function getDetail(int $id);

    public function updateOrderStatus(array $arrOrderStatusData);

    public function handleReport(array $arrReportData, string $aggregatedFn = 'sum', string $field = 'total_price');
}
