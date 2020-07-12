<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GmapsController extends Controller
{
    public function init ()
    {
        return view('maps/maps');
    }
}
