<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Admin\database\factories\OrderStatusFactory;

class OrderStatus extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'name'
    ];

    protected $table = 'order_status';
    protected $primaryKey = 'order_status_id';

    protected static function newFactory(): OrderStatusFactory
    {
        //return OrderStatusFactory::new();
    }

    public function getList()
    {
        return self::all();
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
