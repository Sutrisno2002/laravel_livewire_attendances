<?php

namespace App\Exports;
namespace App\Exports;

use App\Models\Attendance;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AttendancesExport implements FromCollection, WithHeadings, WithStyles
{
    protected $attendances;

    public function __construct($attendances)
    {
        $this->attendances = $attendances;
    }

    public function collection()
    {
        return $this->attendances;
    }

    public function headings(): array
    {
        return [
            'ID', 'User ID', 'Date', 'Check In', 'Check Out', 'Location', 'Created At', 'Updated At'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Styling rows
            1    => ['font' => ['bold' => true]],
        ];
    }
}


