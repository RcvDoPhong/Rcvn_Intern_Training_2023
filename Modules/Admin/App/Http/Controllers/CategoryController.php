<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Redirect;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Http\Repositories\CategoryRepository\CategoryRepositoryInterface;
use Modules\Admin\App\Http\Requests\CategoryFormRequest;

class CategoryController extends Controller
{

    protected CategoryRepositoryInterface $categoryRepo;

    public function __construct(CategoryRepositoryInterface $categoryRepo)
    {
        $this->categoryRepo = $categoryRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin::pages.categories.index', [
            'title' => 'Category management',
            'categories' => $this->categoryRepo->getPaginatedList($request->all()),
            'hierarchies' => Constants::CATEGORY_HIERARCHY,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::pages.categories.create', [
            'title' => 'Create new category',
            'parentCategories' => $this->categoryRepo->getParentCategoryList(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryFormRequest $request)
    {
        return $this->categoryRepo->createNewUpdate($request->all());
    }

    /**
     * Show the specified resource.
     */
    // public function show($id)
    // {
    //     return view('admin::show');
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $category = $this->categoryRepo->getDetail($request->id);

        if (is_null($category)) {
            flashMessage('message', 'Category not found', 'danger');

            return redirect()->route('admin.categories.index');
        }
        return view('admin::pages.categories.edit', [
            'title' => 'Update category',
            'category' => $category,
            'parentCategories' => $this->categoryRepo->getParentCategoryList(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryFormRequest $request)
    {
        return $this->categoryRepo->createNewUpdate($request->all(), $request->_method, $request->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->categoryRepo->destroy($request->id);
    }
}
