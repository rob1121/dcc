<?php namespace App\Observers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class UserObserver
{
    private $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    /**
     * Listen to the User created event.
     * @param User $user
     */
    public function created(User $user) {
//        Log::info("{$this->user->name} added new external specification {$user->name}");
        flash("User successfully added to database!.","success");
    }

    /**
     * @param User $user
     */
    public function saved(User $user) {
//        Log::info("{$this->user->name} added new external specification {$user->name}");
        flash("User Database successfully updated!.","success");
    }
}