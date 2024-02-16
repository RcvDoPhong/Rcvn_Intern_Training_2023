<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Http\Repositories\WardRepository\WardRepositoryInterface;

class WardController extends Controller
{
    protected WardRepositoryInterface $wardRepo;

    public function __construct(WardRepositoryInterface $wardRepo) {
        $this->wardRepo = $wardRepo;
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
        $wards = $this->wardRepo->getWards($request->districtId);

        if ($request->ajax()) {
            return Response([
                'data' => $wards
            ]);
        }

        return $wards;
    }
}
