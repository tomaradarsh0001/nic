<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ReportService;
use App\Services\MisService;
use App\Services\ColonyService;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\DetailExport;
use App\Jobs\DetailedReportExport;
use App\Jobs\ReportExport as JobsReportExport;
use App\Models\PropertyMaster;
use App\Models\Item;
use App\Models\User;
use App\Models\OldColony;
use App\Models\CurrentLesseeDetail;
use App\Models\PropertyRevivisedGroundRent;
use Auth;
use App\Models\PropertyTransferredLesseeDetail;
use App\Models\PropertyLeaseDetail;
use App\Models\PropertySectionMapping;
use App\Models\Section;
use DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;
use Illuminate\Support\Facades\Storage;
use App\Models\UnallottedPropertyDetail;
use App\Services\PropertyMasterService;
use Illuminate\Support\Carbon;
use App\Models\Demand;



class ReportController extends Controller
{

    public function __construct()
    {
        $this->middleware('permission:view reports', ['only' => ['index', 'tabularRecord']]);
    }

    public function index(ReportService $reportService, MisService $misService, ColonyService $colonyService)
    {
        $data['landTypes'] = $misService->getItemsByGroupId(1051);
        $data['propertyTypes'] = $misService->getItemsByGroupId(1052);
        $data['leaseTypes'] = $misService->getItemsByGroupId(102);
        $data['propertyStatus'] = $misService->getItemsByGroupId(109);
        // $data['results'] = $reportService->filterResults();
        $data['results'] = [];
        $data['colonyList'] = $colonyService->getAllColonies();
        return view('report.report', $data);
    }


    public function getPropertyResults(Request $request, ReportService $reportService)
    {
        $filters = $request->filters;
        $results = $reportService->filterResults($filters);
        return response()->json($results);
    }

    public function tabularRecord(ReportService $reportService)
    {
        $tabularRecord = $reportService->tabularRecord();
        return view('tabular_record', compact(['tabularRecord']));
    }

    public function getDistinctSubTypes(Request $request, ReportService $reportService)
    {
        $types = $request->types;
        $subtypes = $reportService->getDistinctSubTypes($types);
        return response()->json($subtypes);
    }
    /* public function reportExport(Request $request, ReportService $reportService)
    {
        $format = $request->format;
        $filters = $request->filters ?? [];
        $results = $reportService->filterResults($filters, false);
        /*$chunkSize = 10000; // Number of rows per chunk
        $chunks = array_chunk($results, $chunkSize); // Split data into chunks
        $export = new ReportExport($chunks); /
        $rows = []; //header rows
        foreach ($results as $index => $item) {

            $rows[] = [
                'old_propert_id' => $item->old_propert_id,
                'unique_propert_id' => $item->unique_propert_id,
                'land_type' => $item->land_type,
                'status' => $item->status,
                'lease_tenure' => $item->lease_tenure,
                'land_use' => $item->land_use,
                'area' => $item->area_in_sqm,
                'address' => $item->address,
                'lesse_name' => $item->lesse_name,
                'gr_in_re_rs' => $item->gr_in_re_rs,
                'gr' => $item->gr,
            ];
        };
        $export = new ReportExport([
            $rows

        ]);
        /* if ($format == 'csv') {
            return Excel::download($export, 'report.csv', \Maatwebsite\Excel\Excel::CSV, [
                'Content-Type' => 'text/csv',
            ]);
        } /
        if ($format == 'xls') {
            return Excel::download($export, 'report.xls', \Maatwebsite\Excel\Excel::XLS);
        }
        /* if ($format == 'pdf') {
            return Excel::download($export, 'report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        } *
    } */
    public function reportExport(Request $request)
    {
        $filters = $request->filters ?? [];

        //$email = Auth::user()->email;
        $email = 'nitinrag@gmail.com';

        dispatch(new JobsReportExport($filters, $email));

        return response()->json(['status' => 'creating export. You will recieve the email when export is ready']);
        /* $fileName = 'public/exports/' . now()->timestamp . '.xls';
        $page = 1;
        $service = new ReportService();
        $rows = [];
        $chunkSize = 1000;
        $filters['limit'] = $chunkSize;
        $results = $service->filterResults($filters)['rows'];
        do {
            $results = $service->filterResults($filters)['rows'];
            $page++;
            if (is_null($results)) break;

            foreach ($results as $index => $item) {
                // dd($chunk);
                // foreach ($chunk as $item) {
                $rows[] = [
                    'old_propert_id' => $item->old_propert_id,
                    'unique_propert_id' => $item->unique_propert_id,
                    'land_type' => $item->land_type,
                    'status' => $item->status,
                    'lease_tenure' => $item->lease_tenure,
                    'land_use' => $item->land_use,
                    'area' => $item->area_in_sqm,
                    'address' => $item->address,
                    'lesse_name' => $item->lesse_name,
                    'gr_in_re_rs' => $item->gr_in_re_rs,
                    'gr' => $item->gr,
                ];
                // }
            }
            // If you want to write each chunk to the file progressively
            // You can do so here depending on the format.

        } while ($page < 3); //while (count($results) == $chunkSize);
        $export = new ReportExport(collect($rows));
        Excel::store($export, $fileName, 'local'); */
    }


