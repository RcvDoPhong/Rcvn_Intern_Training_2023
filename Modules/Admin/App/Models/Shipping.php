<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\Database\factories\ShippingFactory;

class Shipping extends Model
{
    use HasFactory;

    private array $compareLikeField = ['shipping_method_name'];
    private array $compareEqualField = ['shipping_type', 'updated_by'];

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'shipping_method_name',
        'description',
        'shipping_price',
        'shipping_sale_price',
        'shipping_sale_price_percent',
        'shipping_type',
        'estimate_shipping_days',
        'is_delete',
        'updated_by'
    ];

    protected $primaryKey = 'shipping_method_id';
    protected $table = 'shipping_methods';

    protected static function newFactory(): ShippingFactory
    {
        return ShippingFactory::new();
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(City::class, 'shipping_cities', $this->primaryKey, 'city_id');
    }

    public static function getList()
    {
        return self::where('is_delete', '<>', Constants::DESTROY)->get();
    }

    public function isExistsByName(string $name, bool $excluded = false, int $id = 0): bool
    {
        $query = self::where('shipping_method_name', $name);

        if ($excluded) {
            $query = $query->where($this->primaryKey, '<>', $id);
        }

        return $query->exists();
    }

    public function isExistsById(int $id)
    {
        return self::where($this->primaryKey, $id)->exists();
    }

    public function getDetail(int $id)
    {
        if ($this->isExistsById($id)) {
            $shipping = self::where($this->primaryKey, $id)->first();

            if ($shipping->is_delete !== Constants::DESTROY) {
                return $shipping;
            }
        }
        return null;
    }

    public function getCitiesList()
    {
        return City::getList();
    }

    public function getPaginatedList(array $arrSearchData)
    {
        $query = self::where('is_delete', '<>', Constants::DESTROY);

        if (!empty($arrSearchData)) {
            $conditions = formatQuery(array_diff_key($arrSearchData, [
                'priceFrom' => 0,
                'priceTo' => 0,
                'dateFrom' => 0,
                'dateTo' => 0
            ]));

            $query = $query->where($conditions);

            $query = searchBetween($query, 'shipping_price', data_get($arrSearchData, 'priceFrom'), data_get($arrSearchData, 'priceTo'));
            $query = searchBetween($query, 'estimate_shipping_days', data_get($arrSearchData, 'dateFrom'), data_get($arrSearchData, 'dateTo'));
        }

        return $query->orderBy('updated_at', 'DESC')
            ->paginate(Constants::PER_PAGE)
            ->withQueryString();
    }

    public function updateShipping(int $id, array $arrShippingData)
    {
        return tap(self::where($this->primaryKey, $id))->update($arrShippingData)->first();
    }
}
