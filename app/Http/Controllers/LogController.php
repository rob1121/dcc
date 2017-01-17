<?php namespace App\Http\Controllers;

use App\DCC\Logs\DateFormatter;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    private $logDate;

    public function __construct()
    {
        $this->logDate = new DateFormatter();
    }
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
            "date_from"  => "required",
            "date_to"    => "required",
        ]);
        $this->validate($request, [
            "date_from"  => "required|date|before:{$this->logDate->to($request->date_to)}",
            "date_to"    => "required|date|after:{$this->logDate->from($request->date_from)}",
        ]);
        
        return Activity::whereBetween("created_at", [
            $this->logDate->from($request->date_from), 
            $this->logDate->to($request->date_to)
        ])->get()->map(function($log) {
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
