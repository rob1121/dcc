<?php namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
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
            "date_from"  => "required|date|before:" . $request->date_to,
            "date_to"    => "required|date|after:" . $request->date_from,
        ]);

        return Activity::where("created_at", '>=',Carbon::parse($date_from))
            ->where("created_at", '<=',Carbon::parse($date_to))
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
        return [
            "ip"          => $log->getExtraProperty('ip'),
            "name"        => $log->causer->name,
            "description" => trim("{$log->description} {$spec}")
        ];
    }
}
