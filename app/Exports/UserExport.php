<?php

namespace App\Exports;

use App\Http\Controllers\MainController;
use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserExport implements FromCollection,WithHeadings,WithStyles,WithColumnWidths
{
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text.
            1    => ['font' => ['bold' => true]],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 18,
            'C' => 22,
            'D' => 40,
            'E' => 20,
            'F' => 20,
            'G' => 20,
            'H' => 20,
            'I' => 10,
            'J' => 10,
            'K' => 10,
            'L' => 10,
            'M' => 10,
            'N' => 23,
            'O' => 15,
            'P' => 15,
            'Q' => 15,
            'R' => 15,
            'S' => 15,
            'T' => 20,
            'U' => 15,
            'V' => 15,
            'W' => 20,
            'X' => 28,
            'Y' => 25,
            'Z' => 25,
        ];
    }

    public function headings():array
    {
        return ['Client','Client Charge Rate','Client Charge Rate (OT)','Site','Week Start Date','Week End Date','Candidate','Role',
        'Mon','Tue','Wed','Thu','Fri','Total Standard Hours','Mon (OT)','Tue (OT)',
        'Wed (OT)','Thu (OT)','Fri (OT)','Total OT Hours','Sat OT','Sun OT',
        'Standard Rate','5pm TO 7am Penality Rate','Saturday Penality Rate','Sunday Penality Rate'];
    }

    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return collect(MainController::show_csv(request()));
    }
}
