<?php

namespace App\Http\Controllers;

use App\Models\BillPayment;
use App\Models\Bills;
use App\Models\DocumentRequest;
use App\Models\Event;
use App\Models\Reimbursement;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FamilyMemberController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $userId = Auth::id();

        // Find tenant record where logged-in user is a child
        $tenant = Tenant::where('child_id', $userId)->first();

        // 📂 Total Documents
        // requester_id = uploader, target_user_id = recipient, family_owner_id is from tenant
        $totalDocuments = DocumentRequest::where(function ($q) use ($userId, $tenant) {
            $q->where('requester_id', $userId);

            if ($tenant) {
                $q->orWhere('family_owner_id', $tenant->owner_id);
            }

            $q->orWhere('target_user_id', $userId);
        })
            ->count();

        // 💳 Bills
        $totalBills   = Bills::where('assigned_to', $userId)->count();
        $pendingBills = Bills::where('assigned_to', $userId)->where('status', 'pending')->count();
        $paidBills    = Bills::where('assigned_to', $userId)->where('status', 'approved')->count();
        $declinedBills = Bills::where('assigned_to', $userId)->where('status', 'declined')->count();

        // 💵 Contributions This Month
        $contributionsThisMonth = BillPayment::where('payer_id', $userId)
            ->whereMonth('created_at', now()->month)
            ->sum('amount_paid');

        // 🧾 Reimbursements
        $reimbursements = Reimbursement::where('family_member_id', $userId)->count();

        // 📊 For Charts
        $billStatus = [
            'paid'    => $paidBills,
            'pending' => $pendingBills,
            'declined' => $declinedBills,
        ];

        // 📈 Contributions Over Time (last 6 months)
        $contributions = BillPayment::where('payer_id', $userId)
            ->selectRaw('MONTH(created_at) as month, SUM(amount_paid) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total', 'month');

        // 📑 Recent Bills
        $recentBills = Bills::where('assigned_to', $userId)->latest()->take(5)->get();

        // 📑 Recent Contributions
        $recentContributions = BillPayment::where('payer_id', $userId)->latest()->take(5)->get();

        // 📅 Upcoming Events (vacations/outings assigned to this user)
        // $upcomingEvents = Event::whereHas('participants', function ($q) use ($userId) {
        //     $q->where('user_id', $userId);
        // })
        //     ->whereDate('start_date', '>=', now())
        //     ->take(5)
        //     ->get();


        return view('family_member.index', compact(
            'totalDocuments',
            'totalBills',
            'pendingBills',
            'paidBills',
            'contributionsThisMonth',
            'reimbursements',
            'billStatus',
            'contributions',
            'recentBills',
            'recentContributions',
            // 'upcomingEvents'
        ));
        // return view('family_member.index');
    }
}
