<?php

namespace App\Http\Controllers;

use App\Mail\MessageReceived;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;

class MailController extends Controller
{
    private $idClient,$data;
    public function index($id)
    {
        $this->idClient = $id;
        return view('emails.email');
    }
    public function sendMail(Request $request)
    {
        $this->data = $request->all();
       
        Mail::send('emails.messageReceived',$request->all(),function($msg){
            $msg->from('fabian.jesus.jm@gmail.com','Admin');
            $msg->to($this->data['email'])->subject($this->data['affair']);
        });
        
        
        return "mensaje enviado correctamente";
    }
}
