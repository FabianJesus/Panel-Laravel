<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Works;
use App\clients;
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
        $works = Works::with('client')->paginate(15);
        return view('works',compact('works'));
    }
    //TODO:Need validate $request data
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

        $status2="Email no es correcto o cliente no creado";
        $id =  $this->getIdClient($request['client']);
        if($id != null)
        {
            DB::table('works')->insert(
                ['direction' =>$request['direction'],'budget' =>$request['budget'],'cost' =>$request['cost'],'client_id' =>$id->id, 'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()]
            );
            $status2="Trabajo insertado correctamente";
        }
        return back()->with(compact('status2'));
    }
    private function getIdClient($email)
    {
        return DB::table('clients')
        ->select('id')
        ->where('email', '=', $email)
        ->first();
    }
}
