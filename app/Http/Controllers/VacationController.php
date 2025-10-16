<?php

namespace App\Http\Controllers;

use App\Models\Vacation;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class VacationController extends Controller
{
    public function index()
    {
        // Only events where this family member OR their senior is included
        if (request()->ajax()) {
            $query = Vacation::whereHas('users', function ($q) {
                $q->where('user_id', auth()->id());
            })->select('vacations.*');

            return DataTables::of($query)
                ->addColumn('title', fn($row) => $row->title)
                ->addColumn('type', fn($row) => '<span class="badge bg-info">' . ucfirst($row->type) . '</span>')
                ->addColumn('start_date', fn($row) => \Carbon\Carbon::parse($row->start_date)->format('M d, Y'))
                ->addColumn('end_date', fn($row) => $row->end_date ? \Carbon\Carbon::parse($row->end_date)->format('M d, Y') : '-')
                ->addColumn('action', function ($row) {
                    return '<a href="' . route('familyMember.events.show', $row->id) . '" class="btn btn-sm btn-primary">View</a>';
                })
                ->rawColumns(['type', 'action'])
                ->make(true);
        }

        return view('family_member.vacations.index');
    }

    public function show(Vacation $vacation)
    {
        // Authorize: check if current user is part of this event
        if (! $vacation->users->contains(auth()->id())) {
            abort(403, 'Unauthorized');
        }

        return view('family_member.vacations.show', compact('vacation'));
    }
}
