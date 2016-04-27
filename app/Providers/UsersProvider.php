<?php

namespace App\Providers;

use App\Http\Controllers\UsersController;
use Illuminate\Support\ServiceProvider;

class UsersProvider extends ServiceProvider
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
        $this->app->bind('Users', function()
        {
            return new UsersController;
        });
    }
}
