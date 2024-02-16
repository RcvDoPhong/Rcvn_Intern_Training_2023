<?php

namespace Modules\Admin\App\Http\Repositories\ShippingRepository;

use App\Repositories\BaseRepository;
use Modules\Admin\App\Constructs\Constants;

class ShippingRepository extends BaseRepository implements ShippingRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\Shipping::class;
    }

    public function getList()
    {
        return $this->model->getList();
    }

    public function getCitiesList()
    {
        return $this->model->getCitiesList();
    }

    public function getPaginatedList(array $arrSearchData)
    {
        return $this->model->getPaginatedList($arrSearchData);
    }

    public function getDetail(int $id)
    {
        return $this->model->getDetail($id);
    }

    public function createNewUpdate(array $arrShippingData, string $method = "POST", int $id = 0)
    {
        $shippingSalePrice = data_get($arrShippingData, 'shipping_sale_price');
        $arrShippingData['shipping_sale_price'] = $shippingSalePrice ?? $arrShippingData['shipping_price'];
        $arrShippingData['updated_by'] = auth()->guard('admin')->user()->admin_id;

        $message = 'Create new vendor successfully!';
        if ($method === 'POST') {
            $shipping = $this->model->create($arrShippingData);
        } else {
            $shipping = $this->model->updateShipping(
                $id,
                array_diff_key($arrShippingData, ['city_id' => 0])
            );
            $message = 'Update vendor info successfully!';
        }

        $shippingCities = data_get($arrShippingData, 'city_id', null);
        $shipping->cities()->sync($shippingCities);

        return Response([
            'title' => 'Update successfully!',
            'message' => $message,
            'redirect' => route('admin.shippings.index')
        ]);
    }

    public function destroy(int $id)
    {
        $this->model->updateShipping($id, [
            'is_delete' => Constants::DESTROY
        ]);

        return Response([
            'title' => 'Delete Vendor successfully!',
            'message' => 'Selected vendor has been deleted successfully',
        ]);
    }
}
