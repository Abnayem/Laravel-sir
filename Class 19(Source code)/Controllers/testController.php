<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\view;


class testController extends Controller
{
    public function shoMessage()
    {
        echo "This message from controller";
    }

     public function contact()
    {
        return view('testview',['article'=>'Passing Data to Views']);
    }

    public function stuId()
    {
        return view('testview',['student'=>['Hasan','Kiron','Jewel','Mamun','Sagor']]);
    }

    public function mywhile($i)
    {
        return view('testview',compact('i'));
    }

    public function signup()
    {
        return view('signup');
    }

    public function contact2()
    {
        return view('contact');
    }
  

}
