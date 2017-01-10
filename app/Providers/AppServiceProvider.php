<?php

namespace App\Providers;

use App\CompanySpec;
use App\CustomerSpec;
use App\DCC\Transformer\DepartmentTransformer;
use App\Iso;
use App\Observers\CompanySpecObserver;
use App\Observers\CustomerSpecObserver;
use App\Observers\IsoObserver;
use App\Observers\UserObserver;
use App\User;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Collection;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        Collection::macro('userTransformer', function() {

            $charCount = User::employeeIdHighestCharCount();

            return collect($this->items)->map(function($user) use($charCount) {
                $user->employee_id = sprintf("%0{$charCount}d", $user->employee_id);
                return $user;
            });
        });

        User::observe(UserObserver::class);
        Iso::observe(IsoObserver::class);
        CompanySpec::observe(CompanySpecObserver::class);
        CustomerSpec::observe(CustomerSpecObserver::class);
        Event::fire('auth.login');
        Event::listen('auth.login', function($user) {
            Log::info("hello world");
        });
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
