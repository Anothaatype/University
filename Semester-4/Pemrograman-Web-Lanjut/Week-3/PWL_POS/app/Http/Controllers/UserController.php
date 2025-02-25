<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {   
        // tambah data user dengan Eloquent Model
        $data = [
            'nama' => 'Pelanggan Pertama',
        ];
        UserModel::where('username', 'customer-1')->update($data); //tambahkan data ke tabel m_user
        
        //Coba akses Model UserModel
        $user = UserModel::all(); //ambil semua data dari table m_user
        return view ('user', ['data' => $user]);
    }
}
