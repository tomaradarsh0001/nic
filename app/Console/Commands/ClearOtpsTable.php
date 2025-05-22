<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Otp;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class ClearOtpsTable extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'clear:otps';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Deletes expired OTPs from the otps table daily at night 1 AM';

    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Log the start time when job is start
        Log::info("Start# :- Clear otp schedule job start at ". Carbon::now());
        // Log the where clause to delete records older then 24 hours
        Log::info("created_at <  ".Carbon::now()->subHours(24));
        // Delete records older than 24 hours
        $deleted = Otp::where('created_at', '<', Carbon::now()->subHours(24))->delete();
        // Log the deletion information
        Log::info("Deleted $deleted expired OTP records.");
        // Log the stop time when job is stop
        Log::info("End# :- Clear otp schedule job end at ". Carbon::now());
        $this->info("Deleted $deleted expired OTP records.");
    }
}
