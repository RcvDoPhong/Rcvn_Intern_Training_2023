<?php

namespace Modules\Admin\App\Observers;

use Laravel\Scout\ModelObserver;
use Modules\Admin\App\Models\Role;

class RoleObserver
{

    protected ModelObserver $modelObserver;

    public function __construct() {
        $this->modelObserver = new ModelObserver;
    }

    /**
     * Handle the Role "created" event.
     */
    public function created($role): void
    {
        //
    }

    /**
     * Handle the Role "updated" event.
     */
    public function updated($role): void
    {
        //
    }

    public function saved($role)
    {
        $role->searchable();
        // dd('stop');
        // $this->modelObserver->saved($role);
        // static::saved($role);
        // dd($this->modelObserver->test(), 12);
    }

    // /**
    //  * Handle the Role "deleted" event.
    //  */
    // public function deleted(Role $role): void
    // {
    //     //
    // }

    // /**
    //  * Handle the Role "restored" event.
    //  */
    // public function restored(Role $role): void
    // {
    //     //
    // }

    // /**
    //  * Handle the Role "force deleted" event.
    //  */
    // public function forceDeleted(Role $role): void
    // {
    //     //
    // }
}
