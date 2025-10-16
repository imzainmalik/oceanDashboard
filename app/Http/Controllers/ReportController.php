<?php

namespace App\Http\Controllers;

use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ReportController extends Controller
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
        // check_pemission('reports_show', auth()->user()->role_id);

        if ($request->ajax()) {
            $ownerId = auth()->id();

            // Get users under this owner (family members + assignees)
            $users = User::withCount([
                'tasks as total_tasks' => fn ($q) => $q->where('owner_id', $ownerId),
                'tasks as completed_tasks' => fn ($q) => $q->where('owner_id', $ownerId)->where('status', 'completed'),
                'tasks as pending_tasks' => fn ($q) => $q->where('owner_id', $ownerId)->where('status', 'pending'),
                'tasks as cancelled_tasks' => fn ($q) => $q->where('owner_id', $ownerId)->where('status', 'cancelled'),
            ])->whereHas('tasks', fn ($q) => $q->where('owner_id', $ownerId));

            return DataTables::of($users)
                ->filterColumn('member', function($query, $keyword) {
                    $query->where('name', 'like', "%{$keyword}%");
                })
                ->addColumn('member', fn ($row) => $row->name)
                ->addColumn('total_tasks', fn ($row) => $row->total_tasks)
                ->addColumn('completed_tasks', fn ($row) => "<span class='badge bg-success'>{$row->completed_tasks}</span>")
                ->addColumn('pending_tasks', fn ($row) => "<span class='badge bg-warning'>{$row->pending_tasks}</span>")
                ->addColumn('cancelled_tasks', fn ($row) => "<span class='badge bg-danger'>{$row->cancelled_tasks}</span>")
                ->rawColumns(['completed_tasks', 'pending_tasks', 'cancelled_tasks'])
                ->make(true);
        }

        return view('family_owner.report.index');

    }

    public function monthly_report(Request $request)
    {
        $startOfMonth = \Carbon\Carbon::parse($request->start_date)->startOfDay();
        $endOfMonth = \Carbon\Carbon::parse($request->end_date)->endOfDay();

        if ($request->has('start_date') && $request->has('end_date')) {
            $ownerId = auth()->id(); // current logged-in family owner

            $report = \App\Models\User::withCount([
                'tasks as total_tasks' => fn ($q) => $q->where('owner_id', $ownerId)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth]),

                'tasks as completed_tasks' => fn ($q) => $q->where('owner_id', $ownerId)
                    ->where('status', 'completed')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth]),

                'tasks as pending_tasks' => fn ($q) => $q->where('owner_id', $ownerId)
                    ->where('status', 'pending')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth]),

                'tasks as cancelled_tasks' => fn ($q) => $q->where('owner_id', $ownerId)
                    ->where('status', 'cancelled')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth]),
            ])
                ->whereHas('tasks', fn ($q) => $q->where('owner_id', $ownerId)
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth]))
                ->get();
        }
        // dd($monthStart->format('m-d-Y'), $monthEnd->format('m-d-Y'));
        //  dd($report->count());
        // return $pdf->download('monthly_summary_'.now()->subMonth()->format('F_Y').'.pdf');
        // return view('family_owner.report.report_pdf', compact('report'));
        // dd($request->all());
        if ($request->has('member')) {
            // dd($request->has('member'));
            $memberIds = $request->member; // array of IDs

            $report = \App\Models\User::withCount([
                'tasks as total_tasks' => fn ($q) => $q->whereBetween('created_at', [$startOfMonth, $endOfMonth]),
                'tasks as completed_tasks' => fn ($q) => $q->where('status', 'completed')->whereBetween('created_at', [$startOfMonth, $endOfMonth]),
                'tasks as pending_tasks' => fn ($q) => $q->where('status', 'pending')->whereBetween('created_at', [$startOfMonth, $endOfMonth]),
                'tasks as cancelled_tasks' => fn ($q) => $q->where('status', 'cancelled')->whereBetween('created_at', [$startOfMonth, $endOfMonth]),
            ])
                ->whereHas('tasks', fn ($q) => $q->where('assignee_id', $memberIds))
                ->get();
            // dd($report);
        } 
        $pdf = Pdf::loadView('family_owner.report.report_pdf', compact('report'));

        return $pdf->download('monthly_task_summary_'.Carbon::parse(request('start_date'))->format('F d, Y').'_to_'.Carbon::parse(request('end_date'))->format('F d, Y').'.pdf');

    }
}
