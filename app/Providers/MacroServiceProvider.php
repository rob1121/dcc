<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class MacroServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
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
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
