<?php

namespace App\Http\Controllers;

use App\Models\Bill;
use App\Models\Bills;
use App\Models\Tenant;
use Illuminate\Http\Request;

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
        $bills = Bills::with(['assignee', 'payments'])->where('owner_id', auth()->id())->latest()->get();

        // dd($bills);
        return view('family_owner.bills.index', compact('bills'));
    }

    /**
     * Show bill creation form.
     */
    public function create()
    {
        // family members who can be assigned to pay
        $members = Tenant::where('owner_id', auth()->user()->id)
            ->get();

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

        Bills::create([
            'owner_id' => auth()->id(),
            'assigned_to' => $request->assigned_to,
            'title' => $request->title,
            'amount' => $request->amount,
            'details' => $request->details,
            'type' => $request->type,
            'status' => 'pending',
            'payment_method' => $request->payment_method,
        ]);
        dd($request->all());

        return redirect()->route('familyOwner.bills.index')->with('success', 'Bill created successfully.');
    }

    /**
     * Show a single bill with payments.
     */
    public function show($id)
    {
        $bill = Bills::with(['assignee', 'owner', 'payments.payer'])->findOrFail($id);

        // only owner or assignee can view full details
        if (auth()->id() !== $bill->owner_id && auth()->id() !== $bill->assigned_to) {
            abort(403, 'Unauthorized access');
        }

        return view('family_owner.bills.show', compact('bill'));
    }

    /**
     * Edit bill (only owner).
     */
    public function edit($id)
    {
        $bill = Bills::findOrFail($id);
        if (auth()->id() !== $bill->owner_id) {
            abort(403);
        }

        $members = \App\Models\User::where('account_status', 1)->get();

        return view('family_owner.bills.edit', compact('bill', 'members'));
    }

    /**
     * Update bill.
     */
    public function update(Request $request, $id)
    {
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
        $bill = Bills::findOrFail($id);

        if (auth()->id() !== $bill->owner_id) {
            abort(403);
        }

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
