<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    function index() {
        return view('log.index');
    }

    function getByUser($user) {
        return Activity::where("causer_id", $user)
            ->get()->map(function($log) {
                return $this->getLog($log);
            });
    }

    function getByDate(Request $request) {
        $this->validate($request, [
            "date_from"  => "required|date|before:" . Carbon::parse($request->date_to)->addDay(),
            "date_to"    => "required|date|after:" . Carbon::parse($request->date_from)->subDay(),
        ]);

        return Activity::where("created_at", '>=',Carbon::parse($request->date_from)->subDay())
            ->where("created_at", '<=',Carbon::parse($request->date_to)->addDay())
            ->get()->map(function($log) {
                return $this->getLog($log);
            });
    }

    function getAll() {
        return Activity::all()->map(function($log) {
            return $this->getLog($log);
        });
    }

    private function getLog($log) {
        $spec= $log->subject? $log->subject->name : '';
        $causer_name = $log->causer?$log->causer->name:"not defined";
        return [
            "ip"          => $log->getExtraProperty('ip'),
            "name"        => $causer_name,
            "description" => trim("{$log->description} {$spec}"),
            "created_at"  => Carbon::parse($log->created_at)->toDateTimeString(),
        ];
    }
}
