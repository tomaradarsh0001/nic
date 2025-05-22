<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class PropertyCountController extends Controller
{
    // Function for property count API
    public function propertyCountSummary()
    {
        // Step 1: Get the current SQL mode
        $originalSqlMode = DB::select("SELECT @@SESSION.sql_mode AS mode")[0]->mode;

        // Step 2: Temporarily disable strict mode
        DB::statement("SET SESSION sql_mode = ''");

        try {
            // Updated Query: Property Count and Values
            // $propertySummaryQuery = "SELECT
            //     SUM(counter) AS total_count,
            //     SUM(t1.plot_area) AS total_area,
            //     SUM(ldo_value) AS total_ldo_value,
            //     SUM(cr_value) AS total_cr_value
            // FROM
            //     (
            //     SELECT
            //         pm.id,
            //         CASE WHEN pm.is_joint_property IS NULL THEN 1 ELSE COUNT(spd.id) END AS counter,
            //         CASE 
            //             WHEN pm.is_joint_property IS NULL 
            //             THEN COALESCE(MIN(pld.plot_area_in_sqm), MIN(upd.plot_area_in_sqm)) 
            //             ELSE SUM(spd.area_in_sqm) 
            //         END AS plot_area,
            //         CASE 
            //             WHEN pm.is_joint_property IS NULL 
            //             THEN COALESCE(MIN(pld.plot_value), MIN(upd.plot_value)) 
            //             ELSE SUM(spd.plot_value) 
            //         END AS ldo_value,
            //         CASE 
            //             WHEN pm.is_joint_property IS NULL 
            //             THEN COALESCE(MIN(pld.plot_value_cr), MIN(upd.plot_value_cr)) 
            //             ELSE SUM(spd.plot_value_cr) 
            //         END AS cr_value
            //     FROM property_masters pm
            //     LEFT JOIN property_lease_details pld ON pm.id = pld.property_master_id
            //     LEFT JOIN unallotted_property_details upd ON pm.id = upd.property_master_id
            //     LEFT JOIN splited_property_details spd ON pm.id = spd.property_master_id
            //     GROUP BY pm.id, pm.is_joint_property
            //     ORDER BY counter DESC
            // ) t1";

            $propertySummaryQuery = "select sum(counter) as total_count, sum(t1.plot_area) as total_area, sum(ldo_value) as total_ldo_value, sum(cr_value) as total_cr_value
from
(select pm.id, case when pm.is_joint_property is null then 1 else count(spd.id) end as counter,
case when pm.is_joint_property is null then coalesce(pld.plot_area_in_sqm, upd.plot_area_in_sqm) else sum(spd.area_in_sqm) end as plot_area,
case when pm.is_joint_property is null then coalesce(pld.plot_value, upd.plot_value) else sum(spd.plot_value) end as ldo_value,
case when pm.is_joint_property is null then coalesce(pld.plot_value_cr, upd.plot_value_cr) else sum(spd.plot_value_cr) end as cr_value  from
property_masters pm 
left join property_lease_details pld on pm.id = pld.property_master_id
left join unallotted_property_details upd on pm.id = upd.property_master_id
left join splited_property_details spd on pm.id = spd.property_master_id
group by pm.id
order by counter desc)t1";

            // Query 2: Application Counts
            $applicationSummaryQuery = "SELECT
                COUNT(*) AS total_applications,
                SUM(CASE WHEN i.item_code = 'APP_APR' THEN 1 ELSE 0 END) AS app_approved_count,
                SUM(CASE WHEN i.item_code = 'APP_REJ' THEN 1 ELSE 0 END) AS app_rejected_count
            FROM applications AS ap
            JOIN items AS i ON ap.status = i.id";

            // Execute Queries
            $propertySummaryResult = DB::select($propertySummaryQuery);
            $applicationSummaryResult = DB::select($applicationSummaryQuery);

            // Step 4: Restore the original SQL mode
            DB::statement("SET SESSION sql_mode = ?", [$originalSqlMode]);

            // Extract data safely
            $propertySummary = $propertySummaryResult[0] ?? null;
            $applicationSummary = $applicationSummaryResult[0] ?? null;

            if ($propertySummary) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Property and application summary fetched successfully',
                    'total_property_count' => $propertySummary->total_count ?? 0,
                    'total_plot_area' => $propertySummary->total_area ?? 0,
                    'total_ldo_value' => $propertySummary->total_ldo_value ?? 0,
                    'total_cr_value' => $propertySummary->total_cr_value ?? 0,
                    'application_summary' => [
                        'total_applications' => $applicationSummary->total_applications ?? 0,
                        'app_approved_count' => $applicationSummary->app_approved_count ?? 0,
                        'app_rejected_count' => $applicationSummary->app_rejected_count ?? 0,
                    ]
                ], 200);
            }

            return response()->json([
                'status' => 'failed',
                'message' => 'No data found',
                'total_property_count' => 0,
                'total_plot_area' => 0,
                'total_ldo_value' => 0,
                'total_cr_value' => 0,
                'application_summary' => [
                    'total_applications' => 0,
                    'app_approved_count' => 0,
                    'app_rejected_count' => 0,
                ]
            ], 404);
        } catch (\Exception $e) {
            // Step 4: Restore SQL mode even if an error occurs
            DB::statement("SET SESSION sql_mode = ?", [$originalSqlMode]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}