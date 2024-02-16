<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\CarbonImmutable;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Modules\Admin\App\Http\Repositories\BrandRepository\BrandRepositoryInterface;
use Modules\Admin\App\Http\Repositories\OrderRepository\OrderRepositoryInterface;
use Modules\Admin\App\Http\Repositories\ProductRepository\ProductRepositoryInterface;
use Modules\Admin\App\Http\Requests\ReportDateRequest;

class ReportController extends Controller
{
    protected OrderRepositoryInterface $orderRepo;
    protected ProductRepositoryInterface $productRepo;
    protected BrandRepositoryInterface $brandRepo;

    public function __construct(
        OrderRepositoryInterface $orderRepo,
        ProductRepositoryInterface $productRepo,
        BrandRepositoryInterface $brandRepo
    ) {
        $this->orderRepo = $orderRepo;
        $this->productRepo = $productRepo;
        $this->brandRepo = $brandRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin::pages.reports.index', [
            'title' => 'Report overview'
        ]);
    }

    public function reports(ReportDateRequest $request)
    {
        $report = null;
        switch ($request->reportType) {
            case 'sales':
                $report = $this->orderRepo->handleReport($request->all());
                break;
            case 'orders':
                $report = $this->orderRepo->handleReport($request->all(), 'count', '*');
                break;
            case 'products':
                $report = $this->productRepo->handleReport($request->all());
                break;
            case 'brands':
                $report = $this->brandRepo->handleReport($request->all());
                break;

            default:
                $report = null;
                break;
        }
        return $report;
    }
}
