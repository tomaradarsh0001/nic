<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PropertyMaster;
use App\Models\LndoLandRate;
use App\Models\CircleLandRate;
use App\Models\PropertyLeaseDetail;
use App\Models\CurrentLesseeDetail;
use App\Models\PropertyTransferredLesseeDetail;
use App\Models\SplitedPropertyDetail;
use App\Models\CircleResidentialLandRate;
use App\Models\LndoResidentialLandRate;
use App\Models\CircleCommercialLandRate;
use App\Models\LndoCommercialLandRate;
use App\Models\CircleInstitutionalLandRate;
use App\Models\LndoInstitutionalLandRate;
use App\Models\PropertyLeaseDetailHistory;
use App\Models\CircleIndustrialLandRate;
use App\Models\LndoIndustrialLandRate;
use DateTime;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Flat;
use Illuminate\Support\Facades\DB;

class ScriptController extends Controller
{
    ///function to update new Cirle and LNDO rates on basis of property type - SOURAV CHAUHAN (27/Nov/2024)
    public function updateLandRates(){
        //query for getting records from this id to that
        $properties = PropertyMaster::whereBetween('id',array('30001','48000'))->get();
        //$properties = PropertyMaster::whereIn('new_colony_name', ['416', '194'])->get();

        foreach($properties as $property){
            $propertyStatus = $property->status;
            $propertyId = $property->id;
            if($propertyStatus == 1476){
                echo "Unallotted Property ID:- ".$propertyId." <b> Not Updated</b><br>";

            } else {
                $propertyType = $property->property_type;
                $newColonyName = $property->new_colony_name;
                $circleRate = null;
                $lndoRate = null;
                switch ($propertyType) {
                    case '47'://Residential
                        $circleRate = Self::fetchLatestLandRate(CircleResidentialLandRate::class, $newColonyName);
                        $lndoRate = Self::fetchLatestLandRate(LndoResidentialLandRate::class, $newColonyName);
                        // $dataCir = CircleLandRate::where("old_colony_id", $newColonyName)
                        //         ->orderBy('date_from', 'desc')
                        //         ->first();
                        // $circleRate = $dataCir ? $dataCir['residential_land_rate'] : null;
    
    
                        // $dataLndo = LndoLandRate::where("old_colony_id", $newColonyName)
                        //         ->orderBy('date_from', 'desc')
                        //         ->first();
                        // $lndoRate = $dataLndo ? $dataLndo['residential_land_rate'] : null;
                        break;
                    case '48'://Commercial
                    case '72'://Mixed
                        $circleRate = Self::fetchLatestLandRate(CircleCommercialLandRate::class, $newColonyName);
                        $lndoRate = Self::fetchLatestLandRate(LndoCommercialLandRate::class, $newColonyName);
                        break;
                    case '49'://Institutional
                        $circleRate = Self::fetchLatestLandRate(CircleInstitutionalLandRate::class, $newColonyName);
                        $lndoRate = Self::fetchLatestLandRate(LndoInstitutionalLandRate::class, $newColonyName);
                        break;
                        case '469'://industrial
                            $circleRate = Self::fetchLatestLandRate(CircleIndustrialLandRate::class, $newColonyName);
                            $lndoRate = Self::fetchLatestLandRate(LndoIndustrialLandRate::class, $newColonyName);
                            break;
                }
                $propertyLeaseDetails = PropertyLeaseDetail::where('property_master_id', $propertyId)->first();
                $plotAreaInSqm = round($propertyLeaseDetails['plot_area_in_sqm'], 2);
                // dd($lndoRate , (float)$plotAreaInSqm);
                if ($lndoRate !== null) {
                    $propertyLeaseDetails->plot_value = round($lndoRate * (float)$plotAreaInSqm, 2);
                }
                if ($circleRate !== null) {
                    $propertyLeaseDetails->plot_value_cr = round($circleRate * (float)$plotAreaInSqm, 2);
                }
                if($propertyLeaseDetails->save()){
                    echo "Parent Property ID:- ".$propertyId." <b>Updated</b><br>";
                    if($property->is_joint_property){
                        $childPropertyDetails = SplitedPropertyDetail::where('property_master_id', $propertyId)->get();
                        if ($childPropertyDetails) {
                            foreach ($childPropertyDetails as $childPropertyDetail) {
                                $childPropertyId = $childPropertyDetail['id'];
                                $childPlotAreaInSqm = round($childPropertyDetail['area_in_sqm'], 2);
                                if ($lndoRate !== null) {
                                    $childPropertyDetail->plot_value = round($lndoRate * (float)$childPlotAreaInSqm, 2);
                                }
                                if ($circleRate !== null) {
        
                                    $childPropertyDetail->plot_value_cr = round($circleRate * (float)$childPlotAreaInSqm, 2);
                                }
                                if($childPropertyDetail->save()){
                                    echo "Child Property ID:- ".$childPropertyId." <b>Updated</b><br>";
                                } else {
                                    echo "Child Property ID:- ".$childPropertyId." <b>not Updated ----------------------**********<b><br>";
                                }
                            }
                        }
                    }
    
                } else {
                    echo "Parent Property ID:- ".$propertyId." <b>not Updated ----------------------**********<b><br>";
                }
            }
        }
    }

