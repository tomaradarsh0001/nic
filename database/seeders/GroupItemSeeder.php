<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Item;

class GroupItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define the groups to be created
        $groups = [
            [
                'group_id' => 17012,
                'group_name' => 'Club Membership Status',
                'is_active' => 1,
            ],
            [
                'group_id' => 17013,
                'group_name' => 'IHC Categories',
                'is_active' => 1,
            ],
            [
                'group_id' => 17014,
                'group_name' => 'DGC Categories',
                'is_active' => 1,
            ],
            [
                'group_id' => 17015,
                'group_name' => 'Club Membership Designation',
                'is_active' => 1,
            ],
        ];

        // Insert or update groups in the database
        foreach ($groups as $group) {
            DB::table('groups')->updateOrInsert(
                ['group_id' => $group['group_id']],
                [
                    'group_name' => $group['group_name'],
                    'is_active' => $group['is_active'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]
            );
        }

        $items = [
            /* [
                'group_id' => 1031,
                'item_code' => 'APP_NEW',
                'item_name' => 'New',
            ],
            [
                'group_id' => 1031,
                'item_code' => 'APP_PEN',
                'item_name' => 'Pending',
            ],
            [
                'group_id' => 1031,
                'item_code' => 'APP_IP',
                'item_name' => 'In Progress',
            ],
            [
                'group_id' => 1031,
                'item_code' => 'APP_OBJ',
                'item_name' => 'Objected',
            ],
            [
                'group_id' => 1031,
                'item_code' => 'APP_APR',
                'item_name' => 'Approved',
            ],
            [
                'group_id' => 1031,
                'item_code' => 'APP_REJ',
                'item_name' => 'Rejected',
            ],
            [
                'group_id' => 1031,
                'item_code' => 'APP_CAN',
                'item_name' => 'Cancelled',
            ],
            [
                'group_id' => 1031,
                'item_code' => 'APP_WD',
                'item_name' => 'Withdrawn',
            ], */

            //for forgot password otps
            // [
            //     'group_id' => 17002,
            //     'item_code' => 'PASS_FORGET',
            //     'item_name' => 'Forgot Password',
            // ],
            //
            /* [
                'group_id' => 17007,
                'item_code' => 'RECOMMENDED',
                'item_name' => 'Recommended',
            ],
            [
                'group_id' => 17007,
                'item_code' => 'OBJECT',
                'item_name' => 'Object',
            ],
            [
                'group_id' => 17007,
                'item_code' => 'APPROVE',
                'item_name' => 'Approve',
            ],
            [
                'group_id' => 17007,
                'item_code' => 'REC_FOR_APR',
                'item_name' => 'Recommended For Approval',
            ],
            [
                'group_id' => 17007,
                'item_code' => 'REJECT_APP',
                'item_name' => 'Reject',
            ],
            [
                'group_id' => 17007,
                'item_code' => 'FOR_TO_DEP',
                'item_name' => 'Forward To Department',
            ],*/
            //Demand status 
            [
                'group_id' => 17008,
                'item_code' => 'DEM_DRAFT',
                'item_name' => 'Draft',
            ],
            [
                'group_id' => 17008,
                'item_code' => 'DEM_PENDING',
                'item_name' => 'Pending',
            ],
            [
                'group_id' => 17008,
                'item_code' => 'DEM_PAID',
                'item_name' => 'Paid',
            ],
            [
                'group_id' => 17008,
                'item_code' => 'DEM_PART_PAID',
                'item_name' => 'Partially paid',
            ],
            [
                'group_id' => 17008,
                'item_code' => 'DEM_CR_FRW',
                'item_name' => 'Carried Forward',
            ],
            /** demand status */
            /* [
                'group_id' => 7003,
                'item_code' => 'DEM_UEI',
                'item_name' => 'Unearned Increase',
                'item_order' => '1'
            ],
            [
                'group_id' => 7003,
                'item_code' => 'DEM_CONV_CHG',
                'item_name' => 'Conversion Charges',
            ],
            [
                'group_id' => 7003,
                'item_code' => 'DEM_AF_P',
                'item_name' => 'Premium',
            ],
            [
                'group_id' => 7003,
                'item_code' => 'DEM_LF_GR',
                'item_name' => 'Ground Rent',
                'item_order' => '1',
                'additional_data' => ['duration' => true],
            ],
            [
                'group_id' => 7003,
                'item_code' => 'DEM_RGR',
                'item_name' => 'Revised Ground Rent',
                'item_order' => '1',
                'additional_data' => ['duration' => true],
            ],
            [
                'group_id' => 7003,
                'item_code' => 'ADD_FAR_CHG',
                'item_name' => 'Additional FAR Charges',
                'item_order' => '1',
                'is_active' => 0,
                'additional_data' => ['remarks' => true],
            ],
            [
                'group_id' => 7003,
                'item_code' => 'ADD_GR_ADD_FAR_CHG',
                'item_name' => 'Additional Ground Rent for Additional FAR',
                'item_order' => 0,
                'is_active' => 0,
                'additional_data' => ['duration' => true],
            ],
            [
                'group_id' => 7003,
                'item_code' => 'DEM_LUC_RC',
                'item_name' => 'Land Use Change Charges Residential to Commercial',
                'item_order' => 1,
                'is_active' => 0,
                'additional_data' => ['remarks' => true],
            ],
            /*[
                'group_id' => 7003,
                'item_code' => 'RGR_LUC_CHG',
                'item_name' => 'Revised Ground Rent for Land Use Change',
                'item_order' => 1,
                'additional_data' => ['duration' => true],
            ],
            [
                'group_id' => 7003,
                'item_code' => 'SEC_DEPST',
                'item_name' => 'Security Deposit',
                'item_order' => 1,
                'additional_data' => ['remarks' => true],
            ],
            /* [
                'group_id' => 7003,
                'item_code' => 'LIC_FEE',
                'item_name' => 'Licence Fees',
                'item_order' => 1,
                'additional_data' => ['duration' => true],
            ], */
            [
                'group_id' => 7003,
                'item_code' => 'DEM_SLET_CHG',
                'item_name' => 'Subletting Charges',
                'item_order' => 1,
            ],
            [
                'group_id' => 7003,
                'item_code' => 'DEM_PENAL_STANDARD',
                'item_name' => 'Standard Penalty for violation other than non-payment of demand',
                'item_order' => 1,
            ],
            /*[
                'group_id' => 7003,
                'item_code' => 'PREV_DUE',
                'item_name' => 'Previous Dues',
                'item_order' => 1,
                'additional_data' => ['remarks' => true],
            ],
            [
                'group_id' => 7003,
                'item_code' => 'INT_CHG',
                'item_name' => 'Interest',
                'item_order' => 1,
                'additional_data' => ['duration' => true, 'remarks' => true],
            ],
            [
                'group_id' => 7003,
                'item_code' => 'PNL_CHG',
                'item_name' => 'Penalty',
                'item_order' => 1,
                'additional_data' => ['duration' => true, 'remarks' => true],
            ],
            [
                'group_id' => 7003,
                'item_code' => 'DEM_OTHER',
                'item_name' => 'Others',
                'item_order' => 1,
                'additional_data' => ['remarks' => true],
            ], */

            [
                'group_id' => 7003,
                'item_code' => 'DEM_OTHER',
                'item_name' => 'Others',
                'item_order' => 99,
                'is_active' => 0,
                'additional_data' => ['remarks' => true],
            ],
            [
                'group_id' => 7003,
                'item_code' => 'DEM_MANUAL',
                'item_name' => 'Manual Demand',
                'item_order' => 99,
            ],
            [
                'group_id' => 7003,
                'item_code' => 'DEM_CONV_CHG',
                'item_name' => 'Conversion Charges',
                'item_order' => 1,
            ],
            /** Payment status */
            [
                'group_id' => 17009,
                'item_code' => 'PAY_PENDING',
                'item_name' => 'Pending',
            ],
            [
                'group_id' => 17009,
                'item_code' => 'PAY_FAILED',
                'item_name' => 'Failed',
            ],
            [
                'group_id' => 17009,
                'item_code' => 'PAY_SUCCESS',
                'item_name' => 'Success',
            ],

            /** Payment methods */
            [
                'group_id' => 17010,
                'item_code' => 'PAY_ONLINE',
                'item_name' => 'Online',
            ],
            [
                'group_id' => 17010,
                'item_code' => 'PAY_OFFLINE',
                'item_name' => 'ALL',
            ],

            /** Payment types */
            [
                'group_id' => 17011,
                'item_code' => 'PAY_DEMAND',
                'item_name' => 'Demand',
                'additional_data' => ['additional_input' => 'demand_id']
            ],
            [
                'group_id' => 17011,
                'item_code' => 'PAY_APP_CHG',
                'item_name' => 'Application',
                'additional_data' => ['additional_input' => 'application_no', 'displayForAuthUsers' => true]
            ],
            [
                'group_id' => 17011,
                'item_code' => 'PAY_RTI',
                'item_name' => 'RTI',
            ],
            [
                'group_id' => 17011,
                'item_code' => 'PAY_RTI_ACT',
                'item_name' => 'RTI Act 2005',
            ],
            [
                'group_id' => 17011,
                'item_code' => 'PAY_RGR',
                'item_name' => 'RGR',
                'additional_data' => ['additional_input' => 'property_id']
            ],

            // Club Membership Status SwatiMishra 26-01-2025
            [
                'group_id' => 17012,
                'item_code' => 'CM_NEW',
                'item_name' => 'New',
                'item_order' => 1,
            ],

            [
                'group_id' => 17012,
                'item_code' => 'CM_PEN',
                'item_name' => 'Pending',
                'item_order' => 2,
            ],
            [
                'group_id' => 17012,
                'item_code' => 'CM_INP',
                'item_name' => 'In Process',
                'item_order' => 3,
            ],
            [
                'group_id' => 17012,
                'item_code' => 'CM_REJ',
                'item_name' => 'Rejected',
                'item_order' => 4,
            ],
            [
                'group_id' => 17012,
                'item_code' => 'CM_APP',
                'item_name' => 'Approved',
                'item_order' => 5,
            ],
        ];


        foreach ($items as $item) {
            DB::table('items')->updateOrInsert(
                [

                    'item_code' => $item['item_code'],
                    'group_id' => $item['group_id'],

                ],
                [
                    'item_name' => $item['item_name'],
                    'color_code' => null,
                    'item_order' => $item['item_order'] ?? 1,
                    'additional_data' => isset($item['additional_data']) ? json_encode($item['additional_data']) : null,
                    'is_active' => $item['is_active'] ?? 1, //manually set is_active
                    'created_at' => Carbon::now(),
                    'created_by' => null,
                    'updated_at' => Carbon::now(),
                    'updated_by' => null
                ]
            );
        }
    }
}