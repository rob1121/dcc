<?php namespace App\DCC\Logs;

use Spatie\Activitylog\Models\Activity;

class LogRepository
{
    private $formatter;

    public function __construct() {
        $this->formatter = new LogFormatter();
    }

    /**
     * get logs from date range
     *
     * @param $date_from
     * @param $date_to
     * @return mixed
     */
    public function logFrom($date_from, $date_to) {
        return Activity::whereBetween("created_at", [ $date_from, $date_to ])->get()
                ->map(function($log) {
                    return $this->formatter->format($log);
                });
    }
}