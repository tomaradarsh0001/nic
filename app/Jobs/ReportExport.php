<?php

namespace App\Jobs;

use App\Mail\DownloadReady;
use App\Services\ReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Rap2hpoutre\FastExcel\FastExcel;

class ReportExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $filters;
    protected $email;
    public function __construct($filter, $email)
    {
        $this->filters = $filter;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $fileName = 'public/exports/' . date('YmdHis') . '.xlsx';
        $filters = $this->filters;
        // $page = 1;
        $service = new ReportService();
        $rows = [];
        $results = $service->filterResults($filters, false);

        foreach ($results as $index => $item) {
            $rows[] = [
                'old property id' => $item->old_propert_id,
                'unique property id' => $item->unique_propert_id,
                'land type' => $item->land_type,
                'status' => $item->status,
                'lease tenure' => $item->lease_tenure,
                'land use' => $item->land_use,
                'area' => $item->area_in_sqm,
                'address' => $item->address,
                'lesse name' => $item->lesse_name,
                'gr in re rs' => $item->gr_in_re_rs,
                'gr' => $item->gr,
            ];
        }

        // } while ($page < 3); //while ($page < 3); while (count($results) == $chunkSize);
        if (!empty($rows)) {
            (new FastExcel($rows))->export(Storage::path($fileName));
            if (!is_null($this->email)) {
                $link = '/download/' . base64_encode($fileName);
                Mail::to($this->email)->send(new DownloadReady($link));
            }
        }
    }
}
