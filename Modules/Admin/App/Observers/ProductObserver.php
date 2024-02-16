<?php

namespace Modules\Admin\App\Observers;

use Laravel\Scout\ModelObserver;
use Modules\Admin\App\Models\Category;
use Modules\Admin\App\Models\Product;

class ProductObserver extends ModelObserver
{
    /**
     * Handle the Product "created" event.
     */
    public function created(Product $product, Category $category): void
    {
        dd($product);
    }

    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        //
    }

    // /**
    //  * Handle the Product "deleted" event.
    //  */
    // public function deleted(Product $product): void
    // {
    //     //
    // }

    // /**
    //  * Handle the Product "restored" event.
    //  */
    // public function restored(Product $product): void
    // {
    //     //
    // }

    // /**
    //  * Handle the Product "force deleted" event.
    //  */
    // public function forceDeleted(Product $product): void
    // {
    //     //
    // }
}
