<?php

namespace App\Console\Commands;

use App\Models\PropertyMiscDetail;
use App\Models\PropertyMiscDetailHistory;
use App\Models\PropertyRevivisedGroundRent;
use Illuminate\Console\Command;

class ResetRGRStatus extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:rgr-status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset RGR status of properties every year';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $toUpdate = PropertyMiscDetail::where('is_gr_revised_ever', 1)->get(); //update(['is_gr_revised_ever' => 0])
        foreach ($toUpdate as $row) {
            PropertyMiscDetailHistory::where('property_master_id', $row->property_master_id)
                ->when(is_null($row->splited_property_detail_id), function ($query) {
                    return $query->whereNull('splited_property_detail_id');
                }, function ($query) use ($row) {
                    return $query->where('splited_property_detail_id', $row->splited_property_detail_id);
                })->update(['is_gr_revised_ever' => '1', 'new_is_gr_revised_ever' => '0']);
            $row->update(['is_gr_revised_ever' => 0]);
        }
        PropertyRevivisedGroundRent::whereIn('status', ['draft', 'final'])->update(['status' => 'old']);
    }
}
