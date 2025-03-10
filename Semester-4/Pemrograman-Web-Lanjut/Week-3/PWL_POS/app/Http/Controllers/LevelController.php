<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LevelController extends Controller
{
    public function index()
    {
        //DB::insert('insert into m_level(level_kode, level_nama, created_at) values(?, ?, ?)',['CUS', 'Pelanggan', now()]); 
        //return 'Insert data baru berhasil';

        // Facade untuk Update Data 
        //$row = DB::update('update m_level set level_nama = ? where level_kode = ?' , ['Customer', 'CUS']);
        //return 'Update data berhasil. Jumlah data yang diupdate: ' .$row. 'baris';

        // Facade untuk Delete data
        $row = DB::delete('delete from m_level where level_kode = ? ', ['CUS']);
        return 'Delete data berhasil. Jumlah data yang dihapus: ' .$row. 'baris';

        //Facade untuk menampilkan data 
        //$data = DB::select('select * from m_level');
        //return view('level', ['data' => $data]);
    }
}
