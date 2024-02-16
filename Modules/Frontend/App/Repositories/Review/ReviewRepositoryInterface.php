<?php
namespace Modules\Frontend\App\Repositories\Review;

use Illuminate\Http\Request;
use Modules\Frontend\App\Models\Review;
use Modules\Frontend\App\Repositories\RepositoryInterface;

interface ReviewRepositoryInterface extends RepositoryInterface
{

    public function addReview(Request $request, int $productID): ?Review;
    public function isExistReviewProduct(int $productID): bool;

    public function uploadReviewImage(Request $request, int $reviewID);
}
