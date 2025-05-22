<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use App\Services\ColonyService;
use App\Services\MisService;
use App\Models\OldColony;
use App\Models\Item;
use App\Models\User;
use App\Models\Section;
use App\Models\PropertySectionMapping;
use DB;
use Illuminate\Support\Facades\Log;
use Auth;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;

class PropertySectionMappingController extends Controller
{
    // by Swati Mishra on 27-02-2025 to add datatable in index file start
    public function propertyAssignment(Request $request, ColonyService $colonyService)
    {
        if ($request->ajax()) {
            // Fetch raw data from the database
            $query = PropertySectionMapping::query()
                ->join('sections', 'property_section_mappings.section_id', '=', 'sections.id')
                ->join('old_colonies', 'property_section_mappings.colony_id', '=', 'old_colonies.id')
                ->select(
                    'property_section_mappings.colony_id',
                    'property_section_mappings.section_id',
                    'property_section_mappings.property_type',
                    'property_section_mappings.property_subtype',
                    'sections.name as section_name',
                    'sections.section_code',
                    'old_colonies.name as colony_name',
                    'property_section_mappings.created_by'
                );
    
            // Apply search filtering
            if (!empty($request->input('search.value'))) {
                $search = $request->input('search.value');
                $query->where(function ($q) use ($search) {
                    $q->where('sections.name', 'LIKE', "%{$search}%")
                        ->orWhere('sections.section_code', 'LIKE', "%{$search}%")
                        ->orWhere('old_colonies.name', 'LIKE', "%{$search}%")
                        ->orWhere('property_section_mappings.property_type', 'LIKE', "%{$search}%")
                        ->orWhere('property_section_mappings.property_subtype', 'LIKE', "%{$search}%")
                        ->orWhere('property_section_mappings.created_by', 'LIKE', "%{$search}%");
                });
            }
    
            // Fetch all data (for processing)
            $rawData = $query->get();
    
            // Group data manually
            $groupedData = [];
            $rowIndex = 1; // Counter for unique IDs
    
            foreach ($rawData as $row) {
                $key = $row->colony_id . '-' . $row->section_id . '-' . $row->property_type;
    
                if (!isset($groupedData[$key])) {
                    $groupedData[$key] = [
                        'id' => $rowIndex++, // Unique ID for DataTables
                        'colony_name' => $row->colony_name,
                        'section_name' => $row->section_name . ' (' . $row->section_code . ')',
                        'property_type' => (new Item())->itemNameById($row->property_type),
                        'property_subtype' => [],
                        'created_by' => (new User())->userNameById($row->created_by),
                    ];
                }
    
                // Add property subtype to the list
                $groupedData[$key]['property_subtype'][] = (new Item())->itemNameById($row->property_subtype);
            }
    
            // Convert property_subtype array into a comma-separated string
            foreach ($groupedData as &$data) {
                $data['property_subtype'] = implode(', ', $data['property_subtype']);
            }
    
            // Convert associative array into an indexed array
            $finalData = array_values($groupedData);
    
            // Implement proper server-side pagination
            $totalData = count($finalData);
            $totalFiltered = $totalData;
            $currentPage = $request->input('start', 0) / $request->input('length', 10) + 1;
            $perPage = $request->input('length', 10);
            $paginatedData = array_slice($finalData, ($currentPage - 1) * $perPage, $perPage);
    
            // Apply sorting manually
            if (!empty($request->input('order'))) {
                $orderColumnIndex = $request->input('order.0.column');
                $orderDir = $request->input('order.0.dir');
    
                $columns = ['id', 'colony_name', 'section_name', 'property_type', 'property_subtype', 'created_by'];
                $orderByColumn = $columns[$orderColumnIndex] ?? 'colony_name';
    
                usort($paginatedData, function ($a, $b) use ($orderByColumn, $orderDir) {
                    return ($orderDir === 'asc')
                        ? strcmp($a[$orderByColumn], $b[$orderByColumn])
                        : strcmp($b[$orderByColumn], $a[$orderByColumn]);
                });
            }
    
            // Return DataTables JSON response
            return response()->json([
                "draw" => intval($request->input('draw')),
                "recordsTotal" => $totalData,
                "recordsFiltered" => $totalFiltered,
                "data" => $paginatedData
            ]);
        }
    
        // Load the standard view if not an AJAX request
        $colonyList = $colonyService->getColonyList();
        $sections = Section::whereIn('id', [30, 31, 32, 33, 34, 35, 36, 37, 38, 39, 40])->get();
    
        return view('property-assign.index', compact('colonyList', 'sections'));
    }
    
    public function isColonyAssignedToSection(Request $request){
        $isColonyAssigned = PropertySectionMapping::where('colony_id',$request->colony)->first();
        $colonyName = OldColony::where('id', $request->colony)->pluck('name')->first();
        if($isColonyAssigned){
            $response = ['status' => false, 'message' => 'Assignment already done for '.$colonyName. ' colony'];
        } else {
            $response = ['status' => true, 'message' => 'Colony available'];
        }
        return json_encode($response);

    }

