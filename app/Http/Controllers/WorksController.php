<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClientsController;
use App\Works;

class WorksController extends Controller
{
    private $clientController,$statusDate;
    public function __construct()
    {
        $this->middleware('auth');
        $this->clientController = new ClientsController;
        session()->put('statusDate','DESC');
    }

    public function index()
    {
        $statusDate = 'DESC';
        $worksData = Works::with('client')->orderBy('created_at', $statusDate)->paginate(15);
        return view('works',compact('worksData','statusDate'));
    }

    public function filterDate($statusDate)
    {   
        
        $worksData = Works::with('client')->orderBy('created_at', $statusDate)->paginate(15);
        return  view('works',compact('worksData','statusDate'));
    }
    public function filterName(Request $request){
      
        $statusDate = 'DESC';
        $worksData = Works::join("clients","Works.client_id","=","clients.id")
        ->orWhere('name', 'like', '%' . $request['nameClient'] . '%')
        ->paginate(15);
       return  view('works',compact('worksData','statusDate'));
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
