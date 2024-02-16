<?php

namespace Modules\Admin\App\Http\Repositories\ProductRepository;

use App\Repositories\BaseRepository;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\Admin\App\Models\ProductImages;
use Modules\Admin\App\Constructs\Constants;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\Product::class;
    }

    public function getParents()
    {
        return $this->model->getList(true);
    }

    public function getParentsNoChildren(int $productIdIncluded = 0)
    {
        return $this->model->getList(true, true, true, $productIdIncluded);
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
        return $this->model->getDetail($id);
    }

    public function getProductImages(int $productId)
    {
        $product = $this->getDetail($productId);

        $productImages = [];

        if (!is_null($product)) {
            foreach ($product->images as $image) {
                $url = public_path('storage/' . $image->image_path);
                if (File::exists($url)) {
                    $productImages[] = [
                        'imageId' => $image->product_images_id,
                        'name' => File::name($url),
                        'size' => File::size($url),
                        'path' => asset('storage/' . $image->image_path)
                    ];
                }
            }
        }

        return Response([
            'data' => $productImages
        ]);
    }

    public function removeImage(array $arrProductImagesData)
    {
        $productId = $this->model->removeImage($arrProductImagesData['imageId']);
        if ($productId) {
            $fileName = $arrProductImagesData['fileName'];
            $url = public_path("storage\\Products\\Product_id_$productId\\$fileName.png");
            File::delete($url);
        }

        return Response([
            'title' => 'Removed image successfully!',
            'message' => "Removed selected image successfully!"
        ]);
    }

    public function formatProductId(object $objProductData): string
    {
        return strtoupper($objProductData->product_name[0]) . str_pad($objProductData->product_id, 10, 0, STR_PAD_LEFT);
    }

    public function handleUploadImage(int $productId, UploadedFile $imageFile, int $index = 0): string
    {
        $imageName = "Product_Id_$productId" . "_$index.png";
        $url = "Products/$imageName";
        Storage::disk('public')->put($url, file_get_contents($imageFile));

        return $url;
    }

    public function handleUploadMultipleImage(array $arrImages, int $productId, bool $createNew = false)
    {
        $arrProductImages = [];

        $product = $this->model->getDetail($productId);

        foreach ($arrImages as $value) {
            $arrProductImages[] = new ProductImages([
                'image_path' => $this->handleUploadImage($product->product_id, $value, rand(100000, 999999)),
                'product_id' => $product->product_id
            ]);
        }
        $product->images()->saveMany($arrProductImages);

        $message = 'Create new product successfully';
        if (!$createNew) {
            $message = 'Update product successfully';
        }

        return Response([
            'title' => $message,
            'message' => $message,
            'redirect' => route('admin.products.index')
        ]);
    }

    public function createNewUpdate(array $arrProductData, string $method = "POST", int $id = 0)
    {
        $data = [
            'product_name' => $arrProductData['product_name'],
            'base_price' => $arrProductData['base_price'],
            'sale_price' => data_get($arrProductData, 'sale_price', 0),
            'sale_price_percent' => data_get($arrProductData, 'sale_price_percent', 0),
            'stock' => $arrProductData['stock'],
            'brand_id' => $arrProductData['brand_id'],
            'category_id' => $arrProductData['category_id'],
            'status' => $arrProductData['status'],
            'sale_type' => data_get($arrProductData, 'sale_type', 0),
            'brief_description' => $arrProductData['brief_description'],
            'product_description' => $arrProductData['product_description'],
            'updated_by' => auth()->guard('admin')->user()->admin_id,
            'is_sale' => $arrProductData['is_sale'],
        ];

        // Handle create new Product
        if ($method === 'POST') {
            $data['is_delete'] = Constants::NOT_DESTROY;
            $product = $this->model->insert($data);
            $message = 'Create new product successfully';
        } else {
            $product = $this->model->updateProduct($id, $data);
            $message = 'Update product successfully';
        }

        $parentFlag = filter_var($arrProductData['parent_flag'], FILTER_VALIDATE_BOOLEAN);
        $options = data_get($arrProductData, 'options', []);
        $this->model->clearAllOptions($product->product_id);
        $this->handleUpdateOptions($product->product_id, $options, $parentFlag);

        $product->product_uuid = $this->formatProductId($product);

        // Handle upload product thumbnail
        if ($product_thumbnail = data_get($arrProductData, 'product_thumbnail')) {
            $product->product_thumbnail = $this->handleUploadImage($product->product_id, $product_thumbnail);
        }
        $product->save();

        return Response([
            'product_id' => $product->product_id,
            'title' => $message,
            'message' => $message,
            'status' => 200,
            'redirect' => route('admin.products.index')
        ]);
    }

    public function handleUpdateOptions(int $productId, array $options, bool $parentFlag)
    {
        if ($parentFlag) {
            foreach ($options as $option) {
                $this->model->updateProduct($option['option_id'], [
                    'parent_product_id' => $productId,
                    'option_name' => $option['option_name']
                ]);
            }
        } else {
            $this->model->updateProduct($productId, [
                'parent_product_id' => $options[0]['option_id'],
                'option_name' => $options[0]['option_name']
            ]);
        }
    }

    public function handleUpdateImages(array $arrProductImages, int $id)
    {
        if ($product_images = data_get($arrProductImages, 'product_images')) {
            $product = $this->model->getDetail($id);

            $this->model->deleteImage($id);

            $this->handleUploadMultipleImage($product_images, $product);
        }

        return Response([
            'title' => 'Update image successfully!',
            'message' => "Update product's image successfully!",
            'redirect' => route('admin.products.edit', $id)
        ]);
    }

    public function destroy(int $id)
    {
        $this->model->updateProduct($id, [
            'is_delete' => Constants::DESTROY
        ]);

        return Response([
            'title' => 'Delete product successfully!',
            'message' => 'Product has been deleted successfully!',
        ]);
    }

    public function handleReport(array $arrReportData)
    {
        $result = $this->model->handleReport($arrReportData);

        return Response([
            'labels' => $result['labels'],
            'data' => $result['data'],
            'title' => 'Top 10 most sale products ' . Constants::getEnumDateReport($arrReportData['reportTimeType'])
        ]);
    }
}
