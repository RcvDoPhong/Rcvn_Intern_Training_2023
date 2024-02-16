<?php

namespace Modules\Admin\App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Admin\App\Constructs\Constants;
use Modules\Admin\App\Http\Repositories\ReviewRepository\ReviewRepositoryInterface;
use Modules\Admin\App\Http\Repositories\UserRepository\UserRepositoryInterface;

class ReviewController extends Controller
{
    protected ReviewRepositoryInterface $reviewRepo;
    protected UserRepositoryInterface $userRepo;

    public function __construct(
        ReviewRepositoryInterface $reviewRepo,
        UserRepositoryInterface $userRepo
    ) {
        $this->reviewRepo = $reviewRepo;
        $this->userRepo = $userRepo;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin::pages.reviews.index', [
            'title' => 'Review management',
            'statusList' => Constants::APPROVE_LIST,
            'reviews' => $this->reviewRepo->getPaginatedList($request->all()),
            'users' => $this->userRepo->getList()
        ]);
    }

    /**
     * Show the specified resource.
     */
    public function show(Request $request)
    {
        return $this->reviewRepo->getDetail($request->id);
    }

    public function getReviewImages(Request $request)
    {
        return $this->reviewRepo->getReviewImages($request->id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        return $this->reviewRepo->updateReview($request->id, $request->status);
    }
}
