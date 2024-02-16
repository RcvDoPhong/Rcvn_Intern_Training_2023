<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Models\City;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Frontend\Database\factories\ShippingMethodFactory;

class ShippingMethod extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["shipping_method_name", "shipping_price", "shipping_sale_price", "shipping_sale_price_percent", "shipping_type", "estimate_shipping_days"];

    protected $table = "shipping_methods";
    protected $primaryKey = "shipping_method_id";




    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'shipping_cities', $this->primaryKey, 'city_id');
    }

    /**
     * Retrieves all data from the collection.
     *
     * @return Collection The collection containing all data.
     *12/01/2024
     * version:1
     */
    public function getAllMethod(): Collection
    {
        return self::all();
    }

    /**
     * A function to check if a record exists in the database.
     *
     * @param int $id The ID of the record to check.
     * @return bool Returns true if the record exists, false otherwise.
     *    12/01/2024
     * version:1
     */
    public function isExistMethod(int $id): bool
    {

        return self::where($this->primaryKey, $id)->exists();


    }

    /**
     * Retrieves a ShippingMethod object by its ID.
     *
     * @param int $id The ID of the ShippingMethod.
     * @return ShippingMethod|null The ShippingMethod object if found, or null if not found.
     *     *12/01/2024
     * version:1
     */
    public function getMethodByID(int $id): ?ShippingMethod
    {
        if (!$this->isExistMethod($id)) {
            return null;
        }
        return self::where($this->primaryKey, $id)->first();
    }


    /**
     * Retrieves the method based on the city ID.
     *
     * @param int $cityID The ID of the city.
     * @throws Some_Exception_Class A description of the exception that may be thrown.
     * @return Collection The result of the method retrieval.
     * 16/01/024
     * version:1
     */
    public function getMethodByCity(int $cityID): Collection
    {
        return $this->where(function ($query) {
            $query->where('shipping_type', 0)
                ->orWhere(function ($query) {
                    $query->where('shipping_type', 1);
                });
        })
            ->where(function ($query) use ($cityID) {
                $query->whereHas('cities', function ($subquery) use ($cityID) {
                    $subquery->where('cities.city_id', $cityID); // Specify the table name for city_id
                })->orWhereDoesntHave('cities');
            })
            ->with([
                'cities'
            ])
            ->get();
    }





}
