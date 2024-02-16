<?php

namespace Modules\Admin\App\Http\Repositories\BrandRepository;

use App\Repositories\BaseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\App\Constructs\Constants;

class BrandRepository extends BaseRepository implements BrandRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\Brand::class;
    }

    public function getList()
    {
        return $this->model->getList();
    }

    public function getPaginatedList(array $arrSearchData)
    {
        return $this->model->getPaginatedList($arrSearchData);
    }

    public function getDetail(int $id)
    {
        $brand = $this->model->getDetail($id);

        if (request()->ajax()) {
            if (!is_null($brand)) {
                return Response([
                    'brandName' => $brand->brand_name,
                    'brandLogo' => $brand->brand_logo,
                    'data' => [
                        'founded' => $brand->founded,
                        'productCounts' => $brand->products->count(),
                        'updatedBy' => $brand->admin->name,
                    ],
                    'brandId' => $brand->brand_id,
                ]);
            }

            return Response([
                'title' => 'Something went wrong',
                'message' => "Brand doesn't exist"
            ], 404);
        }

        return !is_null($brand) ? $brand : null;
    }

    public function handleUploadImage(string $brandId, UploadedFile $imageFile): string
    {
        $imageName = 'BrandId_' . $brandId . '.png';
        return Storage::disk('public')->putFileAs('images', $imageFile, $imageName);
    }

    public function createNewUpdate(array $arrBrandData, string $method = "POST", int $id = 0)
    {
        $data = [
            'brand_name' => $arrBrandData['brand_name'],
            'founded' => $arrBrandData['founded'],
            'updated_by' => auth()->guard('admin')->user()->admin_id
        ];

        $message = 'Create new brand successfully!';
        if ($method === "POST") {
            $brand = $this->model->create($data);
        } else {
            $brand = $this->model->updateBrandData($id, $data);
            $message = 'Update brand successfully!';
        }

        if (data_get($arrBrandData, 'brand_logo')) {
            $brand->brand_logo = $this->handleUploadImage($brand->brand_id, $arrBrandData['brand_logo']);
            $brand->save();
        }

        return Response([
            'title' => $message,
            'message' => $message,
            'redirect' => route('admin.brands.index')
        ]);
    }

    public function destroy(int $brandId)
    {
        $this->model->updateBrandData($brandId, [
            'is_delete' => Constants::DESTROY
        ]);
        $this->model->updateDeleteProductState($brandId);

        return Response([
            'title' => 'Delete brand successfully!',
            'message' => 'Selected brand has been deleted successfully!'
        ]);
    }

    public function handleReport(array $arrReportData)
    {
        $result = $this->model->handleReport($arrReportData);

        return Response([
            'labels' => $result['labels'],
            'data' => $result['data'],
            'title' => 'Top 5 most sales brands ' . Constants::getEnumDateReport($arrReportData['reportTimeType'])
        ]);
    }
}
