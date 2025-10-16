<?php

namespace App\Http\Controllers;

use App\Models\FamilyOwner;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Customer;
use Stripe\PaymentMethod;
use Stripe\Stripe;

class PaymentMethodController extends Controller
{
    public function index()
    {
        \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));

        $subscriptions = Subscription::where('user_id', auth()->id())->get();
        $allPaymentMethods = collect();
        $customerIds = [];

        foreach ($subscriptions as $sub) {
            $customerId = $sub->stripe_user_id;
            if (!$customerId) continue;

            // Avoid duplicate customer fetch
            if (in_array($customerId, $customerIds)) continue;

            // Fetch all cards linked to this customer
            $paymentMethods = \Stripe\PaymentMethod::all([
                'customer' => $customerId,
                'type' => 'card',
            ]);
            // echo print($paymentMethods);
            foreach ($paymentMethods->data as $method) {
                $allPaymentMethods->push($method);
            }

            $customerIds[] = $customerId;
        }

        // Get default payment method (from the first customer)
        $defaultPaymentMethod = null;
        if (!empty($customerIds)) {
            $customer = \Stripe\Customer::retrieve([
                'id' => $customerIds[0],
                'expand' => ['invoice_settings.default_payment_method'],
            ]);

            $defaultPaymentMethod = $customer->invoice_settings->default_payment_method->id ?? null;
        }
        // dd($allPaymentMethods);
        return view('family_owner.payment_methods.index', [
            'paymentMethods' => $allPaymentMethods->unique('id'),
            'defaultPaymentMethod' => $defaultPaymentMethod,
        ]);
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

    public function setPrimary(Request $request, $id)
    {
        $paymentMethodId = $id;

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // Get all active subscriptions for the logged-in user
        $subscriptions = \App\Models\Subscription::where('user_id', auth()->id())
            ->where('stripe_status', 'active')
            ->get();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));
        foreach ($subscriptions as $sub) {
            $customerId = $sub->stripe_user_id;

            Customer::update($customerId, [
                'invoice_settings' => [
                    'default_payment_method' => $paymentMethodId,
                ],
            ]);

            $stripeSubscriptions = $stripe->subscriptions->all([
                'customer' => $customerId,
                'status' => 'active',
            ]);

            foreach ($stripeSubscriptions->data as $stripeSub) {
                $stripe->subscriptions->update($stripeSub->id, [
                    'default_payment_method' => $paymentMethodId,
                ]);
            }
        }

        return back()->with('success', 'Primary card updated.');
    }

    public function destroy($id)
    {
        $method = PaymentMethod::findOrFail($id);
        $method->delete();
        return back()->with('success', 'Card removed.');
    }
}
