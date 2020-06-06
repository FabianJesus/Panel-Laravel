<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class WorksController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('works');
    }
    //TODO:Need validate $request data and error duplicate email
    public function storeClient(Request $request)
    {

    DB::table('clients')->insert(
        ['name' =>$request['name'],'email' =>$request['email'],'phone' =>$request['phone'],  'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now()]
    );

        $status="Cliente insertado correctamente";
        return back()->with(compact('status'));
    }
    public function storeJob(Request $request)
    {

    DB::table('works')->insert(
        ['direction' =>$request['direction'],'budget' =>$request['budget'],'cost' =>$request['cost'],'client_id' =>$request['client'], 'created_at' => \Carbon\Carbon::now(),
        'updated_at' => \Carbon\Carbon::now()]
    );

        $status="Trabajo insertado correctamente";
        return back()->with(compact('status2'));
    }
}
