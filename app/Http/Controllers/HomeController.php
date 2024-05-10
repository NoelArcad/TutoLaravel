<?php

namespace App\Http\Controllers;

use App\Models\Property;

class HomeController extends Controller
{
      
    public function index(){
        
        $properties = Property::recent()->available()->limit(6)->get();
        return view('home', ['properties' => $properties]);
    }

}
