<?php namespace App\Observers;

use App\CompanySpec;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class CompanySpecObserver
{
    private $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    /**
     * Listen to the document created event.
     * @param CompanySpec $spec
     */
    public function created(CompanySpec $spec) {
        Log::info("{$this->user->name} added new specs {$spec->name}");
        flash("Document save to the database!.","success");
    }

    /*
     * @param CompanySpec $spec
     */
    public function saved(CompanySpec $spec) {
        Log::info("{$this->user->name} update specs {$spec->name}");
        flash("Database successfully updated!.","success");
    }
}