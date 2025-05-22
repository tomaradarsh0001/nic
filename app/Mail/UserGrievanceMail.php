<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class UserGrievanceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $grievance;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($grievance)
    {
        $this->grievance = $grievance;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->subject('Acknowledgment of Grievance Submission to L&DO')
                    ->view('emails.user_grievance_mail');
    }
}
