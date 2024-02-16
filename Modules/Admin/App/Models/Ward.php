<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\WardFactory;

class Ward extends Model
{
    use HasFactory;

    protected $primaryKey = 'ward_id';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): WardFactory
    {
        //return WardFactory::new();
    }

    public static function getList()
    {
        return self::all();
    }

    public static function getWards(?int $districtId)
    {
        return !is_null($districtId) ? self::where('district_id', $districtId)->get() : null;
    }
}
