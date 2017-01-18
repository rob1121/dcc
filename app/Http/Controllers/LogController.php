<?php namespace App\Http\Controllers;

use App\DCC\Logs\DateFormatter;
use App\DCC\Logs\GuardLog;
use App\DCC\Logs\LogRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class LogController extends Controller
{
    private $logDate;
    private $logRepo;
    private $logGuard;

    public function __construct()
    {
        $this->logDate = new DateFormatter();
        $this->logRepo = new LogRepository();
        $this->logGuard = new GuardLog();
    }

    function index() {
        return view('log.index');
    }

    function getByDate(Request $request) {
        $this->logGuard->guard($request);

        return $this->logRepo->logFrom(
                    $this->logDate->from($request->date_from),
                    $this->logDate->to($request->date_to)
                );
    }
}
