<?php
// app/Http/Controllers/FamilyMember/ContributionController.php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\BillPayment;
use App\Models\Bills;
use App\Models\Contributions;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ContributionController extends Controller
{
    public function index(Request $request)
    {
        // $contributions = BillPayment::where('payer_id', auth()->id())
        //     ->with('bill')
        //     ->latest()
        //     ->get();

        if ($request->ajax()) {
            $query = BillPayment::with('bill')
                ->select('bill_payments.*')
                ->where('payer_id', auth()->id())
                ->orderBy('bill_payments.created_at', 'desc');

            return DataTables::of($query)
                ->addColumn('bill', function ($row) {
                    return $row->bill?->title ?? 'N/A';
                })
                ->addColumn('amount', function ($row) {
                    return '$' . number_format($row->amount_paid, 2);
                })
                ->addColumn('status', function ($row) {
                    $status = $row->bill?->status ?? 'unknown';
                    $badgeClass = match ($status) {
                        'pending'  => 'bg-warning',
                        'approved' => 'bg-success',
                        'declined' => 'bg-danger',
                        default    => 'bg-secondary',
                    };
                    return '<span class="badge ' . $badgeClass . '">' . ucfirst($status) . '</span>';
                })
                ->addColumn('date', function ($row) {
                    return $row->created_at->format('M d, Y');
                })
                ->addColumn('payment_type', function ($row) {
                    return $row->type == 0 ? 'Contribution' : 'Shortfall';
                })
                ->rawColumns(['status'])
                ->make(true);
        }

        // dd($contributions);
        return view('family_member.contributions.index');
    }

    public function create()
    {
        $tenant = Tenant::where('child_id', auth()->user()->id)->first();
        if ($tenant != null) {
            $bills = Bills::where('owner_id', $tenant->owner_id)->get();
        } else {
            $bills = Bills::where('owner_id', auth()->user()->id)->get();
        }
        return view('family_member.contributions.create', compact('bills'));
    }

    public function store(Request $request)
    {
        // if (!auth()->user()->hasPermission('contributions_insert') || auth()->user()->check_if_owner == 4) abort(403);
        // check_pemission('contributions_insert', auth()->user()->role_id);
        $request->validate([
            'amount' => 'required|numeric|min:1',
            'type'   => 'required|in:0,1',
            'bill_id' => 'nullable|exists:bills,id',
        ]);

        if ($request->hasFile('receipt')) {
            $attechment = $request->file('receipt');
            $img_2 = time() . $attechment->getClientOriginalName();
            $attechment->move(public_path('payment_proof'), $img_2);
        } else {
            $img_2 = null;
        }

        $tenant = Tenant::where('child_id', auth()->user()->id)->first();

        if ($tenant == null) {
            $owner_id = auth()->user()->id;
        } else {
            $owner_id = $tenant->owner_id;
        }
        // dd($bill);
        // create new payment record
        BillPayment::create([
            'bills_id' => $request->bill_id,
            'payer_id' => auth()->user()->id,
            'amount_paid' => $request->amount,
            'payment_method' => $request->payment_method,
            'type' => $request->type,
            'confirmation_number' => $request->transaction_id ?? null,
            'receipt_path' => $img_2,
            'note' => $request->note,
            'status' => 0, // waiting for admin/family approval
        ]);

        if ($request->type == 0) {
            $type = "Contribution";
        } else {
            $type = "Shortfall";
        }
        // return back()->with('success', 'Payment submitted successfully and is pending review.');
        make_log($owner_id, auth()->user()->name, 'Added contribution', ' ' . auth()->user()->name . ' Added contribution ' . $type . ' ');

        return redirect()->route('' . auth()->user()->role->name . '.contribution.index')->with('success', 'Payment submitted successfully and is pending review.');
    }

    public function show(Contributions $contribution)
    {
        // if (!auth()->user()->hasPermission('contributions_show') || auth()->user()->check_if_owner == 4) abort(403);
        // check_pemission('contributions_show', auth()->user()->role_id);

        return view('family_member.contributions.show', compact('contribution'));
    }

    public function destroy(Contributions $contribution)
    {
        if ($contribution->family_member_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $contribution->delete();
        return redirect()->route('familyMember.contribution.index')->with('success', 'Contribution deleted.');
    }
}
