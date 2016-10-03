<?php

namespace App\Providers;

use App\CompanySpec;
use App\CustomerSpec;
use App\Iso;
use App\Observers\CompanySpecObserver;
use App\Observers\CustomerSpecObserver;
use App\Observers\IsoObserver;
use App\Observers\UserObserver;
use App\User;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        User::observe(UserObserver::class);
        Iso::observe(IsoObserver::class);
        CompanySpec::observe(CompanySpecObserver::class);
        CustomerSpec::observe(CustomerSpecObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
