<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use Mail;


class ContactUsFormController extends Controller
{
    public function createForm(Request $request)
    {
        return view('contact');
    }

    public function ContactUsForm(Request $request)
    {
        $this->validate($request,[

            'name'=>'required',
            'email'=>'required|email',
            'phone'=>'required|regex:/^([0-9\s\-\+\(\)]*)$/|max:11',
            'subject'=>'required',
            'message'=>'required'
        ]);

        Contact::create($request->all());

        //Send mail after insert

        Mail::send('mail',array(

                'name'=>$request->get('name'),
                'email'=>$request->get('email'),
                'phone'=>$request->get('phone'),
                'subject'=>$request->get('subject'),
                'user_query'=>$request->get('message'),
        ), function($message) use ($request){

            $message->from($request->email);
            $message->to('araman666@gmail.com','Admin')->subject($request->get('subject'));
        });

        return back()->with('success','We have received your message and would like to thank you for writing to us.');
    } 
}
