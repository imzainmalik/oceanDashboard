<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FamilyMemberController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index(){
        return view('family_member.index');
    }
}
