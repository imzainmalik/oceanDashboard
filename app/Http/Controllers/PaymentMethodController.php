<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\FamilyOwner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PaymentMethodController extends Controller
{
    public function index()
    {
        $ownerId = FamilyOwner::where('owner_id', Auth::id())->value('id');
        $methods = PaymentMethod::where('family_owner_id', $ownerId)->get();
        return view('family_owner.payment_methods.index', compact('methods'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_brand' => 'required|string',
            'card_last_four' => 'required|digits:4',
            'expiry_month' => 'required|digits:2',
            'expiry_year' => 'required|digits:4',
        ]);

        $ownerId = FamilyOwner::where('owner_id', Auth::id())->value('id');

        // Set primary if first card
        $isPrimary = PaymentMethod::where('family_owner_id', $ownerId)->count() == 0;

        PaymentMethod::create([
            'family_owner_id' => $ownerId,
            'card_brand' => $request->card_brand,
            'card_last_four' => $request->card_last_four,
            'expiry_month' => $request->expiry_month,
            'expiry_year' => $request->expiry_year,
            'is_primary' => $isPrimary,
            'gateway_token' => $request->gateway_token ?? null,
        ]);

        return back()->with('success', 'Card added successfully.');
    }

    public function setPrimary($id)
    {
        $ownerId = FamilyOwner::where('owner_id', Auth::id())->value('id');

        PaymentMethod::where('family_owner_id', $ownerId)->update(['is_primary' => false]);

        $method = PaymentMethod::where('family_owner_id', $ownerId)->findOrFail($id);
        $method->update(['is_primary' => true]);

        return back()->with('success', 'Primary card updated.');
    }

    public function destroy($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->delete();
        return back()->with('success', 'Card removed.');
    }
}