    public function getAllPropertyTypes(Request $request,MisService $misService){
        //property type and subtypes for colony
        $colonyID = $request->colony;
        $typesSubtypesAlreadyDone = PropertySectionMapping::where('colony_id',$colonyID)->get();
        $groupedData = [];

        foreach ($typesSubtypesAlreadyDone as $entry) {
            $type = $entry->property_type;
            $subtype = $entry->property_subtype;

            // Initialize the type if it doesn't exist
            if (!isset($groupedData[$type])) {
                $groupedData[$type] = [
                    'type' => $type,
                    'subtypes' => []
                ];
            }

            // Add the subtype under the correct type
            $groupedData[$type]['subtypes'][] = $subtype;
        }

        // Transform the data to a more readable format
        $formattedData = [];

        foreach ($groupedData as $type => $data) {
            $formattedData[] = [
                'typeId' => $type,
                'subtypes' => $data['subtypes']
            ];
        }


        $propertyTypes = $misService->getItemsByGroupId(1052);
        $typeData = $propertyTypes[0]['items'];
        $data = [];

        foreach($typeData as $propertyType) {
            $propertyTypeSubTypeMapping = DB::table('property_type_sub_type_mapping')
                                            ->where('type', $propertyType->id)
                                            ->get();
                                            
            // foreach ($propertyTypeSubTypeMapping as $mapping) {
            //     $item = new Item;
            //     $subTypeId = $mapping->sub_type;
            //     $name = $item->itemNameById($subTypeId);

            foreach ($propertyTypeSubTypeMapping as $mapping) {
                // Check if the subtype is active in the property_type_sub_type_mapping table
                $isActive = $mapping->is_active; // Access the is_active column directly
                if ($isActive != 1) {
                    continue; // Skip this subtype if it is not active
                }

                $item = new Item;
                $subTypeId = $mapping->sub_type;
                $name = $item->itemNameById($subTypeId);
        
                
                
                if (!isset($data[$propertyType->id])) {
                    $data[$propertyType->id] = [
                        'typeId' => $propertyType->id,
                        'type' => $propertyType->item_name,
                        'subTypes' => []
                    ];
                }

                $data[$propertyType->id]['subTypes'][] = [
                    'subId' => $subTypeId,
                    'subType' => $name
                ];
            }
        }
        
        $data = array_values($data);
        $formattedData = array_values($formattedData);
        $finalData['data'] = $data;
        $finalData['formattedData'] = $formattedData;
        return response()->json($finalData);
    }

    public function propertyAssignmentStore(Request $request){
        try {
            $count = 0;
            $colonyName = OldColony::where('id', $request->colony)->pluck('name')->first();
            $colonyId = $request->colony;
            $section_id = $request->section;
            $section = Section::where('id',$section_id)->value('name');
            $messages = [];
            $item = new Item;

            if(isset($request->propTypes)){
                foreach ($request->propTypes as $key => $propType) {
                    if (isset($request->subTypes[$key])) {
                        foreach ($request->subTypes[$key] as $subType) {
    
                            $isColonySectionAlreadymapped = PropertySectionMapping::where('colony_id',$colonyId)->where('section_id',$section)->where('property_type',$key)->where('property_subtype',$subType)->exists();
    
                            $isColonyTypeSubtypeAlreadymapped = PropertySectionMapping::where('colony_id',$colonyId)->where('property_type',$key)->where('property_subtype',$subType)->exists();
    
    
                            // Prepare messages for user feedback
                            if ($isColonySectionAlreadymapped) {
                                $messages[] = "Type ".$item->itemNameById($key)." and subtype ".$item->itemNameById($subType)." is already linked with the section '$section' for colony '$colonyName'.";
                            } elseif ($isColonyTypeSubtypeAlreadymapped) {
                                $messages[] = "Type ".$item->itemNameById($key)." and subtype ".$item->itemNameById($subType)." is already linked with the colony '$colonyName', in a different section.";
                            }
    
                            if(!$isColonySectionAlreadymapped && !$isColonyTypeSubtypeAlreadymapped){
                                PropertySectionMapping::create([
                                    'colony_id' => $colonyId,
                                    'section_id' => $section_id,
                                    'property_type' => $key,
                                    'property_subtype' => $subType,
                                    'created_by' => Auth::id()
                                ]);
                                $count += 1;
                            }
                        }
                    }
                }
                if ($count == 0) {
                    if (empty($messages)) {
                        $messages[] = $colonyName . ' colony already linked with same or other section.';
                    }
                    return redirect()->back()->with('failure', implode('# ', $messages));
                } else {
                    $messages[] = $colonyName . ' colony linked with ' . $section . ' section successfully.';
                    return redirect()->back()->with('success', implode(' #', $messages));
                }
            } else {
                return redirect()->back()->with('failure', 'No values selected');
            }
        } catch (\Exception $e) {
            Log::error($e);
            return redirect()->back()->with('failure',$e->getMessage());
        }
    }
}
