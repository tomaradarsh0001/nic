<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\Template;
use App\Services\CommunicationService;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\RetryUntil;


class CommonMail extends Mailable implements ShouldQueue
{
    public $data;
    public $action;
    public $communicationService;
    public $mailData;
    public $subject;
    use Queueable, SerializesModels;
    use Dispatchable, InteractsWithQueue;

    /**
     * Create a new message instance.
     */
    public function __construct($data,$action)
    {
        $this->data = $data;
        $this->action = $action;
        $this->communicationService = new CommunicationService();
        $template = Template::where('type','email')->where('action',$action)->where('status',1)->first();
        $this->mailData = $this->communicationService->createTemplate($template->template, $data);
        $this->subject = $template->subject;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.common_mail',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
