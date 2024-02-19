<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Admin\database\factories\OrderHistoryFactory;

class OrderHistory extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    protected $table = 'order_history';

    protected static function newFactory(): OrderHistoryFactory
    {
        //return OrderHistoryFactory::new();
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by');
    }
}
