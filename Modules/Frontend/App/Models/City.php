<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\District;
use Modules\Frontend\App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Modules\Frontend\Database\factories\CityFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class City extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    protected $table = 'cities';
    protected $primaryKey = 'city_id';

    /**
     * Returns the shipping methods associated with the city.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 15/01/2024
     * version:1
     */
    public function shippingMethods(): BelongsToMany
    {
        return $this->belongsToMany(ShippingMethod::class, 'shipping_cities', 'city_id', 'shipping_method_id');
    }

    /**
     * Retrieves the districts associated with the city.
     *
     * @return HasMany The districts associated with the city.
     * 15/01/2024
     * version:1
     */
    public function districts(): HasMany
    {
        return $this->hasMany(District::class, 'city_id', 'city_id');
    }


    public function getCities():Collection
    {
        return $this->all();
    }

}
