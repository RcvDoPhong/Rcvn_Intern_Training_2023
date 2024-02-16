<?php

namespace Modules\Admin\database\seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Modules\Admin\App\Models\City;
use Modules\Admin\App\Models\District;
use Modules\Admin\App\Models\Ward;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $cities = [
        //     [
        //         'code' => 1,
        //         'name' => 'Hà Nội'
        //     ],
        //     [
        //         'code' => 79,
        //         'name' => 'Thành phố Hồ Chí MInh'
        //     ]
        // ];

        // foreach ($cities as $city) {
        //     $cityGet = Http::get('https://provinces.open-api.vn/api/p/' . $city['code'], [
        //         'depth' => 2
        //     ])->collect();

        //     $cityDb = City::create([
        //         'name' => $cityGet['name'],
        //         'updated_by' => 1
        //     ]);

        //     foreach ($cityGet['districts'] as $district) {
        //         $districtGet = Http::get('https://provinces.open-api.vn/api/d/' . $district['code'], [
        //             'depth' => 2
        //         ])->collect();

        //         $districtDb = District::create([
        //             'city_id' => $cityDb->city_id,
        //             'name' => $districtGet['name'],
        //             'updated_by' => 1
        //         ]);

        //         foreach ($districtGet['wards'] as $ward) {
        //             Ward::create([
        //                 'district_id' => $districtDb->district_id,
        //                 'name' => $ward['name'],
        //                 'updated_by' => 1
        //             ]);
        //         }
        //     }
        // }
        $path = public_path('city_district_ward.sql');
        $sql = file_get_contents($path);
        DB::unprepared($sql);
    }
}
