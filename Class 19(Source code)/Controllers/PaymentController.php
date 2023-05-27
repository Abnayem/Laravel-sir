<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\PaymentConfirmation;

class PaymentController extends Controller
{
    public function transcode()
    {
        $transactionCode = 'TNX'.uniqid();

        Mail::to('araman666@gmail.com')->send(new PaymentConfirmation($transactionCode));

        dd("Transaction Code Sent to Your Email");
    }
}
