<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use App\Works;
use App\clients;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function getClient($id)
    {
        $client = $this->getClientData($id);
        return view('clients',compact('client'));
    }
    
    public function editClient($id, Request $request)
    {
        $status = "Cliente actualizado";
        $validData = $request->validate([
            'name' => 'required|min:5|max:70',
            'email' => 'required|email',
            'phone' => 'numeric|required'
        ]);
        $changes = DB::table('clients')
              ->where('id', $id)
              ->update(['name' => $validData['name'],'email' => $validData['email'],'phone' => $validData['phone']]);
        if($changes === 0){
            $status = "No se pudo actualizar cliente";
        }
        return back()->with(compact('status'));
    }

    public function storeClient(Request $request)
    {

        $validData = $request->validate([
            'name' => 'required|min:5|max:70',
            'email' => 'required|email',
            'phone' => 'numeric|required'
        ]);
            
        DB::table('clients')->insert(
            ['name' =>$validData['name'],'email' =>$validData['email'],'phone' =>$validData['phone'],  'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()]
        );
        $email = $validData['email'];
        $status="Cliente insertado correctamente";
        return back()->with(compact('status','email'));
    }
    public function getIdClient($email)
    {
        return DB::table('clients')
        ->select('id')
        ->where('email', '=', $email)
        ->first();
    }
    public function getClientData($id)
    {
        return DB::table('clients')->where('id', '=', $id)->get();
    }
}
