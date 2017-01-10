<?php namespace App\Observers;

use App\CustomerSpec;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CustomerSpecObserver
{
    private $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    /**
     * Listen to the document created event.
     * @param CustomerSpec $spec
     */
    public function created(CustomerSpec $spec) {
        Log::info("{$this->user->name} added new external specification {$spec->name}");
        flash("Document save to the database!.","success");
    }

    /**
     * Listen to the Document updated event.
     * @param CustomerSpec $spec
     */
    public function saved(CustomerSpec $spec) {
        Log::info("{$this->user->name} update external specification {$spec->name}");
        flash("Database successfully updated!.","success");
    }

}