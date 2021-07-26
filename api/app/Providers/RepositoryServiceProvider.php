<?php

namespace App\Providers;

use App\Repositories\Contracts\IUser;
use App\Repositories\Contracts\IDesign;
use Illuminate\Support\ServiceProvider;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Eloquent\DesignRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
      $this->app->bind(IUser::class, UserRepository::class);
      $this->app->bind(IDesign::class, DesignRepository::class);
    }
}
