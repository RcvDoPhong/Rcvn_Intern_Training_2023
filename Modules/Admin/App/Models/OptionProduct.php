<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Modules\Admin\Database\factories\OptionProductFactory;

class OptionProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */

    protected $primaryKey = ['production_id', 'option_id'];
    public $incrementing = false;

    protected $fillable = [
        'production_id',
        'option_id',
    ];
    
    protected static function newFactory(): OptionProductFactory
    {
        //return OptionProductFactory::new();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'option_id', 'product_id');
    }
}
