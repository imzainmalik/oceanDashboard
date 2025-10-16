<?php

namespace App\Http\Controllers;

use App\Models\Bills;
use App\Models\FamilyNote;
use App\Models\Senior;
use App\Models\Task;
use App\Models\Tenant;
use App\Models\VoiceJournal;

class FamilyOwnerController extends Controller
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

    public function index()
    {
        $senior = Senior::with('user')
            ->where('family_owner_id', auth()->id())
            ->first();

        if($senior != null){
        
            $voice_notes = VoiceJournal::where('senior_id', $senior->user_id)->latest()->first();
        }else{
            $voice_notes = null;
        }
            


        // $senior = Tenant::where('owner_id', auth()->user()->id)
        // ->with('users', function ($q) {
        //     $q->whereIn('account_status', [0, 1]);
        // })
        // ->first();
        // dd($senior);
        $requests = Task::with(['assignee'])
            ->where('owner_id', auth()->id())
            ->latest()
            ->take(5) // latest 5
            ->get();

        $assignedRoles = Task::with(['assignee'])
            ->where('owner_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        $notes = FamilyNote::where('family_owner_id', auth()->id())
            ->latest()
            ->get();

        $bills = Bills::with(['assignee'])
            ->where('owner_id', auth()->id())
            ->latest()
            ->get();


        // dd($voice_notes);
        return view('family_owner.index', get_defined_vars());
    }
}
