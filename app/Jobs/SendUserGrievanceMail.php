<?php

namespace App\Jobs;

use App\Mail\UserGrievanceMail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendUserGrievanceMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $grievance;

    public function __construct($grievance)
    {
        $this->grievance = $grievance;
    }

    public function handle()
    {
        Mail::to($this->grievance->email)->send(new UserGrievanceMail($this->grievance));
    }
}
