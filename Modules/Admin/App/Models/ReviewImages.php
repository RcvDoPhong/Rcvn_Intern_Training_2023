<?php

namespace Modules\Admin\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Admin\Database\factories\ReviewImagesFactory;

class ReviewImages extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];

    protected $table = 'review_images';

    protected $primaryKey = 'review_image_id';
    
    protected static function newFactory(): ReviewImagesFactory
    {
        //return ReviewImagesFactory::new();
    }
}
