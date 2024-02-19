<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\database\factories\OrderFactory;

class Order extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'zip_code',
        'user_id',
        'shipping_method_id',
        'city_id',
        'district_id',
        'ward_id',
        'order_uid',
        'payment_method',
        'coupon_code',
        'total_price',
        'subtotal_price',
        'coupon_price',
        'shipping_price',
        'delivery_address',
        'telephone_number',
        'updated_by'
    ];

    protected $primaryKey = 'order_id';

    protected static function newFactory(): OrderFactory
    {
        //return OrderFactory::new();
    }

    public function shipping(): BelongsTo
    {
        return $this->belongsTo(Shipping::class, 'shipping_method_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id');
    }

    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class, 'ward_id');
    }

    public function status(): BelongsToMany
    {
        return $this->belongsToMany(OrderStatus::class, 'order_history', 'order_id', 'order_status_id')
            ->orderByPivot('order_history_id', 'desc')
            ->withTimestamps()
            ->withPivot('order_history_id');
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_detail', 'order_id', 'product_id')
            ->withPivot('quantity', 'price');
    }

    public function isExistsById(int $id): bool
    {
        return self::where($this->primaryKey, $id)->exists();
    }

    public function getOrderStatues()
    {
        return OrderStatus::all();
    }

    public function getShippingsList()
    {
        return Shipping::getList();
    }

    public function getCitiesList()
    {
        return City::getList();
    }

    public function getDistrictsList()
    {
        return District::getList();
    }

    public function getWardsList()
    {
        return Ward::getList();
    }

    public function getPaginatedList(array $arrSearchData)
    {
        $query = self::orderBy('updated_at', 'DESC');

        if (!empty($arrSearchData)) {
            $conditions = formatQuery(array_diff_key($arrSearchData, [
                'priceFrom' => 0,
                'priceTo' => 0,
                'status' => 0
            ]));

            $query = $query->where($conditions);

            $query = searchBetween($query, 'total_price', data_get($arrSearchData, 'priceFrom'), data_get($arrSearchData, 'priceTo'));
        }

        return $query->paginate(Constants::PER_PAGE)
            ->withQueryString();
    }

    public function getDetail(int $id)
    {
        return self::where($this->primaryKey, $id)->first();
    }

    public function updateOrderStatus(int $id, int $status, int $adminId): bool
    {
        $order = $this->getDetail($id);

        if ($order) {
            $order->status()->attach($status);
            $order->updated_by = $adminId;
            $order->save();

            return true;
        }

        return false;
    }

    public function calcSaleReport(array $arrReportData, string $aggregatedFn = 'sum', string $field = 'total_price')
    {
        $alias = $arrReportData['reportType'];
        $query = self::select(DB::raw("$aggregatedFn($field) as $alias"));

        $result = formatQueryReport($query, [
            'timeType' => $arrReportData['reportTimeType'],
            'time' => $arrReportData['timeLineReport']
        ], 'orders');

        return [
            'labels' => $result['labels'],
            'data' => $result['query']->get()
        ];
    }
}
