<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator,Redirect,Response;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Mail\EmailVerificationMail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Mail;
use Session;


class AuthController extends Controller
{
   
    public function index()
    {
    	return view('frontend.login');
    }

    public function register()
    {
    	return view('frontend.register');
    }

 /*   public function create(array $data)
    {   
        return User::create([

                'name'=>$data['name'],
                'email'=>$data['email'],
                'password'=>Hash::make($data['password'])
        ]);

    }*/

    public function postRegister(Request $request)
    {
        request()->validate([

                'name'=>'required',
                'email'=>'required|email|unique:users',
                'password'=>'required|min:6',

        ]);

        $user = User::create([

            'name'=>$request->name,
            'email'=>$request->email,
            'password'=>Hash::make($request->password),
            'email_verification_code'=>Str::random(40),
        ]);

        Mail::to($request->email)->send(new EmailVerificationMail($user));

        //Rehturn a response

        return redirect()->back()->with('success','Registration Successfull.Please check your email inbox form verification link');

    }

    public function verify_email($verification_code)
    {
        $user = User::where('email_verification_code',$verification_code)->first();
        if(!$user)
        {
            return redirect()->route('register')->with('error',"Invalid URL");
        }

        else
        {
            if($user->email_verified_at)
            {
                return redirect()->route('register')->with('error',"Email Already Verified"); 
            }

            else
                if($user->created_at->addMinutes(5)->isPast())
                {
                    return redirect()->route('register')->with('error',"Validation link expired.Please Try Again"); 
                }
            else
            {
                $user->update([

                    'email_verified_at'=>\Carbon\Carbon::now()
                ]);

                return redirect()->route('register')->with('success',"Email Successfully Verified"); 
            }
        }
    }

    public function postLogin(Request $request)
    {
        request()->validate([

                    'email'=>'required',
                    'password'=>'required',
        ]);

        $credentials = $request->only('email','password');

        if(Auth::attempt($credentials))
        {
           
            if(Auth::user()->hasVerifiedEmail())
            {
                return redirect()->intended('dashboard');
            }
            else
            {
                Auth::logout();
                return redirect('/login')->with('warning','Please Verify Your Email.');
            }   


        }
        else
        {

        return redirect('/login')->with('error','Invalid Credentials');
    }
    }

    public function dashboard()
    {
        if(Auth::check())
        {
            return view('frontend.dashboard');
        }

        return Redirect::to('login')->with('error','Direct Access Denied');
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