    //For exporting the property details START ***************************************************************************
    //Sourav Chauhan - 4/June/2024
    /*public function detailsExport(Request $request, ReportService $reportService)
    {
        try {
            $format = $request->format;
            $rows = []; //header rows
            $filters = $request->filters ?? [];


            $loginUser = Auth::user();

            if (isset($filters['colonyNameOld'])) {
                // dd("inside if");
                if ($loginUser->can('view.all.details')) {
                    $propertyDetails = PropertyMaster::query()
                        ->when($filters['colonyNameOld'], function ($q) use ($filters) {
                            $q->where('new_colony_name', $filters['colonyNameOld']);
                        })->with(['propertyLeaseDetail', 'propertyTransferredLesseeDetails', 'propertyInspectionDemandDetail', 'propertyMiscDetail', 'propertyContactDetail', 'splitedPropertyDetail', 'oldColony', 'user'])
                        ->get();

                } else {
                    $propertyDetails = PropertyMaster::query()
                        ->when($filters['colonyNameOld'], function ($q) use ($filters) {
                            $q->where('new_colony_name', $filters['colonyNameOld']);
                        })->where('created_by', $loginUser->id)
                        ->with(['propertyLeaseDetail', 'propertyTransferredLesseeDetails', 'propertyInspectionDemandDetail', 'propertyMiscDetail', 'propertyContactDetail', 'splitedPropertyDetail', 'oldColony', 'user'])
                        ->get();

                }

            } else {
                if (isset($filters['propId']) || isset($filters['date'])) {
                    // $propertyDetails = PropertyMaster::where('old_propert_id', 'like', '%'.$filters['propId'].'%')
                    // ->get();
                    if (isset($filters['date'])) {
                        // $dateTime = new \DateTime($filters['date']);
                        // $dateTime2 = new \DateTime($filters['dateEnd']);
                        // $formattedDate = $dateTime->format('d-m-Y');//production
                        $formattedDate = $filters['date'];//development
                        if (isset($filters['dateEnd'])) {

                            $formattedDateEnd = $filters['dateEnd'];//development
                        }
                        if ($loginUser->can('view.all.details')) {
                            if (isset($filters['dateEnd']) && isset($filters['date'])) {
                                $propertyDetails = PropertyMaster::query()
                                ->when(isset($formattedDate) && isset($formattedDateEnd), function ($q) use ($formattedDate, $formattedDateEnd) {
                                    $q->whereDate('created_at', '>=', $formattedDate)
                                      ->whereDate('created_at', '<=', $formattedDateEnd);
                                })->get();
                            
                            } else if (isset($filters['date'])) {
                                $propertyDetails = PropertyMaster::query()                          
                                ->when($filters['date'], function ($q) use ($formattedDate) {
                                    $q->where('created_at', 'like', '%' . $formattedDate . '%');
                                })->get();
                            }

                        } else {
                            if (isset($filters['dateEnd']) && isset($filters['date'])) {
                                $propertyDetails = PropertyMaster::query()
                                ->when(isset($formattedDate) && isset($formattedDateEnd), function ($q) use ($formattedDate, $formattedDateEnd) {
                                    $q->whereDate('created_at', '>=', $formattedDate)
                                      ->whereDate('created_at', '<=', $formattedDateEnd);
                                })->where('created_by', $loginUser->id)->get();
                            
                            } else if (isset($filters['date'])) {
                                $propertyDetails = PropertyMaster::query()                          
                                ->when($filters['date'], function ($q) use ($formattedDate) {
                                    $q->where('created_at', 'like', '%' . $formattedDate . '%');
                                })->where('created_by', $loginUser->id)->get();
                            }
                        }
                        // dd($propertyDetails);
                    } else {

                        if ($loginUser->can('view.all.details')) {
                            $propertyDetails = PropertyMaster::query()
                                ->when($filters['propId'], function ($q) use ($filters) {
                                    $q->where('old_propert_id', 'like', '%' . $filters['propId'] . '%')
                                        ->orWhere('unique_propert_id', 'like', '%' . $filters['propId'] . '%');
                                })->with(['propertyLeaseDetail', 'propertyTransferredLesseeDetails', 'propertyInspectionDemandDetail', 'propertyMiscDetail', 'propertyContactDetail', 'splitedPropertyDetail', 'oldColony', 'user'])
                                ->get();

                        } else {
                            $propertyDetails = PropertyMaster::query()
                                ->when($filters['propId'], function ($q) use ($filters) {
                                    $q->where('old_propert_id', 'like', '%' . $filters['propId'] . '%')
                                        ->orWhere('unique_propert_id', 'like', '%' . $filters['propId'] . '%');
                                })->where('created_by', $loginUser->id)
                                ->with(['propertyLeaseDetail', 'propertyTransferredLesseeDetails', 'propertyInspectionDemandDetail', 'propertyMiscDetail', 'propertyContactDetail', 'splitedPropertyDetail', 'oldColony', 'user'])
                                ->get();
                        }

                    }

                } else {
                    if ($loginUser->can('view.all.details')) {
                        $propertyDetails = PropertyMaster::with(['propertyLeaseDetail', 'propertyTransferredLesseeDetails', 'propertyInspectionDemandDetail', 'propertyMiscDetail', 'propertyContactDetail', 'splitedPropertyDetail', 'oldColony', 'user'])->get();
                    } else {
                        $propertyDetails = PropertyMaster::where('created_by', $loginUser->id)->with(['propertyLeaseDetail', 'propertyTransferredLesseeDetails', 'propertyInspectionDemandDetail', 'propertyMiscDetail', 'propertyContactDetail', 'splitedPropertyDetail', 'oldColony', 'user'])->get();
                    }
                }
            }
            // dd($propertyDetails);

            foreach ($propertyDetails as $propertyDetail) {
                // dd($propertyDetail);
                $name = '';
                $colconyName = '';
                $name = $propertyDetail->user->name;
                if(isset($filters['colonyNameOld'])){
                    $colconyName = OldColony::where('id', $filters['colonyNameOld'])->first();
                } else {
                    $colconyName = OldColony::where('id', $propertyDetail->new_colony_name)->first();
                }

                // $data = Item::whereIn('id', [$propertyDetail->property_type, $propertyDetail->property_sub_type, $propertyDetail->status, $propertyDetail->propertyLeaseDetail->unit])->get();
                $propertyType = Item::where('id', $propertyDetail->property_type)->first();
                $propertySubType = Item::where('id', $propertyDetail->property_sub_type)->first();
                $status = Item::where('id', $propertyDetail->status)->first();
                if(isset($propertyDetail->propertyLeaseDetail)){

                    $unit = Item::where('id', $propertyDetail->propertyLeaseDetail->unit)->first();
                } else {
                    $unit = '';
                }

                // Convert UTC time to IST using Carbon
                $utcTime = $propertyDetail->created_at; // Assuming $propertyDetail contains your UTC timestamp
                $istTime = $utcTime->setTimezone('Asia/Kolkata');

                //Latest Lessee
                $allLessees = $propertyDetail->propertyTransferredLesseeDetails;
                $lengthOfLessees = count($allLessees);
                $latestLessee = $allLessees[$lengthOfLessees - 1];

                //address
                $blockNo = isset($propertyDetail->block_no) ? $propertyDetail->block_no . '/' : '';
                $plotOrPropertyNo = isset( $propertyDetail->plot_or_property_no) ? $propertyDetail->plot_or_property_no . '/' : '';
                $colconyName = $colconyName->name ?? '';

                $rows[] = [
                    'Property Id' => $propertyDetail->unique_propert_id ?? '',
                    'Old Property Id' => $propertyDetail->old_propert_id ?? '',
                    'File Number' => $propertyDetail->unique_file_no ?? '',
                    'Old File Number' => $propertyDetail->file_no ?? '',
                    'Property Type' => isset($propertyDetail->property_type) ? isset($propertyType) ? $propertyType['item_name'] : '' : '',
                    'Property SubType' => isset($propertyDetail->property_sub_type) ? isset($propertySubType) ? $propertySubType['item_name'] : '' : '',
                    'Property Status' => isset($propertyDetail->status) ? isset($status) ? $status['item_name'] : '' : '',
                    'Section' => $propertyDetail->section_code ?? '',
                    'Address' => $blockNo . $plotOrPropertyNo . $colconyName,
                    'Premium (₹)' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->premium . '.' . $propertyDetail->propertyLeaseDetail->premium_in_paisa ?? $propertyDetail->propertyLeaseDetail->premium_in_aana : '',
                    'Ground Rent (₹)' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->gr_in_re_rs . '.' . $propertyDetail->propertyLeaseDetail->gr_in_paisa ?? $propertyDetail->propertyLeaseDetail->gr_in_aana : '',
                    'Area' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->plot_area . ' ' . (isset($unit) ? $unit['item_name'] : '') : '',
                    'Area in Sqm' => $propertyDetail->propertyLeaseDetail->plot_area_in_sqm ?? '',
                    'Block' => $propertyDetail->block_no ?? '',
                    'Plot' => $propertyDetail->plot_or_property_no ?? '',
                    'Colony' => $colconyName->name ?? '',
                    'Date Of Expiration' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->date_of_expiration : '',
                    'Date Of Execution' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->doe : '',
                    'Date Of Allotment' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->doa : '',
                    'Presently Known As' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->presently_known_as : '',
                    'Start Date Of GR' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->start_date_of_gr : '',
                    'RGR Duration' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->rgr_duration : '',
                    'First RGR Due On' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->first_rgr_due_on : '',
                    'Last Inspection Date' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_inspection_ir_date : '',
                    'Last Demand Letter Date' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_demand_letter_date : '',
                    'Last Demand Id' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_demand_id : '',
                    'Last Demand Amount' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_demand_amount : '',
                    'Last Amount Received' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_amount_received : '',
                    'Last Amount Received Date' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_amount_received_date : '',
                    'Total Dues' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->total_dues : '',
                    'Latest Lessee Name' => $latestLessee['lessee_name'] ?? '',
                    'Lessee Address' => $propertyDetail->propertyContactDetail->address ?? '',
                    'Lessee Phone' => $propertyDetail->propertyContactDetail->phone_no ?? '',
                    'Lessee Email' => $propertyDetail->propertyContactDetail->email ?? '',
                    'Entry By' => $name,
                    'Entry At' => $istTime->format('Y-m-d H:i:s')
                ];
            }

            // dd($rows);

            $export = new DetailExport([
                $rows

            ]);

            if ($format == 'csv') {
                return Excel::download($export, 'details.csv', \Maatwebsite\Excel\Excel::CSV, [
                    'Content-Type' => 'text/csv',
                ]);
            }
            if ($format == 'xls') {
                return Excel::download($export, 'report.xls', \Maatwebsite\Excel\Excel::XLS);
            }
            if ($format == 'pdf') {
                return Excel::download($export, 'report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            }
        } catch (\Exception $e) {
            dd($e);
            // return redirect()->back()->with('failure', $e->getMessage());
        }
    }*/
    //For exporting the property details END ***************************************************************************

