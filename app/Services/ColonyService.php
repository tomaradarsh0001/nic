<?php

namespace App\Services;

use Illuminate\Http\Request;
use App\Models\OldColony;
use App\Models\PropertyMaster;
use App\Models\PropertyMasterHistory;
use App\Models\SplitedPropertyDetail;
use App\Models\PropertySectionMapping;
use Illuminate\Support\Facades\DB;
use Auth;

class ColonyService
{
    /*public function getColonyList()// used in MIS form entry
    {
        return OldColony::where('zone_code', '!=', '_')->orderBy('name','asc')->get();
    }*/

    public function getColonyList()
    {
        return OldColony::selectRaw("
                *,
                CASE 
                    WHEN new_name IS NOT NULL AND new_name != '' 
                    THEN CONCAT(name, ' (', new_name, ')') 
                    ELSE name 
                END AS name
            ")
            ->where('zone_code', '!=', '_')
            ->where('colony_stats', '=', 'Y') // Added condition
            ->orderBy('name', 'asc')
            ->get();
    }



    public function getAllColonies()
    {
        return OldColony::whereNotNull('zone_code')->where(DB::raw('TRIM(zone_code)'), '<>', "_")->orderBy('zone_code')->orderBy('name')->get();
    }
    /* public function blocksInColony($colonyId, $leaseHoldOnly)
    {
        //get not splited properties
        return PropertyMaster::where('old_colony_name', $colonyId)
            ->when($leaseHoldOnly != false, function ($query) {
                return $query->where('status', 951);
            })
            ->select('block_no')->distinct()->orderBy('block_no')->get();
    }
    public function propertiesInBlock($colonyId, $blockId, $leaseHoldOnly)
    {
        //get not splited properties
        $singlePropeties = PropertyMaster::whereNull('is_joint_property')->where('old_colony_name', $colonyId)->when($blockId != "null", function ($query) use ($blockId) {
            return $query->where('block_no', $blockId);
        }, function ($query) {
            return $query->whereNull('block_no');
        })->when($leaseHoldOnly != false, function ($query) {
            return $query->where('status', 951);
        })->orderByRaw('CASE
                WHEN plot_or_property_no REGEXP "^[0-9]+$" THEN 1
                ELSE 2
            END, 
            CASE
                WHEN plot_or_property_no REGEXP "^[0-9]+$" THEN LENGTH(plot_or_property_no)
                ELSE 0
            END,
            CASE
                WHEN plot_or_property_no REGEXP "^[0-9]+$" THEN CAST(plot_or_property_no AS UNSIGNED)
                ELSE plot_or_property_no
            END')->get(); //if plot no is mumeric then order by numeric value

        //get splited properties
        $splitedPropertiesMasterIds = PropertyMaster::whereNotNull('is_joint_property')->where('old_colony_name', $colonyId)->where('block_no', $blockId)->select('id')->get();
        $splitedProperties = SplitedPropertyDetail::whereIn('property_master_id', $splitedPropertiesMasterIds)->when($leaseHoldOnly != false, function ($query) {
            return $query->where('property_status', 951);
        })->orderByRaw('CASE
                    WHEN plot_flat_no REGEXP "^[0-9]+$" THEN 1
                    ELSE 2
                END, 
                CASE
                    WHEN plot_flat_no REGEXP "^[0-9]+$" THEN LENGTH(plot_flat_no)
                    ELSE 0
                END,
                CASE
                    WHEN plot_flat_no REGEXP "^[0-9]+$" THEN CAST(plot_flat_no AS UNSIGNED)
                    ELSE plot_flat_no
                END')->get();

        //merge both
        $propertiesInColony = $singlePropeties->merge($splitedProperties);
        return $propertiesInColony;
    } */

    public function blocksInColony($colonyId, $leaseHoldOnly)
    {
        // Get the sections assigned to the authenticated user
        $user = Auth::user();
        $sectionIds = ($user->roles[0]->name == 'section-officer') ? $user->sections->pluck('id')->toArray() : [];
        // Get blocks assigned to the user's sections
        return PropertyMaster::where('old_colony_name', $colonyId)
            ->when(!empty($sectionIds), function ($query) use ($sectionIds) {
                return $query->whereExists(function ($subQuery) use ($sectionIds) {
                    $subQuery->select(DB::raw(1))
                        ->from('property_section_mappings')
                        ->whereRaw('property_section_mappings.property_type = property_masters.property_type')
                        ->whereRaw('property_section_mappings.property_subtype = property_masters.property_sub_type')
                        ->whereIn('property_section_mappings.section_id', $sectionIds)
                        ->where('property_section_mappings.is_active', 1);
                });
            })
            ->when($leaseHoldOnly, function ($query) {
                return $query->where('status', 951);
            })
            ->select('block_no')
            ->distinct()
            ->orderBy('block_no')
            ->get();
    }

    public function propertiesInBlock($colonyId, $blockId, $leaseHoldOnly)
    {
        $user = Auth::user();
        $sectionIds = ($user->roles[0]->name == 'section-officer') ? $user->sections->pluck('id')->toArray() : [];

        // Get not split properties assigned to user sections
        $singleProperties = PropertyMaster::whereNull('is_joint_property')
            ->join('property_lease_details as pld', 'property_masters.id', '=', 'pld.property_master_id')
            ->where('old_colony_name', $colonyId)
            ->when(!empty($sectionIds), function ($query) use ($sectionIds) {
                return $query->whereExists(function ($subQuery) use ($sectionIds) {
                    $subQuery->select(DB::raw(1))
                        ->from('property_section_mappings')
                        ->whereRaw('property_section_mappings.property_type = property_masters.property_type')
                        ->whereRaw('property_section_mappings.property_subtype = property_masters.property_sub_type')
                        ->whereIn('property_section_mappings.section_id', $sectionIds)
                        ->where('property_section_mappings.is_active', 1);
                });
            })
            ->when($blockId !== "null", function ($query) use ($blockId) {
                return $query->where('block_no', $blockId);
            }, function ($query) {
                return $query->whereNull('block_no');
            })
            ->when($leaseHoldOnly, function ($query) {
                return $query->where('property_masters.status', 951);
            })
            ->select('property_masters.id', 'is_joint_property', 'property_masters.old_propert_id', 'property_masters.plot_or_property_no', 'pld.presently_known_as')
            ->orderByRaw('CASE
            WHEN plot_or_property_no REGEXP "^[0-9]+$" THEN 1 ELSE 2
        END, 
        CASE
            WHEN plot_or_property_no REGEXP "^[0-9]+$" THEN LENGTH(plot_or_property_no) ELSE 0
        END,
        CASE
            WHEN plot_or_property_no REGEXP "^[0-9]+$" THEN CAST(plot_or_property_no AS UNSIGNED) ELSE plot_or_property_no
        END')
            ->get();

        // Get split properties assigned to user sections
        $splitedPropertiesMasterIds = PropertyMaster::whereNotNull('is_joint_property')
            ->where('old_colony_name', $colonyId)
            ->when($blockId !== "null", function ($query) use ($blockId) {
                return $query->where('block_no', $blockId);
            }, function ($query) {
                return $query->whereNull('block_no');
            })
            ->when(!empty($sectionIds), function ($query) use ($sectionIds) {
                return $query->whereIn(DB::raw('(property_type, property_sub_type)'), function ($query) use ($sectionIds) {
                    $query->selectRaw('property_type, property_subtype')
                        ->from('property_section_mappings')
                        ->whereIn('section_id', $sectionIds)
                        ->where('is_active', 1);
                });
            })
            ->pluck('id');

        $splitedProperties = SplitedPropertyDetail::whereIn('property_master_id', $splitedPropertiesMasterIds)
            ->when($leaseHoldOnly, function ($query) {
                return $query->where('property_status', 951);
            })
            ->orderByRaw('CASE
            WHEN plot_flat_no REGEXP "^[0-9]+$" THEN 1 ELSE 2
        END, 
        CASE
            WHEN plot_flat_no REGEXP "^[0-9]+$" THEN LENGTH(plot_flat_no) ELSE 0
        END,
        CASE
            WHEN plot_flat_no REGEXP "^[0-9]+$" THEN CAST(plot_flat_no AS UNSIGNED) ELSE plot_flat_no
        END')
            ->get();

        // Merge both single and split properties
        return $singleProperties->merge($splitedProperties);
    }



    // public function misDoneForColonies()
    // {
    //     $colonyIds = PropertyMaster::select('old_colony_name')->distinct()->pluck('old_colony_name');
    //     if ($colonyIds->count() > 0) {
    //         $foundColonies = OldColony::whereIn('id', $colonyIds)->orderBy('name')->get();
    //     }
    //     return $foundColonies;
    // }

    public function misDoneForColonies($forSection = false)
    {
        // Fetch unique old_colony_name values from PropertyMaster
        $colonyIds = PropertyMaster::select('old_colony_name')->distinct()->pluck('old_colony_name')->toArray();

        if ($forSection) {
            $sections = Auth::user()->sections;
            if ($sections->count() > 0) {
                $sectionIds = $sections->pluck('id')->toArray();
                $colonyList = PropertySectionMapping::whereIn('section_id', $sectionIds)->distinct()->pluck('colony_id')->toArray();
                $colonyIds = array_intersect($colonyIds, $colonyList);
            }
        }

        // Initialize $foundColonies as an empty collection to handle cases where $colonyIds is empty
        $foundColonies = collect();

        if (count($colonyIds) > 0) {
            // Fetch the colonies using a raw SQL query for the display_name field
            $foundColonies = OldColony::selectRaw("
                CASE 
                    WHEN new_name IS NOT NULL AND new_name != '' 
                    THEN CONCAT(name, ' (', new_name, ')') 
                    ELSE name 
                END AS name, id
            ")
                ->whereIn('id', $colonyIds)
                ->where('colony_stats', '=', 'Y')
                ->orderBy('name', 'asc')
                ->get();
        }

        return $foundColonies;
    }




    //Colony List of all the sections assigned to the login user - SOURAV CHAUHAN - (26/Dec/2024)
    public function sectionWiseColonies()
    {
        $user = Auth::user();
        if ($user->roles[0]->id == 7 || $user->roles[0]->id == 8 || $user->roles[0]->id == 10) {
            $loginUserSections = $user->sections;
            $allSections = [];
            foreach ($loginUserSections as $loginUserSection) {
                $sectionCode = $loginUserSection->section_code;
                $allSections[] = $sectionCode;
            }
            // Fetch unique old_colony_name values from PropertyMaster
            $colonyIds = PropertyMaster::whereIn('section_code', $allSections)->select('new_colony_name')->distinct()->pluck('new_colony_name');
        } else {
            // Fetch unique old_colony_name values from PropertyMaster
            $colonyIds = PropertyMaster::select('new_colony_name')->distinct()->pluck('new_colony_name');
        }

        // Initialize $foundColonies as an empty collection to handle cases where $colonyIds is empty
        $foundColonies = collect();

        if ($colonyIds->count() > 0) {
            // Fetch the colonies using a raw SQL query for the display_name field
            $foundColonies = OldColony::selectRaw("
                CASE 
                    WHEN new_name IS NOT NULL AND new_name != '' 
                    THEN CONCAT(name, ' (', new_name, ')') 
                    ELSE name 
                END AS name, id
            ")
                ->whereIn('id', $colonyIds)
                ->where('colony_stats', '=', 'Y')
                ->orderBy('name', 'asc')
                ->get();
        }
        // dd($foundColonies);

        return $foundColonies;
    }



    public function leaseHoldProperties($colonyId = null)
    {
        return DB::table('property_masters as pm')
            ->join('property_lease_details as pld', 'pm.id', '=', 'pld.property_master_id')
            ->leftJoin('splited_property_details as spd', 'pm.id', '=', 'spd.property_master_id')
            ->whereIn('pm.property_type', [47, 48]) //only residential and commercial are required -  added on 08072024
            ->where(function ($query) use ($colonyId) {
                if (is_null($colonyId)) {
                    return $query->where([
                        ['pm.is_joint_property', '=', null],
                        ['pm.status', '=', 951]
                    ])
                        ->orwhere([
                            ['pm.is_joint_property', '<>', null],
                            ['spd.property_status', '=', 951]
                        ]);
                } else {
                    return $query->where([
                        ['pm.is_joint_property', '=', null],
                        ['pm.old_colony_name', '=', $colonyId],
                        ['pm.status', '=', 951]
                    ])
                        ->orwhere([
                            ['pm.is_joint_property', '<>', null],
                            ['pm.old_colony_name', '=', $colonyId],
                            ['spd.property_status', '=', 951]
                        ]);
                }
            })
            ->select('pm.id', 'pm.is_joint_property', 'spd.id as splited_id', 'pm.old_propert_id as property_id', 'pm.property_type')
            ->addSelect(DB::raw('case when pm.is_joint_property is null then pld.plot_area_in_sqm else spd.area_in_sqm end as plot_area, case when pm.is_joint_property is null then pld.presently_known_as else spd.presently_known_as end as presently_known_as'))
            ->get();
    }

    public function allPropertiesInColony($colonyId)
    {
        return DB::table('property_masters as pm')
            ->leftJoin('property_lease_details as pld', 'pm.id', '=', 'pld.property_master_id')
            ->leftJoin('unallotted_property_details as upd', 'pm.id', '=', 'upd.property_master_id')
            ->leftJoin('items as ipt', 'pm.property_type', '=', 'ipt.id')
            ->leftJoin('items as ips', 'pm.property_sub_type', '=', 'ips.id')
            ->leftJoin('splited_property_details as spd', 'pm.id', '=', 'spd.property_master_id')
            ->where('pm.new_colony_name', '=', $colonyId)
            ->select('pm.id', 'spd.id as splited_id', 'pm.property_type', 'ipt.item_name as property_type_name', 'ips.item_name as property_subtype_name')
            ->addSelect(DB::raw('case when pm.is_joint_property is null then pm.status else spd.property_status end as property_status, case when pm.is_joint_property is null then coalesce(pld.plot_area_in_sqm, upd.plot_area_in_sqm) else spd.area_in_sqm end as plot_area, case when pm.is_joint_property is null then coalesce(pld.plot_value, upd.plot_value)  else spd.plot_value end as plot_value_ldo, case when pm.is_joint_property is null then coalesce(pld.plot_value_cr, upd.plot_value_cr) else spd.plot_value_cr end as plot_value_cr'))
            ->get();
    }



    public function mergeColonies($colonyToBeMerged, $colonyMergedWith)
    {
        // Fetch the 'code' of both selected colonies from the 'old_colonies' table
        $colony1 = OldColony::select('code')->where('id', $colonyToBeMerged)->first();
        $colony2 = OldColony::select('code')->where('id', $colonyMergedWith)->first();

        // Fetch combinations of section_name, property_type, and property_subtype
        $sectionMappingsColonyMergedWith = PropertySectionMapping::where('colony_id', $colonyMergedWith)
            ->join('sections', 'property_section_mappings.section_id', '=', 'sections.id')
            ->select('sections.section_code as section', 'property_section_mappings.property_type', 'property_section_mappings.property_subtype')
            ->get();

        // dd($sectionMappingsColonyMergedWith);

        \Log::info("Section Mappings for ColonyMergedWith ID $colonyMergedWith:");
        \Log::info($sectionMappingsColonyMergedWith->toArray());

        // Start a database transaction
        DB::beginTransaction();

        try {
            // Create a table header for logging
            $logHeader = str_pad("Table", 15) .
                str_pad("ID", 10) .
                str_pad("Old New Colony Name", 25) .
                str_pad("New New Colony Name", 25) .
                str_pad("Old Unique File No", 25) .
                str_pad("New Unique File No", 25) .
                str_pad("Old Section Code", 25) .
                str_pad("New Section Code", 25);
            \Log::info($logHeader);
            \Log::info(str_repeat("-", 200));

            // Check if ColonyMergedWith has mappings
            if ($sectionMappingsColonyMergedWith->count() < 1) {
                $errorMessage = "ColonyMergedWith ID $colonyMergedWith has no mappings in PropertySectionMapping.";
                \Log::error($errorMessage);
                return ['success' => false, 'error' => $errorMessage];
            }

            // Process PropertyMaster records
            $propertyMasters = PropertyMaster::where('new_colony_name', $colonyToBeMerged)->get();
            foreach ($propertyMasters as $property) {
                // dd($property);
                $oldNewColonyName = $property->new_colony_name;
                $oldUniqueFileNo = $property->unique_file_no;
                $oldSectionCode = $property->section_code;

                // Update new_colony_name
                $property->new_colony_name = $colonyMergedWith;

                // Replace colony code in unique_file_no
                $property->unique_file_no = str_replace($colony1->code, $colony2->code, $property->unique_file_no);
                $updatedUniqueFileNo = $property->unique_file_no;

                // Match property_type and property_subtype
                $matchedSection = null;
                foreach ($sectionMappingsColonyMergedWith as $section) {
                    if ($section->property_type == $property->property_type && $section->property_subtype == $property->property_sub_type) {
                        $matchedSection = $section;
                        break;
                    }
                }
                // dd($matchedSection);
                $property->section_code = $matchedSection->section ?? null;

                // Save changes
                $property->save();

                $logRow = str_pad("PropertyMaster", 15) .
                    str_pad($property->id, 10) .
                    str_pad($oldNewColonyName, 25) .
                    str_pad($property->new_colony_name, 25) .
                    str_pad($oldUniqueFileNo, 25) .
                    str_pad($updatedUniqueFileNo, 25) .
                    str_pad($oldSectionCode ?? '', 25) .
                    str_pad($property->section_code ?? '', 25);

                \Log::info($logRow);

                // Process PropertyMasterHistory records
                $propertyMasterHistories = PropertyMasterHistory::where('property_master_id', $property->id)->get();
                foreach ($propertyMasterHistories as $history) {
                    $oldNewColonyName = $history->new_new_colony_name;
                    $oldUniqueFileNo = $history->new_unique_file_no;
                    $oldSectionCode = $history->new_section_code;

                    $history->new_colony_name = $oldNewColonyName;
                    $history->new_new_colony_name = $colonyMergedWith;
                    $history->unique_file_no = $oldUniqueFileNo;
                    $history->new_unique_file_no = str_replace($colony1->code, $colony2->code, $history->unique_file_no);
                    $history->section_code = $oldSectionCode;
                    // Match property_type and property_subtype for history
                    $matchedSection = null;
                    foreach ($sectionMappingsColonyMergedWith as $section) {
                        if ($section->property_type == $history->property_type && $section->property_subtype == $history->property_sub_type) {
                            $matchedSection = $section;
                            break;
                        }
                    }
                    $history->new_section_code = $matchedSection->section ?? null;

                    // Save changes
                    $history->save();

                    // dd([
                    //     'history_id' => $history->id,
                    //     'old_new_colony_name' => $oldNewColonyName,
                    //     'new_new_colony_name' => $history->new_new_colony_name,
                    //     'old_unique_file_no' => $oldUniqueFileNo,
                    //     'new_unique_file_no' => $history->unique_file_no,
                    //     'old_section_code' => $oldSectionCode,
                    //     'new_section_code' => $history->new_section_code,
                    // ]);


                    $logRow = str_pad("PropertyHistory", 15) .
                        str_pad($history->id, 10) .
                        str_pad($oldNewColonyName ?? 'N/A', 25) .
                        str_pad($history->new_new_colony_name ?? 'N/A', 25) .
                        str_pad($oldUniqueFileNo ?? 'N/A', 25) .
                        str_pad($history->new_unique_file_no ?? 'N/A', 25) .
                        str_pad($oldSectionCode ?? 'N/A', 25) .
                        str_pad($history->new_section_code ?? 'N/A', 25);

                    \Log::info($logRow);
                }
            }

            // Update the old_colonies table
            OldColony::where('id', $colonyToBeMerged)->update([
                'colony_stats' => 'N',
                'merge_with_colony' => $colonyMergedWith,
                'updated_at' => now()
            ]);

            DB::commit();
            \Log::info("Changes successfully applied and verified.");
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Colony merge failed: " . $e->getMessage());
            return false;
        }
    }
}