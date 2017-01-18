<?php namespace App\DCC\Logs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;

class GuardLog
{
    use ValidatesRequests;
    private $logDate;

    public function __construct()
    {
        $this->logDate = new DateFormatter();

    }

    /**
     * validates input date range
     * @param Request $request
     */
    function guard(Request $request) {
        $this->validate($request, [
            "date_from" => "required",
            "date_to" => "required",
        ]);

        $this->validate($request, [
            "date_from" => "required|date|before:{$this->logDate->to($request->date_to)}",
            "date_to" => "required|date|after:{$this->logDate->from($request->date_from)}",
        ]);
    }
}