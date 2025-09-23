<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class VotingPoolController extends Controller
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

    
    public function index()
    {
        return view('family_owner.pools.index');
    }

    public function data()
    {
        $query = Pool::where('is_deleted', 0)->with('owner')->withCount('votings')
        ->where('owner_id',auth()->user()->id)->orderByDesc('created_at');

        return DataTables::of($query)
            ->addColumn('owner', fn ($row) => $row->owner?->name ?? '-')
            ->addColumn('votes', fn ($row) => $row->votings_count)
            ->addColumn('status', fn ($row) => ucfirst($row->status))
            ->addColumn('action', function ($row) {
                return '
                    <a href="'.route('familyOwner.pools.show', $row->id).'" class="btn btn-sm btn-primary">View</a>
                    <a href="'.route('familyOwner.pools.edit', $row->id).'" class="btn btn-sm btn-warning">Edit</a>
                    <form method="POST" action="'.route('familyOwner.pools.destroy', $row->id).'" style="display:inline;">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete?\')">Delete</button>
                    </form>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('family_owner.pools.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'voting_expires_at' => 'nullable|date',
        ]);

        Pool::create([
            'owner_id' => auth()->id(),
            'title' => $request->title,
            'description' => $request->description,
            'voting_expires_at' => $request->voting_expires_at,
        ]);

        make_log(auth()->user()->id, auth()->user()->name, 'Created Pool', ' '.auth()->user()->name.' Created Pool');

        return redirect()->route('familyOwner.pools.index')->with('success', 'Pool created successfully.');
    }

    public function show(Pool $voting)
    {
        $voting->load('votings.user', 'comments.user', 'comments.replies', 'owner', 'finalDecisionBy');

        // dd($voting);
        return view('family_owner.pools.show', compact('voting'));
    }

    public function edit(Pool $voting)
    {
        return view('family_owner.pools.create', compact('voting'));
    }

    public function update(Request $request, $pool)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'voting_expires_at' => 'nullable|date',
            'status' => 'nullable|in:open,closed,final_decision',
        ]);
         Pool::where('id', $pool)->update(array(
            'title' => $request->title, 
            'description' => $request->description, 
            'voting_expires_at' => $request->voting_expires_at, 
            // 'status' => $request->status
         ));
        // $pool->update($request->only(['title', 'description', 'voting_expires_at', 'status']));
        make_log(auth()->user()->id, auth()->user()->name, 'Updated Pool', ' '.auth()->user()->name.' Updated Pool');

        return redirect()->route('familyOwner.pools.index')->with('success', 'Pool updated successfully.');
    }

    public function destroy($pool)
    {
        Pool::where('id', $pool)->update(array(
            'is_deleted' => 1
        ));
        make_log(auth()->user()->id, auth()->user()->name, 'Pool deleted', ' '.auth()->user()->name.' Pool deleted');

        return redirect()->route('familyOwner.pools.index')->with('success', 'Pool deleted successfully.');
    }

    public function finalize(Request $request, $pool)
    {
        $request->validate(['final_decision_notes' => 'required|string']);
        $pool_details = Pool::where('id', $pool)->first();

        if (auth()->id() !== $pool_details->owner_id && auth()->user()->role->name !== 'familyOwner') {
            abort(403, 'Unauthorized');
        }

        Pool::where('id', $pool)->update([
            'status' => 'final_decision',
            'final_decision_by' => auth()->id(),
            'final_decision_notes' => $request->final_decision_notes,
        ]);

        make_log(auth()->user()->id, auth()->user()->name, 'Took final Decision', ' '.auth()->user()->name.' Took final Decision');

        return back()->with('success', 'Final decision has been recorded.');
    }
}
