<?php

namespace App\Imports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;

class StockImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Stock([
            'item_id' => $row[0],
            'user_id' => $row[1],
            'stock_qty' => $row[2],
        ]);
    }
}
