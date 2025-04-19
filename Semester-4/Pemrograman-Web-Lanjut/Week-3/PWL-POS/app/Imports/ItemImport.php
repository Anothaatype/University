<?php

namespace App\Imports;

use App\Models\Item;
use Maatwebsite\Excel\Concerns\ToModel;

class ItemImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Item([
            'category_id' => $row[0],
            'item_code' => $row[1],
            'item_name' => $row[2],
            'item_buy_price' => $row[3],
            'item_sell_price' => $row[4],
        ]);
    }
}
