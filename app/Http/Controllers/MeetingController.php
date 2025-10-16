<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use App\Services\ZoomService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;

class MeetingController extends Controller
{
    public function index(Request $request)
    {
        // check_pemission('meetings_show', auth()->user()->role_id);
        $meetings = Meeting::where('senior_id', auth()->id())->latest();
        if ($request->ajax()) {
            $meetings = Meeting::where('senior_id', auth()->id())->latest();

            return DataTables::of($meetings)
                ->addColumn('topic', fn($row) => e($row->topic ?? '-'))
                ->addColumn('start_time', fn($row) => $row->start_time ? Carbon::parse($row->start_time)->format('d M Y h:i A') : '-')
                ->addColumn('status', function ($row) {
                    $badgeClass = match (strtolower($row->status)) {
                        'completed' => 'success',
                        'pending' => 'warning',
                        'cancelled' => 'danger',
                        default => 'secondary'
                    };
                    return '<span class="badge bg-' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
                })
                ->addColumn('links', function ($row) {
                    $join = $row->join_url ? '<a href="' . e($row->join_url) . '" target="_blank" class="btn btn-sm btn-primary me-1">Join</a>' : '';
                    $start = $row->start_url ? '<a href="' . e($row->start_url) . '" target="_blank" class="btn btn-sm btn-success">Start</a>' : '';
                    return $join . $start;
                })
                ->addColumn('is_active', fn($row) => $row->is_active ? '<span class="badge bg-success">Yes</span>' : '<span class="badge bg-danger">No</span>')
                ->addColumn('actions', function ($row) {
                    $viewUrl = route('senior.meetings.show', $row->id);
                    $editUrl = route('senior.meetings.edit', $row->id);
                    $deleteUrl = route('senior.meetings.destroy', $row->id);
                    $btns = '';

                    if (auth()->user()->role->id == 4) {
                        $btns .= '<li><a class="dropdown-item" href="' . $editUrl . '">Edit</a></li>';
                        $btns .= '<li>
                                    <form action="' . $deleteUrl . '" method="POST" id="delete_' . $row->id . '">
                                        ' . csrf_field() . method_field('DELETE') . '
                                        <button type="submit" class="dropdown-item text-danger" onclick="return confirm(\'Delete this task?\')">Delete</button>
                                    </form>
                                 </li>';

                        return '<div class="btn-group btnIconDetail" style="display:block;">
                                <button class="btn btn-light btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    ' . $btns . '
                                </ul>
                            </div>';
                    } else {
                        return null;
                    }
                })
                ->rawColumns(['status', 'links', 'is_active', 'actions'])
                ->make(true);
        }

        return view('senior.meetings.index', compact('meetings'));
    }

    public function create()
    {
        return view('senior.meetings.create');
    }

    public function store(Request $request, ZoomService $zoom)
    {
        check_pemission('meetings_insert', auth()->user()->role_id);

        $meetingData = $zoom->createMeeting(
            $request->topic,
            $request->start_time,
            $request->duration,
            $request->agenda ?? ''
        );
        // dd($meetingData);
        $lastRecord = Meeting::latest()->first();
        // dd($lastRecord);
        if ($lastRecord != null) {
            Meeting::where('id', $lastRecord->id)->update([
                'is_active' => 1,
            ]);
        }

        //  dd
        Meeting::create([
            'senior_id' => Auth::user()->id,
            'created_by' => Auth::id(),
            'topic' => $request->topic,
            'agenda' => $request->agenda,
            'start_time' => $request->start_time,
            'duration' => $request->duration,
            'zoom_meeting_id' => $meetingData['id'],
            'join_url' => $meetingData['join_url'],
            'start_url' => $meetingData['start_url'],
        ]);

        return redirect()->route('' . auth()->user()->custom_role . '.meetings.index')->with('success', 'Meeting created successfully.');
    }

    public function show(Meeting $meeting)
    {
        check_pemission('meetings_show', auth()->user()->role_id);

        return view('' . auth()->user()->custom_role . '.meetings.show', compact('meeting'));
    }

    public function edit(Meeting $meeting)
    {
        return view('' . auth()->user()->custom_role . '.meetings.edit', compact('meeting'));
    }

    public function update(Request $request, Meeting $meeting)
    {
        check_pemission('meetings_update', auth()->user()->role_id);
        $request->validate([
            'topic' => 'required|string|max:255',
            'agenda' => 'nullable|string',
            'start_time' => 'required|date',
            'duration' => 'required|integer|min:15|max:180',
            'status' => 'required|in:scheduled,cancelled,completed',
        ]);

        $meeting->update($request->all());

        return redirect()->route('' . auth()->user()->custom_role . '.meetings.index')->with('success', 'Meeting updated.');
    }

    public function destroy($meeting)
    {
        check_pemission('meetings_delete', auth()->user()->role_id);
        // $meeting->delete();
        Meeting::where('id', $meeting)->update(array(
            'is_active' => 1
        ));
        return redirect()->route('' . auth()->user()->custom_role . '.meetings.index')->with('success', 'Meeting deleted.');
    }
}
