<?php

namespace App\Http\Controllers;

use App\Models\Pool;
use App\Models\Tenant;
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
        // dd(auth()->user()->id);
        return view('family_owner.pools.index');
    }

    public function data()
    {
        $tenant = Tenant::where('child_id', auth()->user()->id)->first();

        if ($tenant != null) {
            $query = Pool::where('is_deleted', 0)->with('owner')->withCount('votings')
                ->where('owner_id', $tenant->owner_id)->orderByDesc('created_at');
            // dd($query);
        } else {
            $query = Pool::where('is_deleted', 0)->with('owner')->withCount('votings')
                ->where('owner_id', auth()->user()->id)->orderByDesc('created_at');
        }
        return DataTables::of($query)
            ->addColumn('owner', fn($row) => $row->owner?->name ?? '-')
            ->addColumn('votes', fn($row) => $row->votings_count)
            ->addColumn('status', fn($row) => ucfirst($row->status))
            ->addColumn('action', function ($row) {
 
                
                
                 $role = auth()->user()->custom_role;
    
                    $viewUrl = route("{$role}.pools.show", $row->id);
                    $editUrl = route("{$role}.pools.edit", $row->id);
                    $deleteUrl = route("{$role}.pools.destroy", $row->id);
    
                    // return '
                    //     <a href="' . $viewUrl . '" class="btn btn-info btn-sm">View</a>
                    //     <a href="' . $editUrl . '" class="btn btn-warning btn-sm">Edit</a>
                    //     <form action="' . $deleteUrl . '" method="POST" style="display:inline-block;">
                    //         ' . csrf_field() . method_field('DELETE') . '
                    //         <button class="btn btn-danger btn-sm" onclick="return confirm(\'Delete this note?\')">Delete</button>
                    //     </form>
                    // ';
                    
                      $btns = '';

                    $btns .= '<li><a class="dropdown-item" href="' . $viewUrl . '">View</a></li>';

                    if (auth()->user()->role->id == 4) {
                        $btns .= '<li><a class="dropdown-item" href="' . $editUrl . '">Edit</a></li>';
                        $btns .= '<li>
                                    <form action="' . $deleteUrl . '" method="POST" id="delete_' . $row->id . '">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Delete this task?\')">Delete</button>
                                    </form>
                                 </li>';
                    }

                    return '<div class="btn-group btnIconDetail" style="display:block;">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    ' . $btns . '
                                </ul>
                            </div>';
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

        make_log(auth()->user()->id, auth()->user()->name, 'Created Pool', ' ' . auth()->user()->name . ' Created Pool');

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
        make_log(auth()->user()->id, auth()->user()->name, 'Updated Pool', ' ' . auth()->user()->name . ' Updated Pool');

        return redirect()->route('familyOwner.pools.index')->with('success', 'Pool updated successfully.');
    }

    public function destroy($pool)
    {
        Pool::where('id', $pool)->update(array(
            'is_deleted' => 1
        ));
        make_log(auth()->user()->id, auth()->user()->name, 'Pool deleted', ' ' . auth()->user()->name . ' Pool deleted');

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

        make_log(auth()->user()->id, auth()->user()->name, 'Took final Decision', ' ' . auth()->user()->name . ' Took final Decision');

        return back()->with('success', 'Final decision has been recorded.');
    }
}
