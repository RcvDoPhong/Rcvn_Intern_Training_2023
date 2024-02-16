<?php

namespace Modules\Frontend\App\Models;

use Modules\Admin\App\Models\City;
use Modules\Admin\App\Models\User;
use Modules\Admin\App\Models\Ward;
use Modules\Admin\App\Models\Admin;
use Modules\Admin\App\Models\District;
use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Modules\Frontend\App\Models\OrderStatus;
use Modules\Frontend\App\Models\OrderHistory;
use Illuminate\Pagination\LengthAwarePaginator;
use Modules\Frontend\App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';

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
        'billing_address',
        'telephone_number',
        'updated_by',
    ];

    protected $casts = [
        'payment_method' => 'integer', // Cast to integer
    ];

    protected $table = 'orders';


    /**
     * Retrieves the associated user for this model.
     *
     * @return BelongsTo The user model associated with this model.
     *  16/01/2024
     * version:1
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    /**
     * Retrieves the shipping method associated with the current instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo The shipping method relation.
     *  16/01/2024
     * version:1
     */
    public function shippingMethod(): BelongsTo
    {
        return $this->belongsTo(ShippingMethod::class, 'shipping_method_id', 'shipping_method_id');
    }
    /**
     * Retrieves the city that this object belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo The city relationship.
     *  16/01/2024
     * version:1
     */
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class, 'city_id', 'city_id');
    }

    /**
     * Get the district associated with the model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 16/01/2024
     * version:1
     */
    public function district(): BelongsTo
    {
        return $this->belongsTo(District::class, 'district_id', 'district_id');
    }

    /**
     * Retrieves the associated Ward model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 16/01/2024
     * version:1
     */
    public function ward(): BelongsTo
    {
        return $this->belongsTo(Ward::class, 'ward_id', 'ward_id');
    }

    /**
     * Retrieves the relationship between the current model and the "Admin" model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     * 16/01/2024
     * version:1
     */
    public function updatedBy(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'admin_id');
    }

    /**
     * Retrieves the order history associated with this object.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 17/01/2024
     * version:1
     */
    public function orderHistory()
    {
        return $this->belongsToMany(OrderStatus::class, 'order_history', 'order_id', 'order_status_id')
            ->withTimestamps();
    }
    /**
     * Retrieve the products associated with the current instance.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     * 16/01/2024
     * version:1
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_detail', 'order_id', 'product_id')
            ->withPivot('price', 'quantity')
            ->withTimestamps();
    }

    /**
     * Add an order.
     *
     * @param array $option The options for creating the order.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return mixed The result of the order creation.
     * 16/01/2024
     * version:1
     */
    public function addOrder(array $option)
    {
        return $this->create($option);
    }

    /**
     * Adds a new order and its details.
     *
     * @param array $orderData The data for creating the order.
     * @param array $orderDetailData The data for creating the order details.
     * @throws Some_Exception_Class Description of exception if applicable.
     * @return Order|array The newly created order.
     * 16/01/2024
     * version:1
     */
    public function addOrderAndDetail(array $orderData, array $orderDetailData): Order|array
    {
        // Create a new order
        $order = self::create($orderData);

        foreach ($orderDetailData as $item) {
            $product = Product::find($item['product_id']);
            $outOfStockArr = [];
            if ($product && $product->stock >= $item['quantity']) {
                $order->products()->attach($product, [
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);

                // Update product stock
                $product->stock -= $item['quantity'];
                $product->save();
            } else {
                $outOfStockArr[] = "The product $product->product_name is out of stock.";
            }
        }

        if (!empty($outOfStockArr)) {
            return [
                "messages" => $outOfStockArr,
                "status" => 400
            ];
        }

        $this->addToOrderHistory(1, $order->order_id);

        return $order;
    }


    /**
     * check exist function
     *
     * @param string $orderUID The uuid order for check if exist.
     * @return bool
     * 16/01/2024
     * version:1
     */
    public function isExistOrderUUID(string $orderUID): bool
    {

        return $this->where('order_uid', $orderUID)->exists();
    }

    /**
     * Adds an entry to the order history.
     *
     * @param int $orderStatusId The ID of the order status.
     * @param int $updatedBy The ID of the user who updated the order status.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return void
     * 17/01/2024
     * version:1
     */
    public function addToOrderHistory(int $orderStatusId, int $orderId): void
    {
        $this->orderHistory()->attach($orderStatusId, ['order_id' => (int) $orderId]);
    }

    /**
     * Retrieves the orders along with their details and history for a specific user.
     *
     * @param int $userID The ID of the user.
     * @throws Some_Exception_Class Description of the exception that may be thrown.
     * @return Illuminate\Database\Eloquent\Collection The collection of orders with details and history.
     * 17/01/2024
     * version:1
     */
    public function getOrdersWithDetailsAndHistory(int $userID): LengthAwarePaginator
    {
        return OrderHistory::whereHas('order', function ($query) use ($userID) {
            $query->where('user_id', $userID);
        })->with(['order.products', 'order.user', 'orderStatus'])->orderByDesc('created_at')->paginate(10);
    }

    /**
     * Retrieves a specific order history record by user ID and order history ID.
     *
     * @param int $userId The ID of the user.
     * @param int $orderHistoryId The ID of the order history.
     * @throws ModelNotFoundException If the order history is not found or doesn't belong to the user.
     * @return OrderHistory|null The order history record, or null if not found or doesn't belong to the user.
     * 18/01/2024
     * version:1
     */

    public function getOrderHistoryById(int $userId, int $orderHistoryId): ?OrderHistory
    {
        try {
            return OrderHistory::where('order_history_id', $orderHistoryId)
                ->whereHas('order', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->with([
                    'order.products',
                    'order.products.reviews',
                    'order.shippingMethod',
                    'order.district',
                    'order.ward',
                    'order.city',
                    'order.user',
                    'orderStatus'
                ])
                ->first();
        } catch (ModelNotFoundException $e) {
            // Return null if the order history is not found or doesn't belong to the user.
            return null;
        }
    }




    /**
     * Cancels an order by updating the order status in the OrderHistory table.
     *
     * @param int $orderHistoryID The ID of the order history entry to cancel.
     * @throws Some_Exception_Class A description of the exception that can be thrown.
     * @return void
     */
    public function cancelOrder(int $orderHistoryID): void
    {
        OrderHistory::where('order_history_id', $orderHistoryID)->update([
            "order_status_id" => 5
        ]);
    }
}
