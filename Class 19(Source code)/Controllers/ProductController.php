<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\NewProductNotification;

class ProductController extends Controller
{
 public function show(Product $product)
    {
        return view('product.show',compact('product'));
    }

public function store(Request $request)
{
    $product = new Product;
    $product->name = $request->input('name');
    $product->price = $request->input('price');
    $product->save();

    $product->categories()->attach($request->input('categories'));

    $users = User::all();
    Notification::send($users, new NewProductNotification($product));

    return redirect()->back()->with('success','Product added successfully');
}

public function showusers($product)
{
    if(auth()->check())
    {
        return view('frontend.dashboard');
    }

    else
    {
        Auth::logout();
        return redirect()->route('login');
    }
}

public function sendCategory()
{
    $categories = Category::with('products')->get();
    return view('product.add',compact('categories'));
}

public function index()
{
    $categories = Category::with('products')->get();

    return view('product.show',compact('categories'));
}
}
