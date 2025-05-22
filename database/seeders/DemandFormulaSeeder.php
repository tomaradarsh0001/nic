<?php

namespace Database\Seeders;

use App\Models\DemandFormula;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DemandFormulaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $demandHeads = [
            [
                'head_code' => 'DEM_AF_P',
                'date_from' => date('Y-m-d', strtotime('2025-01-01')),
                'date_to' => null,
                'formula' => 'AF or P = N% x (LR x LA)',
                'description' => 'N = Number of years for which allotment is to be made
                                    LR = Land Rate per sqmtr.
                                    LA = Land Area in sqmtr.
                                    LV = Land Value
                                    minimum - 15 days, maximum - 50 years',
                'for_allotment_type' => 1,
                'parent_head_code' => null,
            ],
            [
                'head_code' => 'DEM_LF_GR',
                'date_from' => date('Y-m-d', strtotime('2025-01-01')),
                'date_to' => null,
                'formula' => 'LF or GR = 0.5% x LV. [LV = LR x LA]',
                'description' => ' N = Number of years for which allotment is to be made
                                    LR = Land Rate per sqmtr.
                                    LA = Land Area in sqmtr.
                                    LV = Land Value',
                'for_allotment_type' => 1,
                'parent_head_code' => 'DEM_AF_P',
            ],
            [
                'head_code' => 'DEM_UEI',
                'date_from' => date('Y-m-d', strtotime('2025-01-01')),
                'date_to' => null,
                'formula' => 'UEI = 10% x LV (on the date of transfer) or CV, whichever is higher',
                'description' => 'UEI = Unearned Increase, LV = Land Value, CV = Consideration Value',
                'for_allotment_type' => 0,
                'parent_head_code' => null,
            ],
            [
                'head_code' => 'DEM_CONV_CHG',
                'date_from' => date('Y-m-d', strtotime('2025-01-01')),
                'date_to' => null,
                'formula' => 'NCCL = CCL - R,',
                'description' => 'CCL = 20% x LV
                    [LV= LR x LA]
                    R = 40% x CCL',
                'for_allotment_type' => 0,
                'parent_head_code' => null,
            ],
            [
                'head_code' => 'DEM_LUC_RC',
                'date_from' => date('Y-m-d', strtotime('2025-01-01')),
                'date_to' => null,
                'formula' => 'LUCC = 10% x LV',
                'description' => 'When Built Up Area sought to be used as Commercial is less than 20% of Total Built Up Area no charges to be paid',
                'for_allotment_type' => 0,
                'parent_head_code' => null,
            ],
            [
                'head_code' => 'DEM_SLET_CHG',
                'date_from' => date('Y-m-d', strtotime('2025-01-01')),
                'date_to' => null,
                'formula' => 'SC = 10% x AI, PSC = 25% x (AI x Y) ',
                'description' => 'AI = Annual Income generated from subletting leased land or property, PSC = Penal Subletting Charges, Y = Number of years elapsed since the leased land or property was sublet without permission',
                'for_allotment_type' => 0,
                'parent_head_code' => null,
            ],
            [
                'head_code' => 'DEM_PENAL_STANDARD',
                'date_from' => date('Y-m-d', strtotime('2025-01-01')),
                'date_to' => null,
                'formula' => 'SC = 1% of LV',
                'description' => 'LV = Land value = Land Rate x Land Area',
                'for_allotment_type' => 0,
                'parent_head_code' => null,
            ],
        ];
        foreach ($demandHeads as $key => $head) {
            DemandFormula::updateOrCreate(
                ['head_code' => $head['head_code']],
                $head
            );
        }
    }
}
