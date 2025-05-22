<?php

namespace App\Jobs;

use App\Mail\RGRDraft;
use App\Models\PropertyRevivisedGroundRent;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendRGRDraft implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $data;
    protected $to;
    protected $userId;
    public function __construct($rgr, $email, $userId)
    {
        $this->data = $rgr;
        $this->to  = $email;
        $this->userId  = $userId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $email = new RGRDraft($this->data);
        $sent = Mail::to($this->to)->send($email);
        if ($sent) { // update draft status in model on success
            $rgr = PropertyRevivisedGroundRent::find($this->data->id);
            if (!empty($rgr)) {
                PropertyRevivisedGroundRent::where('property_master_id', $rgr->property_master_id)->where(function ($query) use ($rgr) {
                    if (is_null($rgr->splited_property_detail_id)) {
                        return $query->whereNull('splited_property_detail_id');
                    } else {
                        return $query->where('splited_property_detail_id', $rgr->splited_property_detail_id);
                    }
                })->whereIn('status', ['draft', 'final'])->update(['is_draft_sent' => 1, 'updated_by' => $this->userId]);
                //$rgr->update(['is_draft_sent' => 1, 'updated_by' => $this->userId]);
            }
        }
    }
}