    //to fetch land ates from different models
    function fetchLatestLandRate($modelClass, $colonyId) {
        $data = $modelClass::where("colony_id", $colonyId)
                          ->orderBy('date_from', 'desc')
                          ->first();
                          
        return $data ? $data->land_rate : 0;
    }


    public function updateLandValue($id)
    {
        $colonyId = $id;
        $properties = PropertyMaster::where('new_colony_name', $colonyId)->get();

        $lndoRate = LndoLandRate::where("old_colony_id", $colonyId)
            ->orderBy('date_from', 'desc')
            ->first();

        $circleRate = CircleLandRate::where("old_colony_id", $colonyId)
            ->orderBy('date_from', 'desc')
            ->first();

        if ($lndoRate || $circleRate) {
            foreach ($properties as $property) {
                $propertyLeaseDetails = PropertyLeaseDetail::where('property_master_id', $property->id)->first();

                if ($propertyLeaseDetails) {
                    $propertyType = $propertyLeaseDetails['is_land_use_changed'] == 1
                        ? $propertyLeaseDetails['property_type_at_present']
                        : $propertyLeaseDetails['property_type_as_per_lease'];

                    $lndoRateInv = null;
                    $circleRateInv = null;

                    switch ($propertyType) {
                        case '47':
                            $lndoRateInv = $lndoRate ? $lndoRate['residential_land_rate'] : null;
                            $circleRateInv = $circleRate ? $circleRate['residential_land_rate'] : null;
                            break;
                        case '48':
                            $lndoRateInv = $lndoRate ? $lndoRate['commercial_land_rate'] : null;
                            $circleRateInv = $circleRate ? $circleRate['commercial_land_rate'] : null;
                            break;
                        case '49':
                            $lndoRateInv = $lndoRate ? $lndoRate['institutional_land_rate'] : null;
                            $circleRateInv = $circleRate ? $circleRate['institutional_land_rate'] : null;
                            break;
                    }
                    $plotAreaInSqm = round($propertyLeaseDetails['plot_area_in_sqm'], 2);
                    if ($lndoRateInv !== null) {
                        $propertyLeaseDetails->plot_value = round($lndoRateInv * $plotAreaInSqm, 2);
                    }
                    if ($circleRateInv !== null) {
                        $propertyLeaseDetails->plot_value_cr = round($circleRateInv * $plotAreaInSqm, 2);
                    }
                    $propertyLeaseDetails->save();
                } else {
                    return "Property lease details not found for property ID: {$property->id}";
                }
            }

            return "Land value updated successfully";
        } else {
            return "Colony ID not available in LNDO Rates or Circle Rates Table";
        }
    }

