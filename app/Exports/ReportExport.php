<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportExport implements FromArray, WithHeadings, WithStyles
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
            'Old Property Id',
            'Unique Property Id',
            'Land Type',
            'Land Status',
            'Lease Tenure',
            'Land Use',
            'Area(SQM)',
            "Address",
            "Lesse/Owner Name",
            'Ground Rent(Rs)',
            'Status of RGR'
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
