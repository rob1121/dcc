<?php

namespace App\Http\Controllers;

use App\CustomerSpec;
use Illuminate\Http\Request;
use TomLingham\Searchy\Facades\Searchy;
use App\CompanySpec;

class SearchController extends Controller
{
    /**
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {

        return [
            "internal" => self::searchFor("company_specs", new CompanySpec, $request->q),
            "external" =>  self::searchFor("customer_specs", new CustomerSpec, $request->q),
        ];
    }

    public static function searchFor($db_name, $collection, $query)
    {
        return Searchy::search($db_name)->fields("spec_no", "name")->query($query)->getQuery()->limit(10)->get()
            ->flatMap(function($item) use($collection) {
                return $collection->whereId($item->id)->get();
            });
    }
}
