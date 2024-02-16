<?php

namespace Modules\Frontend\App\Models;

use Modules\Admin\App\Models\City;
use Modules\Admin\App\Models\User;
use Modules\Admin\App\Models\Ward;
use Modules\Admin\App\Models\Admin;
use Modules\Admin\App\Models\District;
use Modules\Frontend\App\Models\Order;
use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\Product;
use Modules\Frontend\App\Models\ShippingMethod;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class OrderHistory extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_status_id';

    protected $fillable = [
        'order_history_id',
        'order_id',
        'order_status_id',
    ];



    protected $table = 'order_history';

    /**
     * Retrieves the Order model associated with this object.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }

    /**
     * Retrieves the order status associated with this order.
     *
     * @return OrderStatus The order status.
     */
    public function orderStatus()
    {
        return $this->belongsTo(OrderStatus::class, 'order_status_id');
    }

}
