<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class UserExport implements FromCollection, WithStyles, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return User::with('level')
            ->get()
            ->map(function ($user) {
                return [
                    'ID'       => $user->user_id,
                    'Username' => $user->username,
                    'Name'     => $user->name,
                    'Level'    => $user->level->level_name,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Username',
            'Name',
            'Level',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
