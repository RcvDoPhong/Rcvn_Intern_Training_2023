<?php

namespace Modules\Frontend\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Frontend\App\Repositories\Place\CityRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\DistrictRepositoryInterface;
use Modules\Frontend\App\Repositories\Place\WardRepositoryInterface;

class PlaceController extends Controller
{

    private $cityRepo;

    private $districtRepo;
    private $wardRepo;


    public function __construct(CityRepositoryInterface $cityRepo, DistrictRepositoryInterface $districtRepo, WardRepositoryInterface $wardRepo)
    {

        $this->cityRepo = $cityRepo;
        $this->districtRepo = $districtRepo;
        $this->wardRepo = $wardRepo;
    }

    public function getCities()
    {
        $cities = $this->cityRepo->getCities();
        return response()->json($cities);
    }

    public function getDistrictsByCity(Request $request, $cityID)
    {
        $districts = $this->districtRepo->getDistrictsByCity($cityID);
        return response()->json($districts);

    }

    public function getWardByDistrict(Request $request, $districtID)
    {

        $wards = $this->wardRepo->getWardsByDistrict($districtID);
        return response()->json($wards);
    }
}
