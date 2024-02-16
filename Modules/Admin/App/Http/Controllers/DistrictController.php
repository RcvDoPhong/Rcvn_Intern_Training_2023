<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Http\Repositories\DistrictRepository\DistrictRepositoryInterface;

class DistrictController extends Controller
{
    protected DistrictRepositoryInterface $districtRepo;

    public function __construct(DistrictRepositoryInterface $districtRepo) {
        $this->districtRepo = $districtRepo;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::index');
    }


    /**
     * Show the specified resource.
     */
    public function show(Request $request)
    {
        $districts = $this->districtRepo->getDistricts($request->cityId);

        if ($request->ajax()) {
            return Response([
                'data' => $districts
            ]);
        }

        return $districts;
    }
}
