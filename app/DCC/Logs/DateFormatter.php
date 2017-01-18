<?php namespace App\DCC\Logs;

use Carbon\Carbon;

class DateFormatter {
    public function from($date_from) {
        return $date_from ? Carbon::parse($date_from)->toDateString():'';
    }

    public function to($date_to) {
        return $date_to ? Carbon::parse($date_to)
            ->addDay()
            ->subSecond()
            ->toDateString():'';
    }
}