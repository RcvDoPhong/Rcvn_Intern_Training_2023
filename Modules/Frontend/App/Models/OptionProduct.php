<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\Product;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Frontend\Database\factories\OptionProductFactory;

class OptionProduct extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["option_id", "product_id"];

    protected $table = "option_product";

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, "option_id", 'product_id');
    }

}
