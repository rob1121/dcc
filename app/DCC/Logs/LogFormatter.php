<?php namespace App\DCC\Logs;
use Carbon\Carbon;
use Spatie\Activitylog\Models\Activity;

class LogFormatter
{
    /**
     * format activity log object
     * @param Activity $log
     * @return array
     */
    public function format(Activity $log) {
        $spec= $log->subject? $log->subject->name : '';
        $causer_name = $log->causer?$log->causer->name:"-";
        return [
            "ip"          => $log->getExtraProperty('ip'),
            "name"        => $causer_name,
            "description" => trim("{$log->description} {$spec}"),
            "created_at"  => Carbon::parse($log->created_at)->toDateTimeString(),
        ];

    }
}