    /*public function detailsExport(Request $request, ReportService $reportService)
    {
        try {
            $format = $request->format;
            $filters = $request->filters ?? [];
            $loginUser = Auth::user();

            // Determine the query to use based on the filters and user permissions
            $query = PropertyMaster::query()
                ->when(isset($filters['colonyNameOld']), function ($q) use ($filters, $loginUser) {
                    $q->where('new_colony_name', $filters['colonyNameOld']);
                    if (!$loginUser->can('view.all.details')) {
                        $q->where('created_by', $loginUser->id);
                    }
                })
                ->when(isset($filters['date']), function ($q) use ($filters, $loginUser) {
                    $formattedDate = $filters['date'];
                    $q->where('created_at', 'like', '%' . $formattedDate . '%');
                    if (!$loginUser->can('view.all.details')) {
                        $q->where('created_by', $loginUser->id);
                    }
                })
                ->when(isset($filters['propId']), function ($q) use ($filters, $loginUser) {
                    $q->where(function ($query) use ($filters) {
                        $query->where('old_propert_id', 'like', '%' . $filters['propId'] . '%')
                            ->orWhere('unique_propert_id', 'like', '%' . $filters['propId'] . '%');
                    });
                    if (!$loginUser->can('view.all.details')) {
                        $q->where('created_by', $loginUser->id);
                    }
                });

            // Add eager loading
            $query->with(['propertyLeaseDetail', 'propertyTransferredLesseeDetails', 'propertyInspectionDemandDetail', 'propertyMiscDetail', 'propertyContactDetail', 'splitedPropertyDetail', 'oldColony', 'user']);

            $rows = []; // Initialize rows array

            // Chunk the results to handle large datasets
            $query->chunk(5000, function ($propertyDetails) use (&$rows, $filters) {
                foreach ($propertyDetails as $propertyDetail) {
                    $name = '';
                    $colonyName = '';
                    $propertyType = $propertySubType = $status = $unit = '';
                    $name = $propertyDetail->user->name;
                    // if (isset($filters['colonyNameOld'])) {
                    //     $colonyName = OldColony::where('id', $filters['colonyNameOld'])->first();
                    // } else {
                    //     $colonyName = OldColony::where('id', $propertyDetail->new_colony_name)->first();
                    // }
                    // if (!empty($propertyDetail->property_type)) {
                    //     $propertyType = Item::where('id', $propertyDetail->property_type)->first();
                    // }
                    // if (!empty($propertyDetail->property_sub_type)) {
                    //     $propertySubType = Item::where('id', $propertyDetail->property_sub_type)->first();
                    // }
                    // if (!empty($propertyDetail->status)) {
                    //     $status = Item::where('id', $propertyDetail->status)->first();
                    // }
                    // if (!empty($propertyDetail->propertyLeaseDetail->unit)) {
                    //     $unit = Item::where('id', $propertyDetail->propertyLeaseDetail->unit)->first();
                    // }

                    // Convert UTC time to IST using Carbon
                    $utcTime = $propertyDetail->created_at; // Assuming $propertyDetail contains your UTC timestamp
                    $istTime = $utcTime->setTimezone('Asia/Kolkata');

                    // Latest Lessee
                    $allLessees = $propertyDetail->propertyTransferredLesseeDetails;
                    $latestLessee = $allLessees->isNotEmpty() ? $allLessees->last() : null;

                    $rows[] = [
                        'Property Id' => $propertyDetail->unique_propert_id ?? '',
                        'Old Property Id' => $propertyDetail->old_propert_id ?? '',
                        'File Number' => $propertyDetail->unique_file_no ?? '',
                        'Old File Number' => $propertyDetail->file_no ?? '',
                        'Property Type' => isset($propertyDetail->property_type) ? (isset($propertyType) ? '' : '') : '',
                        'Property SubType' => isset($propertyDetail->property_sub_type) ? (isset($propertySubType) ? '' : '') : '',
                        'Property Status' => isset($propertyDetail->status) ? (isset($status) ? '' : '') : '',
                        'Section' => $propertyDetail->section_code ?? '',
                        'Address' => $propertyDetail->block_no . '/' . $propertyDetail->plot_or_property_no  ?? '',
                        'Premium (₹)' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->premium . '.' . $propertyDetail->propertyLeaseDetail->premium_in_paisa ?? $propertyDetail->propertyLeaseDetail->premium_in_aana : '',
                        'Ground Rent (₹)' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->gr_in_re_rs . '.' . $propertyDetail->propertyLeaseDetail->gr_in_paisa ?? $propertyDetail->propertyLeaseDetail->gr_in_aana : '',
                        'Area' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->plot_area . ' ' . (isset($unit) ? '' : '') : '',
                        'Area in Sqm' => $propertyDetail->propertyLeaseDetail->plot_area_in_sqm ?? '',
                        'Block' => $propertyDetail->block_no ?? '',
                        'Plot' => $propertyDetail->plot_or_property_no ?? '',
                        'Colony' => '',
                        'Date Of Expiration' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->date_of_expiration : '',
                        'Date Of Execution' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->doe : '',
                        'Date Of Allotment' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->doa : '',
                        'Presently Known As' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->presently_known_as : '',
                        'Start Date Of GR' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->start_date_of_gr : '',
                        'RGR Duration' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->rgr_duration : '',
                        'First RGR Due On' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->first_rgr_due_on : '',
                        'Last Inspection Date' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_inspection_ir_date : '',
                        'Last Demand Letter Date' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_demand_letter_date : '',
                        'Last Demand Id' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_demand_id : '',
                        'Last Demand Amount' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_demand_amount : '',
                        'Last Amount Received' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_amount_received : '',
                        'Last Amount Received Date' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_amount_received_date : '',
                        'Total Dues' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->total_dues : '',
                        'Latest Lessee Name' => $latestLessee ? $latestLessee['lessee_name'] : '',
                        'Lessee Address' => $propertyDetail->propertyContactDetail->address ?? '',
                        'Lessee Phone' => $propertyDetail->propertyContactDetail->phone_no ?? '',
                        'Lessee Email' => $propertyDetail->propertyContactDetail->email ?? '',
                        'Entry By' => $name,
                        'Entry At' => $istTime->format('Y-m-d H:i:s')
                    ];
                }
            });

            $export = new DetailExport([
                $rows
            ]);

            if ($format == 'csv') {
                return Excel::download($export, 'details.csv', \Maatwebsite\Excel\Excel::CSV, [
                    'Content-Type' => 'text/csv',
                ]);
            }
            if ($format == 'xls') {
                return Excel::download($export, 'report.xls', \Maatwebsite\Excel\Excel::XLS);
            }
            if ($format == 'pdf') {
                return Excel::download($export, 'report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            }
        } catch (\Exception $e) {
            dd($e);
            // return redirect()->back()->with('failure', $e->getMessage());
        }
    }*/

