<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\Product;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    use HasFactory;
    protected $table = 'coupons';

    protected $primaryKey = 'coupon_id';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
    ];

    /**
     * Retrieves a coupon by its code.
     *
     * @param string $code The code of the coupon.
     * @return Coupon|null The retrieved coupon, or null if not found.
     * 16/01/2024
     * version:1
     */
    public function getCouponByCode(string $code = ""): Coupon|string
    {
        $getCoupon = self::where('code', $code)->first();

        if (is_null($getCoupon)) {
            return "Coupon not found";
        }

        // Use the coupon ID directly for status checks
        $couponId = $getCoupon->coupon_id;

        // Fetch coupon only once
        $coupon = self::where('coupon_id', $couponId)->first();

        if ($this->isExpireCoupon($coupon) || $this->isDeleteCoupon($coupon) || !$this->isActiveCoupon($coupon)) {
            return "Coupon expired";
        }

        return $coupon;
    }

    public function isExpireCoupon(Coupon $coupon): bool
    {
        $expirationDate = Carbon::parse($coupon->expire_at);

        return $expirationDate->isPast();
    }

    public function isActiveCoupon(Coupon $coupon): bool
    {
        return $coupon->is_active == 1;
    }

    public function isDeleteCoupon(Coupon $coupon): bool
    {
        return $coupon->is_delete == 1;
    }

}