    //For updating the land values according to LNDO rates and Circle Rates in Splited Table
    public function updateLandValueInChild($id)
    {
        $colonyId = $id;
        $properties = PropertyMaster::where('is_joint_property', 1)->where('new_colony_name', $colonyId)->get();

        $lndoRate = LndoLandRate::where("old_colony_id", $colonyId)
            ->orderBy('date_from', 'desc')
            ->first();

        $circleRate = CircleLandRate::where("old_colony_id", $colonyId)
            ->orderBy('date_from', 'desc')
            ->first();

        if ($lndoRate || $circleRate) {
            foreach ($properties as $property) {
                // $propertyLeaseDetails = PropertyLeaseDetail::where('property_master_id', $property->id)->first();
                $childPropertyDetails = SplitedPropertyDetail::where('property_master_id', $property->id)->get();
                if ($childPropertyDetails) {
                    foreach ($childPropertyDetails as $childPropertyDetail) {

                        $propertyType = $property->property_type;
                        $lndoRateInv = null;
                        $circleRateInv = null;
                        switch ($propertyType) {
                            case '47':
                                $lndoRateInv = $lndoRate ? $lndoRate['residential_land_rate'] : null;
                                $circleRateInv = $circleRate ? $circleRate['residential_land_rate'] : null;
                                break;
                            case '48':
                                $lndoRateInv = $lndoRate ? $lndoRate['commercial_land_rate'] : null;
                                $circleRateInv = $circleRate ? $circleRate['commercial_land_rate'] : null;
                                break;
                            case '49':
                                $lndoRateInv = $lndoRate ? $lndoRate['institutional_land_rate'] : null;
                                $circleRateInv = $circleRate ? $circleRate['institutional_land_rate'] : null;
                                break;
                        }

                        $plotAreaInSqm = round($childPropertyDetail['area_in_sqm'], 2);
                        if ($lndoRateInv !== null) {
                            $childPropertyDetail->plot_value = round($lndoRateInv * $plotAreaInSqm, 2);
                        }
                        if ($circleRateInv !== null) {

                            $childPropertyDetail->plot_value_cr = round($circleRateInv * $plotAreaInSqm, 2);
                        }
                        $childPropertyDetail->save();
                    }
                } else {
                    return "Property not available in Splited Table for property ID: {$property->id}";
                }
            }

            return "Land value updated successfully";
        } else {
            return "Colony ID not available in LNDO Rates or Circle Rates Table";
        }
    }
	