    public function detailsExport(Request $request)
    {
        try {
            $format = $request->format;
            $filters = $request->filters ?? [];
            $loginUser = Auth::user();

            // Determine the query to use based on the filters and user permissions
            $query = PropertyMaster::query()
                ->when(isset($filters['colonyNameOld']), function ($q) use ($filters, $loginUser) {
                    $q->where('new_colony_name', $filters['colonyNameOld']);
                    if (!$loginUser->can('view.all.details')) {
                        $q->where('created_by', $loginUser->id);
                    }
                })
                ->when(isset($filters['date']), function ($q) use ($filters, $loginUser) {
                    $formattedDate = $filters['date'];
                    $q->where('created_at', 'like', '%' . $formattedDate . '%');
                    if (!$loginUser->can('view.all.details')) {
                        $q->where('created_by', $loginUser->id);
                    }
                })
                ->when(isset($filters['propId']), function ($q) use ($filters, $loginUser) {
                    $q->where(function ($query) use ($filters) {
                        $query->where('old_propert_id', 'like', '%' . $filters['propId'] . '%')
                            ->orWhere('unique_propert_id', 'like', '%' . $filters['propId'] . '%');
                    });
                    if (!$loginUser->can('view.all.details')) {
                        $q->where('created_by', $loginUser->id);
                    }
                });


                //For exporting ther data according to assigned sections - SOURAV CHAUHAN (31/Dec/2024)
                if($loginUser->roles[0]->id == 7 || $loginUser->roles[0]->id == 8 || $loginUser->roles[0]->id == 10){
                    $loginUserSections = $loginUser->sections;
                    $allSections = [];
                    foreach($loginUserSections as $loginUserSection){
                        $sectionCode = $loginUserSection->section_code;
                        $allSections[] = $sectionCode;
                    }
                    $query->whereIn('section_code',$allSections);
                }



                /* $query->where('file_no','like','L-V%')
				->where('status','!=',1476); */
				
            // $query->leftJoin('splited_property_details', 'splited_property_details.property_master_id', '=', 'property_masters.id');
            // Add eager loading
            $query->with(['propertyLeaseDetail', 'propertyTransferredLesseeDetails', 'propertyInspectionDemandDetail', 'propertyMiscDetail', 'propertyContactDetail', 'splitedPropertyDetail', 'oldColony', 'user']);

            $rows = []; // Initialize rows array

            // Chunk the results to handle large datasets
            $query->chunk(1000, function ($propertyDetails) use (&$rows, $filters) {
				//dd($propertyDetails);
                foreach ($propertyDetails as $propertyDetail) {
                    $name = '';
                    $colonyName = '';
                    $propertyType = $propertySubType = $propertyTypeNew = $propertySubTypeNew = $status = $unit = '';
                    $name = $propertyDetail->user->name;
                    if (isset($filters['colonyNameOld'])) {
                        $colonyName = OldColony::where('id', $filters['colonyNameOld'])->first();
                    } else {
                        $colonyName = OldColony::where('id', $propertyDetail->new_colony_name)->first();
                    }


                    if (!empty($propertyDetail->propertyLeaseDetail)) {
                        $propertyTypeData = Item::where('id', $propertyDetail->propertyLeaseDetail->property_type_as_per_lease)->first();
                        $propertyType = $propertyTypeData['item_name'];

                        $propertySubTypeData = Item::where('id', $propertyDetail->propertyLeaseDetail->property_sub_type_as_per_lease)->first();
                        $propertySubType = isset($propertySubTypeData['item_name'])? $propertySubTypeData['item_name'] : '';
                        if (!empty($propertyDetail->propertyLeaseDetail->property_type_at_present)) {
                            $propertyTypeNewData = Item::where('id', $propertyDetail->propertyLeaseDetail->property_type_at_present)->first();
                            $propertyTypeNew = $propertyTypeNewData['item_name'];

                            $propertySubTypeNewData = Item::where('id', $propertyDetail->propertyLeaseDetail->property_sub_type_at_present)->first();
                            $propertySubTypeNew = $propertySubTypeNewData['item_name'];
                        }
                    }


                    // if (!empty($propertyDetail->property_sub_type)) {
                    //     $propertySubType = Item::where('id', $propertyDetail->property_sub_type)->first();
                    // }
                    if (!empty($propertyDetail->status)) {
                        $status = Item::where('id', $propertyDetail->status)->first();
                    }
                    if (!empty($propertyDetail->propertyLeaseDetail->unit)) {
                        $unit = Item::where('id', $propertyDetail->propertyLeaseDetail->unit)->first();
                    }
                    if (!empty($propertyDetail->propertyLeaseDetail->unit)) {
                        $typeOfLease = Item::where('id', $propertyDetail->propertyLeaseDetail->type_of_lease)->first();
                    }
                    if (!empty($propertyDetail->land_type)) {
                        $landType = Item::where('id', $propertyDetail->land_type)->first();
                    }

                    // Convert UTC time to IST using Carbon
                    $utcTime = $propertyDetail->created_at; // Assuming $propertyDetail contains your UTC timestamp
                    $istTime = $utcTime->setTimezone('Asia/Kolkata');

                    // Latest Lessee
                    // $allLessees = $propertyDetail->propertyTransferredLesseeDetails;
                    // $latestLessee = $allLessees->isNotEmpty() ? $allLessees->last() : null;

                    //added for getting the current lesse from current lessees table - SOURAV CHAUHAN (15/July/2024)
                    $latestLessee = CurrentLesseeDetail::where('property_master_id', $propertyDetail->id)->first();


                    //Splitted properties START - SOURAV CHAUHAN (20/sep/2024)****************
                    $jointPropertiesArray = [];
                    if ($propertyDetail->splitedPropertyDetail->isEmpty()) {
                       
                    } else {
                        foreach($propertyDetail->splitedPropertyDetail as $key => $chldProperty){
                            if(!empty($chldProperty->old_property_id)){
                                $jointPropertiesArray[] = $chldProperty->old_property_id;
                            }
                        }
                    }
                    $jointProperties = implode('/', $jointPropertiesArray);
                     //Splitted properties END - SOURAV CHAUHAN (20/sep/2024)****************

                    $rows[] = [
                        'Property Id' => $propertyDetail->unique_propert_id ?? '',
                        'Old Property Id' => $propertyDetail->old_propert_id ?? '',
                        'Joint Properties' => $jointProperties ?? '',
                        'File Number' => $propertyDetail->unique_file_no ?? '',
                        'Old File Number' => $propertyDetail->file_no ?? '',
                        'Land Type' => isset($landType) ? $landType['item_name'] : '',
                        'Property Status' => isset($propertyDetail->status) ? (isset($status) ? $status['item_name'] : '') : '',
                        'Property Type' => $propertyType,
                        'Property SubType' => $propertySubType,
                        'Is Land Use Changed' => isset($propertyDetail->propertyLeaseDetail->is_land_use_changed) ? 'Yes'  : 'No',
                        'Latest Property Type' => $propertyTypeNew,
                        'Latest Property SubType' => $propertySubTypeNew,
                        'Section' => $propertyDetail->section_code ?? '',
                        'Address' => $propertyDetail->block_no . '/' . $propertyDetail->plot_or_property_no . '/' . $colonyName->name ?? '',
                        'Premium (₹)' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->premium . '.' . $propertyDetail->propertyLeaseDetail->premium_in_paisa ?? $propertyDetail->propertyLeaseDetail->premium_in_aana : '',
                        'Ground Rent (₹)' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->gr_in_re_rs . '.' . $propertyDetail->propertyLeaseDetail->gr_in_paisa ?? $propertyDetail->propertyLeaseDetail->gr_in_aana : '',
                        'Area' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->plot_area . ' ' . (isset($unit) ? $unit['item_name'] : '') : '',
                        'Area in Sqm' => $propertyDetail->propertyLeaseDetail->plot_area_in_sqm ?? '',
                        'Colony' => $colonyName->name ?? '',
                        'Block' => $propertyDetail->block_no ?? '',
                        'Plot' => $propertyDetail->plot_or_property_no ?? '',
                        'Presently Known As' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->presently_known_as : '',
                        'Lease Type' => isset($typeOfLease) ? $typeOfLease['item_name'] : '',
                        'Date Of Allotment' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->doa : '',
                        'Date Of Execution' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->doe : '',
                        'Date Of Expiration' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->date_of_expiration : '',
                        'Start Date Of GR' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->start_date_of_gr : '',
                        'RGR Duration' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->rgr_duration : '',
                        'First RGR Due On' => isset($propertyDetail->propertyLeaseDetail) ? $propertyDetail->propertyLeaseDetail->first_rgr_due_on : '',
                        'Last Inspection Date' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_inspection_ir_date : '',
                        'Last Demand Letter Date' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_demand_letter_date : '',
                        'Last Demand Id' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_demand_id : '',
                        'Last Demand Amount' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_demand_amount : '',
                        'Last Amount Received' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_amount_received : '',
                        'Last Amount Received Date' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->last_amount_received_date : '',
                        'Total Dues' => isset($propertyDetail->propertyInspectionDemandDetail) ? $propertyDetail->propertyInspectionDemandDetail->total_dues : '',
                        'Latest Lessee Name' => $latestLessee ? $latestLessee['lessees_name'] : '',
                        'Lessee Address' => $propertyDetail->propertyContactDetail->address ?? '',
                        'Lessee Phone' => $propertyDetail->propertyContactDetail->phone_no ?? '',
                        'Lessee Email' => $propertyDetail->propertyContactDetail->email ?? '',
                        'Entry By' => $name,
                        'Entry At' => $istTime->format('Y-m-d H:i:s')
                    ];
                }
            });


            if (!empty($rows)) {
                return (new FastExcel($rows))->download('details.csv');
            }

            // dd($rows);

            //OLD Packge START*******************************************************************
            // $export = new DetailExport([
            //     $rows
            // ]);

            // if ($format == 'csv') {
            //     return Excel::download($export, 'details.csv', \Maatwebsite\Excel\Excel::CSV, [
            //         'Content-Type' => 'text/csv',
            //     ]);
            // }
            // if ($format == 'xls') {
            //     return Excel::download($export, 'report.xls', \Maatwebsite\Excel\Excel::XLS);
            // }
            // if ($format == 'pdf') {
            //     return Excel::download($export, 'report.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
            // }
            //OLD Packge END*******************************************************************



        } catch (\Exception $e) {
            dd($e);
            // return redirect()->back()->with('failure', $e->getMessage());
        }
    }

