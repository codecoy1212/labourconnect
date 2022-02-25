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
            'A' => 40,
            'B' => 20,
            'C' => 22,
            'D' => 20,
            'E' => 20,
            'F' => 40,
            'G' => 20,
            'H' => 20,
            'I' => 20,
            'J' => 20,
            'K' => 10,
            'L' => 10,
            'M' => 10,
            'N' => 10,
            'O' => 10,
            'P' => 23,
            'Q' => 15,
            'R' => 15,
            'S' => 15,
            'T' => 15,
            'U' => 15,
            'V' => 20,
            'W' => 15,
            'X' => 15,
            'Y' => 20,
            'Z' => 28,
            'AA' => 25,
            'AB' => 25,
        ];
    }

    public function headings():array
    {
        return ['Client','Client Charge Rate','5pm to 7am (OT)','Saturday (OT)','Sunday (OT)','Site','Week Start Date','Week End Date','Candidate','Role',
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
