<?php

use App\Models\Shoe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $shoes = Shoe::all();
    return view('welcome' , ['shoes' =>$shoes]);
});

Route::get('/shoes/{id}', function (Request $request , $id) {
    $shoe = Shoe::where('id' , $id)->first();
    return view('show' , ['shoe' =>$shoe]);
});
