<?php

namespace App\Http\Controllers;

use App\Models\Bills;
use App\Models\Reimbursement;
use App\Models\Tenant;
use Illuminate\Http\Request;

class ReimbursementController extends Controller
{
    public function index()
    {

        $reimbursements = Reimbursement::where('family_member_id', auth()->id())
            ->with('bill')
            ->latest()
            ->get();

        return view('family_member.reimbursements.index', compact('reimbursements'));
    }

    public function create()
    {
        $tenant = Tenant::where('child_id', auth()->user()->id)->first();
        $bills = Bills::where('owner_id', $tenant->owner_id)->get();
        return view('family_member.reimbursements.create', compact('bills'));
    }

    public function store(Request $request)
    {
        // if (!auth()->user()->hasPermission('reimbursements_insert') || auth()->user()->check_if_owner == 4) abort(403);
        check_pemission('reimbursements_insert', auth()->user()->role_id);

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'bill_id' => 'nullable|exists:bills,id',
            'reason' => 'nullable|string|max:255',
        ]);

        Reimbursement::create([
            'family_member_id' => auth()->id(),
            'bill_id' => $request->bill_id,
            'amount' => $request->amount,
            'reason' => $request->reason,
            'status' => 'pending',
        ]);
        $tenant = Tenant::where('child_id', auth()->user()->id)->first();

        make_log($tenant->owner_id, auth()->user()->name, 'Added Reimbursement', ' ' . auth()->user()->name . ' Added Reimbursement Request for ' . $request->amount . ' ');

        return redirect()->route('familyMember.reimbursment.index')
            ->with('success', 'Reimbursement request submitted successfully.');
    }

    public function show(Reimbursement $reimbursement)
    {
        // if (!auth()->user()->hasPermission('reimbursements_show') || auth()->user()->check_if_owner == 4) abort(403);
        check_pemission('reimbursements_show', auth()->user()->role_id);

        $this->authorizeOwner($reimbursement);
        return view('family_member.reimbursements.show', compact('reimbursement'));
    }

    public function edit(Reimbursement $reimbursement)
    {

        $this->authorizeOwner($reimbursement);
        $tenant = Tenant::where('child_id', auth()->user()->id)->first();
        $bills = Bills::where('owner_id', $tenant->owner_id)->get();

        return view('family_member.reimbursements.edit', compact('reimbursement', 'bills'));
    }

    public function update(Request $request, Reimbursement $reimbursement)
    {
        // if (!auth()->user()->hasPermission('reimbursements_update') || auth()->user()->check_if_owner == 4) abort(403);
        check_pemission('reimbursements_update', auth()->user()->role_id);

        $this->authorizeOwner($reimbursement);

        $request->validate([
            'amount' => 'required|numeric|min:1',
            'bill_id' => 'nullable|exists:bills,id',
            'reason' => 'nullable|string|max:255',
        ]);

        $reimbursement->update([
            'bill_id' => $request->bill_id,
            'amount' => $request->amount,
            'reason' => $request->reason,
        ]);

        return redirect()->route('familyMember.reimbursment.index')
            ->with('success', 'Reimbursement request updated successfully.');
    }

    public function destroy(Reimbursement $reimbursement)
    {
        // if (!auth()->user()->hasPermission('reimbursements_delete') || auth()->user()->check_if_owner == 4) abort(403);
        check_pemission('reimbursements_delete', auth()->user()->role_id);

        $this->authorizeOwner($reimbursement);
        $reimbursement->delete();

        return redirect()->route('familyMember.reimbursment.index')
            ->with('success', 'Reimbursement request deleted.');
    }

    private function authorizeOwner(Reimbursement $reimbursement)
    {
        if ($reimbursement->family_member_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }
    }
}
