<?php

namespace Modules\Frontend\App\Models;

use Illuminate\Support\Facades\Auth;
use Modules\Frontend\App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Modules\Frontend\App\Models\Product;
use Modules\Frontend\App\Models\ReviewImage;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Frontend\Database\factories\ReviewFactory;

class Review extends Model
{
    use HasFactory;

    protected $primaryKey   = "review_id";

    protected $table        = "reviews";
    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = ["review_id", 'user_id', "product_id", "rating", 'updated_by', 'created_at', "updated_at", 'title', 'is_approved', 'comment'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'product_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'user_id');
    }

    public function reviewImages(): HasMany
    {
        return $this->hasMany(ReviewImage::class, 'review_id', 'review_id');
    }


    /**
     * Adds a review to the system.
     *
     * @param array $data The data for the review.
     * @return Review The newly created review.
     *  18/01/2024
     * version:1
     */
    public function addReview(array $data): Review
    {
        return self::create($data);
    }


    /**
     * Check if a review for a product exists.
     *
     * @param int $productID The ID of the product.
     * @throws Some_Exception_Class description of exception
     * @return
     *  18/01/2024
     * version:1
     */
    public function isExistReviewProduct(int $productID): bool
    {
        return $this->where("product_id", $productID)->where("user_id", Auth::user()->user_id)->exists();
    }

    /**
     * Adds a review image to the system.
     *
     * @param array $data The data of the review image.
     * @param int $reviewID The ID of the review.
     * @throws Some_Exception_Class A description of the exception.
     * @return ReviewImage The added review image.
     */
    public function addReviewImage(array $data, int $reviewID): ReviewImage
    {
        return ReviewImage::create(["image_path" => $data["image_path"], "review_id" => $reviewID]);
    }
}
