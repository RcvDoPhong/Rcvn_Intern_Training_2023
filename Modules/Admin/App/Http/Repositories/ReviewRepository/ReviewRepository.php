<?php

namespace Modules\Admin\App\Http\Repositories\ReviewRepository;

use App\Repositories\BaseRepository;
use Illuminate\Support\Facades\File;
use Modules\Admin\App\Constructs\Constants;

class ReviewRepository extends BaseRepository implements ReviewRepositoryInterface
{
    public function getModel()
    {
        return \Modules\Admin\App\Models\Review::class;
    }

    public function getPaginatedList(array $arrSearchData)
    {
        return $this->model->getPaginatedList($arrSearchData);
    }

    public function getDetail(int $id)
    {
        $review = $this->model->getDetail($id);
        if (request()->ajax()) {
            return Response([
                'review' => $review,
                'userName' => $review->user->name,
                'productName' => $review->product->product_name,
                'imagesCount' => $review->images->count(),
                'statusList' => Constants::APPROVE_LIST
            ]);
        }
        return $review;
    }

    public function getReviewImages(int $id)
    {
        $review = $this->model->getDetail($id);

        $reviewImages = [];

        if (!is_null($review)) {
            foreach($review->images as $image) {
                $url = public_path('storage\\' . $image->image_path);
                if (File::exists($url)) {
                    $reviewImages[] = [
                        'imageId' => $image->review_image_id,
                        'name' => File::name($url),
                        'size' => File::size($url),
                        'path' => asset('storage/' . $image->image_path)
                    ];
                }
            }
        }

        return Response([
            'data' => $reviewImages
        ]);
    }

    public function updateReview(int $id, int $statusCode)
    {
        $result = $this->model->updateReview($id, [
            'is_approved' => $statusCode,
            'updated_by' => auth()->guard('admin')->user()->admin_id
        ]);

        if ($result) {
            return Response([
                'title' => 'Update review status successfully!',
                'message' => "Review's status has been updated successfully!",
            ]);
        }

        return Response([
            'title' => 'Something went wrong!',
            'message' => "Can't update review's status!",
        ], 403);
    }
}
