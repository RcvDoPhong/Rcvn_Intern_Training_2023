<?php

namespace Modules\Admin\App\Http\Repositories\ReviewRepository;

use App\Repositories\RepositoryInterface;

interface ReviewRepositoryInterface extends RepositoryInterface
{
    public function getPaginatedList(array $arrSearchData);

    public function getDetail(int $id);

    public function getReviewImages(int $id);

    public function updateReview(int $id, int $statusCode);
}
