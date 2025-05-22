<?php

namespace App\Http\Controllers;

use App\Helpers\UserActionLogHelper;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use App\Imports\GenericImport;
use Maatwebsite\Excel\HeadingRowImport;

class ImportController extends Controller
{
    // public function importLndoLandRate(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx',
    //     ]);

    //     Excel::import(new LndoResidentialLandRatesImport, $request->file('file'));

    //     // Manage user import LndoLandRates action activity lalit on 22/07/24
    //     UserActionLogHelper::UserActionLog('import', url("/import-lndo-land-rates"), 'importLAndDoRates', "New L&Do rates imported successfully by " . Auth::user()->name);


    //     return redirect()->back()->with('success', 'L&DO Land rates imported successfully.');
    // }

    // public function importCircleRate(Request $request)
    // {
    //     $request->validate([
    //         'file' => 'required|mimes:xlsx',
    //     ]);

    //     Excel::import(new CircleRatesImport, $request->file('file'));
        
    //     // Manage user import CircleRates action activity lalit on 22/07/24
    //     UserActionLogHelper::UserActionLog('import', url("/import-circle-rates"), 'importCircleRates', "New circle rates imported successfully by " . Auth::user()->name.".");

    //     return redirect()->back()->with('success', 'Circle rates imported successfully.');
    // }

    public function showImportForm()
    {
        $tables = DB::select('SHOW TABLES');
        $tableNames = array_map('current', $tables);

        return view('import-excel.import', ['tables' => $tableNames]);
    }

    public function importTable(Request $request)
    {
        $request->validate([
            'table' => 'required|string',
            'file' => 'required|file|mimes:xlsx,csv',
        ]);

        $table = $request->input('table');
        $file = $request->file('file');

        Log::info("Import process started for table: {$table}");

        try {
            // Get all columns in the table except id, created_at, updated_at
            $columns = array_diff(
                DB::getSchemaBuilder()->getColumnListing($table),
                ['id', 'created_at', 'updated_at']
            );

            Log::info("Filtered columns for duplication check: " . implode(', ', $columns));

            $import = new GenericImport($table); // Pass the table name
            Excel::import($import, $file);

            $data = $import->data;
            Log::info("Data successfully read from Excel file.", ['data_count' => count($data)]);

            foreach ($data as $index => $row) {
                // Filter the row to only include columns relevant for comparison
                $filteredRow = array_intersect_key($row, array_flip($columns));

                try {
                    // Check for duplicates
                    $exists = DB::table($table)
                        ->where($filteredRow)
                        ->exists();

                    if ($exists) {
                        Log::info("Skipping duplicate row at index {$index}.", ['row_data' => $row]);
                        continue;
                    }

                    // Insert the row if no duplicate is found
                    DB::table($table)->insert($row);
                } catch (\Exception $e) {
                    Log::error("Failed to insert row at index {$index}.", [
                        'row_data' => $row,
                        'error_message' => $e->getMessage()
                    ]);
                }
            }

            Log::info("Import process completed successfully for table: {$table}");
            return back()->with('success', 'Data imported successfully!');

        } catch (\Exception $e) {
            Log::error("Import process failed for table: {$table}.", [
                'error_message' => $e->getMessage(),
                'file_path' => $file->getRealPath()
            ]);
            return back()->withErrors('An error occurred during import. Please check the logs for details.');
        }
    }



}
