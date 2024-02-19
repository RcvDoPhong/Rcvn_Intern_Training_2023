<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\database\factories\ProductImagesFactory;

class ProductImages extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'product_id',
        'image_path'
    ];
    protected $primaryKey = 'product_images_id';

    protected static function newFactory(): ProductImagesFactory
    {
        //return ProductImagesFactory::new();
    }

    public static function isExistsById(int $imageId)
    {
        return self::where('product_images_id', $imageId)->exists();
    }

    public static function getProductId(int $imageId)
    {
        if (self::isExistsById($imageId)) {
            return self::where('product_images_id', $imageId)->first();
        }

        return null;
    }
}
