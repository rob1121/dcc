<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class SearchController extends Controller
{
    /**
     * it search for given keyword
     * @param Request $request
     */
    public function search(Request $request)
    {
        return "search controller";

    }
}
