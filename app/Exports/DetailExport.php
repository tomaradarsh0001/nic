<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class DetailExport implements FromArray, WithHeadings, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    protected $output;
    public function __construct(array $output)
    {
        $this->output = $output;
        ob_clean();
    }

    public function headings(): array
    {
        return [
            'Property Id',
            'Old Property ID',
            'File Number',
            'Old File Number',
            'Land Type',
            'Property Status',
            'Property Type',
            'Property SubType',
            'Is Land Use Changed',
            'Latest Property Type',
            'Latest Property SubType',
            'Section',
            "Address",
            "Premium (Rs)",
            "Ground Rent (Rs)",
            'Area',
            'Area in Sqm',
            'Colony',
            'Block',
            'Plot',
            'Presently Known As',
            'Lease Type',
            'Date of allotment',
            'Date of execution',
            'Date of expiration',
            'Start Date Of GR',
            'RGR Duration',
            'First rgr due on',
            'Last Inspection Date',
            'Last Demand Letter Date',
            'Last Demand ID',
            'Last Demand Amount',
            'Last Amount Received',
            'Last Amount Received Date',
            'Total Dues',
            'Current Lessee',
            'Communication Address',
            'Contact Mobile No.',
            'Email',
            'Entry By',
            'Entry At'
        ];
    }

    public function array(): array
    {
        return $this->output;
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }
}
