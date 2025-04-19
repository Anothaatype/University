<?php

namespace App\Exports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ItemExport implements FromCollection, WithHeadings, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Item::with('category')
            ->get()
            ->map(function ($item) {
                return [
                    'ID'          => $item->item_id,
                    'Category'    => $item->category->category_name,
                    'Code'        => $item->item_code,
                    'Name'        => $item->item_name,
                    'Buy Price'   => $item->item_buy_price,
                    'Sell Price'  => $item->item_sell_price,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'ID',
            'Category',
            'Code',
            'Name',
            'Buy Price',
            'Sell Price',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1    => ['font' => ['bold' => true]],
        ];
    }
}
