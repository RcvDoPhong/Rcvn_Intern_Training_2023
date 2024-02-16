<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Frontend\Database\factories\ReviewImageFactory;

class ReviewImage extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["image_path", "review_id"];
    protected $table = "review_images";
    protected $primaryKey = "review_image_id";
    /**
     * Retrieve the Review model associated with this instance.
     *
     * @return BelongsTo The Review model associated with this instance.
     */
    public function review(): BelongsTo
    {
        return $this->belongsTo(Review::class, 'review_id', 'review_id');
    }

    public function addReviewImage(array $data, int $reviewID): ReviewImage
    {
        return self::create(["image_path" => $data["image_path"], "review_id" => $reviewID]);
    }
}
