<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;

class UserImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new User([
            'level_id' => $row[0],
            'username' => $row[1],
            'name' => $row[2],
            'password' => bcrypt($row[3]),
        ]);
    }
}