	//for updating the current lessee in seperate table
	public function updateCurrentLessee($id)
	{
		try {
			$colonyId = $id;
			$properties = PropertyMaster::where('new_colony_name', $colonyId)->get();

			if ($properties->isEmpty()) {
				return "No properties found for the given colony ID.";
			}

			foreach ($properties as $property) {

				//if property is joint
				if($property->is_joint_property == 1){
					
					$splitedPropertyDetails = SplitedPropertyDetail::where('property_master_id',$property->id)->get();
					foreach($splitedPropertyDetails as $splitedPropertyDetail){
						// dd('Inside foreach');
						// Property Details
						$propertyMasterIdChild = $property->id;
						$splitedPropertyDetailId = $splitedPropertyDetail->id;
						$oldPropertyIdChild = $splitedPropertyDetail->old_property_id;
						$propertyStatusChild = $splitedPropertyDetail->property_status;
						$currentArea = $splitedPropertyDetail->current_area;
						$areaInSqm = $splitedPropertyDetail->area_in_sqm;
						$unitChild = $splitedPropertyDetail->unit;
						$presentlyKnownAsChild = $splitedPropertyDetail->presently_known_as;
						$createdByChild = $splitedPropertyDetail->created_by;


						 // Find lessees
						$latestBatchIdChild = PropertyTransferredLesseeDetail::where('property_master_id', $property->id)->where('splited_property_detail_id',$splitedPropertyDetailId)->max('batch_transfer_id');
						// if ($latestBatchIdChild === null) {
						//     return "No lessee details found for property ID: {$property->id} and Splitted property id {$splitedPropertyDetailId}";
						// }

						if($latestBatchIdChild){

							$lesseesWithLatestBatchIdChild = PropertyTransferredLesseeDetail::where('property_master_id', $property->id)
								->where('splited_property_detail_id',$splitedPropertyDetailId)
								->where('batch_transfer_id', $latestBatchIdChild)
								->pluck('lessee_name')
								->toArray();

							$lesseesNamesChild = implode(",", $lesseesWithLatestBatchIdChild);
							$currentLesseeDetailChild = CurrentLesseeDetail::where('property_master_id', $property->id)->where('splited_property_detail_id',$splitedPropertyDetail->id)->first();
							// If current lessee details already saved
							if (!empty($currentLesseeDetailChild)) {
								if ($currentLesseeDetailChild['lessees_name'] != $lesseesNamesChild) {
									$currentLesseeDetailChild->property_status = $propertyStatusChild;
									$currentLesseeDetailChild->lessees_name = $lesseesNamesChild;
									$currentLesseeDetailChild->property_known_as = $presentlyKnownAsChild;
									$currentLesseeDetailChild->area = $currentArea;
									$currentLesseeDetailChild->unit = $unitChild;
									$currentLesseeDetailChild->area_in_sqm = $areaInSqm;
									$currentLesseeDetailChild->save();
								}
							} else {
								CurrentLesseeDetail::create([
									'property_master_id' => $propertyMasterIdChild,
									'splited_property_detail_id' => $splitedPropertyDetailId,
									'old_property_id' => $oldPropertyIdChild,
									'property_status' => $propertyStatusChild,
									'lessees_name' => $lesseesNamesChild,
									'property_known_as' => $presentlyKnownAsChild,
									'area' => $currentArea,
									'unit' => $unitChild,
									'area_in_sqm' => $areaInSqm,
									'created_by' => $createdByChild
								]);
							}
						}

					}
					
				} else {

					// Property Details
					$propertyMasterId = $property->id;
					$oldPropertyId = $property->old_propert_id;
					$propertyStatus = $property->status;

					// Find lessees
					$latestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property->id)->max('batch_transfer_id');
					if ($latestBatchId === null) {
						return "No lessee details found for property ID: {$property->id}";
					}

					$lesseesWithLatestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property->id)
						->where('batch_transfer_id', $latestBatchId)
						->pluck('lessee_name')
						->toArray();

					$lesseesNames = implode(",", $lesseesWithLatestBatchId);

					// Details from lease details
					$leaseDetails = PropertyLeaseDetail::where('property_master_id', $property->id)->first();
					if ($leaseDetails === null) {
						return "No lease details found for property ID: {$property->id}";
					}

					$presentlyKnown = $leaseDetails['presently_known_as'] ?? '';
					$plotArea = $leaseDetails['plot_area'] ?? 0;
					$unit = $leaseDetails['unit'] ?? '';
					$plotAreaInSqm = round($leaseDetails['plot_area_in_sqm'] ?? 0, 2);
					$createdBy = $leaseDetails['created_by'] ?? '';

					$currentLesseeDetail = CurrentLesseeDetail::where('property_master_id', $property->id)->first();

					// If current lessee details already saved
					if (!empty($currentLesseeDetail)) {
						if ($currentLesseeDetail['lessees_name'] != $lesseesNames) {
							$currentLesseeDetail->property_status = $propertyStatus;
							$currentLesseeDetail->lessees_name = $lesseesNames;
							$currentLesseeDetail->property_known_as = $presentlyKnown;
							$currentLesseeDetail->area = $plotArea;
							$currentLesseeDetail->unit = $unit;
							$currentLesseeDetail->area_in_sqm = $plotAreaInSqm;
							$currentLesseeDetail->save();
						}
					} else {
						CurrentLesseeDetail::create([
							'property_master_id' => $propertyMasterId,
							'splited_property_detail_id' => null,
							'old_property_id' => $oldPropertyId,
							'property_status' => $propertyStatus,
							'lessees_name' => $lesseesNames,
							'property_known_as' => $presentlyKnown,
							'area' => $plotArea,
							'unit' => $unit,
							'area_in_sqm' => $plotAreaInSqm,
							'created_by' => $createdBy
						]);
					}

				}
			}

