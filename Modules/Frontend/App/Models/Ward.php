<?php

namespace Modules\Frontend\App\Models;

use Modules\Frontend\App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\District;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ward extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    protected $table = 'wards';
    protected $primaryKey = 'ward_id';

    /**
     * Returns the district that this ward belongs to.
     *
     * @return BelongsTo
     * 15/01/2024
     * version:1
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'ward_id', 'ward_id');
    }

    public function getWardsByDistrict(int $districtID): Collection
    {
        return $this->where('district_id', $districtID)->get();
    }

}
