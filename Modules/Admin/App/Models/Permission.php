<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\database\factories\PermissionFactory;

class Permission extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name'
    ];

    protected $table = 'permissions';
    protected $primaryKey = 'permission_id';

    protected static function newFactory(): PermissionFactory
    {
        //return ViewPermissionFactory::new();
    }

    public static function getList()
    {
        return self::all();
    }

    public static function getDetailByName(string $name)
    {
        return self::where('name', $name)->first();
    }
}
