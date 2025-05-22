<?php

namespace App\Jobs;

use App\Services\ReportService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Rap2hpoutre\FastExcel\FastExcel;
use Mail;
use App\Mail\DownloadReady;
use Exception;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DetailedReportExport implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $filter;
    protected $email;
    public function __construct($filter, $email)
    {
        $this->filter = $filter;
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $filters = $this->filter;
            $reportService = new ReportService();
            $properties = $reportService->detailedReport($filters, true);
            $rows = [];
            foreach ($properties as $prop) {


                $rows[] = [
                    'Property Id' => $prop->unique_propert_id ?? '',
                    'Old Property Id' => $prop->old_propert_id ?? '',
                    'Child Property Id' => $prop->child_prop_id ?? '',
                    'File Number' => $prop->unique_file_no ?? '',
                    'Old File Number' => $prop->file_no ?? '',
                    'Land Type' => $prop->landType ?? '',
                    'Property Status' => $prop->propertyStatus ?? '',
                    'Property Type' => $prop->propertyType ?? '',
                    'Property SubType' => $prop->propertySubtype ?? '',
                    'Is Land Use Changed' => $prop->is_land_use_changed,
                    'Latest Property Type' => $prop->presentPropertyType,
                    'Latest Property SubType' => $prop->presentPropertySubtype,
                    'Section' => $prop->section ?? '',
                    'Address' => $prop->block . '/' . $prop->plot_no . '/' . $prop->colony ?? '',
                    'Premium (₹)' => $prop->premium . '.' . $prop->premium_in_paisa ?? '',
                    'Ground Rent (₹)' => $prop->ground_rent ?? '',
                    'Area' => $prop->area ?? '',
                    'Area in Sqm' => $prop->area_in_sqm ??  '',
                    'Colony' => $prop->colony ?? '',
                    'Block' => $prop->block ?? '',
                    'Plot' => $prop->plot_no ?? '',
                    'Presently Known As' => $prop->presently_known_as ?? '',
                    'Lease Type' => $prop->leaseDeed ?? '',
                    'Date Of Allotment' => $prop->date_of_allotment ?? '',
                    'Date Of Execution' => $prop->date_of_execution ?? '',
                    'Date Of Expiration' =>  $prop->date_of_expiration ?? '',
                    'Start Date Of GR' => $prop->start_date_of_gr ?? '',
                    'RGR Duration' =>  $prop->rgr_duration ?? '',
                    'First RGR Due On' => $prop->first_rgr_due_on ?? '',
                    'Last Inspection Date' => $prop->last_inspection_ir_date ?? '',
                    'Last Demand Letter Date' => $prop->last_demand_letter_date ?? '',
                    'Last Demand Id' =>  $prop->last_demand_id ?? '',
                    'Last Demand Amount' => $prop->last_demand_amount ?? '',
                    'Last Amount Received' => $prop->last_amount_received ?? '',
                    'Last Amount Received Date' => $prop->last_amount_received_date ?? '',
                    'Total Dues' => $prop->total_dues ?? '',
                    'Latest Lessee Name' => $prop->current_lesse_name ?? '',
                    'Lessee Address' => $prop->lessee_address ?? '',
                    'Lessee Phone' => $prop->lessee_phone ?? '',
                    'Lessee Email' => $prop->lessee_email ?? '',
                    'Entry By' => $prop->created_by ?? '',
                    'Entry At' => date('Y-m-d H:i:s', strtotime($prop->created_at))
                ];
            }
            if (!empty($rows)) {
                $fileName = 'public/exports/details' . date('YmdHis') . '.xlsx';
                (new FastExcel($rows))->export(Storage::path($fileName));
                if (!is_null($this->email)) {
                    $link = '/download/' . base64_encode($fileName);
                    Mail::to($this->email)->send(new DownloadReady($link));
                }
            }
        } catch (Exception $e) {
            Log::error('export failed', [
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ]);
            throw $e;
        }
    }
}
