<?php

namespace Modules\Admin\App\Http\Repositories\ProductRepository;

use App\Repositories\RepositoryInterface;
use Illuminate\Http\UploadedFile;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getModel();

    public function getList();

    public function getPaginatedList(array $arrSearchData);

    public function getDetail(int $id);

    public function getParents();

    public function getParentsNoChildren(int $productIdIncluded = 0);

    public function getProductImages(int $productId);

    public function removeImage(array $arrProductImagesData);

    public function formatProductId(object $objProductData): string;

    public function handleUploadImage(int $productId, UploadedFile $imageFile, int $index = 0): string;

    public function handleUploadMultipleImage(array $arrImages, int $productId);

    public function createNewUpdate(array $arrProductData, string $method = "POST", int $id = 0);

    public function destroy(int $id);

    public function handleReport(array $arrReportData);
}