    public function detailedReport(Request $request, ColonyService $colonyService, MisService $misService, ReportService $reportService)
    {
        $filters = [];

        $filters = $request->except(['export']);
        if ($request->export == 1) {
            $email = Auth::user()->email;
            dispatch(new DetailedReportExport($filters, $email));
            return redirect()->back()->with('success', 'Generating the report. Download link will be sent to your email id');
        }
        $properties = $reportService->detailedReport($filters);
        $subtypes = [];
        if (isset($filters['property_type'])) {
            $subtypes = $reportService->getDistinctSubTypes($filters['property_type']);
        }
        $data['colonyList'] = $colonyService->misDoneForColonies();
        $data['propertyStatus'] = $misService->getItemsByGroupId(109);
        $data['landTypes'] = $misService->getItemsByGroupId(1051);
        $data['leaseTypes'] = $misService->getItemsByGroupId(102);
        $data['propertyTypes'] = $misService->getItemsByGroupId(1052);
        $data['propertySubtypes'] = $subtypes;
        $data['properties'] = $properties;
        $data['total'] = $properties['total'];
        $data['filters'] = $filters;
        return view('report.detailed-report', $data);
    }
    public function download($file)
    {
        $fileName = base64_decode($file);
        if (Storage::exists($fileName)) {
            return Storage::download($fileName);
        } else {
            abort(404);
        }
    }

