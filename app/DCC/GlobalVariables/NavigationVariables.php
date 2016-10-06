<?php namespace App\DCC\GlobalVariables;

use Illuminate\Contracts\View\View;

class NavigationVariables
{
    public function compose(View $view)
    {
        // $internal = \App\CompanySpecRevision::where("revision_date",">", \Carbon::now()->subDays(7))->count();
        // $external = \App\CustomerSpecRevision::whereIsReviewed(0)->count();
        // $iso = \App\Iso::where("revision_date",">", \Carbon::now()->subDays(7))->count();

        // $view->with("internal_count", $internal);
        // $view->with("external_count", $external);
        // $view->with("iso_count", $iso);
    }
}