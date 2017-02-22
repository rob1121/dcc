<?php namespace App\Console\Commands;

use App\CustomerSpec;
use App\Mail\ExternalSpecFollowUpMailer;
use App\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class FollowUp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:followup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'follow up for review documents that are overdue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $reviewer = CustomerSpec::reviewer();
        $to = User::followUp($reviewer);
        $cc = User::cc();

        Mail::to($to)->cc($cc)->send(new ExternalSpecFollowUpMailer);
    }
}
