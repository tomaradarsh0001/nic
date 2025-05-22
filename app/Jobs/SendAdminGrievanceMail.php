<?php

namespace App\Jobs;

use App\Mail\AdminGrievanceMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendAdminGrievanceMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $grievance;

    public function __construct($grievance)
    {
        $this->grievance = $grievance;
    }

    public function handle()
    {
        $adminEmail = 'srivastavaamita3@gmail.com';
        Mail::to($adminEmail)->send(new AdminGrievanceMail($this->grievance));
    }
}
