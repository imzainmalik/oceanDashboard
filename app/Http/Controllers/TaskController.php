<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
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
        $tasks = Task::with(['owner', 'assignee'])
            ->where('is_deleted', 0)
            ->where('owner_id', auth()->user()->id)
            ->orwhere('assignee_id', auth()->user()->id)
            ->orwhere('assignee_id', null)
            ->get();
        // dd($tasks); 

        if ($request->ajax()) {
            return DataTables::of($tasks)
                ->addColumn('name', function ($row) {
                    $user = $row->assignee ?? $row->owner;
                    $image = $user && $user->profile_image
                        ? asset('display_picture/' . $user->profile_image)
                        : asset('family_owner/assets/images/user_not_found.png');
                    $name = $user?->name ?? 'N/A';

                    return '
                <div class="d-flex align-items-center">
                    <img src="' . $image . '" class="rounded-circle me-2" width="40" height="40" alt="User">
                    <span>' . e($name) . '</span>
                </div>';
                })

                ->addColumn('task', fn($row) => '<strong>' . e(ucfirst($row->title ?? '-')) . '</strong>')

                ->addColumn('assigned_on', fn($row) => Carbon::parse($row->created_at)->format('m-d-Y'))

                ->addColumn('status', function ($row) {
                    $colorMap = [
                        'accepted' => 'green',
                        'declined' => 'red',
                        'unread' => 'purple',
                        'seen/no-response' => 'orange',
                    ];
                    $color = $colorMap[strtolower($row->status)] ?? 'gray';
                    return '<span style="color:' . $color . '; font-weight:500;">' . ucwords($row->status) . '</span>';
                })

                ->addColumn('actions', function ($row) {
                    $btns = '';

                    $btns .= '<li><a class="dropdown-item" href="' . route('familyOwner.tasks.show', $row->id) . '">View</a></li>';

                    if (auth()->user()->role->id == 4) {
                        $btns .= '<li><a class="dropdown-item" href="' . route('familyOwner.tasks.edit', $row->id) . '">Edit</a></li>';
                        $btns .= '<li>
                                    <form action="' . route('familyOwner.tasks.destroy', $row->id) . '" method="POST" id="delete_' . $row->id . '">
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

                ->rawColumns(['name', 'task', 'status', 'assigned_on', 'actions'])
                ->make(true);
        }


        return view('tasks.index', compact('tasks'));
    }

    public function create()
    {
        $tenant = Tenant::where('owner_id', auth()->user()->id)->pluck('child_id')->toArray();
        $users = User::whereIn('id', $tenant)->get();
        // dd($users);
        return view('tasks.create', compact('users'));
    }

    public function store(Request $request)
    {
        check_pemission('tasks_insert', auth()->user()->role_id);
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
            'details' => $request->description,
            'status' => 'pending',
        ]);

        $assignee_details = User::find($request->assignee_id);

        return redirect()->route('familyOwner.tasks.index')->with('success', 'Task created successfully!');
    }

    public function show(Task $task)
    {
        // check_pemission('tasks_show', auth()->user()->role_id);
        $task->load('owner', 'assignee', 'comments.user');

        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task)
    {
        $tenants = Tenant::where('owner_id', auth()->user()->id)->get();
        // $users = User::where('');

        return view('tasks.edit', compact('task', 'tenants'));
    }

    public function update(Request $request, Task $task)
    {
        check_pemission('tasks_update', auth()->user()->role_id);
        // dd($request->all());
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:medical,non-medical',
            'details' => 'nullable|string',
            // 'status' => 'required|in:pending,in_progress,completed',
        ]);

        $task->update($request->only(['title', 'type', 'assignee_id', 'details', 'status']));
        $assignee_details = User::find($request->assignee_id);


        make_log(auth()->user()->id, auth()->user()->name, "Task updated", " " . auth()->user()->name . " Updated Task for" . $assignee_details->name . " ");

        return redirect()->route('familyOwner.tasks.index')->with('success', 'Task updated successfully!');
    }

    public function destroy($task)
    {
        check_pemission('tasks_delete', auth()->user()->role_id);
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
