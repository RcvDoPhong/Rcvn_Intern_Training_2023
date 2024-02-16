<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Http\Repositories\BrandRepository\BrandRepositoryInterface;
use Modules\Admin\App\Http\Requests\BrandFormRequest;

class BrandController extends Controller
{
    protected BrandRepositoryInterface $brandRepo;

    public function __construct(BrandRepositoryInterface $brandRepo)
    {
        $this->brandRepo = $brandRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin::pages.brands.index', [
            'title' => 'Brand management',
            'brands' => $this->brandRepo->getPaginatedList($request->all())
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::pages.brands.create', [
            'title' => 'Create new brand'
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(BrandFormRequest $request)
    {
        return $this->brandRepo->createNewUpdate($request->all());
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request)
    {
        return $this->brandRepo->getDetail($request->id);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $brand = $this->brandRepo->getDetail($request->id);

        if (is_null($brand)) {
            flashMessage('message', 'Brand not found', 'danger');

            return redirect()->route('admin.brands.index');
        }

        return view('admin::pages.brands.edit', [
            'title' => 'Update brand',
            'brand' => $brand
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(BrandFormRequest $request)
    {
        return $this->brandRepo->createNewUpdate($request->all(), $request->_method, $request->id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->brandRepo->destroy($request->id);
    }
}
