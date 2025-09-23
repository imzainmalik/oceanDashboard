<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\Tenant;
use App\Models\TimelineLog;
use Illuminate\Support\Facades\Auth;

class DailyUpdateController extends Controller
{
    public function index()
    {
        $seniorId = Auth::user()->id;

        $tenant = Tenant::where('child_id', $seniorId)->first();
        // Care logs for this senior
        $careLogs = TimelineLog::where('family_owner_id', $tenant->owner_id)
            ->orderBy('created_at', 'desc')
            ->get();

        // Requests & responses for this senior
        $requests = Task::where('assignee_id', $seniorId)
            ->orderBy('created_at', 'desc')
            ->get();

        // Merge into a single collection (optional)
        $updates = collect();

        foreach ($careLogs as $log) {
            $updates->push([
                'type' => 'care_log',
                'title' => $log->name,
                'description' => $log->action_desc ?? '',
                'date' => $log->created_at,
                'created_at' => $log->created_at,
                'status' => 'completed',
            ]);
        }

        foreach ($requests as $task) {
            $updates->push([
                'type' => 'request',
                'title' => $task->title,
                'description' => $task->description ?? '',
                'date' => $task->created_at,
                'status' => $task->status,
                'created_at' => $task->created_at,
            ]);
        }

        // Sort by date
        $updates = $updates->sortByDesc('date');

        // dd(colors());
        return view('senior.daily_updates.index', compact('updates'));
    }
}
