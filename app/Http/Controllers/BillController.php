<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\BillPayment;
use App\Models\Bills;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BillController extends Controller
{
    /**
     * Show all bills (owner’s dashboard).
     */

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

        $tenant = Tenant::where('child_id', auth()->user()->id)->first();
        if ($tenant == null) {
            $bills = Bills::with(['assignee', 'payments'])->where('owner_id', auth()->user()->id)
                ->orwhere('assigned_to', auth()->id())->latest()->get();
        } else {
            $bills = Bills::with(['assignee', 'payments'])->where('owner_id', $tenant->owner_id)->latest()->get();
        }


        // dd($bills);
        return view('family_owner.bills.index', compact('bills'));
    }

    /**
     * Show bill creation form.
     */
    public function create()
    {
        // if (!auth()->user()->hasPermission('bills_insert') || auth()->user()->check_if_owner == 4) abort(403);
        // family members who can be assigned to pay
        // check_pemission('bills_insert', auth()->user()->role_id);
        $tenant = Tenant::where('child_id', auth()->user()->id)
            ->first();

            if($tenant == null){
                $members = Tenant::where('owner_id', auth()->user()->id)->get();
            }else{
                $members = Tenant::where('owner_id', $tenant->owner_id)->get();
            }

        // dd($members);
        return view('family_owner.bills.create', compact('members'));
    }

    /**
     * Store new bill request.
     */
    public function store(Request $request)
    {
        // $request->validate([
        //     'title' => 'required|string|max:255',
        //     'amount' => 'required|numeric|min:0',
        //     'assigned_to' => 'required|exists:users,id',
        //     'details' => 'nullable|string',
        //     'type' => 'required|in:medical,non-medical',
        // ]);
        check_pemission('bills_insert', auth()->user()->role_id);

        // if (!auth()->user()->hasPermission('bills_update') || auth()->user()->check_if_owner == 4) abort(403);
         $tenant = Tenant::where('child_id', auth()->user()->id)->first();
        if ($tenant == null) {
            $owner_id = auth()->user()->id;
        }else{
            $owner_id = $tenant->owner_id;
        }
        Bills::create([
            'owner_id' => $owner_id,
            'assigned_to' => $request->assigned_to,
            'title' => $request->title,
            'amount' => $request->amount,
            'details' => $request->details,
            'type' => $request->type,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);
        // dd($request->all());

        return redirect()->route('' . auth()->user()->role->name . '.bills.index')->with('success', 'Bill created successfully.');
    }

    public function submitPayment(Request $request, Bills $bill)
    {
        // check permission
        // if (!auth()->user()->hasPermission('bill_payments_insert') || auth()->user()->check_if_owner == 4) abort(403);
        check_pemission('bill_payments_insert', auth()->user()->role_id);
 
        //  dd(Auth::user()->permissions);
        $validated = $request->validate([
            'amount' => 'required|numeric|min:1',
            'payment_method' => 'required|string|max:255',
            'transaction_id' => 'nullable|string|max:255',
        ]);

        if ($request->hasFile('receipt')) {
            $attechment = $request->file('receipt');
            $img_2 = time() . $attechment->getClientOriginalName();
            $attechment->move(public_path('payment_proof'), $img_2);
        } else {
            $img_2 = null;
        }

        // dd($bill);
        // create new payment record
        $payment = BillPayment::create([
            'bills_id' => $bill->id,
            'payer_id' => Auth::user()->id,
            'amount_paid' => $validated['amount'],
            'payment_method' => $validated['payment_method'],
            'confirmation_number' => $validated['transaction_id'] ?? null,
            'receipt_path' => $img_2,
            'status' => 0, // waiting for admin/family approval
        ]);

        return back()->with('success', 'Payment submitted successfully and is pending review.');
    }

    public function reviewPayment(Request $request, BillPayment $payment)
    {
        // only FamilyOwner/Admin should review — add guard
        if (! Auth::user()->hasRole('familyOwner') && ! Auth::user()->hasRole('admin')) {
            abort(403, 'Not allowed to review payments');
        }

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'review_notes' => 'nullable|string|max:1000',
        ]);

        $payment->update([
            'status' => $validated['status'],
            'reviewed_by' => Auth::id(),
            'review_notes' => $validated['review_notes'] ?? null,
        ]);

        // auto update bill status if approved
        if ($validated['status'] === 'approved') {
            $payment->bill->update(['status' => 'paid']);
        }

        return back()->with('success', 'Payment reviewed successfully.');
    }

    /**
     * Show a single bill with payments.
     */
    public function show($id)
    {
        // if (!auth()->user()->hasPermission('bill_payments_show') || auth()->user()->check_if_owner == 4) abort(403);
        check_pemission('bill_payments_show', auth()->user()->role_id);

        // dd($id);
        $bill = Bills::with(['assignee', 'owner', 'payments.payer'])->findOrFail($id);

        // only owner or assignee can view full details
        // if (auth()->id() !== $bill->owner_id && auth()->id() !== $bill->assigned_to) {
        //     abort(403, 'Unauthorized access');
        // }
        $payments = $bill->payments()->get();


        return view('family_owner.bills.show', compact('bill', 'payments'));
    }

    /**
     * Edit bill (only owner).
     */
    public function edit($id)
    {
        // if (!auth()->user()->hasPermission('bills_update') || auth()->user()->check_if_owner == 4 != null) abort(403);

        $bill = Bills::findOrFail($id);
        // if (auth()->id() !== $bill->owner_id) {
        //     abort(403);
        // }

        $members = \App\Models\User::where('account_status', 1)->get();

        return view('family_owner.bills.edit', compact('bill', 'members'));
    }

    /**
     * Update bill.
     */
    public function update(Request $request, $id)
    {
        // if (!auth()->user()->hasPermission('bills_update') || auth()->user()->check_if_owner == 4) abort(403);
        check_pemission('bills_update', auth()->user()->role_id);
        $bill = Bills::findOrFail($id);

        if (auth()->id() !== $bill->owner_id) {
            abort(403);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'assigned_to' => 'required|exists:users,id',
            'details' => 'nullable|string',
            'type' => 'required|in:medical,non-medical',
        ]);

        $bill->update($request->only('title', 'amount', 'assigned_to', 'details', 'type'));

        return redirect()->route('familyOwner.bills.index')->with('success', 'Bill updated successfully.');
    }

    /**
     * Delete bill (only owner).
     */
    public function destroy($id)
    {
        // if (!auth()->user()->hasPermission('bills_delete') || auth()->user()->check_if_owner == 4) abort(403);
        check_pemission('bills_delete', auth()->user()->role_id);

        $bill = Bills::findOrFail($id);

        // if (auth()->id() !== $bill->owner_id) {
        //     abort(403);
        // }

        $bill->delete();

        return redirect()->route('familyOwner.bills.index')->with('success', 'Bill deleted successfully.');
    }

    public function approve(Bills $bill)
    {
        Bills::where('id', $bill->id)->update(['status' => 'approved']);

        return redirect()->route('familyOwner.bills.index')->with('success', 'Bill approved successfully.');
    }

    // Decline Bill
    public function decline(Bills $bill)
    {
        Bills::where('id', $bill->id)->update(['status' => 'declined']);

        return redirect()->route('familyOwner.bills.index')->with('error', 'Bill declined.');
    }
}
