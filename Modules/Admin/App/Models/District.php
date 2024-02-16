<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\DistrictFactory;

class District extends Model
{
    use HasFactory;

    protected $primaryKey = 'district_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): DistrictFactory
    {
        //return DistrictFactory::new();
    }

    public static function getList()
    {
        return self::all();
    }

    public static function getDistricts(?int $cityId)
    {
        return !is_null($cityId) ? self::where('city_id', $cityId)->get() : null;
    }
}
