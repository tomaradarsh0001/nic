<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\CreatePdfForProperty;
use App\Jobs\SendRGRDraft;
use App\Models\CircleLandRate;
use App\Models\Demand;
use App\Models\DemandDetail;
use App\Models\Item;
use App\Models\LndoLandRate;
use App\Models\PropertyLeaseDetail;
use App\Models\PropertyLeaseDetailHistory;
use App\Services\ColonyService;
use App\Services\PropertyMasterService;
use Illuminate\Http\Request;
use App\Models\PropertyMaster;
use App\Models\PropertyMiscDetail;
use App\Models\PropertyMiscDetailHistory;
use App\Models\PropertyRevivisedGroundRent;
use App\Models\PropertyTransferLesseeDetailHistory;
use App\Models\PropertyTransferredLesseeDetail;
use App\Models\SplitedPropertyDetail;
use App\Models\SplitedPropertyDetailHistory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class RgrController extends Controller
{
    public function index(ColonyService $colonyService)
    {
        $data = Self::getRGRviewData($colonyService);
        return view('rgr.dashboard', $data);
    }

    public function singlePropertyRGRInput(ColonyService $colonyService)
    {
        $data['colonies'] = $colonyService->misDoneForColonies();
        return view('rgr.property-input', $data);
    }
    public function rgrColony(ColonyService $colonyService)
    {
        $data['colonies'] = $colonyService->misDoneForColonies();
        return view('rgr.colony-input', $data);
    }


    public function blocksInColony($colonyId, $leaseHoldOnly = false, ColonyService $colonyService)
    {
        $blocksInColony = $colonyService->blocksInColony($colonyId, $leaseHoldOnly);
        return $blocksInColony;
    }
    public function propertiesInBlock($colonyId, $blockId, $leaseHoldOnly = false)
    {
        $colonyService = new ColonyService();
        $propertiesInColony = $colonyService->propertiesInBlock($colonyId, $blockId, $leaseHoldOnly);
        return $propertiesInColony;
    }
    public function propertyBasicdetail(Request $request, PropertyMasterService $propertyMasterService)
    {
        // dd($request->all());
        $propertyId = $request->property_id;
        $returnSplitedProp = false;
        $splitedPropId = null;
        $searchIncolumn = 'old_propert_id'; // for non splited property property is found by old property id when selected from colony block plot dropdown
        $statusColumn = "status";
        if (strpos($propertyId, '_')) { // // for property master_id.'_.child_id
            $idArr = explode('_', $propertyId);
            $propertyId = $idArr[0];
            $splitedPropId = $idArr[1];
            $returnSplitedProp = true;

            $searchIncolumn = 'id';
        }
        $property = PropertyMaster::where($searchIncolumn, $propertyId)->first();
        if (empty($property)) { // if property not found in masters table
            /** If property not found in masters table then check in splitedProperty table */
            $property = SplitedPropertyDetail::where('old_property_id', $propertyId)->first();
            if (empty($property)) {

                return ['status' => 'error', 'message' => 'given property not found'];
            }
            $splitedPropId = $property->id;
            $returnSplitedProp = true;
            $propertyMasterId = $property->property_master_id;
            $statusColumn = 'property_status';
        } else {
            $propertyMasterId = $property->id;
        }
        if ($property->{$statusColumn} != '951') { //check if current status is not lease hold
            return ['status' => 'error', 'message' => 'Can not create RGR for this property it is not lease hold'];
        }
        if (array_key_exists('is_joint_property', $property->getAttributes())) { //check if is_joint_property exist in property, only available in property masters
            if (!is_null($property->is_joint_property)) {
                $statusColumn = 'property_status';
                $children = SplitedPropertyDetail::where('property_master_id', $propertyMasterId)->where($statusColumn, '951')->get();
                if ($children->count() == 0) {
                    return ['status' => 'error', 'message' => 'Can not Process this property. Please check property details'];
                } else {
                    $propertyData = [];
                    foreach ($children as $child) {
                        $propertyData[] = $this->preparePropertyDetails($child->master, true, $child->id, $propertyMasterId);
                    }
                }
            } else {
                $propertyData = $this->preparePropertyDetails($property, false, null, $propertyMasterId);
            }
        } else {
            $propertyData = $this->preparePropertyDetails($property->master, true, $splitedPropId, $propertyMasterId);
        }
        return ['status' => 'success', 'data' => $propertyData];
    }

    public function create(Request $request)
    {
        $request->validate(['property_id' => 'required', 'splited' => 'required', 'fromDate' => 'required|date', 'calculation_rate' => 'required']);

        $property_id = $request->property_id;
        $splited = $request->splited;
        $fromDate = $request->fromDate;
        $insertData = Self::groundRentCalculation($property_id, $splited, $fromDate);
        if (isset($insertData['failure'])) {
            return redirect()->back()->with('failure', $insertData['failure']);
        } else {
            $insertData['data'] = array_slice($insertData['data'], 0, -4, true); //remove already_done, lndoPercent, circlePercent, rgrFacor from array // remove last 3 keys from array
            $insertData['data']['calculated_on_rate'] = $request->calculation_rate;
            $insertData['data']['status'] = 'draft';
            $insertData['data']['created_by'] = Auth::id();
            $insertData['data']['updated_by'] = Auth::id();
            $added = null;
            DB::transaction(function () use ($insertData, &$added) {
                try {
                    $added = PropertyRevivisedGroundRent::create($insertData['data']);
                    if ($added) {
                        // propertyMIscDetails
                        // $this->updateMiscDetails($insertData['data']['property_master_id'], $insertData['data']['splited_property_detail_id']);
                        // $this->updatePresentGroundRent($added);
                    }
                } catch (\Exception $th) {
                    throw ($th);
                }
            });
            return redirect()->back()->with(['newRGR' => $added ? $added->id : null]);
        }
    }

    public function calculateGroundRent(Request $request)
    {
        // dd($request->all());
        $request->validate(['property_id' => 'required', 'splited' => 'required', 'fromDate' => 'required|date']);

        $property_id = $request->property_id;
        $splited = $request->splited;
        $fromDate = $request->fromDate;
        $tillDate = $request->tillDate;
        return Self::groundRentCalculation($property_id, $splited, $fromDate, $tillDate);
    }

    private function groundRentCalculation($property_id, $splited, $fromDate, $tillDate = null, $updatedArea = null)
    {
        try {
            $splited_property_detail_id = null;
            $propertyMaster = null;
            $property_master_id = $property_id;
            if ($splited == 1) {
                $property = SplitedPropertyDetail::find($property_id);
                $propertyMaster = $property->master;
                $area = $property->area_in_sqm;
                $splited_property_detail_id = $property->id;
                $property_master_id = $property->property_master_id;
            } else {
                $propertyMaster = PropertyMaster::find($property_id);
                $area = $propertyMaster->propertyLeaseDetail->plot_area_in_sqm;
            }

            if (!is_null($updatedArea)) {
                $area = $updatedArea;
            }

            $colony_id = $propertyMaster->old_colony_name;


            $fromDate = new \DateTime($fromDate);
            $existingRGR = PropertyRevivisedGroundRent::where(function ($query) use ($property_id, $splited) {
                if ($splited == 1) {
                    return $query->where('splited_property_detail_id', $property_id);
                } else {
                    return $query->where('property_master_id', $property_id);
                }
            })->whereDate('till_date', '>=', $fromDate)->whereIn('status', ['draft', 'final'])->first();

            if (is_null($tillDate)) {
                $currentYear = date('Y');
                $tillDate = new \DateTime($currentYear . '-12-31');

                /** following code not required anymore */
                /*  $currentYear = date('Y');
                $currentMonth = date('m'); */

                // Determine the till date based on the current month
                /* if ($currentMonth > 6) {
                    $tillDate = new \DateTime(($currentYear + 1) . '-01-14'); // If after June, set tillDate to 14 January of the next year
                } else {
                    $tillDate = new \DateTime($currentYear . '-07-14'); // If June or earlier, set tillDate to 14 July of the current year
                } */
            } else {
                $tillDate = new \DateTime($tillDate);
            }
            // Get the current date components

            /** get ground rent rate */

            $lndoGroundRentRow = Self::getLandRates(LndoLandRate::class, $colony_id, $fromDate);
            $circleGroundRentRow = Self::getLandRates(CircleLandRate::class, $colony_id, $fromDate);
            if (!empty($lndoGroundRentRow) || !empty($circleGroundRentRow)) {
                $proprtyTypeName = Item::itemNameById($propertyMaster->property_type);
                $column_name = strtolower($proprtyTypeName) . '_land_rate';
                $lndoLandRate = !empty($lndoGroundRentRow) ? $lndoGroundRentRow->{$column_name} : null;
                $circleLandRate = !empty($circleGroundRentRow) ? $circleGroundRentRow->{$column_name} : null;
                if (!is_null($lndoLandRate) || !is_null($circleLandRate)) {
                    $lndoLandValue = !is_null($lndoLandRate) ? $area * $lndoLandRate : null;
                    $circleLandValue = !is_null($circleLandRate) ? $area * $circleLandRate : null;
                    $lndoCalculation = Self::getPerAnumRent($proprtyTypeName, $lndoLandValue, 'lndo'); //!is_null($lndoLandRate) ? ($lndoLandValue * 2.5) / 100 : null;
                    $circleCalculation = Self::getPerAnumRent($proprtyTypeName, $circleLandValue, 'circle'); //!is_null($circleLandRate) ? ($circleLandValue) / 100 : null;
                    // Calculate the difference in days
                    $lndorgrPerAnum = $lndoCalculation['rgrPerAnum'];
                    $lndoPercent = $lndoCalculation['percent'];
                    // Calculate the difference in days
                    $circlergrPerAnum = $circleCalculation['rgrPerAnum'];
                    $circlePercent = $circleCalculation['percent'];
                    $interval = $fromDate->diff($tillDate);
                    $daysBetween = $interval->days + 1; // also include start date
                    $fromDateYear = $fromDate->format('Y');
                    $daysInYear = ((int)$fromDateYear % 4 == 0) ? 366 : 365;
                    $lndoRgr = !is_null($lndoLandRate) ? round(($lndorgrPerAnum / $daysInYear) * $daysBetween) : null;
                    $circleRgr = !is_null($circleLandRate) ? round(($circlergrPerAnum / $daysInYear) * $daysBetween) : null;
                    $lndo_land_rate_period = null;
                    if (!is_null($lndoLandRate)) {
                        if (is_null($lndoGroundRentRow->date_from)) {
                            $lndo_land_rate_period = 'before ' . $lndoGroundRentRow->date_to;
                        } else if (is_null($lndoGroundRentRow->date_to)) {
                            $lndo_land_rate_period = $lndoGroundRentRow->date_from . ' onwards';
                        } else {
                            $lndo_land_rate_period = ($lndoGroundRentRow->date_from) . ' - ' . $lndoGroundRentRow->date_to;
                        }
                    }
                    $circle_land_rate_period = null;
                    if (!is_null($circleLandRate)) {
                        if (is_null($circleGroundRentRow->date_from)) {
                            $circle_land_rate_period = 'before ' . $circleGroundRentRow->date_to;
                        } else if (is_null($circleGroundRentRow->date_to)) {
                            $circle_land_rate_period = $circleGroundRentRow->date_from . ' onwards';
                        } else {
                            $circle_land_rate_period = ($circleGroundRentRow->date_from) . ' - ' . $circleGroundRentRow->date_to;
                        }
                    }

                    return ['data' => [
                        'property_master_id' => $property_master_id,
                        'splited_property_detail_id' => $splited_property_detail_id,
                        'colony_id' => $colony_id,
                        'property_area_in_sqm' => $area,
                        'from_date' => $fromDate,
                        'till_date' => $tillDate,
                        'lndo_land_rate' => $lndoLandRate,
                        'circle_land_rate' => $circleLandRate,
                        'lndo_land_rate_period' => $lndo_land_rate_period,
                        'circle_land_rate_period' => $circle_land_rate_period,
                        'lndo_land_value' => !is_null($lndoLandRate) ? round($lndoLandValue, 2) : null,
                        'circle_land_value' => !is_null($circleLandRate) ? round($circleLandValue, 2) : null,
                        'lndo_rgr' => $lndoRgr,
                        'circle_rgr' => $circleRgr,
                        'is_re_calculated' => false,
                        'no_of_days' => $daysBetween,
                        'lndo_rgr_per_annum' => !is_null($lndorgrPerAnum) ? round($lndorgrPerAnum, 2) : null,
                        'circle_rgr_per_annum' => !is_null($circlergrPerAnum) ? round($circlergrPerAnum, 2) : null,
                        'already_done' => $existingRGR,
                        'lndoPercent' => $lndoPercent,
                        'circlePercent' => $circlePercent,
                        'rgrFactor' => Config::get('constants.rgr_factor')
                    ]];
                    // Convert DateTime objects to strings

                } else {
                    return ['failure' => 'Land rates are not available for this property type'];
                }
            } else {
                return ['failure' => 'Land rates are not available for this colony and date'];
            }
        } catch (\Exception $th) {
            dd($th);
        }
    }

    private function getPerAnumRent($propertyType, $landValue, $lndoOrCircle)
    {
        if (is_null($landValue))
            return ['rgrPerAnum' => null, 'percent' => null];

        $rgrFactor = Config::get('constants.rgr_factor');
        $percent = $rgrFactor[$lndoOrCircle][strtolower($propertyType)];
        $rgrPerAnum = ($landValue * $percent) / 100;
        return ['rgrPerAnum' => $rgrPerAnum, 'percent' => $percent];
    }

    private function getLandRates($model, $colony_id, $fromDate)
    {
        return $model::where('old_colony_id', $colony_id)->where(function ($query) use ($fromDate) {

            return $query->whereDate('date_from', '<=', $fromDate)->whereDate('date_to', '>=', $fromDate)->orWhere(
                function ($q1) use ($fromDate) {
                    return $q1->whereNull('date_from')->whereDate('date_to', '>=', $fromDate);
                }
            )->orWhere(function ($q2) use ($fromDate) {
                return $q2->whereNull('date_to')->whereDate('date_from', '<=', $fromDate);
            });
        })->first();
    }

    private function getRGRviewData($colonyService)
    {
        $leaseHoldResult = $colonyService->leaseHoldProperties();
        $totalLeaseholdCount = $leaseHoldResult->count();
        $data['totalLeaseHoldCount']  = 0;
        $data['totalLeaseHoldarea']  = 0;
        if ($totalLeaseholdCount > 0) {
            $data['totalLeaseHoldCount']  = $totalLeaseholdCount;
            $data['totalLeaseHoldarea']  = $leaseHoldResult->sum('plot_area');
        }
        $propRGRDone = PropertyRevivisedGroundRent::whereIn('status', ['draft', 'final'])->get();
        /* $doneIds = $propRGRDone->select(['id', 'property_master_id', 'splited_property_detail_id', 'from_date', 'till_date']);
        dd($doneIds); */
        $rgrLDO = $propRGRDone->sum('lndo_rgr_per_annum');
        $data['rgrLDO'] = $rgrLDO;
        $data['rgrCount'] = $propRGRDone->count();
        $rgrCircle = $propRGRDone->sum('circle_rgr_per_annum');
        $rgrDoneArea = $propRGRDone->sum('property_area_in_sqm');
        $data['rgrCircle'] = $rgrCircle;
        $data['rgrDoneArea'] = $rgrDoneArea;
        $data['shouldEdit'] = Self::getEditableRGR();
        // dd($data['shouldEdit']);
        return $data;
    }

    public function colonyRGRDetails(Request $request, ColonyService $colonyService)
    {
        $colonyId = $request->selectedColonyId;
        $startDate = isset($request->startDate) ? $request->startDate : date('Y-01-01');
        $doneOnly = isset($request->doneOnly);
        if ($colonyId != "") {
            $propertiesInColony = $colonyService->leaseHoldProperties($colonyId);
            $leaseHoldCount = $propertiesInColony->count();
            $leaseHoldArea = $propertiesInColony->sum('plot_area');
            $rgrDone = PropertyRevivisedGroundRent::where('colony_id', $colonyId)->whereDate('till_date', '>=', $startDate)->whereIn('status', ['draft', 'final'])->get();
            if ($doneOnly) {
                if ($rgrDone->count() > 0) {
                    $emailNotFound = 0;
                    foreach ($rgrDone as $dataRow) {
                        if (!$dataRow->contactDetails || $dataRow->contactDetails->email == null) {
                            $emailNotFound++;
                        }
                    }
                    $pdfCount = $rgrDone->whereNotNull('draft_file_path')->count();
                    $emailsentCount = $rgrDone->sum('is_draft_sent');
                    return response()->json(['status' => 'success', 'data' => $rgrDone, 'summary' => [
                        'emailNotFound' => $emailNotFound,
                        'leaseHoldCount' => $leaseHoldCount,
                        'pdfCount' => $pdfCount,
                        'emailsentCount' => $emailsentCount
                    ]]);
                } else {
                    return response()->json(['status' => 'error', 'details' => 'No property found with revised ground rent']);
                }
            }
            $rgrDoneCount = $rgrDone->count();
            // $rgrDoneproperties = $rgrDone->pluck('splited_property_detail_id', 'property_master_id');
            $rgrDoneArea = $rgrDoneCount > 0 ? $rgrDone->sum('property_area_in_sqm') : 0;

            /** In case of slited properties we need to send Id for both master and child sent to view
             * 
             * if no child then property_master_id =>$rgr->id
             * if splited then property_master_id => [child1=>$rgr->id1, child2=>$rgr->id2]
             * */

            $done = [];
            if ($rgrDone->count() > 0) {
                foreach ($rgrDone as $row) {
                    if ($row->splited_property_detail_id == null) {
                        $done[$row->property_master_id] = ['id' => $row->id, 'pdf' => $row->draftPath];
                    } else {
                        if (!isset($done[$row->property_master_id])) {
                            $done[$row->property_master_id] = [];
                        }
                        $done[$row->property_master_id][$row->splited_property_detail_id] = ['id' => $row->id, 'pdf' => $row->draftPath];
                    }
                }
            }

            /**------------------------------------------------------------------ */
            /**Land rates for a colny */

            $lndoRates = Self::getLandRates(LndoLandRate::class, $colonyId, $startDate);
            $circleRates = Self::getLandRates(CircleLandRate::class, $colonyId, $startDate);

            return response()->json([
                'status' => 'success',
                'data' => [
                    'leaseHoldCount' => $leaseHoldCount,
                    'leaseHoldArea' => $leaseHoldArea,
                    'rgrDoneCount' => $rgrDoneCount,
                    'rgrDoneArea' => $rgrDoneArea,
                    'properties' => $propertiesInColony,
                    'done' => $done,
                    'lndoRates' => $lndoRates,
                    'circleRates' => $circleRates,
                    'rgrFactor' => Config::get('constants.rgr_factor')
                ]
            ]);
        } else {
            return redirect()->back()->with('failure', 'Colony not recognized');
        }
    }

    public function reviseGroundRentForColony(Request $request, ColonyService $colonyService)
    {
        $request->validate(['colony_id' => 'required', 'calculation_rate' => 'required']);
        if ($request->colony_id) {
            $propertiesInColony = $colonyService->leaseHoldProperties($request->colony_id);
            $skipped = 0;
            $done = 0;
            $done_array = [];
            if ($propertiesInColony->count() > 0) {
                foreach ($propertiesInColony as $prop) {
                    if (!is_null($prop->is_joint_property)) {
                        $insertData = Self::groundRentCalculation($prop->splited_id, 1, $request->start_date, $request->end_date);
                    } else {
                        $insertData = Self::groundRentCalculation($prop->id, 0, $request->start_date, $request->end_date);
                    }
                    if (isset($insertData['data']['already_done']) && !empty($insertData['data']['already_done'])) {
                        $skipped++;
                    } else {
                        $insertData['data'] = array_slice($insertData['data'], 0, -4, true); //remove already_done, lndoPercent, circlePercent, rgrFacor from array // remove last 3 keys from array
                        $insertData['data']['calculated_on_rate'] = $request->calculation_rate;
                        $insertData['data']['status'] = 'draft';
                        $insertData['data']['created_by'] = Auth::id();
                        $insertData['data']['updated_by'] = Auth::id();
                        $added = PropertyRevivisedGroundRent::create($insertData['data']);
                        if ($added) {
                            $done++;
                            $done_array[] = ['target' => $prop->id . (!is_null($prop->is_joint_property) ? '-' . $prop->splited_id : ''), 'id' => $added->id];
                            // $this->updateMiscDetails($prop->id,  $prop->splited_id);
                            // $this->updatePresentGroundRent($added);
                        }
                    }
                }
            } else {
                return response()->json(['status' => 'error', 'message' => 'No free hold property found']);
            }
            return response()->json(['status' => 'success', 'message' => "Ground rent added for $done properties, skipped $skipped. See table for more details", 'data' => $done_array]);
        }
    }

    private function updateMiscDetails($masterId, $splitedId)
    {
        $miscRow = PropertyMiscDetail::where('property_master_id', $masterId)->where('splited_property_detail_id', $splitedId)->first();
        if (empty($miscRow)) {
            PropertyMiscDetail::create([
                'property_master_id' => $masterId,
                'splited_property_detail_id' => $splitedId,
                'is_gr_revised_ever' => 1,
                'gr_revised_date' => date('Y-m-d'),
                'updated_by' => Auth::id()
            ]);
        } else {
            $old_is_gr_revised_ever = $miscRow->is_gr_revised_ever;
            $old_gr_revised_date = $miscRow->gr_revised_date;
            $miscRow->update([
                'is_gr_revised_ever' => 1,
                'gr_revised_date' => date('Y-m-d'),
                'updated_by' => Auth::id()
            ]);
            $pmdh = new PropertyMiscDetailHistory();
            $pmdh->property_master_id = $masterId;
            $pmdh->splited_property_detail_id = $splitedId;
            $pmdh->is_gr_revised_ever = $old_is_gr_revised_ever;
            $pmdh->new_is_gr_revised_ever = 1;
            $pmdh->gr_revised_date = $old_gr_revised_date;
            $pmdh->new_gr_revised_date = date('Y-m-d');
            $pmdh->updated_by = Auth::id();
            $saved = $pmdh->save();
            if ($saved) {
                return true;
            }
        }
    }

    public function checAreaChanged(Request $request)
    {
        $property_master_id = $request->property_master_id;
        $splited_property_detail_id = $request->splited_property_detail_id;
        // if($request->is_supplimentry_lease_deed_executed)
        if (isset($request->property_area_in_sqm) && ($request->property_area_in_sqm > 0)) {
            $area = $request->property_area_in_sqm;
            $miscRow = PropertyMiscDetail::where('property_master_id', $property_master_id)
                ->where('splited_property_detail_id', $splited_property_detail_id)
                ->where('is_supplimentry_lease_deed_executed', 1)->first();
            if (!empty($miscRow)) {
                if (!is_null($miscRow->supplementary_area_in_sqm) && $miscRow->supplementary_area_in_sqm > 0 && $miscRow->supplementary_area_in_sqm != $area) {
                    return response()->json(['status' => 'ok', 'data' => ['date' => $miscRow->supplimentry_lease_deed_executed_date, 'area' => $miscRow->supplementary_area_in_sqm]]);
                } else {
                    return response()->json(['status' => 'error', 'details' => 'No difference in area detected']);
                }
            } else {
                return response()->json(['status' => 'error', 'details' => 'No Data Found']);
            }
        }
    }
    public function saveEditedRGR(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'oldId' => 'required|integer',
            'from_date.*' => 'required|date',
            'till_date.*' => 'required|date',
            'reason_for_change' => 'required',
            'area.*' => 'required_if:area_changed,1'
        ]);
        try {
            DB::transaction(function () use ($validated, $request) {
                $oldId = $validated['oldId'];
                $oldRGR = PropertyRevivisedGroundRent::find($oldId);
                $calculation_rate = isset($request->calculation_rate) ? $request->calculation_rate : $oldRGR->calculated_on_rate;
                if ($oldRGR) {
                    $oldRGRDemandDetail = $oldRGR->demandDetails;
                    if (!is_null($oldRGRDemandDetail)) {
                        $oldDemandDetail = DemandDetail::find($oldRGRDemandDetail->id);
                        if (!is_null($oldDemandDetail)) {
                            $oldDemand = Demand::find($oldRGRDemandDetail->demand_id);

                            $oldDemandDetail->update(['status' => 'withdrawn', 'updated_by' => Auth::id()]);
                            $oldDemandDetails = $oldDemand->demandDetails;
                            $allWithdrawn = $oldDemandDetails->every(fn($item) => $item->status == 'withdrawn');
                            if ($allWithdrawn) {
                                $oldDemand->update(['status' => 'withdrawn', 'updated_by' => Auth::id()]);
                            }
                        }
                    }


                    /*  $updated =   */
                    $oldRGR->update(['status' => 'withdrawn', 'updated_by' => Auth::id()]);
                    // dd($updated);
                    foreach ($validated['from_date'] as $i => $date) {
                        $area = isset($validated['area']) ? $validated['area'][$i] : null; //pass null when area is not in request
                        /** when property is not splited ,send property master id and 0 as splited
                         * when splited send splited property detail id and 1 as splited
                         */
                        $propertyId = is_null($oldRGR->splited_property_detail_id) ? $oldRGR->property_master_id : $oldRGR->splited_property_detail_id;
                        $splited = is_null($oldRGR->splited_property_detail_id) ? 0 : 1;
                        $updatedDetails = $this->groundRentCalculation($propertyId, $splited, $date, $validated['till_date'][$i], $area);
                        $updatedDetails = array_slice($updatedDetails['data'], 0, -4, true);

                        PropertyRevivisedGroundRent::create(array_merge(
                            $updatedDetails,
                            [
                                'is_re_calculated' => 1,
                                'status' => 'draft',
                                'calculated_on_rate' => $calculation_rate,
                                'reason_for_change' => $validated['reason_for_change'],
                                'created_by' => Auth::id(),
                                'updated_by' => Auth::id()
                            ]
                        ));
                    }
                } else {
                    return response()->json(['status' => 'error', 'details' => 'Withdrawn RGR not found']);
                }
            });

            return response()->json(['status' => 'success', 'details' => 'RGR updated successfully']);
        } catch (\Exception $e) {
            dd($e);
            // Log the exception message if needed
            return response()->json(['status' => 'error', 'details' => 'An error occurred while updating RGR', 'error' => $e->getMessage()], 500);
        }
    }

    public function editMultipleRGR(Request $request)
    {
        $data = $request->data;
        if (empty($data)) {
            return response()->json(['status' => 'error', 'details' => 'Invalid data']);
        } else {
            try {
                DB::transaction(function () use ($data) {
                    foreach ($data as $row) {
                        /*  $row['from_date'] = ['0' => $row['from_date']];
                        $row['till_date'] = ['0' => $row['till_date']]; */

                        // Create a new request instance for each item
                        $newRequest = new Request($row);
                        $this->saveEditedRGR($newRequest);
                    }
                });

                return response()->json(['status' => 'success', 'details' => 'All RGRs updated successfully']);
            } catch (\Exception $e) {
                // Log the exception message if needed
                return response()->json(['status' => 'error', 'details' => 'An error occurred while updating RGRs', 'error' => $e->getMessage()], 500);
            }
        }
    }
    public function list(ColonyService $colonyService)
    {
        $data['colonies'] = $colonyService->misDoneForColonies();
        return view('rgr.list', $data);
    }

    public function viewDraft($rgrId)
    {
        $data = $this->getRGRDraftData($rgrId);
        if (!is_null($data)) {
            return view('rgr.draft', $data);
        } else {
            abort(404);
        }
    }

    private function getRGRDraftData($rgrId, $shouldCreateDemand = false)
    {
        $rgr = PropertyRevivisedGroundRent::find($rgrId);
        $demandId = '........'; //initailaize a demand id

        if (!empty($rgr)) {

            $withDrawnRGR = PropertyRevivisedGroundRent::where('property_master_id', $rgr->property_master_id)
                ->when(is_null($rgr->property_master_id), function ($query) {
                    return $query->whereNull('splited_property_detail_id');
                }, function ($query) use ($rgr) {
                    return $query->where('splited_property_detail_id', $rgr->splited_property_detail_id);
                })->where('status', 'withdrawn')->latest()->first();
            if (!is_null($rgr->reason_for_change)) {
                if (in_array($rgr->reason_for_change, [2, 3])) {
                    if (empty($rgr->demandDetails) && $shouldCreateDemand) {
                        $demandId = $this->createDemandAndReturnUniqueIdForRGR(collect([$rgr]));
                    } elseif (!empty($rgr->demandDetails)) {
                        $demandId = $rgr->demandDetails->demand->unique_demand_id;
                    }
                    return  ['rgr' => $rgr, 'withdrawn' => $withDrawnRGR, 'demandId' => $demandId];
                } else {
                    $allArciveRGRs = PropertyRevivisedGroundRent::where('property_master_id', $rgr->property_master_id)
                        ->when(is_null($rgr->property_master_id), function ($query) {
                            return $query->whereNull('splited_property_detail_id');
                        }, function ($query) use ($rgr) {
                            return $query->where('splited_property_detail_id', $rgr->splited_property_detail_id);
                        })->whereIn('status', ['draft', 'final'])->get();
                    if (is_null($allArciveRGRs[0]->demandDetails) && $shouldCreateDemand) {
                        $demandId = $this->createDemandAndReturnUniqueIdForRGR($allArciveRGRs);
                    } elseif (!is_null($allArciveRGRs[0]->demandDetails) && !is_null($allArciveRGRs[0]->demandDetails->demand)) {
                        $demandId = $allArciveRGRs[0]->demandDetails->demand->unique_demand_id;
                    }
                    return ['withdrawn' => $withDrawnRGR, 'allArciveRGRs' => $allArciveRGRs, 'demandId' => $demandId];
                }
            } else {
                if (empty($rgr->demandDetails) && $shouldCreateDemand) {
                    $demandId = $this->createDemandAndReturnUniqueIdForRGR(collect([$rgr]));
                } elseif (!empty($rgr->demandDetails)) {
                    $demandId = $rgr->demandDetails->demand->unique_demand_id;
                }
                return ['rgr' => $rgr, 'demandId' => $demandId];
            }
        } else {
            return null;
        }
    }

    public function rgrDetailsForProperty(Request $request)
    {
        $propertyId = $request->propertyId;
        if ($propertyId != "") {
            if (strpos($propertyId, '_') == false) {
                /**case 1 when property id =  old property id */
                $propertyMaster = PropertyMaster::where('old_propert_id', $propertyId)->first();
                if (empty($propertyMaster)) {
                    $childProperty = SplitedPropertyDetail::where('old_property_id', $propertyId)->first();
                    if (empty($childProperty)) {
                        return response()->json(['status' => 'error', 'details' => "Given property not found"]);
                    }
                    $rgr = PropertyRevivisedGroundRent::where('property_master_id', $childProperty->property_master_id)->where('splited_property_detail_id', $childProperty->id)->whereIn('status', ['draft', 'final'])->get();
                } else {
                    $rgr = PropertyRevivisedGroundRent::with('propertyMaster')->where('property_master_id', $propertyMaster->id)->whereIn('status', ['draft', 'final'])->get();
                }
            } else {
                /** case 2 -  when property id  = master_id.'_'.child_id */
                $id_arr = explode('_', $propertyId);
                if (count($id_arr) > 1) {
                    $masterId = $id_arr[0];
                    $splitedId = $id_arr[1];
                    $rgr = PropertyRevivisedGroundRent::where('property_master_id', $masterId)->where('splited_property_detail_id', $splitedId)->whereIn('status', ['draft', 'final'])->get();
                } else {
                    return response()->json(['status' => 'error', 'details' => "Property Id is not in expected format"]);
                }
            }
            if (empty($rgr)) {
                return response()->json(['status' => 'error', 'details' => "Revised ground rent not found for given property"]);
            } else {
                return response()->json(['status' => 'success', 'data' => $rgr]);
            }
        } else {
            return response()->json(['status' => 'error', 'details' => "Property Id not provided"]);
        }
    }

    public function saveAsPdf($rgrId)
    {
        $rgr = PropertyRevivisedGroundRent::find($rgrId);


        if (empty($rgr)) {
            return response()->json(['status' => 'error', 'details' => 'RGR not found']);
            // return view('rgr.draft', compact('rgr'));
        } else if (!is_null($rgr->draft_file_path)) {
            return response()->json(['status' => 'error', 'details' => 'PDF already generated']);
        } else {
            $colonyName = $rgr->propertyMaster->oldColony->name;
            if (is_null($colonyName) || strlen($colonyName) == 0) {
                return response()->json(['status' => 'error', 'details' => 'Colony name not found']);
            } else {
                $pdfData = $this->getRGRDraftData($rgrId, true);
                $pdfJob = new CreatePdfForProperty($colonyName, $rgr, $pdfData, Auth::id());
                dispatch($pdfJob);
                return response()->json(['status' => 'success', 'message' => 'Creating PDF']);
            }
        }
    }
    public function saveMultiplePdf(Request $request)
    {
        if (isset($request->ids) && count($request->ids) > 0) {
            $ids = $request->ids;
            $errors = []; // to return the details of errors
            $done = 0; // to return how many pdf  saved
            foreach ($ids as $key => $id) {
                $saved = json_decode(Self::saveAsPdf($id)->getContent());
                if ($saved->status == 'success') {
                    $done++;
                } else {
                    $errors[$key] = $saved->details;
                }
            }
            return response()->json(['done' => $done, 'errors' => $errors]);
        } else {
            return response()->json(['status' => 'error', 'details' => 'Invalid data']);
        }
    }
    public function sendDraft($rgrId)
    {
        $rgr = PropertyRevivisedGroundRent::find($rgrId);


        if (empty($rgr)) {
            return response()->json(['status' => 'error', 'details' => 'RGR not found']);
            // return view('rgr.draft', compact('rgr'));
        } else if (is_null($rgr->draft_file_path)) {
            return response()->json(['status' => 'error', 'details' => 'Attachment file not found']);
        } else {
            $contactDetails = $rgr->contactDetails;
            // dd($contactDetails);
            if (!is_null($contactDetails) && !empty($contactDetails)) { //checking contact details in controller else it may fail in job or email
                // $email = $contactDetails->email;
                $email = 'tomaradarsh0001@gmail.com';
                if (!is_null($email) && strlen($email) > 0) {
                    // $emailJob = (new SendRGRDraft($rgr))->delay(Carbon::now()->addMinute());
                    $emailJob = new SendRGRDraft($rgr, $email, Auth::id());
                    dispatch($emailJob);
                    /* $mail = new RGRDraft($rgr);
                    // dd($rgr, $mail);
                    Mail::to($email)->send($mail); */
                    return response()->json(['status' => 'success', 'message' => 'Mail sent']);
                } else {
                    return response()->json(['status' => 'error', 'details' => 'email not found']);
                }
            } else {
                return response()->json(['status' => 'error', 'details' => 'Contact Details not found']);
            }
        }
    }

    public function sendMultipleDrafts(Request $request)
    {
        if (isset($request->ids) && count($request->ids) > 0) {
            $ids = $request->ids;
            $errors = []; // to return the details of errors
            $done = 0; // to return how many pdf  saved
            foreach ($ids as $key => $id) {
                $saved = json_decode(Self::sendDraft($id)->getContent());
                if ($saved->status == 'success') {
                    $done++;
                } else {
                    $errors[$key] = $saved->details;
                }
            }
            return response()->json(['done' => $done, 'errors' => $errors]);
        } else {
            return response()->json(['status' => 'error', 'details' => 'Invalid data']);
        }
    }

    public function checkPropertyStatusChanged(Request $request)
    {
        // dd($request->all());
        $property_master_id = $request->property_master_id;
        $splited_property_detail_id = $request->splited_property_detail_id;
        $conversion = PropertyTransferredLesseeDetail::where([
            'property_master_id' => $property_master_id,
            'splited_property_detail_id' => $splited_property_detail_id,
            'process_of_transfer' => 'Conversion'
        ])->orderBy('transferDate', 'desc')->first();
        if (!empty($conversion)) {
            if (!is_null($conversion->transferDate)) {
                return response()->json(['status' => 'success', 'data' => ['date' => $conversion->transferDate]]);
            } else {
                return response()->json(['status' => 'error', 'details' => 'Transfer date details not available']);
            }
        } else {
            return response()->json(['status' => 'error', 'details' => 'No conversoin found for this property']);
        }
    }

    private function getEditableRGR()
    {
        /**This function is to check whether any property bacome free hold or re entred. In that case the Ground rent needs to be edited */
        $query_land_status_change_counter = "select count(t1.rgr_id) as counter from (select rgr.id as rgr_id, rgr.property_master_id, rgr.splited_property_detail_id, rgr.from_date, rgr.till_date,tld.transferDate from (select * from property_revivised_ground_rent where status in ('draft', 'final'))rgr
        join
        (select * from property_transferred_lessee_details where process_of_transfer = 'Conversion') tld
        on rgr.property_master_id = tld.property_master_id and (rgr.splited_property_detail_id = tld.splited_property_detail_id or(rgr.splited_property_detail_id is null and tld.splited_property_detail_id is null))
        where tld.transferDate >= rgr.from_date and tld.transferDate < rgr.till_date)t1

        left join property_lease_details pld on t1.property_master_id = pld.property_master_id
        left join splited_property_details spd on t1.splited_property_detail_id = spd.id";
        $land_status_change = DB::select($query_land_status_change_counter)[0];
        $query_re_entered_count = "SELECT 
            count(t1.rgr_id) as counter
            FROM
                (SELECT 
                    rgr.id AS rgr_id,
                        rgr.property_master_id,
                        rgr.splited_property_detail_id,
                        rgr.from_date,
                        rgr.till_date,
                        pmd.re_rented_date AS reentry_date
                FROM
                    (SELECT 
                    *
                FROM
                    property_revivised_ground_rent
                WHERE
                    status IN ('draft' , 'final')) rgr
                JOIN (SELECT 
                    *
                FROM
                    property_misc_details
                WHERE
                    is_re_rented = '1') pmd ON rgr.property_master_id = pmd.property_master_id
                    AND (rgr.splited_property_detail_id = pmd.splited_property_detail_id
                    OR (rgr.splited_property_detail_id IS NULL
                    AND pmd.splited_property_detail_id IS NULL))
                WHERE
                    pmd.re_rented_date >= rgr.from_date AND pmd.re_rented_date < rgr.till_date) t1
                    LEFT JOIN
                property_lease_details pld ON t1.property_master_id = pld.property_master_id
                    LEFT JOIN
                splited_property_details spd ON t1.splited_property_detail_id = spd.id";
        $re_entered = DB::select($query_re_entered_count)[0];
        $query_area_chnged_counter = "SELECT 
                COUNT(rgr.id) AS counter
            FROM
                (SELECT 
                    *
                FROM
                    property_revivised_ground_rent
                WHERE
                    status IN ('draft' , 'final')) rgr
                    JOIN
                (SELECT 
                    *
                FROM
                    property_misc_details
                WHERE
                    is_supplimentry_lease_deed_executed = 1
                        AND supplementary_area_in_sqm IS NOT NULL) sld ON rgr.property_master_id = sld.property_master_id
                    AND (rgr.splited_property_detail_id = sld.splited_property_detail_id
                    OR (rgr.splited_property_detail_id IS NULL
                    AND sld.splited_property_detail_id IS NULL))
            WHERE
                sld.supplimentry_lease_deed_executed_date >= rgr.from_date
                    AND sld.supplimentry_lease_deed_executed_date < rgr.till_date";
        $area_changed = DB::select($query_area_chnged_counter)[0];
        if ($land_status_change->counter == 0 && $re_entered->counter == 0 && $area_changed->counter == 0) {
            return null;
        }
        return ['land_status_change' => $land_status_change->counter, 're_entered' => $re_entered->counter, 'area_changed' => $area_changed->counter];
    }

    public function statusChangeList()
    {
        $query_land_status_change = "select t1.*, case when t1.splited_property_detail_id is null then pld.presently_known_as else spd.presently_known_as end as address from (select rgr.id as rgr_id, rgr.property_master_id, rgr.splited_property_detail_id, rgr.from_date, rgr.till_date,tld.transferDate from (select * from property_revivised_ground_rent where status in ('draft', 'final'))rgr
        join
        (select * from property_transferred_lessee_details where process_of_transfer = 'Conversion') tld
        on rgr.property_master_id = tld.property_master_id and (rgr.splited_property_detail_id = tld.splited_property_detail_id or(rgr.splited_property_detail_id is null and tld.splited_property_detail_id is null))
        where tld.transferDate >= rgr.from_date and tld.transferDate < rgr.till_date)t1

        left join property_lease_details pld on t1.property_master_id = pld.property_master_id
        left join splited_property_details spd on t1.splited_property_detail_id = spd.id";
        $data['rows']  = DB::select($query_land_status_change);
        $data['reason'] = 2;
        return view('rgr.editable', $data);
    }

    public function reenteredList()
    {
        $query_re_entered = "SELECT 
        t1.*,
            CASE
                WHEN t1.splited_property_detail_id IS NULL THEN pld.presently_known_as
                ELSE spd.presently_known_as
            END AS address
            FROM
            (SELECT 
                rgr.id AS rgr_id,
                    rgr.property_master_id,
                    rgr.splited_property_detail_id,
                    rgr.from_date,
                    rgr.till_date,
                    pmd.re_rented_date AS reentry_date
            FROM
                (SELECT 
                *
            FROM
                property_revivised_ground_rent
            WHERE
                status IN ('draft' , 'final')) rgr
            JOIN (SELECT 
                *
            FROM
                property_misc_details
            WHERE
                is_re_rented = '1') pmd ON rgr.property_master_id = pmd.property_master_id
                AND (rgr.splited_property_detail_id = pmd.splited_property_detail_id
                OR (rgr.splited_property_detail_id IS NULL
                AND pmd.splited_property_detail_id IS NULL))
            WHERE
                pmd.re_rented_date >= rgr.from_date AND pmd.re_rented_date < rgr.till_date) t1
                LEFT JOIN
            property_lease_details pld ON t1.property_master_id = pld.property_master_id
                LEFT JOIN
            splited_property_details spd ON t1.splited_property_detail_id = spd.id";
        $re_entered = DB::select($query_re_entered);
        $data = ['rows' => $re_entered, 'reason' => 3];
        return view('rgr.editable', $data);
    }
    public function areaChangeList()
    {
        $query_area_change = "SELECT 
                t1.rgr_id, 
                t1.from_date, 
                t1.till_date, 
                t1.old_area, 
                t1.supplimentry_lease_deed_executed_date AS update_date, 
                t1.supplementary_area_in_sqm AS updated_area, 
                CASE 
                    WHEN t1.splited_property_detail_id IS NULL THEN pld.presently_known_as 
                    ELSE spd.presently_known_as 
                END AS address 
            FROM (
                SELECT 
                    rgr.id AS rgr_id,
                    rgr.from_date, 
                    rgr.till_date, 
                    rgr.property_area_in_sqm AS old_area,
                    rgr.property_master_id, 
                    rgr.splited_property_detail_id,
                    sld.supplimentry_lease_deed_executed_date,
                    sld.supplementary_area_in_sqm
                FROM 
                    (SELECT * FROM property_revivised_ground_rent WHERE status IN ('draft', 'final')) AS rgr
                JOIN (
                    SELECT * FROM property_misc_details 
                    WHERE is_supplimentry_lease_deed_executed = 1 AND supplementary_area_in_sqm IS NOT NULL
                ) AS sld
                ON 
                    rgr.property_master_id = sld.property_master_id
                    AND (
                        rgr.splited_property_detail_id = sld.splited_property_detail_id
                        OR (rgr.splited_property_detail_id IS NULL AND sld.splited_property_detail_id IS NULL)
                    )
                WHERE 
                    sld.supplimentry_lease_deed_executed_date >= rgr.from_date 
                    AND sld.supplimentry_lease_deed_executed_date < rgr.till_date
            ) AS t1
            LEFT JOIN property_lease_details AS pld 
                ON t1.property_master_id = pld.property_master_id
            LEFT JOIN splited_property_details AS spd 
                ON t1.splited_property_detail_id = spd.id;";
        $re_entered = DB::select($query_area_change);
        $data = ['rows' => $re_entered, 'reason' => 1];
        return view('rgr.editable', $data);
    }
    /*   public function createDemandAndReturnUniqueIdForRGR($rgrCollection)
    {
        if ($rgrCollection->count() > 0) {
            $amount = $rgrCollection->sum('amount');
            if ($amount > 0) {
                try {
                    DB::transaction(function () use ($rgrCollection, $amount) {
                        $firstRGR = $rgrCollection[0];
                        $propertyId = $firstRGR->propertyId;
                        $property_master_id = $firstRGR->property_master_id;
                        $splited_property_detail_id = $firstRGR->splited_property_detail_id;
                        $master_old_property_id = $firstRGR->propertyMaster->old_propert_id;
                        $splited_old_property_id = !is_null($firstRGR->splited_property_detail_id) ? $firstRGR->splitedPropertyDetail->old_property_id : null;
                        $oldDemand = Demand::where('property_master_id', $property_master_id)->where(function ($query) use ($splited_property_detail_id) {
                            if (is_null($splited_property_detail_id)) {
                                return $query->whereNull('splited_property_detail_id');
                            } else {
                                return $query->where('splited_property_detail_id', $splited_property_detail_id);
                            }
                        })->whereIn('status', ['pending', 'partially paid'])->latest()->first();
                        $forwarded_amount = $forward_reference_id = null;
                        if (!empty($oldDemand)) {
                            $forwarded_amount = $oldDemand->balance_amount;
                            $forward_reference_id = $oldDemand->id;
                        }
                        $newAmount = $amount + $forwarded_amount;
                        $newDemand = Demand::create([
                            'unique_demand_id' => 'D' . $propertyId . date('dmY') . '01' . date('His'),
                            'property_master_id' => $property_master_id,
                            'splited_property_detail_id' => $splited_property_detail_id,
                            'master_old_property_id' => $master_old_property_id,
                            'splited_old_property_id' => $splited_old_property_id,
                            'amount' => $newAmount,
                            'forwarded_amount' => $forwarded_amount,
                            'forward_reference_id' => $forward_reference_id,
                            'balance_amount' => $newAmount,
                            'status' => 'pending',
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id()
                        ]);
                        if ($newDemand) {
                            $demandId = $newDemand->id;
                            $uniqueDemandId = $newDemand->unique_demand_id;
                            foreach ($rgrCollection as $rgr) {
                                $demandDetail = DemandDetail::create([
                                    'demand_id' => $demandId,
                                    'property_master_id' => $property_master_id,
                                    'splited_property_detail_id' => $splited_property_detail_id,
                                    'master_old_property_id' => $master_old_property_id,
                                    'splited_old_property_id' => $splited_old_property_id,
                                    'model' => 'PropertyRevivisedGroundRent',
                                    'model_id' => $rgr->id,
                                    'amount' => $rgr->amount,
                                    'balance_amount' => $rgr->amount,
                                    'status' => 'pending',
                                    'created_by' => Auth::id(),
                                    'updated_by' => Auth::id()
                                ]);
                            }
                            return '$uniqueDemandId';
                        } else {
                            return 'case 1';
                        }
                    });
                } catch (\Throwable $th) {
                    dd($th);
                }
            } else {
                return 'case2';
            }
        } else {
            return 'case3';
        }
    } */

    public function createDemandAndReturnUniqueIdForRGR($rgrCollection)
    {
        if ($rgrCollection->count() > 0) {
            $amount = $rgrCollection->sum('amount');
            if ($amount > 0) {
                try {
                    return DB::transaction(function () use ($rgrCollection, $amount) {
                        $firstRGR = $rgrCollection[0];
                        $propertyId = $firstRGR->propertyId;
                        $property_master_id = $firstRGR->property_master_id;
                        $splited_property_detail_id = $firstRGR->splited_property_detail_id;
                        $master_old_property_id = $firstRGR->propertyMaster->old_propert_id;
                        $splited_old_property_id = !is_null($firstRGR->splited_property_detail_id) ? $firstRGR->splitedPropertyDetail->old_property_id : null;

                        $oldDemand = Demand::where('property_master_id', $property_master_id)
                            ->where(function ($query) use ($splited_property_detail_id) {
                                if (is_null($splited_property_detail_id)) {
                                    return $query->whereNull('splited_property_detail_id');
                                } else {
                                    return $query->where('splited_property_detail_id', $splited_property_detail_id);
                                }
                            })->latest()->first(); // removed ->whereIn('status', ['pending', 'partially paid']) enum('pending','partially paid','paid','withdrawn','forwarded')

                        $forwarded_amount = $forward_reference_id = null;
                        if ($oldDemand) { //check for any pending/ overpaid demand
                            if (in_array($oldDemand->status, ['pending', 'partially paid'])) {
                                $forwarded_amount = $oldDemand->balance_amount;
                                $forward_reference_id = $oldDemand->id;
                            } elseif ($oldDemand->status == 'withdrawn' && !is_null($oldDemand->paid_amount)) {
                                $forwarded_amount = $oldDemand->paid_amount;
                                $forward_reference_id = $oldDemand->id;
                            }
                        }

                        $newAmount = $amount + $forwarded_amount;
                        $newDemand = Demand::create([
                            'unique_demand_id' => $this->createUniqueDemandId($propertyId),
                            'property_master_id' => $property_master_id,
                            'splited_property_detail_id' => $splited_property_detail_id,
                            'master_old_property_id' => $master_old_property_id,
                            'splited_old_property_id' => $splited_old_property_id,
                            'service_type' => 1371,
                            'total_amount' => $newAmount,
                            'forwarded_amount' => $forwarded_amount,
                            'forward_reference_id' => $forward_reference_id,
                            'balance_amount' => $newAmount,
                            'status' => 'pending',
                            'created_by' => Auth::id(),
                            'updated_by' => Auth::id()
                        ]);

                        if (!$newDemand) {
                            throw new \Exception('Failed to create new demand');
                        }

                        $demandId = $newDemand->id;
                        $uniqueDemandId = $newDemand->unique_demand_id;

                        foreach ($rgrCollection as $rgr) {
                            DemandDetail::create([
                                'demand_id' => $demandId,
                                'property_master_id' => $property_master_id,
                                'splited_property_detail_id' => $splited_property_detail_id,
                                'master_old_property_id' => $master_old_property_id,
                                'splited_old_property_id' => $splited_old_property_id,
                                'subhead_type' => 495,
                                'model' => 'PropertyRevivisedGroundRent',
                                'model_id' => $rgr->id,
                                'total_amount' => $rgr->amount,
                                'balance_amount' => $rgr->amount,
                                'status' => 'pending',
                                'created_by' => Auth::id(),
                                'updated_by' => Auth::id()
                            ]);
                        }

                        return $uniqueDemandId;
                    });
                } catch (\Throwable $th) {
                    // Log the error for debugging
                    // Handle or rethrow the exception as needed
                    return ['status' => 'error', 'details' => 'Failed to create demand: ' . $th->getMessage()];
                }
            } else {
                //throw new \Exception('Amount is zero, no demand created.');
                return ['status' => 'error', 'details' => 'Amount is zero, no demand created.'];
            }
        } else {
            //throw new \Exception('Empty collection, no demand created.');
            return ['status' => 'error', 'details' => 'Empty collection, no demand created.'];
        }
    }

    private function createUniqueDemandId($propertyId)
    {
        $latestId = Demand::max('id');
        $newId = !is_null($latestId) ? ($latestId + 1) : 1;
        return 'D' . $propertyId . date('YmdHis') . str_pad($newId, 6, '0', STR_PAD_LEFT);
    }

    private function preparePropertyDetails($property, $returnSplitedProp, $splitedPropId, $propertyMasterId)
    {
        $propertyMasterService = new PropertyMasterService();
        $propertyData = $propertyMasterService->formatPropertyDetails($property, $returnSplitedProp, $splitedPropId);
        $rgrDone = PropertyRevivisedGroundRent::where('property_master_id', $propertyMasterId)->when(is_null($splitedPropId), function ($query) {
            return $query->whereNull('splited_property_detail_id');
        }, function ($query) use ($splitedPropId) {
            return $query->where('splited_property_detail_id', $splitedPropId);
        })->whereIn('status', ['draft', 'final'])->first();

        if (!empty($rgrDone)) {
            $propertyData['rgr_id'] = $rgrDone->id;
        }
        $trasferDetails = PropertyTransferredLesseeDetail::where('property_master_id', $propertyMasterId)->when(is_null($splitedPropId), function ($query) {
            return $query->whereNull('splited_property_detail_id');
        }, function ($query) use ($splitedPropId) {
            return $query->where('splited_property_detail_id', $splitedPropId);
        })->select([
            'property_master_id',
            'splited_property_detail_id',
            'batch_transfer_id',
            'process_of_transfer',
            'transferDate'
        ])->selectRaw("GROUP_CONCAT(lessee_name SEPARATOR ', ') as lesse_name")->groupBy('property_master_id', 'splited_property_detail_id', 'batch_transfer_id', 'process_of_transfer', 'transferDate')->orderBy('transferDate')->get();
        $propertyData['trasferDetails'] = $trasferDetails;
        return $propertyData;
    }

    public function completeList($id = null)
    {
        $data = PropertyRevivisedGroundRent::whereIn('status', ['draft', 'final'])->latest()->paginate(25);
        return view('rgr.complete-list', ['data' => $data, 'highlighted' => $id]);
    }

    private function updatePresentGroundRent($rgr)
    {
        if (is_null($rgr->splited_property_detail_id)) {
            $detailRow = PropertyLeaseDetail::where('property_master_id', $rgr->property_master_id)->first();
            PropertyLeaseDetailHistory::create([
                'property_master_id' => $rgr->property_master_id,
                'present_ground_rent' => $detailRow->present_ground_rent,
                'new_present_ground_rent' => $rgr->amount,
                'updated_by' => Auth::id()
            ]);
            $detailRow->update(['present_ground_rent' => $rgr->amount, 'updated_by' => Auth::id()]);
        } else {
            $property = SplitedPropertyDetail::find($rgr->splited_property_detail_id);
            SplitedPropertyDetailHistory::create([
                'splited_property_detail_id' => $property->id,
                'present_ground_rent' => $property->present_ground_rent,
                'new_present_ground_rent' => $rgr->amount,
                'updated_by' => Auth::id()
            ]);
            $property->update(['present_ground_rent' => $rgr->amount, 'updated_by' => Auth::id()]);
        }
    }
}
