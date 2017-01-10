<?php namespace App\Observers;

use App\Iso;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IsoObserver
{
    private $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    /**
     * Listen to the document created event.
     * @param Iso $spec
     */
    public function created(Iso $spec) {
        Log::info("{$this->user->name} added new external specification {$spec->name}");
        flash("Document save to the database!.","success");
    }

    /**
     * @param Iso $spec
     */
    public function saved(Iso $spec) {
        Log::info("{$this->user->name} update external specification {$spec->name}");
        flash("Database successfully updated!.","success");
    }
}