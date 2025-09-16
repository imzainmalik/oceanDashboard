<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function check_role(){
        // dd(auth()->user()->role);
        if(auth()->user()->role->id == 1){
            return redirect()->route('superadmin.index');
        }
        elseif(auth()->user()->role->id == 2){
            return redirect()->route('Senior.index');
        }
        elseif(auth()->user()->role->id == 3){
            return redirect()->route('familyMember.index');
        }
        elseif(auth()->user()->role->id == 4){
            return redirect()->route('familyOwner.index');
        }
        elseif(auth()->user()->role->id == 5){
            return redirect()->route('careGiver.index');
        }else{
            Auth::logout();
            return redirect()->route('login')->with('error','dd adad');
        }
    }
}
