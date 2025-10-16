<?php

namespace App\Http\Controllers;

use App\Models\FamilyNote;
use App\Models\FamilyOwner;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class FamilyNoteController extends Controller
{
    public function index(Request $request)
    {
        $tenant = Tenant::where('child_id', auth()->user()->id)->first();
        // dd($tenant);
        if ($tenant != null) {
            $ownerId = User::where('id', $tenant->owner_id)->value('id');
        } else {
            $ownerId = auth()->user()->id;
        }
        // dd($ownerId);
        $notes = FamilyNote::where('family_owner_id', $ownerId)->latest()->get();
        
         if ($request->ajax()) { 
            return DataTables::of($notes)
                ->addColumn('title', fn($row) => $row->title)
                ->addColumn('type', fn($row) => ucfirst($row->type))
                ->addColumn('created_at', fn($row) => $row->created_at->format('d M Y'))
                ->addColumn('actions', function ($row) {
                    $role = auth()->user()->custom_role;
    
                    $viewUrl = route("{$role}.family-notes.show", $row);
                    $editUrl = route("{$role}.family-notes.edit", $row);
                    $deleteUrl = route("{$role}.family-notes.destroy", $row);
    
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
                ->rawColumns(['actions']) // allow HTML for buttons
                ->make(true);
        }
        return view('family_owner.family_notes.index', compact('notes'));
    }

    public function create()
    {
        return view('family_owner.family_notes.create');
    }

    public function store(Request $request)
    {
        // check_pemission('family_notes_insert', auth()->user()->role_id);    
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:note,feedback',
            // 'visibility' => 'required|in:private,family',
        ]);

        $tenant = Tenant::where('child_id', auth()->user()->id)->first();

        if ($tenant != null) {
            $ownerId = $tenant->owner_id;
        } else {
            $ownerId = auth()->user()->id;
        }

        FamilyNote::create([
            'family_member_id' => auth()->user()->id,
            'family_owner_id' => $ownerId,
            'title' => $request->title,
            'content' => $request->content,
            'type' => $request->type,
            'visibility' => 'family',
        ]);

        return redirect()->route('' . auth()->user()->custom_role . '.family-notes.index')->with('success', 'Note created successfully.');
    }

    public function show(FamilyNote $familyNote)
    {
        check_pemission('family_notes_show', auth()->user()->role_id);

        return view('family_owner.family_notes.show', compact('familyNote'));
    }

    public function edit(FamilyNote $familyNote)
    {
        
        return view('family_owner.family_notes.create', compact('familyNote'));
    }

    public function update(Request $request, FamilyNote $familyNote)
    {
        // check_pemission('family_notes_update', auth()->user()->role_id);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'type' => 'required|in:note,feedback',
            // 'visibility' => 'required|in:private,family',
        ]);

        $familyNote->update($request->all());

        return redirect()->route('' . auth()->user()->custom_role . '.family-notes.index')->with('success', 'Note updated successfully.');
    }

    public function destroy(FamilyNote $familyNote)
    {
        $familyNote->delete();
        return redirect()->route('' . auth()->user()->custom_role . '.family-notes.index')->with('success', 'Note deleted successfully.');
    }
}
