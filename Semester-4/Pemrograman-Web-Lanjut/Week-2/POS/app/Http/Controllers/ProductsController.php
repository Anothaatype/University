<?php

namespace App\Http\Controllers;

class ProductsController extends Controller
{
    public function FoodBeverages(){
        return view('products.FoodBeverages');
    }

    public function BeautyHealth(){
        return view('products.BeautyHealth');
    }

    public function HomeCare(){
        return view('products.HomeCare');
    }

    public function BabyKid(){
        return view('products.BabyKid');
    }
}