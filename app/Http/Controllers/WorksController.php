<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Works;
use App\Http\Controllers\ClientsController;

class WorksController extends Controller
{
    private $clientController;
    public function __construct()
    {
        $this->middleware('auth');
        $this->clientController = new ClientsController;
    }

    public function index()
    {
        $works = Works::with('client')->paginate(15);
        return view('works',compact('works'));
    }
    
    public function storeJob(Request $request)
    {
        $validData = $request->validate([
            'direction' => 'required|min:5|max:255',
            'budget' => 'numeric|required',
            'cost' => 'numeric|required',
            'client'=> 'required|email'
        ]);
        $status="Email no es correcto o cliente no creado";
        $id =  $this->clientController->getIdClient($validData['client']);
        $emailClient = "emaiul";

        if($id != null)
        {
            DB::table('works')->insert(
                ['direction' =>$validData['direction'],'budget' =>$validData['budget'],'cost' =>$validData['cost'],'client_id' => $id->id, 'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now()]
            );
            $status = "Trabajo insertado correctamente";
        }
        return view('works',compact('status'));
    }
    public function deleteJob($id)
    {
        DB::table('works')->where('id', '=', $id)->delete();
        $status ="Se ha elimidado correctamente";
        return back()->with(compact('status'));
    }
  
}
