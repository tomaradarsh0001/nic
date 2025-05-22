<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SteetviewController extends Controller
{
    public function map(Request $request,$id)
    {
        $propertyid = $id;
        return view('streetview',compact(['propertyid']));
    }
}
