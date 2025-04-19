<?php

namespace App\Exports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Stock::with('item')
        ->get()
        ->map(function ($stock) {
            return [
                'ID'          => $stock->stock_id,
                'Item Code'   => $stock->item->item_code,
                'Item Name'   => $stock->item->item_name,
                'Quantity'    => $stock->stock_qty,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Item Code',
            'Item Name',
            'Quantity',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
