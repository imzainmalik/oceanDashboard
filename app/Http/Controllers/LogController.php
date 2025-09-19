<?php

namespace App\Http\Controllers;

use App\Models\TimelineLog;
use Illuminate\Http\Request;

class LogController extends Controller
{
    //
        /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function logs()
    {
        $logs = TimelineLog::where('family_owner_id', auth()->user()->id)
        ->orderBy('id','DESC')->paginate(20);
        return view('family_owner.log.all',compact('logs'));
    }
}
