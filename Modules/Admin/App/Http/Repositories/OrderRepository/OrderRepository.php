<?php

namespace Modules\Admin\App\Http\Repositories\OrderRepository;

use App\Repositories\BaseRepository;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Resources\OrderDetailResource;
use Modules\Admin\App\Resources\OrderProductDetail;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\Order::class;
    }

    public function getList()
    {
        return $this->model->getList();
    }

    public function getOrderStatues()
    {
        return $this->model->getOrderStatues();
    }

    public function getShippingsList()
    {
        return $this->model->getShippingsList();
    }

    public function getCitiesList()
    {
        return $this->model->getCitiesList();
    }

    public function getDistrictsList()
    {
        return $this->model->getDistrictsList();
    }

    public function getWardsList()
    {
        return $this->model->getWardsList();
    }

    public function getPaginatedList(array $arrSearchData)
    {
        return $this->model->getPaginatedList($arrSearchData);
    }

    public function getDetail(int $id)
    {
        $order = $this->model->getDetail($id);

        if (request()->ajax()) {
            if (!is_null($order)) {
                return Response([
                    'data' => new OrderDetailResource($order),
                    'products' => OrderProductDetail::collection($order->products),
                    'orderStatus' => $order->status->pluck('order_status_id')[0],
                    'orderStatusList' => $this->getOrderStatues()
                ]);
            }

            return Response([
                'title' => 'Oops!',
                'message' => 'Order not found'
            ], 404);
        }

        return !is_null($order) ? $order : null;
    }

    public function updateOrderStatus(array $arrOrderStatusData)
    {
        $result = $this->model->updateOrderStatus(
            $arrOrderStatusData['id'],
            $arrOrderStatusData['status'],
            auth()->guard('admin')->user()->admin_id
        );

        if ($result) {
            return Response([
                'title' => 'Update order status successfully!',
                'message' => "Order's status has been successfully",
            ]);
        }

        return Response([
            'title' => 'Something went wrong',
            'message' => "Can't update order status!",
        ], 403);
    }

    public function handleReport(array $arrReportData, string $aggregatedFn = 'sum', string $field = 'total_price')
    {
        $result = $this->model->calcSaleReport($arrReportData, $aggregatedFn, $field);
        $title = $field === 'total_price' ? 'Total sales ' : 'Total orders ';
        $alias = $arrReportData['reportType'];
        $data = $result['data'];
        $data = $this->reIndexArray($data->toArray(), $result['labels']->toArray(), $alias);

        return Response([
            'labels' => $result['labels'],
            'data' => $data,
            'title' => $title . Constants::getEnumDateReport($arrReportData['reportTimeType']),
            'chartType' => 'line'
        ]);
    }

    public function reIndexArray(array $arrOrderData, array $arrDateLabels, string $field)
    {
        $newArrOrders = [];
        foreach ($arrOrderData as $order) {
            $date = $order['dates'];
            $newArrOrders[$date] = $order[$field];
        }

        foreach ($arrDateLabels as $date) {
            if (is_null(data_get($newArrOrders, $date))) {
                $newArrOrders[$date] = 0;
            }
        }

        ksort($newArrOrders);
        return $newArrOrders;
    }
}
