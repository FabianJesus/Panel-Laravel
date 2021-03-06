<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\ClientsController;
use App\Works;
use Carbon\Carbon;

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
            'budget' => 'numeric|required',
            'cost' => 'numeric|required',
            'client'=> 'required|email',
            'lat'=>'required',
            'lon'=>'required'
        ]);
        $status="Email no es correcto o cliente no creado";
        $id =  $this->clientController->getIdClient($validData['client']);
         
        
        if($id != null)
        {

            $newJob = new Works;
            $newJob->lat = floatval($validData['lat']);
            $newJob->lon = floatval($validData['lon']);
            $newJob->budget =$validData['budget'];
            $newJob->cost =$validData['cost'];
            $newJob->client_id =$id[0]->id;
            $newJob->save();
          
            $status = "Trabajo insertado correctamente";
        }
        return back()->with(compact('status'));
    }
    public function getjob($id)
    {
        $statusDate = 'DESC';
        $nameclient = '';
        $worksData = Works::with('client')->where('id',$id)->get();
        return view('works',compact('worksData','statusDate','nameclient'));
    }
    public function deleteJob($id)
    {
        $deleteJob = works::findOrFail($id);
        $deleteJob->delete();
       
        $status = "Se ha eliminado correctamente";
        return back()->with(compact('status'));
    }
    public function getWorkbyDate($data){
        $date1 = new Carbon($data);
        $date2 = new Carbon($data);
        $date2->addDay(1)->subSecond(1);
        return Works::with('client')->whereBetween('created_at', [$date1, $date2])->get();
    }
  
}
