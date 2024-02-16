<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Http\Repositories\BrandRepository\BrandRepositoryInterface;
use Modules\Admin\App\Http\Repositories\CategoryRepository\CategoryRepositoryInterface;
use Modules\Admin\App\Http\Repositories\ProductRepository\ProductRepositoryInterface;
use Modules\Admin\App\Http\Requests\ProductFormRequest;
use Modules\Admin\App\Http\Requests\ProductUploadImageRequest;

class ProductController extends Controller
{
    protected ProductRepositoryInterface $productRepo;
    protected BrandRepositoryInterface $brandRepo;
    protected CategoryRepositoryInterface $categoryRepo;

    public function __construct(
        ProductRepositoryInterface $productRepo,
        BrandRepositoryInterface $brandRepo,
        CategoryRepositoryInterface $categoryRepo,

    ) {
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $productStatus = Constants::PRODUCT_STATUS;
        $saleTypes = Constants::PRODUCT_PRICE_TYPE;

        return view('admin::pages.products.index', [
            'title' => 'Product management',
            'products' => $this->productRepo->getPaginatedList($request->all()),
            'brands' => $this->brandRepo->getList(),
            'categories' => $this->categoryRepo->getChildCategoryList(),
            'stats' => $productStatus,
            'saleTypes' => $saleTypes,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $productStatus = Constants::PRODUCT_STATUS;
        $saleTypes = Constants::PRODUCT_PRICE_TYPE;

        return view('admin::pages.products.create', [
            'title' => 'Create new product',
            'brands' => $this->brandRepo->getList(),
            'categories' => $this->categoryRepo->getChildCategoryList(),
            'stats' => $productStatus,
            'saleTypes' => $saleTypes,
            'optionParents' => $this->productRepo->getParents(),
            'optionChildren' => $this->productRepo->getParentsNoChildren(),
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductFormRequest $request)
    {
        return $this->productRepo->createNewUpdate($request->all());
    }

    public function removeImage(Request $request)
    {
        return $this->productRepo->removeImage($request->except('_method'));
    }

    public function storeImages(ProductUploadImageRequest $request)
    {
        $createNew = filter_var($request->create_status, FILTER_VALIDATE_BOOLEAN);
        return $this->productRepo->handleUploadMultipleImage($request->product_images, $request->product_id, $createNew);
    }

    public function getProductImages(Request $request)
    {
        return $this->productRepo->getProductImages($request->id);
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request)
    {
        $product = $this->productRepo->getDetail($request->id);

        if ($request->ajax()) {
            if (!is_null($product)) {
                return Response([
                    'data' => $product,
                    'imagesList' => $product->images->pluck('image_path'),
                    'updatedBy' => $product->admin->name
                ]);
            }
            return null;
        }

        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $product = $this->productRepo->getDetail($request->id);

        if (is_null($product)) {
            flashMessage('message', 'Product not found', 'danger');

            return redirect()->back();
        }

        $productStatus = Constants::PRODUCT_STATUS;
        $saleTypes = Constants::PRODUCT_PRICE_TYPE;

        return view('admin::pages.products.edit', [
            'title' => 'Update product',
            'product' => $product,
            'brands' => $this->brandRepo->getList(),
            'categories' => $this->categoryRepo->getChildCategoryList(),
            'stats' => $productStatus,
            'saleTypes' => $saleTypes,
            'optionParents' => $this->productRepo->getParents(),
            'optionChildren' => $this->productRepo->getParentsNoChildren($request->id),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductFormRequest $request)
    {
        return $this->productRepo->createNewUpdate($request->except('_method'), $request->_method, $request->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->productRepo->destroy($request->id);
    }
}
