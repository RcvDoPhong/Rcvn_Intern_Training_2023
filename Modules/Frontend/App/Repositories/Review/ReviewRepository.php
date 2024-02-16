<?php

namespace Modules\Frontend\App\Repositories\Review;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Modules\Frontend\App\Models\Review;
use Modules\Frontend\App\Repositories\BaseRepository;

/**
 * class ReviewRepository for add review and get reviews.
 *
 * 4/1/2023
 * version:1
 */
class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{


    public function getModel()
    {
        return Review::class;
    }

    /**
     * Adds a review for a product.
     *
     * @param Request $request The request object containing the review data.
     * @param int $productID The ID of the product to add the review for.
     * @throws Some_Exception_Class A description of the exception that may be thrown.
     * @return Review The review object that was added.
     * 18/01/2024
     */
    public function addReview(Request $request, int $productID): ?Review
    {
        if ($this->isExistReviewProduct($productID)) {
            return null;
        }
        $data = [
            "product_id" => $productID,
            "user_id" => Auth::user()->user_id,
            'rating' => $request->rating,
            'comment' => substr_replace($request->comment, "", -1),
            'title' => $request->title,
            'is_approved' => 0
        ];

        return $this->model->addReview($data);
    }

    /**
     * Checks if a review exists for a product.
     *
     * @param int $productID The ID of the product to check.
     * @return bool Returns true if a review exists for the product, false otherwise.
     */
    public function isExistReviewProduct(int $productID): bool
    {

        return $this->model->isExistReviewProduct($productID);
    }


    /**
     * Uploads a review image.
     *
     * @param Request $request The request object containing the image data.
     * @param int $reviewID The ID of the review.
     * @throws Some_Exception_Class A description of the exception that may be thrown.
     */
    public function uploadReviewImage(Request $request, int $reviewID)
    {
        // Handle image uploads
        if ($request->hasFile('review-images')) {
            $images = $request->file('review-images');
            Log::info($images);

            foreach ($images as $image) {


                // Generate a unique name for the image
                $imageName = 'review_' . $reviewID . '_' . time()
                    . '_'
                    . uniqid()
                    . '.'
                    . $image->getClientOriginalExtension();

                // Upload the image to the storage
                Storage::disk('public')->put(
                    'reviews/'
                        . $imageName,
                    file_get_contents($image)
                );
                $this->model->addReviewImage([
                    "image_path" => 'reviews/' . $imageName
                ], $reviewID);
            }
        }
    }
}
