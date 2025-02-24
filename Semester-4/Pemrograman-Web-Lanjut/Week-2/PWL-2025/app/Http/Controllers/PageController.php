<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index(){
        return 'Selamat Datang';
    }

    public function about(){
        return 'Baskoro Seno Aji, 2341720063';
    }

    public function article($id){
        return 'Halaman Artikel Dengan ID-' . $id;
    }
}
