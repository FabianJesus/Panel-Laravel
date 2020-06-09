<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use App\Contact;

class MailController extends Controller
{
    private $data;
    public function index($id)
    {
        $client = new ClientsController();
        $mailData = $client->getClientData($id);

        $msgs = Contact::where('email_client', '=', $mailData->email)->paginate(5);


        return view('emails.email',compact('mailData','msgs'));
    }
    public function sendMail(Request $request)
    {
        $this->data = $request->all();
        $this->storageMail();
        Mail::send('emails.messageReceived',$request->all(),function($msg){
            $msg->from('Tu email','Admin');
            $msg->to($this->data['email'])->subject($this->data['affair']);
        });
        
        
        $status ="mensaje enviado correctamente";
        return back()->with(compact('status'));
    }
    public function storageMail(){
        
        $mail = new Contact;
        $mail->name = $this->data['name'];
        $mail->affair = $this->data['affair'];
        $mail->email_client = $this->data['email'];
        $mail->message = $this->data['msg'];
        $mail->save();
      
    }
}
