<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
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

    
    public function index(Request $request)
    {
        // dd(auth()->user()->id);
    $tasks = Task::with(['owner','assignee'])
        ->where('is_deleted', 0)
        ->where('owner_id', auth()->user()->id)
        ->orwhere('assignee_id', auth()->user()->id) 
        ->get();
        // dd($tasks);
        if ($request->ajax()) {
            return DataTables::of($tasks)
                ->addColumn('owner', fn ($row) => $row->owner?->name ?? '-')
                ->addColumn('assignee', fn ($row) => $row->assignee?->name ?? '-')
                ->addColumn('status', fn ($row) => '<span class="badge bg-secondary">'.ucfirst($row->status).'</span>')
                ->addColumn('actions', function ($row) {
                    return '
                    <a href="'.route('familyOwner.tasks.show', $row->id).'" class="btn btn-sm btn-info">View</a>
                    <a href="'.route('familyOwner.tasks.edit', $row->id).'" class="btn btn-sm btn-warning">Edit</a>
                    <form action="'.route('familyOwner.tasks.destroy', $row->id).'" method="POST" style="display:inline;">
                        '.csrf_field().method_field('DELETE').'
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm(\'Delete this task?\')">Delete</button>
                    </form>
                ';
                })
                ->rawColumns(['status', 'actions', 'owner', 'assignee'])
                ->make(true);
        }

        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $tenant = Tenant::where('owner_id', auth()->user()->id)->first();

        $users= User::where('id',$tenant->child_id)->get();
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:medical,non-medical',
            'assignee_id' => 'required|exists:users,id',
            'details' => 'nullable|string',
        ]);

        Task::create([
            'owner_id' => auth()->id(),
            'assignee_id' => $request->assignee_id,
            'title' => $request->title,
            'type' => $request->type,
            'details' => $request->details,
            'status' => 'pending',
        ]);

        $assignee_details = User::find($request->assignee_id);

        make_log(auth()->user()->id, auth()->user()->name, "Task created", " " . auth()->user()->name . " Created Task for" . $assignee_details->name . " ");

        return redirect()->route('familyOwner.tasks.index')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        $task->load('owner', 'assignee', 'comments.user');

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $users = User::all();

        return view('tasks.edit', compact('task', 'users'));
    }

    public function update(Request $request, Task $task)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'type' => 'required|in:medical,non-medical',
        //     'details' => 'nullable|string',
        //     'status' => 'required|in:pending,in_progress,completed',
        // ]);

        $task->update($request->only(['title', 'type', 'assignee_id', 'details', 'status']));
        $assignee_details = User::find($request->assignee_id);

        
        make_log(auth()->user()->id, auth()->user()->name, "Task updated", " " . auth()->user()->name . " Updated Task for" . $assignee_details->name . " ");

        return redirect()->route('familyOwner.tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy($task)
    {
        // $task->delete();
        $task_details = Task::find($task);
        $task = Task::where('id', $task)->update(array(
            'is_deleted' => 1
        ));

        make_log(auth()->user()->id, auth()->user()->name, "Task Deleted", " " . auth()->user()->name . " Deleted Task for" . $task_details->assignee->name . " ");

        return redirect()->route('familyOwner.tasks.index')->with('success', 'Task deleted!');
    }

    public function comment_store(Request $request, Task $task)
    {
        // dd($request->all());
        $user = auth()->user();

        if (! in_array($user->role->name, ['familyOwner']) && $user->id !== $task->assignee_id) {
            return abort(403, 'You are not allowed to comment on this task.');
        }

        $request->validate([
            'message' => 'required|string|max:500',
            'parent_id' => 'nullable|exists:task_comments,id',
        ]);

        $task->comments()->create([
            'user_id' => $user->id,
            'message' => $request->message,
            'parent_id' => (int)$request->parent_id,
        ]);
        make_log(auth()->user()->id, auth()->user()->name, "Comment on task", " " . auth()->user()->name . " Commented on Task for ");

        return back()->with('success', 'Comment added!');
    }
}
