<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\CityFactory;

class City extends Model
{
    use HasFactory;

    protected $primaryKey = 'city_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected static function newFactory(): CityFactory
    {
        return CityFactory::new();
    }

    public static function getList()
    {
        return self::all();
    }
}
