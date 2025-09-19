<?php

namespace App\Http\Controllers;

use App\Models\Bills;
use App\Models\Senior;
use App\Models\Task;

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

        $requests = Task::with(['assignee'])
            ->where('owner_id', auth()->id())
            ->latest()
            ->take(5) // latest 5
            ->get();

        $assignedRoles = Task::with(['assignee'])
            ->where('owner_id', auth()->id())
            ->orderBy('created_at', 'desc')
            ->get();

        // $notes = FamilyNote::where('owner_id', auth()->id())
        // ->latest()
        // ->get();
        $bills = Bills::with(['assignee'])
            ->where('owner_id', auth()->id())
            ->latest()
            ->get();

        return view('family_owner.index', get_defined_vars());
    }
}
