<?php

namespace App\Http\Controllers;

use App\CustomerSpec;
use App\Iso;
use App\User;
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
        return self::searchFor(
            $request->table,
            self::model($request->table),
            $request->q
        );
    }

    public static function searchFor($db_name, $collection, $query)
    {
        return Searchy::search($db_name)->fields(self::columns($db_name))->query($query)->getQuery()->limit(10)->get()
            ->flatMap(function($item) use($collection) {
                return $collection->whereId($item->id)->get();
            });
    }

    private static function columns($table)
    {
        return $table === "users" ? ["email", "name"] : ["spec_no", "name"];
    }

    private static function model($table)
    {
        switch ($table) {
            case "users": return new User(); break;
            case "company_specs": return new CompanySpec(); break;
            case "customer_specs": return new CustomerSpec(); break;
            case "isos": return new Iso(); break;
        }
    }
}