    public function unallotedPropertyView(Request $request)
    {
        return view('report.unalloted-properties-index');
    }

    public function getUnallotedProperties(Request $request)
    {
        $query = UnallottedPropertyDetail::query()
            ->leftJoin('property_masters', 'unallotted_property_details.property_master_id', '=', 'property_masters.id')
            ->leftJoin('items', 'property_masters.land_type', '=', 'items.id')
            ->leftJoin('old_colonies', 'property_masters.new_colony_name', '=', 'old_colonies.id')
            ->leftJoin('departments', 'unallotted_property_details.transferred_to', '=', 'departments.id')
            ->select(
                'unallotted_property_details.old_property_id',
                'unallotted_property_details.plot_area_in_sqm',
                'unallotted_property_details.is_litigation',
                'unallotted_property_details.is_encrached',
                'unallotted_property_details.is_vaccant',
                'unallotted_property_details.is_transferred',
                'unallotted_property_details.transferred_to',
                'unallotted_property_details.is_property_document_exist',
                'unallotted_property_details.date_of_transfer',
                'unallotted_property_details.purpose',
                'unallotted_property_details.created_at',
                'property_masters.unique_propert_id',
                'property_masters.land_type',
                'property_masters.new_colony_name',
                'items.item_name as landType',
                'old_colonies.name as colonyName',
                'departments.name as departmentName',
            );

        // Define the searchable columns
        $searchableColumns = [
            'unallotted_property_details.old_property_id',
            'unallotted_property_details.date_of_transfer',
            'unallotted_property_details.purpose',
            'property_masters.unique_propert_id',
            'property_masters.land_type',
            'items.item_name',
            'old_colonies.name',
            'departments.name',
        ];

        $totalData = $query->count();
        $totalFiltered = $totalData;

        // Handle pagination, ordering, and filtering
        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column');
        $dir = $request->input('order.0.dir');

        if (!empty($request->input('search.value'))) {
            $search = $request->input('search.value');
            $query->where(function ($q) use ($search, $searchableColumns) {
                foreach ($searchableColumns as $column) {
                    $q->orWhere($column, 'LIKE', "%{$search}%");
                }
            });
            $totalFiltered = $query->count();
        }

        $getUnallotedPropertyData = $query->offset($start)
            ->limit($limit)
            ->orderBy($searchableColumns[$orderColumnIndex] ?? 'unallotted_property_details.created_at', $dir)
            ->get();

        $counter = 1; // Initialize counter for auto-increment
        $data = [];
        foreach ($getUnallotedPropertyData as $property) {
            $propertyHTML = $documentHTML = '';
            $nestedData['id'] = $counter++; // Auto-incremented ID
            $propertyHTML .= '<div class="text-primary">'.$property->unique_propert_id.'</div><span class="text-secondary">('.$property->old_property_id.')</span>';
            $nestedData['unique_propert_id'] = $propertyHTML;    
            // $nestedData['unique_propert_id'] = $property->unique_propert_id;
            // $nestedData['old_property_id'] = $property->old_property_id;
            $nestedData['landType'] = $property->landType;
            $nestedData['colonyName'] = $property->colonyName;
            $nestedData['is_property_document_exist'] = $property->is_property_document_exist ? 'Yes' : 'No';
            $nestedData['plot_area_in_sqm'] = $property->plot_area_in_sqm;
            $nestedData['is_vaccant'] = $property->is_vaccant ? 'Yes' : 'No';
            if (!empty($property->is_transferred)) {
                $documentHTML .= !empty($property->departmentName) 
                    ? '<div class="text-secondary">' . htmlspecialchars($property->departmentName) . '</div>' 
                    : '';
            
                $documentHTML .= !empty($property->date_of_transfer) 
                    ? '<div><span class="text-secondary">Transfer Date : ' . \Carbon\Carbon::parse($property->date_of_transfer)->format('d/m/Y') . '</span></div>' 
                    : '';
            
                $documentHTML .= !empty($property->purpose) 
                    ? '<div><span class="text-secondary">Purpose : ' . htmlspecialchars($property->purpose) . '</span></div>' 
                    : '';
            } else {
                $documentHTML .= '<span>No</span>';
            }
            
            $nestedData['is_transferred'] = $documentHTML;
            // $nestedData['is_transferred'] = $property->is_transferred ? $property->departmentName : 'Null';
            $nestedData['is_encrached'] = $property->is_encrached ? 'Yes' : 'No';
            $nestedData['is_litigation'] = $property->is_litigation ? 'Yes' : 'No';
            $data[] = $nestedData;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        ];

        return response()->json($json_data);
    }

