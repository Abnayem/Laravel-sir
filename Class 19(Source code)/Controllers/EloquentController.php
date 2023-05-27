<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Customer;
use App\Models\Company;

class EloquentController extends Controller
{
    public function home()
    {
        $companies = Company::all();
        return view('welcome',compact('companies'));
    }
}
