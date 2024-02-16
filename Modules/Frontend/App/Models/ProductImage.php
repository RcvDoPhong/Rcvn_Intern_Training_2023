<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Frontend\Database\factories\ProductImageFactory;

class ProductImage extends Model
{
    use HasFactory;
    protected $table = 'product_images';
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["image_path", 'updated_by'];

    public function product()
    {

        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }
}