			return "Current lessee details updated successfully.";
		} catch (\Exception $e) {
			return "An error occurred: " . $e->getMessage();
		}
	}
	//This function is written to update the duration and next GR revision date -- Amita [16-12-2024]
	public function updateGrDurationAndDate($colonyId){

		$property_details = PropertyMaster::where(['new_colony_name' => $colonyId])->get();
		
		$i =1;
		if(!empty($property_details)){
			foreach($property_details as $property){
				//Get the data from lease detils from PropertyLeaseDetail
				$lease_details = PropertyLeaseDetail::where('property_master_id', $property->id )->first();
				
				$lease_details->rgr_duration = 30;
				$start_date_of_gr = new DateTime($lease_details->start_date_of_gr);
				$lease_details->first_rgr_due_on =  $start_date_of_gr->modify('+30 years');
				$lease_details->save();
				print_r($lease_details->first_rgr_due_on);
				echo '<br>';
				$lease_details_history = PropertyLeaseDetailHistory::where('property_master_id', $property->id)->first();
				
				if($lease_details_history){
					$lease_details_history->rgr_duration = 99;
					$lease_details_history->new_rgr_duration = 30;
					$lease_details_history->first_rgr_due_on = $lease_details->first_rgr_due_on;
					$lease_details_history->new_first_rgr_due_on = $lease_details->first_rgr_due_on;
					$lease_details_history->save(); 
					print_r($lease_details_history->new_first_rgr_due_on);
				}
				
				//exit;
			}
		   $i++; 
		   echo '<br>'.$i;
		}
	   

	}
