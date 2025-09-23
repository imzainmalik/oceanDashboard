<?php

namespace App\Http\Controllers;

class SeniorController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        return view('senior.index');
    }
}
