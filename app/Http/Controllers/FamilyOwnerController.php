<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FamilyOwnerController extends Controller
{
    //

    public function index(){
        return view('family_owner.index');
    }
}
