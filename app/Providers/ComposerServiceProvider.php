<?php

namespace App\Providers;

use App\DCC\ComposerServiceProvider\GlobalVariables;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param ViewFactory $view
     */

    public function boot(ViewFactory $view) {
        $view->composer('*', GlobalVariables::class);
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