    public function customizeReport(Request $request, ReportService $reportService)
    {
        if ($request->export == 1) {
            $rules = [
                'report_type' => 'required',
            ];

            if ($request->report_type === 'PIAS') {
                $rules['section'] = 'required';
            }

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $reportType = $request->report_type;
            $section = $request->section;
            $export = $request->export == 1;
            $page = $request->page_no ?? false;
            switch ($reportType) {
                case 'SWPC':
                    $data = $reportService->sectionwisePropertyCount($export, $page);
                    $exportArray = [];
                    foreach ($data as $i => $row) {
                        unset($row->id);
                        foreach ($row as $key => $value) {
                            $exportArray[$i][ucwords(str_replace('_', ' ', $key))] = $value;
                        }
                    }
                    if (!empty($exportArray)) {
                        return (new FastExcel($exportArray))->download('SWPC.xlsx');
                    } else {
                        return redirect()->back()->with('failure', 'No data found');
                    }
                    break;
                case "CLHFHUA":
                    $data = $reportService->colonyWisePropertyReport($export, $page);
                    if (!empty($data)) {
                        return (new FastExcel($data))->download('CLHFHUA.xlsx');
                    } else {
                        return redirect()->back()->with('failure', 'No data found');
                    }
                    break;
                case "TWPC":
                    $data = $reportService->typewisePropertyCount($export);
                    $exportArray = [];
                    foreach ($data as $i => $row) {
                        foreach ($row as $key => $value) {
                            $exportArray[$i][ucwords(str_replace('_', ' ', $key))] = $value;
                        }
                    }
                    if (!empty($exportArray)) {
                        return (new FastExcel($exportArray))->download('TWPC.xlsx');
                    } else {
                        return redirect()->back()->with('failure', 'No data found');
                    }
                    break;
                //Add new case for report type Property In A Section - Lalit (11/March/2025)
                case 'PIAS':
                    $data = $reportService->propertyInASectionCount($export, $section, $page);
                    //Get Section Code
                    if (!empty($section)) {
                        $sectionCode = Section::where('id', $section)->value('section_code');
                    } else {
                        $sectionCode = 'section';
                    }

                    if (!empty($data)) {
                        return (new FastExcel($data))->download('Property_In_A_' . $sectionCode . '.xlsx');
                    } else {
                        return redirect()->back()->with('failure', 'No data found');
                    }
                    break;

                default:
                    # code...
                    break;
            }
        } else {
            $data['reportTypes'] = ['SWPC' => 'Section-wise Property Count', "CLHFHUA" => "Colony-wise Leasehold, Freehold, and Unallotted Count", "TWPC" => 'Property Type-wise Count', "PIAS" => 'Properties in a Section'];
            $data['sections'] = getRequiredSections(); //changed by Swati as common function to fetch lese and property section is added in common function on 20-03-2025
            return view('report.customize-report-new', $data);
        }
    }

