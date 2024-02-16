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

class OrderStatus extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_status_id';

    protected $fillable = [
        'order_status_id',
        'name',
        'updated_by',
    ];



    protected $table = 'order_status';

    /**
     * Retrieves the orders associated with this model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany The relationship between the current model and the Order model.
     * 17/01/2024
     * version:1
     */
    public function orders()
    {
        return $this->belongsToMany(Order::class, 'order_history', 'order_status_id', 'order_id')
            ->withTimestamps();
    }

}
