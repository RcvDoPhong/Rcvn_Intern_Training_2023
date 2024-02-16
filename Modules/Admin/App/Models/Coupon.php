<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\CouponFactory;

class Coupon extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'code',
        'sale_price',
        'sale_price_percent',
        'sale_type',
        'description',
        'shipping_price',
        'shipping_price_percent',
        'shipping_type',
        'is_active',
        'is_delete',
        'expire_at',
        'updated_by'
    ];
    
    protected static function newFactory(): CouponFactory
    {
        return CouponFactory::new();
    }
}
