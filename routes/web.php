<?php

use App\Http\Middleware\GetToken;
use App\Models\Shoe;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Foundation\Http\Middleware;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;

Route::get('/', function () {
    $shoes = Shoe::all();
    return view('welcome' , ['shoes' =>$shoes]);
});

Route::get('/shoes/{id}', function (Request $request , $id) {
    $shoe = Shoe::where('id' , $id)->first();
    return view('show' , ['shoe' =>$shoe]);
});

Route::post("/payments" , function(Request $request){
    // {
    //     "BusinessShortCode": "174379",
    //     "Password": "MTc0Mzc5YmZiMjc5ZjlhYTliZGJjZjE1OGU5N2RkNzFhNDY3Y2QyZTBjODkzMDU5YjEwZjc4ZTZiNzJhZGExZWQyYzkxOTIwMTYwMjE2MTY1NjI3",
    //     "Timestamp":"20160216165627",
    //     "TransactionType": "CustomerPayBillOnline",
    //     "Amount": "1",
    //     "PartyA":"254708374149",
    //     "PartyB":"174379",
    //     "PhoneNumber":"254708374149",
    //     "CallBackURL": "https://mydomain.com/pat",
    //     "AccountReference":"Test",
    //     "TransactionDesc":"Test"
    //  }
    $token = $request->request->get('token');
    $passkey = "bfb279f9aa9bdbcf158e97dd71a467cd2e0c893059b10f78e6b72ada1ed2c919";
    $short_code = "174379";
    $timestamp = Carbon::now()->format("YmdHis");
    $password = base64_encode($short_code . $passkey . $timestamp);
    $response = Http::withHeaders([
        'Authorization' => 'Bearer ' . $token
    ])->post("https://sandbox.safaricom.co.ke/mpesa/stkpush/v1/processrequest" , [
        "BusinessShortCode" => "174379",
        "Password" => $password,
        "Timestamp" => $timestamp,
        "TransactionType" => "CustomerPayBillOnline",
        "Amount" => "1",
        "PartyA" => "254758262427",
        "PartyB" => "174379",
        "PhoneNumber" =>"254758262427",
        "CallBackURL" => "https://large-eyes-show.loca.lt/callback",
        "AccountReference" => "Test",
        "TransactionDesc" => "Test"
    ]);


})->middleware(GetToken::class);

Route::post('/callback', function (Request $request) {
   $data = file_get_contents('php://input');
    Storage::disk('local')->put('stk.txt' , $data);
    // Log::debug($data);
});

