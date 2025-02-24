<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function hello(){
        return 'Hello World';
    }
    
    /*public function greeting(){
        return view ('blog.hello', ['name' => 'Baskoro Seno Aji']);
    }*/

    public function greeting(){
        return view ('blog.hello')
        -> with ('name' , 'Baskoro Seno Aji')
        -> with ('occupation' , 'astronaut');
    }
}
