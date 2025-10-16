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
      $colors = ['#28a745', '#007bff', '#ffc107', '#dc3545', '#6f42c1'];
    $logs = TimelineLog::where('family_owner_id', auth()->user()->id)
        ->orderBy('id', 'DESC')
        ->get();

    return view('family_owner.log.all', compact('logs', 'colors'));
     }
}
