<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Http\Repositories\ShippingRepository\ShippingRepositoryInterface;
use Modules\Admin\App\Http\Requests\ShippingFormRequest;

class ShippingController extends Controller
{

    protected ShippingRepositoryInterface $shippingRepo;

    public function __construct(ShippingRepositoryInterface $shippingRepo) {
        $this->shippingRepo = $shippingRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin::pages.shippings.index', [
            'title' => 'Vendor management',
            'shippings' => $this->shippingRepo->getPaginatedList($request->all()),
            'shippingTypes' => Constants::VENDOR_AREA_SUPPORT,
            'cities' => $this->shippingRepo->getCitiesList()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin::pages.shippings.create', [
            'title' => 'Create new vendor',
            'cities' => $this->shippingRepo->getCitiesList()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ShippingFormRequest $request)
    {
        return $this->shippingRepo->createNewUpdate($request->all());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Request $request)
    {
        $shipping = $this->shippingRepo->getDetail($request->id);

        if (is_null($shipping)) {
            flashMessage('message', 'Vendor not found', 'danger');

            return redirect()->route('admin.shippings.index');
        }

        $shippingTypes = Constants::VENDOR_AREA_SUPPORT;

        return view('admin::pages.shippings.edit', [
            'title' => 'Update vendor',
            'shipping' => $shipping,
            'shippingTypes' => $shippingTypes,
            'cities' => $this->shippingRepo->getCitiesList()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShippingFormRequest $request)
    {
        return $this->shippingRepo->createNewUpdate(
            $request->except(['_method']),
            $request->_method,
            $request->id
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        return $this->shippingRepo->destroy($request->id);
    }
}
