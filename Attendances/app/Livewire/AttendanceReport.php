<?php

namespace App\Livewire;


use Livewire\Component;
use App\Models\Attendance;
use App\Exports\AttendancesExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class AttendanceReport extends Component
{
    public $startDate, $endDate, $reportType = 'daily';
    public $attendances;

    public function render()
    {
        $this->loadAttendances();
        return view('livewire.attendance-report');
    }

    public function loadAttendances()
    {
        $query = Attendance::query();

        if ($this->startDate && $this->endDate) {
            $query->whereBetween('date', [$this->startDate, $this->endDate]);
        }

        $this->attendances = $query->get();
    }

    public function export($format)
    {
        $export = new AttendancesExport($this->attendances);

        if ($format == 'csv') {
            return Excel::download($export, 'attendances.csv');
        } elseif ($format == 'xlsx') {
            return Excel::download($export, 'attendances.xlsx');
        } elseif ($format == 'pdf') {
            return Excel::download($export, 'attendances.pdf', \Maatwebsite\Excel\Excel::DOMPDF);
        }
    }
}
