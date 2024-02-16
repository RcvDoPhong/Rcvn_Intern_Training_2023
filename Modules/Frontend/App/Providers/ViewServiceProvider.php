<?php

namespace Modules\Frontend\App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use Modules\Frontend\App\Repositories\Category\CategoryRepositoryInterface;


class ViewServiceProvider extends ServiceProvider
{
    public function boot(CategoryRepositoryInterface $categoryRepo): void
    {
        View::composer('frontend::layouts.master', function ($view) use ($categoryRepo) {
            $categories = $categoryRepo->getCategories();
            $searchName = request()->input('searchName', '');

            $view->with('childCategories', $categories['child'])
                ->with('parentCategories', $categories['parent'])
                ->with('searchName', $searchName);
        });
    }
}
