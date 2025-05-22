<?php
namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use PhpOffice\PhpSpreadsheet\Shared\Date as ExcelDate;
use Illuminate\Support\Facades\Schema;

class GenericImport implements ToArray, WithHeadingRow
{
    public $data;
    protected $table;
    protected $dateColumns = [];

    public function __construct($table)
    {
        $this->table = $table;
        $this->fetchDateColumns();
    }

    /**
     * Fetch date columns from the database table schema.
     */
    private function fetchDateColumns()
    {
        $columns = Schema::getColumnListing($this->table);
        foreach ($columns as $column) {
            $type = Schema::getColumnType($this->table, $column);
            if (in_array($type, ['date', 'datetime', 'timestamp'])) {
                $this->dateColumns[] = $column;
            }
        }
    }

    /**
     * Handle the array of data from Excel.
     *
     * @param array $array
     */
    public function array(array $array)
    {
        $this->data = array_map(function ($row) {
            // Transform date columns if applicable
            foreach ($row as $key => $value) {
                if (in_array($key, $this->dateColumns) && $value) {
                    $row[$key] = $this->transformDate($value);
                }
            }
            return $row;
        }, $array);
    }

    /**
     * Transform Excel date value to \DateTime object.
     *
     * @param mixed $value
     * @return string|null Formatted date string (Y-m-d) or null.
     */
    private function transformDate($value)
    {
        try {
            if (is_numeric($value)) {
                return ExcelDate::excelToDateTimeObject($value)->format('Y-m-d');
            } elseif (strtotime($value) !== false) {
                return (new \DateTime($value))->format('Y-m-d');
            }
        } catch (\Exception $e) {
            return null;
        }
        return null;
    }
}

