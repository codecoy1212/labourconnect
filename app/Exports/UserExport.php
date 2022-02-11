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
            'B' => 40,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 20,
            'G' => 10,
            'H' => 10,
            'I' => 10,
            'J' => 10,
            'K' => 10,
            'L' => 23,
            'M' => 15,
            'N' => 15,
            'O' => 15,
            'P' => 15,
            'Q' => 15,
            'R' => 20,
            'S' => 15,
            'T' => 15,
            'U' => 20,
            'V' => 28,
            'W' => 25,
            'X' => 25,
        ];
    }

    public function headings():array
    {
        return ['Client','Site','Week Start Date','Week End Date','Candidate','Role',
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
