<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClientsController;
use App\Works;

class WorksController extends Controller
{
    private $clientController;
    public function __construct()
    {
        $this->middleware('auth');
        $this->clientController = new ClientsController;
        session()->put('statusDate','DESC');
    }

    public function index()
    {
        $statusDate = 'DESC';
        $nameclient = '';
        $worksData = Works::with('client')->orderBy('created_at', $statusDate)->paginate(15);
        return view('works',compact('worksData','statusDate','nameclient'));
    }

    public function filterDate($statusDate)
    {   
        session()->put('statusDate',$statusDate);
        $nameclient = session()->get('nameClient');
        if(!$nameclient){
            $nameclient ='';
            $worksData = Works::with('client')->orderBy('created_at', $statusDate)->paginate(15);
            return  view('works',compact('worksData','statusDate','nameclient'));
        }
        $worksData = Works::join("clients","Works.client_id","=","clients.id")->orWhere('name', 'like', '%' . $nameclient . '%')->orderBy('Works.created_at', $statusDate)->paginate(15);
        return  view('works',compact('worksData','statusDate','nameclient'));
    }
    public function filterName(Request $request){
        $statusDate =  session()->get('statusDate');
        session()->put('nameClient',$request['nameClient']);
        $nameclient = $request['nameClient'];
        
        $worksData = Works::join("clients","Works.client_id","=","clients.id")
        ->orWhere('name', 'like', '%' . $request['nameClient'] . '%')->orderBy('Works.created_at', $statusDate)
        ->paginate(15);
       return  view('works',compact('worksData','statusDate','nameclient'));
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
      
        if($id != null)
        {

            $newJob = new Works;
            $newJob->direction =$validData['direction'];
            $newJob->budget =$validData['budget'];
            $newJob->cost =$validData['cost'];
            $newJob->client_id =$id[0]->id;
            $newJob->save();
          
            $status = "Trabajo insertado correctamente";
        }
        return back()->with(compact('status'));
    }
    public function deleteJob($id)
    {
        
        $deleteJob = works::findOrFail($id);
        $deleteJob->delete();
       
        $status = "Se ha eliminado correctamente";
        return back()->with(compact('status'));
    }
  
}
