<?php

namespace App\Imports;

use App\Models\Level;
use Maatwebsite\Excel\Concerns\ToModel;

class LevelImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Level([
            'level_code' => $row[0],
            'level_name' => $row[1],
        ]);
    }
}
