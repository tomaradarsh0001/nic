<?php

namespace App\Jobs;

use App\Models\PropertyRevivisedGroundRent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CreatePdfForProperty implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $data;
    protected $colonyName;
    protected $rgr;
    protected $updatedBy;
    /**
     * Create a new job instance.
     */
    public function __construct($colonyName, $rgr, $data, $authId)
    {
        $this->colonyName = $colonyName;
        $this->rgr = $rgr;
        $this->data = $data;
        $this->updatedBy = $authId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $pdf = Pdf::loadView('rgr.draft', $this->data);
        if ($pdf) {
            $path = 'public/documents/' . $this->colonyName . '/rgr/' . $this->rgr->property_master_id . '_' . $this->rgr->splited_property_detail_id . '_' . date('YmdHis') . '.pdf';
            $saved = Storage::put($path, $pdf->output());
            if ($saved) {
                // $storagePath = str_replace('public', 'storage', $path);
                if (isset($this->data['allArciveRGRs'])) { //If there are multiple active RGRs
                    foreach ($this->data['allArciveRGRs'] as $rgr) {
                        PropertyRevivisedGroundRent::where('id', $rgr->id)->update(['draft_file_path' => $path, 'updated_by' => $this->updatedBy]);
                    }
                } else {
                    PropertyRevivisedGroundRent::where('id', $this->rgr->id)->update(['draft_file_path' => $path, 'updated_by' => $this->updatedBy]);
                }
            }
        }
    }
}
