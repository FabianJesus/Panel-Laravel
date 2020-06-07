<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Works;
use App\clients;

class ClientsController extends Controller
{
    public function getClient($id)
    {
        $client = DB::table('clients')->where('id', '=', $id)->get();
        return view('clients',compact('client'));
    }
}
