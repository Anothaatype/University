<?php

namespace App\Http\Controllers;

class UserController extends Controller
{
    //compact are use to send the data into the view 
    public function Show($id, $name){
        return view('user', compact('id', 'name'));
    }
}