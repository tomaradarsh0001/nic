<?php

namespace App\Http\Controllers;

use App\Helpers\GeneralFunctions;
use App\Http\Controllers\Controller;
use App\Models\AdminPublicGrievance;
use App\Models\ApplicationMovement;
use App\Models\Application;
use App\Models\ApplicationAppointmentLink;
use App\Models\AppointmentDetail;
use App\Models\Demand;
use App\Models\OldDemand;
use App\Models\MutationApplication;
use App\Models\NewlyAddedProperty;
use App\Models\PropertyMaster;
use App\Models\SplitedPropertyDetail;
use App\Services\ColonyService;
use Illuminate\Http\Request;
use App\Services\DashboardService;
use App\Services\MisService;
use App\Services\ReportService;
use App\Models\UnallottedPropertyDetail;
use App\Services\PropertyMasterService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        // dd($user->roles);
        //dd($user->hasAnyRole('engineer-officer', 'AE', 'JE', 'AO', 'audit-cell', 'vegillence'));
        if ($user->hasAnyRole('super-admin', 'sub-admin', 'minister')) {
            $data = self::getAdminData();
            return view('dashboard.admin', $data);
        } elseif ($user->hasAnyRole('section-officer', 'deputy-lndo', 'lndo', 'it-cell')) {
            $data = self::getSectionData();
            return view('dashboard.section-user', $data);
        } elseif ($user->hasRole('CDV')) {
            $data = self::getCdvData();
            return view('dashboard.cdv-user', $data);
        } elseif ($user->hasAnyRole('engineer-officer', 'AE', 'JE', 'AO', 'audit-cell', 'vegillence')) {
            $data = self::otherOffcialData();
            return view('dashboard.other-official', $data);
        } elseif ($user->hasRole('applicant')) {
            $data = self::applicantData();
            return view('dashboard.applicant', $data);
        } else {
            return view('dashboard.user');
        }
    }


    //For showing the main dashboard to other user accoding to permission - SOURAV CHAUHAN (27/Dec/2024)
    public function mainDashboard()
    {
        $data = self::getAdminData();
        return view('dashboard.admin', $data);
    }
        public function publicDashboard()
    {
        $data = self::getAdminData();
        return view('dashboard.public-dashboard', $data);
    }


    public function propertyTypeDetails($typeId, $colonyId = null, $encodeJson = true,)
    {
        // dd($typeId, $encodeJson, $colonyId);
        $colonyQuery = !is_null($colonyId) ? " and old_colony_name = $colonyId" : '';
        $detailsQueryStatement = "select its.item_name as PropSubType, coalesce( t_data.counter, 0) as counter from(select property_type, property_sub_type, count(*) as counter  from (SELECT 
            *
        FROM
            property_masters
        WHERE
            property_type = $typeId
            $colonyQuery
            )p
        left join
        splited_property_details spd on p.id = spd.property_master_id
        group by property_type, property_sub_type)t_data
                right join (
                select items.item_name, pts.sub_type from
                (select * from property_type_sub_type_mapping where type = $typeId) pts
                join items on items.id = pts.sub_type
                )its
                on its.sub_type = t_data.property_sub_type";
        $propertyTypeDetailsResult = DB::select($detailsQueryStatement);
        if ($encodeJson) {
            return response()->json($propertyTypeDetailsResult);
        } else {
            return $propertyTypeDetailsResult;
        }
    }

    public function dashbordColonyFilter(Request $request, ColonyService $colonyService)
    {
        $colonyId = $request->colony_id;
        $colonyData = $colonyService->allPropertiesInColony($colonyId);
        $propertyTypeArray = ['residential' => 0, 'commercial' => 0, 'industrial' => 0, 'institutional' => 0, 'mixed' => 0, 'others' => 0];
        //sometime getting empty string instead of null, 0

        foreach ($colonyData as $item) {
            if ($item->property_type_name !== "") {
                $lowercaseTypeName = strtolower($item->property_type_name);
                if (array_key_exists($lowercaseTypeName, $propertyTypeArray)) {
                    $propertyTypeArray[$lowercaseTypeName]++;
                }
            }
            // Ensure numeric values for these properties
            $item->plot_value_ldo = is_numeric($item->plot_value_ldo) ? $item->plot_value_ldo : 0;
            $item->plot_value_cr = is_numeric($item->plot_value_cr) ? $item->plot_value_cr : 0;
            $item->plot_area = is_numeric($item->plot_area) ? $item->plot_area : 0;
        }
        $data['property_types'] = $propertyTypeArray;
        $areaRangeArray = [
            ['min' => null, 'max' => 50],
            ['min' => 50, 'max' => 100],
            ['min' => 100, 'max' => 250],
            ['min' => 250, 'max' => 350],
            ['min' => 350, 'max' => 500],
            ['min' => 500, 'max' => 750],
            ['min' => 750, 'max' => 1000],
            ['min' => 1000, 'max' => 2000],
            ['min' => 2000, 'max' => null]
        ];

        $areaRangeDataArray = [
            ['label' => '< 50', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '51-100', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '101-250', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '251-350', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '351-500', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '501-750', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '751-1000', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '1001-2000', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
            ['label' => '> 2000', 'count' => 0, 'area' => 0, 'percent_count' => 0, 'percent_area' => 0],
        ];

        //total
        $data['total_count'] = $colonyData->count();
        $data['total_area'] = $colonyData->sum('plot_area');
        $data['total_area_formatted'] = customNumFormat(round($data['total_area']));
        $data['total_land_value_ldo'] = $colonyData->sum('plot_value_ldo');
        $data['total_land_value_ldo_formatted'] = '₹' . (($data['total_land_value_ldo'] > 10000000) ? (customNumFormat(round($data['total_land_value_ldo'] / 10000000)) . ' Cr.') : customNumFormat(round($data['total_land_value_ldo'])));
        $data['total_land_value_circle'] = $colonyData->sum('plot_value_cr');
        // $data['total_land_value_circle_formatted'] = '₹' . customNumFormat(round($data['total_land_value_circle'] / 10000000)) . ' Cr.';
        $data['total_land_value_circle_formatted'] = '₹' . (($data['total_land_value_circle'] > 10000000) ? (customNumFormat(round($data['total_land_value_circle'] / 10000000)) . ' Cr.') : customNumFormat(round($data['total_land_value_circle'])));
        // Lease hold
        $leaseHold = $colonyData->where('property_status', 951);
        $data['lease_hold_count'] = $leaseHold->count();
        $data['lease_hold_area'] = customNumFormat(round($leaseHold->sum('plot_area')));
        $data['lease_hold_land_value_ldo'] = $leaseHold->sum('plot_value_ldo');
        // $data['lease_hold_land_value_ldo_formatted'] = '₹' . customNumFormat(round($data['lease_hold_land_value_ldo'] / 10000000)) . ' Cr.';
        $data['lease_hold_land_value_ldo_formatted'] = '₹' . (($data['lease_hold_land_value_ldo'] > 10000000) ? (customNumFormat(round($data['lease_hold_land_value_ldo'] / 10000000)) . ' Cr.') : customNumFormat(round($data['lease_hold_land_value_ldo'])));
        $data['lease_hold_land_value_circle'] = $leaseHold->sum('plot_value_cr');
        // $data['lease_hold_land_value_circle_formatted'] = '₹' . customNumFormat(round($data['lease_hold_land_value_circle'] / 10000000)) . ' Cr.';
        $data['lease_hold_land_value_circle_formatted'] = '₹' . (($data['lease_hold_land_value_circle'] > 10000000) ? (customNumFormat(round($data['lease_hold_land_value_circle'] / 10000000)) . ' Cr.') : customNumFormat(round($data['lease_hold_land_value_circle'])));

        // Free hold
        $freeHold = $colonyData->where('property_status', 952);
        $data['free_hold_count'] = $freeHold->count();
        $data['free_hold_area'] = customNumFormat(round($freeHold->sum('plot_area')));
        $data['free_hold_land_value_ldo'] = $freeHold->sum('plot_value_ldo');
        // $data['free_hold_land_value_ldo_formatted'] = '₹' . customNumFormat(round($data['free_hold_land_value_ldo'] / 10000000)) . ' Cr.';
        $data['free_hold_land_value_ldo_formatted'] = '₹' . (($data['free_hold_land_value_ldo'] > 10000000) ? (customNumFormat(round($data['free_hold_land_value_ldo'] / 10000000)) . ' Cr.') : customNumFormat(round($data['free_hold_land_value_ldo'])));
        $data['free_hold_land_value_circle'] = $freeHold->sum('plot_value_cr');
        // $data['free_hold_land_value_circle_formatted'] = '₹' . customNumFormat(round($data['free_hold_land_value_circle'] / 10000000)) . ' Cr.';
        $data['free_hold_land_value_circle_formatted'] = '₹' . (($data['free_hold_land_value_circle'] > 10000000) ? (customNumFormat(round($data['free_hold_land_value_circle'] / 10000000)) . ' Cr.') : customNumFormat(round($data['free_hold_land_value_circle'])));



        // Unalloted
        $unallotted = $colonyData->where('property_status', 1476);
        $data['unallotted_count'] = $unallotted->count();
        $data['unallotted_area'] = customNumFormat(round($unallotted->sum('plot_area')));
        $data['unallotted_land_value_ldo'] = $unallotted->sum('plot_value_ldo');
        // $data['unallotted_land_value_ldo_formatted'] = '₹' . customNumFormat(round($data['unallotted_land_value_ldo'] / 10000000)) . ' Cr.';
        $data['unallotted_land_value_ldo_formatted'] = '₹' . (($data['unallotted_land_value_ldo'] > 10000000) ? (customNumFormat(round($data['unallotted_land_value_ldo'] / 10000000)) . ' Cr.') : customNumFormat(round($data['unallotted_land_value_ldo'])));
        $data['unallotted_land_value_circle'] = $unallotted->sum('plot_value_cr');
        // $data['unallotted_land_value_circle_formatted'] = '₹' . customNumFormat(round($data['unallotted_land_value_circle'] / 10000000)) . ' Cr.';
        $data['unallotted_land_value_circle_formatted'] = '₹' . (($data['unallotted_land_value_circle'] > 10000000) ? (customNumFormat(round($data['unallotted_land_value_circle'] / 10000000)) . ' Cr.') : customNumFormat(round($data['unallotted_land_value_circle'])));


        foreach ($areaRangeArray as $index => $range) {
            // Clone the original dataset to apply filters
            $filteredData = clone $colonyData;

            if (!is_null($range['min'])) {
                $filteredData = $filteredData->where('plot_area', '>', $range['min']);
            }
            if (!is_null($range['max'])) {
                $filteredData = $filteredData->where('plot_area', '<=', $range['max']);
            }

            // Calculate the sum for the filtered dataset
            $sum = $filteredData->sum('plot_area');
            $leaseHoldCount = $filteredData->where('property_status', 951)->count();
            $freeHoldCount = $filteredData->where('property_status', 952)->count();

            // Store the result
            $areaRangeDataArray[$index]['count'] = $filteredData->count();
            $areaRangeDataArray[$index]['area'] = $sum;
            $areaRangeDataArray[$index]['leaseHoldCount'] = $leaseHoldCount;
            $areaRangeDataArray[$index]['freeHoldCount'] = $freeHoldCount;
            $areaRangeDataArray[$index]['percent_count'] = round((($filteredData->count() / $data['total_count']) * 100), 2);
            $areaRangeDataArray[$index]['percent_area'] = round((($sum / $colonyData->sum('plot_area')) * 100), 2);
            $areaRangeDataArray[$index]['percent_leaseHold'] = round((($leaseHoldCount / $data['total_count']) * 100), 2);
            $areaRangeDataArray[$index]['percent_freeHold'] = round((($freeHoldCount / $data['total_count']) * 100), 2);
        }
        $data['areaRangeData'] = $areaRangeDataArray;
        return response()->json($data);
    }

    private function getAdminData() //ColonyService $colonyService
    {
        $countAndTotalArea = DB::select('call property_count_and_area()');
        $data['totalCount'] = $countAndTotalArea[0]->total_count;
        $data['totalArea'] = $countAndTotalArea[0]->total_area;
        $data['totalLdoValue'] = $countAndTotalArea[0]->total_ldo_value;
        $data['totalCircleValue'] = $countAndTotalArea[0]->total_cr_value;
         $data['applicationData'] = $this->getApplicationData(getRequiredSections()->pluck('id')->toArray());
        $data['statusList'] = getApplicationStatusList(true, true);
        // Add a new item to the collection for display Disposed application count (Approved + Reject) - Lalit Tiwari (17/04/2025)
       
   
        $propArea = DB::select('call get_property_area_details()');
        // dd($propArea);
        //Added by Amita -- 27-06-2024
        /* $lh_land_val = DB::select("select  sum(l.plot_value_cr) as totalCrVal from property_masters p join property_lease_details l on 
                        p.id  = l.property_master_id where p.status = 951");
                        
        $fh_land_val = DB::select("select  sum(l.plot_value_cr) as totalCrVal from property_masters p join property_lease_details l on 
                        p.id  = l.property_master_id where p.status = 952"); */
        //End

        /** changes done by Nitin on 28.06.2024 */









        /** we need to transform the data to show it on table in dashboard */
        $labels = [];
        $counts = [];
        $areas = [];
        $firstRow = true;
        $areaWiseDetails = [];
        foreach ($propArea as $index => $col) {
            $rowKey = '';
            foreach ($col as $key => $val) {

                if ($key != 'type') {
                    if ($firstRow) {
                        $areaWiseDetails[$key] = [];
                    }
                    /* if (isset($rowKey) && $rowKey == 'count') {
                        array_push($counts, $val);
                    }
                    if (isset($rowKey) && $rowKey == 'area') {
                        array_push($areas, $val);
                    } */
                    if (isset($rowKey) && $rowKey != '') {
                        $areaWiseDetails[$key][$rowKey] = $val;
                    }
                } else {
                    $rowKey = $val;
                }
            }
            $firstRow = false;
        }
        $data['propertyAreaDetails'] = $areaWiseDetails;
        $statusCount = ['free_hold' => 0, 'lease_hold' => 0, 'unallotted' => 0];
        $statusArea = ['free_hold' => 0, 'lease_hold' => 0, 'unallotted' => 0];
        $statusLdoValue = ['free_hold' => 0, 'lease_hold' => 0, 'unallotted' => 0];
        $statusCircleValue = ['free_hold' => 0, 'lease_hold' => 0, 'unallotted' => 0];
        $statusCountData = DB::select('call count_status()');
        if (count($statusCountData) > 0) {
            foreach ($statusCountData as $row) {
                if ($row->item_name == 'Free Hold') {
                    $statusCount['free_hold'] = $row->counter;
                    $statusArea['free_hold'] = $row->total_area;
                    $statusLdoValue['free_hold'] = $row->ldo_value;
                    $statusCircleValue['free_hold'] = $row->cr_value;
                }
                if ($row->item_name == 'Lease Hold') {
                    $statusCount['lease_hold'] = $row->counter;
                    $statusArea['lease_hold'] = $row->total_area;
                    $statusLdoValue['lease_hold'] = $row->ldo_value;
                    $statusCircleValue['lease_hold'] = $row->cr_value;
                }
                if ($row->item_name == 'Unallotted') {
                    $statusCount['unallotted'] = $row->counter;
                    $statusArea['unallotted'] = $row->total_area;
                    $statusLdoValue['unallotted'] = $row->ldo_value;
                    $statusCircleValue['unallotted'] = $row->cr_value;
                }
            }
        }
        /* //unalloted properties
                $UnallottedPropertyDetail = PropertyMaster::where('status', 1476)->get();
                $data['unallottedPropertyCount'] = $UnallottedPropertyDetail->count();
                $data['unallottedPropertyArea'] = UnallottedPropertyDetail::sum('plot_area_in_sqm');
                $data['unallottedPropertyLndoRate'] = UnallottedPropertyDetail::sum('plot_value');
                $data['unallottedPropertyCircleRate'] = UnallottedPropertyDetail::sum('plot_value_cr'); */
        $data['statusCount'] = $statusCount;
        $data['statusArea'] = $statusArea;
        $data['statusLdoValue'] = $statusLdoValue;
        $data['statusCircleValue'] = $statusCircleValue;
        /*
        $data['lh_land_val'] = $lh_land_val[0]->totalCrVal;   //Added by Amita -- 27-06-2024
        $data['fh_land_val'] = $fh_land_val[0]->totalCrVal;   //Added by Amita -- 27-06-2024 */


        // $property
        $propertyTypeCount = ['Residential' => 0, 'Commercial' => 0, 'Industrial' => 0, 'Institutional' => 0, 'Mixed' => 0, 'Others' => 0];
        $propertyTypeArea = ['Residential' => 0, 'Commercial' => 0, 'Industrial' => 0, 'Institutional' => 0, 'Mixed' => 0, 'Others' => 0];
        $propertyTypeCountData = DB::select('call count_property_type()');
        if (count($propertyTypeCountData) > 0) {
            foreach ($propertyTypeCountData as $row) {
                /*  if ($row->item_name == 'Residential') {
                    $propertyTypeCount['Residential'] = $row->counter;
                    $propertyTypeArea['Residential'] = $row->total_area;
                }
                if ($row->item_name == 'Commercial') {
                    $propertyTypeCount['Commercial'] = $row->counter;
                    $propertyTypeArea['Commercial'] = $row->total_area;
                }

                if ($row->item_name == 'Industrial') {
                    $propertyTypeCount['Industrial'] = $row->counter;
                    $propertyTypeArea['Industrial'] = $row->total_area;
                }
                if ($row->item_name == 'Institutional') {
                    $propertyTypeCount['Institutional'] = $row->counter;
                    $propertyTypeArea['Institutional'] = $row->total_area;
                } */
                $propertyTypeCount[$row->item_name] = $row->counter;
                $propertyTypeArea[$row->item_name] = $row->total_area;
            }
        }
        $data['propertyTypeCount'] = $propertyTypeCount;
        $data['propertyTypeArea'] = $propertyTypeArea;
        $landTypeCount = ['Rehabilitation' => 0, 'Nazul' => 0];
        $landTypeCountData = DB::select('call count_land()');
        if (count($landTypeCountData) > 0) {
            foreach ($landTypeCountData as $row) {
                if ($row->item_name == 'Rehabilitation') {
                    $landTypeCount['Rehabilitation'] = $row->counter;
                }
                if ($row->item_name == 'Nazul') {
                    $landTypeCount['Nazul'] = $row->counter;
                }
            }
        }
        $data['landTypeCount'] = $landTypeCount;

        $barChartData = DB::select('call bar_chart_data()');
        $data['barChartData'] = $barChartData;
        $queryStatement = "SELECT 
        items.item_name AS property_type_name,
        items.id,
        COALESCE(pm.counter, 0) AS counter
        FROM
            (SELECT 
                *
            FROM
                items
            WHERE
                group_id = 1052 AND is_active = 1
            ORDER BY item_order) items
                LEFT JOIN
            (SELECT 
                t.property_type, COUNT(t.property_type) AS counter
            FROM
                (SELECT 
                property_type
            FROM
                property_masters
            WHERE
                is_joint_property IS NULL UNION ALL SELECT 
                m.property_type
            FROM
                splited_property_details spd
            JOIN property_masters m ON spd.property_master_id = m.id) t
            GROUP BY property_type) pm ON items.id = pm.property_type
        ORDER BY items.item_order";
        $queryResult = DB::select($queryStatement);
        $data['tabHeader'] = $queryResult;
        $tab1Data = $queryResult[0];
        $tab1Id = $tab1Data->id;
        $data['tab1Details'] = self::propertyTypeDetails($tab1Id, null, false);
        // dd($data['tab1Details']);

        //grt data for land value chart added on 03.07.2024 by Nitin
        $landValueData = DB::select('call land_value()')[0];
        $formattedLandValueData = ['labels' => [], 'values' => []];
        foreach ($landValueData as $i => $val) {
            $formattedLandValueData['labels'][] = "'" . $i . "'";
            $formattedLandValueData['values'][] = $val;
        }
        $data['landValueData'] = $formattedLandValueData;
        $colonyService = new ColonyService();
        $data['colonies'] = $colonyService->misDoneForColonies();

        $oldDemandQuery = OldDemand::select(
            DB::raw('count(distinct(property_id)) as property_count'),
            DB::raw('sum(amount) as amount'),
            DB::raw('sum(outstanding) as outstanding_amount'),
        )->whereNotNull('property_status');
        $totalData = (clone $oldDemandQuery)->first();
        $leaseHoldData = (clone $oldDemandQuery)->where('property_status', 951)->first();
        $freeHoldData = (clone $oldDemandQuery)->where('property_status', 952)->first();
        $data['oldDemandData'] = ['total' => $totalData, 'leaseHold' => $leaseHoldData, 'freeHold' => $freeHoldData];

        return $data;
    }

    private function getSectionData()
    {
        /**Code added by Nitin to get dynamic status of applications */
        $user = Auth::user();
        $sections = $user->sections;
        $data['sections'] = $sections;
        if ($sections->count() > 0) {
            foreach ($sections as $key => $section) {
                $sections[$key]->property_count = $this->getSectionPropertyCount($section->id);
            }
        }
        $sectionIdArray = $sections->pluck('id')->all();
        $sectionIdCommaSaperatedString = implode(',', $sectionIdArray);
        
        //Added by Lalit -- 29-07-2024  Call the stored procedure and fetch results from user_registration table to show total registration, pending , approved, rejected etc..

        //modified by Nitin to get data for sections assigned to user
        $data['registrations'] = $this->getUserRegistrationCount($sectionIdCommaSaperatedString);

        $data['newProperty'] = $this->getNewPropertyTypes($sectionIdCommaSaperatedString);
        $sectionIds = [];
        foreach ($sections as $section) {
            array_push($sectionIds, $section->id);
        }
        $applicationData = $this->getApplicationData($sectionIds);
        $data = array_merge($data, $applicationData);
        $data['statusList'] = getApplicationStatusList(true, true);
        return $data;
    }


    //for getting cdv dashboard details - SOURAV CHAUHAN (17 Feb 2025)
    private function getCdvData()
    {
        /**Code added by Nitin to get dynamic status of applications */
        $user = Auth::user();
        $sections = $user->sections;
        $data['sections'] = $sections;
        $sectionIdArray = $sections->pluck('id')->all();
        $sectionIdCommaSaperatedString = implode(',', $sectionIdArray);

        $sectionIds = [];
        foreach ($sections as $section) {
            array_push($sectionIds, $section->id);
        }
        $applicationData = $this->getCdvApplicationData($sectionIds);
        // dd($applicationData);
        $data = array_merge($data, $applicationData);
        $data['statusList'] = getApplicationStatusList(true, true);
        return $data;
    }

    //for getting cdv dashboard details - SOURAV CHAUHAN (17 Feb 2025)
    private function getCdvApplicationData($sectionIds){

        $userId = Auth::id();
        $applicationMovements = ApplicationMovement::whereIn('id', function ($subquery) use ($userId) {
            $subquery->selectRaw('MAX(id)')
                ->from('application_movements')
                ->where(function ($query) use ($userId) {
                    $query->where('assigned_to', $userId)
                          ->orWhere('assigned_by', $userId);
                })
                ->groupBy('application_no');
        })
        ->get();

        
        $applicationNumbers = $applicationMovements->pluck('application_no');
        //dd($applicationNumbers);
    
      
        $itemsSubquery = DB::table('items')
        ->where('group_id', 1031)
        ->where('is_active', 1)
        ->select('id', 'item_code', 'item_name');
    $mutataionAppDetail = DB::table('mutation_applications as ma')
        ->whereIn('ma.application_no', $applicationNumbers)
        ->rightJoinSub($itemsSubquery, 'items', function ($join) {
            $join->on('ma.status', '=', 'items.id');
        })
        ->select('items.item_code', DB::raw('coalesce(count(ma.id),0) as count'))
        ->groupBy('items.id', 'ma.status')
        ->get();
        // dd($mutataionAppDetail);
    $mutationData = $this->formatAppData($itemsSubquery->get(), $mutataionAppDetail);
   
   
    $conversionAppDetail = DB::table('conversion_applications as ca')
    ->whereIn('ca.application_no', $applicationNumbers)
    ->rightJoinSub($itemsSubquery, 'items', function ($join) {
        $join->on('ca.status', '=', 'items.id');
    })
        ->select('items.item_code', 'items.item_name', DB::raw('COALESCE(COUNT(ca.id), 0) as count'))
        ->groupBy('items.id', 'items.item_code')
        ->get();
    // dd($conversionAppDetail->toSql(), $conversionAppDetail->getBindings());

    $conversionData = $this->formatAppData($itemsSubquery->get(), $conversionAppDetail);

    // dd($mutationData,$conversionData);
    // Combine status-wise counts across all processes
    $statusWiseCounts = $this->combineStatusData($mutationData, $conversionData);
    // Calculate total application count by summing status-wise counts
    $totalAppCount = array_sum($statusWiseCounts) - (isset($statusWiseCounts['total']) ? $statusWiseCounts['total'] : 0) - (isset($statusWiseCounts['APP_DES']) ? $statusWiseCounts['APP_DES'] : 0); // total, approved, rejected and disposed are  repeated;


   

    return ['mutataionData' => $mutationData, 'conversionData' => $conversionData, 'totalAppCount' => $totalAppCount, 'statusWiseCounts' => $statusWiseCounts];

    }

    public function DashboardTileList($proppertyType, $colony = null)
    {
        $reportService = new ReportService();
        $filters = ['property_type' => [$proppertyType]];
        if (!is_null($colony))
            $filters['colony'] = [$colony];
        $properties = $reportService->detailedReport($filters);
        $data['total'] = $properties['total'];
        $data['properties'] = $properties['data'];
        return view('mis.property-list', $data);
    }

    public function dashbordSectionFilter(Request $request)
    {
        $filter = $request->filter;
        if (!is_array($filter)) {
            $filter = [$filter];
        }
        $data = $this->getApplicationData($filter);

        if ($data) {
            return response()->json(array_merge(['status' => 'success'], $data));
        }
    }

    public function getApplicationData($sectionIds)
    {
        $itemsSubquery = DB::table('items')
            ->where('group_id', 1031)
            ->where('is_active', 1)
            ->select('id', 'item_code', 'item_name');
        $mutataionAppDetail = DB::table('mutation_applications as ma')
            ->join('property_masters as pm', 'pm.id', 'ma.property_master_id')
            ->join('property_section_mappings as psm', function ($join) {
                $join->on('pm.new_colony_name', 'psm.colony_id');
                $join->whereColumn('pm.property_type', 'psm.property_type');
                $join->whereColumn('pm.property_sub_type', 'psm.property_subtype');
            })
            ->join('sections', 'psm.section_id', 'sections.id')
            ->whereIn('sections.id', $sectionIds)
            ->rightJoinSub($itemsSubquery, 'items', function ($join) {
                $join->on('ma.status', '=', 'items.id');
            })
            ->select('items.item_code', DB::raw('coalesce(count(ma.id),0) as count'))
            ->groupBy('items.id', 'ma.status')
            ->get();
        $mutationData = $this->formatAppData($itemsSubquery->get(), $mutataionAppDetail);
        $doaAppDetail = DB::table('deed_of_apartment_applications as doa')
            ->join('property_masters as pm', 'pm.id', 'doa.property_master_id')
            ->join('property_section_mappings as psm', function ($join) {
                $join->on('pm.new_colony_name', 'psm.colony_id');
                $join->whereColumn('pm.property_type', 'psm.property_type');
                $join->whereColumn('pm.property_sub_type', 'psm.property_subtype');
            })
            ->join('sections', 'psm.section_id', 'sections.id')
            ->whereIn('sections.id', $sectionIds)
            ->rightJoinSub($itemsSubquery, 'items', function ($join) {
                $join->on('doa.status', '=', 'items.id');
            })
            ->select('items.item_code', DB::raw('coalesce(count(doa.id),0) as count'))
            ->groupBy('items.id', 'doa.status')
            ->get();
        $doaData = $this->formatAppData($itemsSubquery->get(), $doaAppDetail);
        $lucAppDetail = DB::table('land_use_change_applications as luc')
            ->join('property_masters as pm', 'pm.id', '=', 'luc.property_master_id')
            ->join('property_section_mappings as psm', function ($join) {
                $join->on('pm.new_colony_name', 'psm.colony_id');
                $join->whereColumn('pm.property_type', 'psm.property_type');
                $join->whereColumn('pm.property_sub_type', 'psm.property_subtype');
            })
            ->join('sections', 'psm.section_id', 'sections.id')
            ->whereIn('sections.id', $sectionIds)
            ->rightJoinSub($itemsSubquery, 'items', function ($join) {
                $join->on('luc.status', '=', 'items.id');
            })
            ->select('items.item_code', 'items.item_name', DB::raw('COALESCE(COUNT(luc.id), 0) as count'))
            ->groupBy('items.id', 'items.item_code')
            ->get();

        $lucData = $this->formatAppData($itemsSubquery->get(), $lucAppDetail);
        $conversionAppDetail = DB::table('conversion_applications as ca')
            ->join('property_masters as pm', 'pm.id', '=', 'ca.property_master_id')
            ->join('property_section_mappings as psm', function ($join) {
                $join->on('pm.new_colony_name', 'psm.colony_id');
                $join->whereColumn('pm.property_type', 'psm.property_type');
                $join->whereColumn('pm.property_sub_type', 'psm.property_subtype');
            })
            ->join('sections', 'psm.section_id', 'sections.id')
            ->whereIn('sections.id', $sectionIds)
            ->rightJoinSub($itemsSubquery, 'items', function ($join) {
                $join->on('ca.status', '=', 'items.id');
            })
            ->select('items.item_code', 'items.item_name', DB::raw('COALESCE(COUNT(ca.id), 0) as count'))
            ->groupBy('items.id', 'items.item_code')
            ->get();
        // dd($conversionAppDetail->toSql(), $conversionAppDetail->getBindings());

        $conversionData = $this->formatAppData($itemsSubquery->get(), $conversionAppDetail);

         // Add Query for NOC - Lalit Tiwari (20/March/2025)
         $nocAppDetail = DB::table('noc_applications as noc')
         ->join('property_masters as pm', 'pm.id', 'noc.property_master_id')
         ->join('property_section_mappings as psm', function ($join) {
             $join->on('pm.new_colony_name', 'psm.colony_id');
             $join->whereColumn('pm.property_type', 'psm.property_type');
             $join->whereColumn('pm.property_sub_type', 'psm.property_subtype');
         })
         ->join('sections', 'psm.section_id', 'sections.id')
         ->whereIn('sections.id', $sectionIds)
         ->rightJoinSub($itemsSubquery, 'items', function ($join) {
             $join->on('noc.status', '=', 'items.id');
         })
         ->select('items.item_code', DB::raw('coalesce(count(noc.id),0) as count'))
         ->groupBy('items.id', 'noc.status')
         ->get();
     $nocData = $this->formatAppData($itemsSubquery->get(), $nocAppDetail);



        // Combine status-wise counts across all processes
        $statusWiseCounts = $this->combineStatusData($mutationData, $doaData, $lucData, $conversionData,$nocData);
        // Calculate total application count by summing status-wise counts
        $totalAppCount = array_sum($statusWiseCounts) - (isset($statusWiseCounts['total']) ? $statusWiseCounts['total'] : 0) - (isset($statusWiseCounts['APP_DES']) ? $statusWiseCounts['APP_DES'] : 0); // total, approved, rejected and disposed are  repeated;

        //total Registration Count - added on 04-december
        $registrationData = $this->getUserRegistrationCount(implode(',', $sectionIds));


        //New property data
        $newPropertyData = $this->getNewPropertyTypes(implode(',', $sectionIds));

        //appointment count
        $appointmentCount = $this->getAppointmentCount($sectionIds);

        //grievences count

        $grievencesCount = $this->getGrievencesCount($sectionIds);

        return ['mutataionData' => $mutationData, 'doaData' => $doaData, 'lucData' => $lucData, 'conversionData' => $conversionData, 'totalAppCount' => $totalAppCount, 'statusWiseCounts' => $statusWiseCounts, 'registrationData' => $registrationData, 'newPropertyData' => $newPropertyData ?? 0, 'appointmentCount' => $appointmentCount, 'grievencesCount' => $grievencesCount,'nocData' => $nocData];
    }

    private function formatAppData($statusArray, $dataArray)
    {
        $returnArr = [];
        foreach ($statusArray as $row) {
            $returnArr[$row->item_code] = 0;
        }
        foreach ($dataArray as $data) {
            $returnArr[$data->item_code] = $data->count;
        }
        $returnArr['total'] = array_sum($returnArr);
        /**Approved and Rejected applications shoudl be displayed under Disposed heading */
        $returnArr['APP_DES'] = $returnArr["APP_APR"] + $returnArr["APP_REJ"];
        return $returnArr;
    }

    private function combineStatusData(...$dataArrays)
    {
        $combinedData = [];
        foreach ($dataArrays as $dataArray) {
            foreach ($dataArray as $itemCode => $count) {
                if (!isset($combinedData[$itemCode])) {
                    $combinedData[$itemCode] = 0;
                }
                $combinedData[$itemCode] += $count;
            }
        }
        /**Approved and Rejected applications shoudl be displayed under Disposed heading */
        $combinedData['APP_DES'] = $combinedData["APP_APR"] + $combinedData["APP_REJ"];
        return $combinedData;
    }


    /** function added by Nitin to get data for remaining officials - 02-12-2024 */

    private function otherOffcialData()
    {
        $userId = Auth::id();


        $appMovements = ApplicationMovement::where('assigned_to', $userId)->pluck('id')->toArray();

        $latestMovements = ApplicationMovement::selectRaw('MAX(id) as id')
            ->groupBy('application_no')
            ->pluck('id')
            ->toArray();
        $assignedToUser = array_intersect($appMovements, $latestMovements);
        $assignedToUserCount = count($assignedToUser);
        $passedApplicationsCount = count($appMovements) - $assignedToUserCount;


        return [
            'assignedToUser' => $assignedToUserCount,
            'passed' => $passedApplicationsCount,
        ];
    }

    /** common code moved to saperate function  - added by Nitin to 04- dec-2024*/

    private function getUserRegistrationCount($sectionIds)
    {
        //proceedure is moified to take section ids as input
        $getUserRegistrationCountData = DB::select('CALL GetUserRegistrationCounts(?)', [$sectionIds]);
        return [
            'totalCount' => $getUserRegistrationCountData[0]->TotalCount,
            'newCount' => $getUserRegistrationCountData[0]->RS_NEW ?? 0,
            'appCount' => $getUserRegistrationCountData[0]->RS_APP ?? 0,
            'rejCount' => $getUserRegistrationCountData[0]->RS_REJ ?? 0,
            'urewCount' => $getUserRegistrationCountData[0]->RS_UREW ?? 0,
            'rewCount' => $getUserRegistrationCountData[0]->RS_REW ?? 0,
            'penCount' => $getUserRegistrationCountData[0]->RS_PEN ?? 0,
        ];
    }

    /** function added by Nitin to move common code in a function - 04-dec-2024 */

    private function getNewPropertyTypes($sectionIds)
    {
        // $getNewPropertyCountData = DB::select('CALL GetNewPropertyCounts(?)', [$sectionIds]);
        $getNewPropertyCountData = DB::select('CALL GetNewPropertyCounts(?)', [$sectionIds]);
        return [
            'totalCount' => $getNewPropertyCountData[0]->TotalCount,
            'newCount' => $getNewPropertyCountData[0]->RS_NEW ?? 0,
            'appCount' => $getNewPropertyCountData[0]->RS_APP ?? 0,
            'rejCount' => $getNewPropertyCountData[0]->RS_REJ ?? 0,
            'urewCount' => $getNewPropertyCountData[0]->RS_UREW ?? 0,
            'rewCount' => $getNewPropertyCountData[0]->RS_REW ?? 0,
            'penCount' => $getNewPropertyCountData[0]->RS_PEN ?? 0,
        ];
    }

    /** function to give count of appointment and public grievences */

    private function getGrievencesCount($sectionIds)
    {
        return AdminPublicGrievance::whereIn('section_ids', $sectionIds)->count();
    }
    private function getAppointmentCount($sectionIds)
    {
        return AppointmentDetail::whereIn('dealing_section_code', $sectionIds)->count();
    }

    private function applicantData()
    {
        $user = Auth::user();
        $userProperties = $user->userProperties;
        if ($userProperties->count() > 0) {
            $userProperties = $user->userProperties->map(function ($up) {
                if (is_null($up->known_as)) {
                    $up->known_as = $up->plot . (!is_null($up->block) ? '/' . $up->block : '') . '/' . $up->oldColony->name;
                }
                return $up;
            });
        }
        $data['userProperties'] = $userProperties;
        $userApplications = Application::where('created_by', $user->id)->get();
        $data['userApplications'] = $userApplications;
        $userApplicationIds = $userApplications->pluck('application_no')->all();
        $userAppointments = ApplicationAppointmentLink::whereIn('application_no', $userApplicationIds)->whereDate('valid_till', '>', date('Y-m-d H:i:s'))->where('is_active', 1)->where('is_attended', 0)->get();
        $data['userAppointments'] = $userAppointments;
        $unpaidDemandCount = GeneralFunctions::getUserDemandData(true);
        $data['demandCount'] = $unpaidDemandCount;
        return $data;
    }

    private function getSectionPropertyCount($sectionId)
    {
        return DB::table('property_section_mappings', 'psm')
            ->join('property_masters as pm', function ($join) {
                return $join->on('pm.new_colony_name', '=', 'psm.colony_id')
                    ->on('pm.property_type', '=', 'psm.property_type')
                    ->on('pm.property_sub_type', '=', 'psm.property_subtype');
            })
            ->leftJoin('splited_property_details as spd', 'pm.id', '=', 'spd.property_master_id')
            ->where('psm.section_id', $sectionId)
            ->count();
    }
}
