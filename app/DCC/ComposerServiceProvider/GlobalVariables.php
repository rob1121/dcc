<?php namespace App\DCC\ComposerServiceProvider;

use Illuminate\Contracts\View\View;
use JavaScript;

class GlobalVariables
{
    public function compose(View $view)
    {
        $server = "";
        // $server = "/qdn/public";
        $view->with('server', $server);
        JavaScript::put(['env_server' => $server]);
    }
}