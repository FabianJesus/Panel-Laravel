<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class MailController extends Controller
{
    private $data;
    public function index($id)
    {
        $client = new ClientsController();
        $mailData = $client->getClientData($id);
        
        $msgs = DB::table('contact')->where('email_client', '=', $mailData[0]->email)->paginate(15);

        return view('emails.email',compact('mailData','msgs'));
    }
    public function sendMail(Request $request)
    {
        $this->data = $request->all();
        $this->storageMail();
        Mail::send('emails.messageReceived',$request->all(),function($msg){
            $msg->from('tu email','Admin');
            $msg->to($this->data['email'])->subject($this->data['affair']);
        });
        
        
        $status ="mensaje enviado correctamente";
        return back()->with(compact('status'));
    }
    public function storageMail(){
        DB::table('contact')->insert(
            ['name' =>$this->data['name'],'affair' =>$this->data['affair'],'email_client' =>$this->data['email'],'message' => $this->data['msg'], 'created_at' => \Carbon\Carbon::now(),
            'updated_at' => \Carbon\Carbon::now()]
        );
    }
}