/*Writing this function to update the current lessees of leased properties where conversion record got entered as blank and current lessee as blank 
    as blank string --Amita Srivastava & Sourav [09-01-2025]*/
    public function updateCurrentLesseeOfLeasedProperty(){

        $properties = PropertyMaster::where('status', 951)->get();
        foreach ($properties as $property) {
            $propertyId = $property->id;
                $isConversionRecordAvailable = PropertyTransferredLesseeDetail::where('property_master_id',$propertyId)->where('process_of_transfer','Conversion')->where('lessee_name', NULL)->get();
                if(count($isConversionRecordAvailable) > 0){
                    foreach($isConversionRecordAvailable as $conversionRecord){
                        if($conversionRecord->delete()){
                            echo "Conversion deleted for property ID:- ".$propertyId. "<br>";
                        }
                    }
                    self::updateNewCurrentLessee($propertyId);
                }
            
        }

    }

    //for updating the current lessee in seperate table
     public static function updateNewCurrentLessee($id)
     {
         try {
             $propertyId = $id;
             $properties = PropertyMaster::where('id', $propertyId)->get();
 
             if ($properties->isEmpty()) {
                 echo "No properties found for the given ID.";
             }
 
             foreach ($properties as $property) {
 
                 //if property is joint
                 if ($property->is_joint_property == 1) {
 
                     $splitedPropertyDetails = SplitedPropertyDetail::where('property_master_id', $property->id)->get();
                     foreach ($splitedPropertyDetails as $splitedPropertyDetail) {
                         // Property Details
                         $propertyMasterIdChild = $property->id;
                         $splitedPropertyDetailId = $splitedPropertyDetail->id;
                         $oldPropertyIdChild = $splitedPropertyDetail->old_property_id;
                         $propertyStatusChild = $splitedPropertyDetail->property_status;
                         $currentArea = $splitedPropertyDetail->current_area;
                         $areaInSqm = $splitedPropertyDetail->area_in_sqm;
                         $unitChild = $splitedPropertyDetail->unit;
                         $presentlyKnownAsChild = $splitedPropertyDetail->presently_known_as;
                         $createdByChild = $splitedPropertyDetail->created_by;
 
 
                         // Find lessees
                         $latestBatchIdChild = PropertyTransferredLesseeDetail::where('property_master_id', $property->id)->where('splited_property_detail_id', $splitedPropertyDetailId)->max('batch_transfer_id');
                         // if ($latestBatchIdChild === null) {
                         //     return "No lessee details found for property ID: {$property->id} and Splitted property id {$splitedPropertyDetailId}";
                         // }
 
                         if ($latestBatchIdChild) {
 
                             $lesseesWithLatestBatchIdChild = PropertyTransferredLesseeDetail::where('property_master_id', $property->id)
                                 ->where('splited_property_detail_id', $splitedPropertyDetailId)
                                 ->where('batch_transfer_id', $latestBatchIdChild)
                                 ->pluck('lessee_name')
                                 ->toArray();
 
                             $lesseesNamesChild = implode(",", $lesseesWithLatestBatchIdChild);
                             $currentLesseeDetailChild = CurrentLesseeDetail::where('property_master_id', $property->id)->where('splited_property_detail_id', $splitedPropertyDetail->id)->first();
                             // If current lessee details already saved
                             if (!empty($currentLesseeDetailChild)) {
                                 if ($currentLesseeDetailChild['lessees_name'] != $lesseesNamesChild) {
                                     $currentLesseeDetailChild->property_status = $propertyStatusChild;
                                     $currentLesseeDetailChild->lessees_name = $lesseesNamesChild;
                                     $currentLesseeDetailChild->property_known_as = $presentlyKnownAsChild;
                                     $currentLesseeDetailChild->area = $currentArea;
                                     $currentLesseeDetailChild->unit = $unitChild;
                                     $currentLesseeDetailChild->area_in_sqm = $areaInSqm;
                                     $currentLesseeDetailChild->save();
                                 }
                             } else {
                                 CurrentLesseeDetail::create([
                                     'property_master_id' => $propertyMasterIdChild,
                                     'splited_property_detail_id' => $splitedPropertyDetailId,
                                     'old_property_id' => $oldPropertyIdChild,
                                     'property_status' => $propertyStatusChild,
                                     'lessees_name' => $lesseesNamesChild,
                                     'property_known_as' => $presentlyKnownAsChild,
                                     'area' => $currentArea,
                                     'unit' => $unitChild,
                                     'area_in_sqm' => $areaInSqm,
                                     'created_by' => $createdByChild
                                 ]);
                             }
                         }
                     }
                 } else {
 
                     // Property Details
                     $propertyMasterId = $property->id;
                     $oldPropertyId = $property->old_propert_id;
                     $propertyStatus = $property->status;
 
                     // Find lessees
                     $latestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property->id)->max('batch_transfer_id');
                     if ($latestBatchId === null) {
                         echo "No lessee details found for property ID: {$property->id}";
                     }
 
                     $lesseesWithLatestBatchId = PropertyTransferredLesseeDetail::where('property_master_id', $property->id)
                         ->where('batch_transfer_id', $latestBatchId)
                         ->pluck('lessee_name')
                         ->toArray();
 
                     $lesseesNames = implode(",", $lesseesWithLatestBatchId);
 
                     // Details from lease details
                     $leaseDetails = PropertyLeaseDetail::where('property_master_id', $property->id)->first();
                     if ($leaseDetails === null) {
                         echo "No lease details found for property ID: {$property->id}";
                     }
 
                     $presentlyKnown = $leaseDetails['presently_known_as'] ?? '';
                     $plotArea = $leaseDetails['plot_area'] ?? 0;
                     $unit = $leaseDetails['unit'] ?? '';
                     $plotAreaInSqm = round($leaseDetails['plot_area_in_sqm'] ?? 0, 2);
                     $createdBy = $leaseDetails['created_by'] ?? '';
 
                     $currentLesseeDetail = CurrentLesseeDetail::where('property_master_id', $property->id)->first();
 
                     // If current lessee details already saved
                     if (!empty($currentLesseeDetail)) {
                         if ($currentLesseeDetail['lessees_name'] != $lesseesNames) {
                             $currentLesseeDetail->property_status = $propertyStatus;
                             $currentLesseeDetail->lessees_name = $lesseesNames;
                             $currentLesseeDetail->property_known_as = $presentlyKnown;
                             $currentLesseeDetail->area = $plotArea;
                             $currentLesseeDetail->unit = $unit;
                             $currentLesseeDetail->area_in_sqm = $plotAreaInSqm;
                             $currentLesseeDetail->save();
                         }
                     } else {
                         CurrentLesseeDetail::create([
                             'property_master_id' => $propertyMasterId,
                             'splited_property_detail_id' => null,
                             'old_property_id' => $oldPropertyId,
                             'property_status' => $propertyStatus,
                             'lessees_name' => $lesseesNames,
                             'property_known_as' => $presentlyKnown,
                             'area' => $plotArea,
                             'unit' => $unit,
                             'area_in_sqm' => $plotAreaInSqm,
                             'created_by' => $createdBy
                         ]);
                     }
                 }
             }
 
             echo "Current lessee details updated successfully.";
         } catch (\Exception $e) {
             echo "An error occurred: " . $e->getMessage();
         }
     }
     //by Swati Mishra on 04-03-2024 for updating flat rates of existing records
    public function updateExistingFlatsRateAndValue()
    {
        try {
            $flats = Flat::all();
            $updatedCount = 0;
            $updatedIds = [];
            $skippedIds = [];

            foreach ($flats as $flat) {
                // Skipping the record if area is NULL
                if (is_null($flat->area) || trim($flat->area) === '') {
                    $skippedIds[] = $flat->id;
                    continue;
                }
                
                $area_in_sqm = $flat->area_in_sqm;

                // Fetch property type ID from property_masters
                $propertyTypeId = DB::table('property_masters')
                    ->where('id', $flat->property_master_id)
                    ->value('property_type');

                // Fetch property type name from items table
                $propertyTypeName = DB::table('items')
                    ->where('id', $propertyTypeId)
                    ->value('item_name');

                // Initialize rate and value
                $rate = null;
                $value = null;

                // Fetch rate only if property is Residential or Commercial
                if (in_array($propertyTypeName, ['Residential', 'Commercial'])) {
                    $rate = DB::table('flat_rates')
                        ->where('property_type', $propertyTypeId)
                        ->whereNull('date_to')
                        ->value('rate');
                }

                // Calculate value only if area_in_sqm and rate are available
                if (!is_null($area_in_sqm) && !is_null($rate)) {
                    $value = $area_in_sqm * $rate;
                }

                // Check if the new values are different from existing ones before updating
                $flat->update([
                    'rate' => $rate,
                    'value' => $value
                ]);
                
                $updatedCount++;
                $updatedIds[] = $flat->id;
                
            }

             // Log updated and skipped flat IDs
             Log::info("Updated Flats: " . json_encode($updatedIds));
             Log::info("Skipped Flats (Due to NULL/Empty Area): " . json_encode($skippedIds));
    
            return response()->json([
                'status' => 'success',
                'message' => "{$updatedCount} flat records updated successfully.",
                'updated_ids' => $updatedIds 
            ]);

        } catch (\Exception $e) {
            Log::error('Failed to update flats rate and value: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'An error occurred while updating flat records.',
                'error' => $e->getMessage()
            ]);
        }
    }
}
