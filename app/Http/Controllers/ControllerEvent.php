<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\WorksController;
use App\Event;

class ControllerEvent extends Controller
{   
  private $works;
    function __construct()
    {
       $this->works = new WorksController();
        $this->mes =[
        'Jan' =>"Enero",
        'Feb' =>"Febrero",
        'Mar' =>"Marzo",
        'Apr' =>"Abril",
        'May' =>"Mayo",
        'Jun' =>"Junio",
        'Jul' =>"Julio",
        'Aug' =>"Agosto",
        'Sep' =>"Septiembre",
        'Oct' =>"Octubre",
        'Nov' =>"Noviembre",
        'Dec' =>"Diciembre"
        ];
    }
    public function form(){
      return view("event/form");
    }

    public function create(Request $request){

      $this->validate($request, [
      'titulo'     =>  'required',
      'descripcion'  =>  'required',
      'fecha' =>  'required'
     ]);

      Event::insert([
        'titulo'       => $request->input("titulo"),
        'descripcion'  => $request->input("descripcion"),
        'fecha'        => $request->input("fecha")
      ]);

      return back()->with('success', 'Enviado exitosamente!');

    }
    public function delete($id){
      Event::where("id","=",$id)->delete();
      $status = "Evento eliminado correctamente.";
      return redirect("/Evento/index")->with(compact('status'));
    }
    public function details($id){

      $event = Event::find($id);

      return view("event/event",[
        "event" => $event
      ]);

    }


    // =================== CALENDARIO =====================

    public function index(){

       $month = date("Y-m");
       //
       $data = $this->calendar_month($month);
       // obtener mes en espanol
       $mespanish = $this->spanish_month($data['month']);
       $mes = $data['month'];

       return view("event/calendar",[
         'data' => $data,
         'mes' => $mes,
         'mespanish' => $mespanish
       ]);

   }

   public function index_month($month){

      $data = $this->calendar_month($month);
      // obtener mes en espanol
      $mespanish = $this->spanish_month($data['month']);
      $mes = $data['month'];

      return view("event/calendar",[
        'data' => $data,
        'mes' => $mes,
        'mespanish' => $mespanish
      ]);

    }

    public function calendar_month($month){
      $mes = $month;
   
      //sacar el ultimo de dia del mes
      $daylast =  date("Y-m-d", strtotime("last day of ".$mes));
      //sacar el dia de dia del mes
      $fecha      =  date("Y-m-d", strtotime("first day of ".$mes));
      $daysmonth  =  date("d", strtotime($fecha));
      $montmonth  =  date("m", strtotime($fecha));
      $yearmonth  =  date("Y", strtotime($fecha));
      // sacar el lunes de la primera semana
      $nuevaFecha = mktime(0,0,0,$montmonth,$daysmonth,$yearmonth);
      $diaDeLaSemana = date("w", $nuevaFecha);
      $nuevaFecha = $nuevaFecha - ($diaDeLaSemana*24*3600); //Restar los segundos totales de los dias transcurridos de la semana
      $dateini = date ("Y-m-d",$nuevaFecha);
      //$dateini = date("Y-m-d",strtotime($dateini."+ 1 day"));
      // numero de primer semana del mes
  
      $semana1 = date("W",strtotime($fecha));
      // numero de ultima semana del mes
      $semana2 = date("W",strtotime($daylast));
      // semana todal del mes
      // en caso si es diciembre
      if (date("m", strtotime($mes))==12) {
          $semana = 5;
      }
       if(($semana2-$semana1) < 0){
        $semana2 = 5;
        $semana1 = 1;
       }
       $semana = ($semana2-$semana1)+1;
      // semana todal del mes
      $datafecha = $dateini;
      $calendario = array();
      $iweek = 0;
      while ($iweek < $semana):
          $iweek++;
          //echo "Semana $iweek <br>";
          //
          $weekdata = [];
          for ($iday=0; $iday < 7 ; $iday++){
            // code...
            $datafecha = date("Y-m-d",strtotime($datafecha."+ 1 day"));
            $datanew['mes'] = date("M", strtotime($datafecha));
            $datanew['dia'] = date("d", strtotime($datafecha));
            $datanew['fecha'] = $datafecha;
            //AGREGAR CONSULTAS EVENTO
            $datanew['works'] = $this->works->getWorkbyDate($datafecha);
            $datanew['evento'] = Event::where("fecha",$datafecha)->get();
            array_push($weekdata,$datanew);
          }
          $dataweek['semana'] = $iweek;
          $dataweek['datos'] = $weekdata;
          //$datafecha['horario'] = $datahorario;
          array_push($calendario,$dataweek);
      endwhile;
      $nextmonth = date("Y-M",strtotime($mes."+ 1 month"));
      $lastmonth = date("Y-M",strtotime($mes."- 1 month"));
      $month = date("M",strtotime($mes));
      $yearmonth = date("Y",strtotime($mes));
      //$month = date("M",strtotime("2019-03"));
      $data = array(
        'next' => $nextmonth,
        'month'=> $month,
        'year' => $yearmonth,
        'last' => $lastmonth,
        'calendar' => $calendario,
      );
      
      return $data;
    }

    public function spanish_month($month)
    {
        return $this->mes[$month];      
    }

}