    public function getCustomizeReportData(Request $request, ReportService $reportService)
    {
        $reportType = $request->input('report_type');
        $section = $request->input('section');
        $search = $request->input('search.value');

        switch ($reportType) {
            case 'SWPC':
                $query = $reportService->sectionwisePropertyCountNew($search);
                break;
            case 'CLHFHUA':
                $query = $reportService->colonyWisePropertyReportNew($search);
                break;
            case 'TWPC':
                $query = $reportService->typewisePropertyCountNew($search);
                break;
            case 'PIAS':
                $query = $reportService->propertyInASectionCountNew($section, $search);
                break;
            default:
                return response()->json(['error' => 'Invalid report type'], 400);
        }

        return DataTables::of($query)->make(true);
    }
    
    /** function to show colonywise breakup of section properies to section user - Added by Nitin on 19-02-2025*/
    public function colonywiseSectionReport($sectionId)
    {
        $data = DB::table('property_section_mappings', 'psm')
            ->join('property_masters as pm', function ($join) use ($sectionId) {
                return $join->on('pm.new_colony_name', '=', 'psm.colony_id')
                    ->on('pm.property_type', '=', 'psm.property_type')
                    ->on('pm.property_sub_type', '=', 'psm.property_subtype');
            })
            ->leftJoin('old_colonies as colony', 'pm.new_colony_name', '=', 'colony.id')
            ->leftJoin('splited_property_details as spd', 'pm.id', '=', 'spd.property_master_id')
            ->where('psm.section_id', $sectionId)
            ->select('colony.id as colonyId', 'colony.name as colony_name', DB::raw('count(pm.id) as counter'))
            ->groupBy('colony.id', 'colony.name')
            ->orderBy('colony.name')
            ->get();
        return view('report.section-porperties-colonywise', ['data' => $data, 'sectionId' => $sectionId]);
    }

    //added by swati mishra for displaying dues in filter report by Swati Mishra 11-04-2025
    public function getDemandDetails(Request $request)
    {
        // dd($request);
        $propertyId = $request->property_id; // This is the old_property_id

        // Step 1: Check local demand using old_property_id
        $demand = Demand::where('old_property_id', $propertyId)
            ->whereIn('status', [
                getServiceType('DEM_PENDING'),
                getServiceType('DEM_PART_PAID')
            ])
            ->first();

            // dd($demand);

        if ($demand) {
            return response()->json([
                'status' => true,
                'source' => 'local',
                'data' => [
                    'demand_id' => $demand->unique_id,
                    'demand_date' => Carbon::parse($demand->created_at)->format('d-m-Y'),
                    'amount' => $demand->net_total,
                    'paid' => $demand->paid_amount,
                    'outstanding' => $demand->balance_amount
                ]
            ]);
        }


        // Step 2: Fetch from API using PropertyID (same as old_property_id)
        $pms = new PropertyMasterService();
        $apiData = $pms->getPreviousDemands($propertyId);

        if (
            $apiData &&
            isset($apiData->LatestDemanddetails) &&
            is_array($apiData->LatestDemanddetails) &&
            count($apiData->LatestDemanddetails) > 0
        ) {
            $first = $apiData->LatestDemanddetails[0];
            $paid = $first->AlreadyPaid_asperSection + $first->NTRP_Paid;

            // dd($apiData);

            return response()->json([
                'status' => true,
                'source' => 'live_api',
                'data' => [
                    'demand_id' => $first->DemandID,
                    'demand_date' => Carbon::parse($first->DemandDate)->format('d-m-Y'),
                    'amount' => $first->Amount,
                    'paid' => $paid,
                    'outstanding' => $first->Outstanding
                ]
            ]);
        }

        // Final fallback
        return response()->json([
            'status' => false,
            'message' => 'No demand records found.'
        ]);
    }
}