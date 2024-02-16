<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Models\City;
use Modules\Frontend\App\Models\Ward;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class District extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    protected $table = 'districts';
    protected $primaryKey = 'district_id';

    /**
     * Retrieves the associated city for this model.
     *
     * @return BelongsTo
     * 15/01/2024

     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    /**
     * Retrieves the wards associated with the district.
     *
     * @return HasMany
     * 15/01/2024
     */
    public function wards(): HasMany
    {
        return $this->hasMany(Ward::class, 'district_id', 'district_id');
    }


    public function getDistrictsByCity(int $cityID): Collection
    {
        return $this->where('city_id', $cityID)->get();
    }

}
