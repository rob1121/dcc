<?php namespace App\DCC\GlobalVariables;

use Illuminate\Contracts\View\View;

class NavigationVariables
{
    public function compose(View $view)
    {
        $view->with('nav', [
            "internal" => newCompanySpecCount(),
            "external" => customerForSpecReviewCount(),
            "iso" => newIsoDocumentCount()
        ]);
    }
}