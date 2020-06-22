<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\clients;

class ClientsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(){
        $clientsData = clients::orderBy('created_at')->paginate(15);
        return  view('clientsList',compact('clientsData'));
    }
    public function getClient($id)
    {
        $client = $this->getClientData($id);
        return view('clients',compact('client'));
    }
    
    public function editClient($id, Request $request)
    {
        $validData = $request->validate([
            'name' => 'required|min:5|max:70',
            'email' => 'required|email',
            'phone' => 'numeric|required'
        ]);

       $clientToUpdate = clients::find($id);
       $clientToUpdate->name =  $validData['name'];
       $clientToUpdate->email =  $validData['email'];
       $clientToUpdate->phone =  $validData['phone'];
       $clientToUpdate->save();
    
        $status = "Cliente actualizado";

        return back()->with(compact('status'));
    }

    public function storeClient(Request $request)
    {

        $validData = $request->validate([
            'name' => 'required|min:1|max:70',
            'email' => 'required|email',
            'phone' => 'numeric|required'
        ]);
        $newClient = new clients;
        $newClient->name = $validData['name'];
        $newClient->email = $validData['email'];
        $newClient->phone = $validData['phone'];
        $newClient->save();

        $email = $validData['email'];
        $status="Cliente insertado correctamente";
        return back()->with(compact('status','email'));
    }
    public function getIdClient($email)
    {
        return clients::where('email', '=', $email)->get();
    }
    public function getClientData($id)
    {
       return clients::findOrFail($id);
    }
}
