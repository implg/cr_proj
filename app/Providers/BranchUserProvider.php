<?php

namespace App\Providers;

use App\Http\Controllers\BranchUserController;
use Illuminate\Support\ServiceProvider;

class BranchUserProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('BranchUser', function()
        {
            return new BranchUserController;
        });
    }
}
