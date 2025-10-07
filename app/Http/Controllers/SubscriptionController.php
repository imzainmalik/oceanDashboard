<?php

namespace App\Http\Controllers;

use App\Models\FamilyOwner;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;
use Stripe\PaymentMethod;

class SubscriptionController extends Controller
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

    public function index()
    {
        // $ownerId = FamilyOwner::where('owner_id', Auth::id())->value('id');
        $subscriptions_db = Subscription::where('user_id', auth()->user()->id)->latest()->first();
        // dd($subscriptions);
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));

        $customerId = $subscriptions_db->stripe_user_id; // stored by Cashier

        $subscriptions = $stripe->subscriptions->all([
            'customer' => $customerId,
        ]);
        $priceId = $subscriptions_db->stripe_price;
        // dd($subscriptions);
        $target = collect($subscriptions->data);


        // $subscriptions_expand = $stripe->subscriptions->all([
        //     'customer' => $customerId,
        //     'expand' => [
        //         'data.default_payment_method',  // include payment method details
        //         'data.customer.default_source', // fallback for older setups
        //         'data.latest_invoice.payment_intent', // optional, to get transaction info
        //         'data.items.data.price', // include product details
        //     ],
        // ]);

        // $customer = $stripe->customers->retrieve(
        //     $customerId,
        //     ['expand' => ['invoice_settings.default_payment_method']]
        // );



        // dd($customer);
        // if ($target) {
        // dd([
        //     'id' => $target->id,
        //     'status' => $target->status,
        //     'price' => $target->items->data[0]->price->id,
        //     'current_period_end' => date('Y-m-d H:i:s', $target->current_period_end),
        // ]);
        // } else {
        // dd('No subscription found with that price ID');
        // }


        return view('family_owner.subscriptions.index', compact('target', 'subscriptions_db'));
    }

    public function packages()
    {
        return view('subscription.packages');
    }

    public function payment(Request $request)
    {
        return view('subscription.payment', compact('request'));
    }

    public function store(Request $request)
    {
        // dd($request->price_id);
        // $user->newSubscription('Starting', 'price_1SED8FIqrFLrMDhXghvgZzo7')->checkout([
        //         'success_url' => route('familyOwner.index'),
        //         'cancel_url' => route('familyOwner.index'),
        // ]);

        $check_customer = Subscription::where('user_id', auth()->user()->id)->first();
        $stripe = new \Stripe\StripeClient(env('STRIPE_SECRET'));


        // $subscription = $stripe->subscriptions->retrieve(
        //     $check_customer->stripe_id,
        //     []
        // );

        // dd($subscription);


        if ($check_customer == null) {
            $customer = $stripe->customers->create([
                'email' => auth()->user()->email,
                'name'  => auth()->user()->name,
                'payment_method' => $request->payment_method, // from Stripe Elements
                'invoice_settings' => [
                    'default_payment_method' => $request->payment_method,
                ],
            ]);
            $pm = $stripe->paymentMethods->attach(
                $request->payment_method,
                ['customer' => $customer->id]
            );
            // dd($customer);
            $subscription = $stripe->subscriptions->create([
                'customer' => $customer->id,
                'items' => [['price' => $request->price_id]],
            ]);
            $subscribers = new Subscription;
            $subscribers->user_id = auth()->user()->id;
            $subscribers->type = $request->type;
            $subscribers->stripe_id = $subscription->id;
            $subscribers->stripe_user_id = $customer->id;
            $subscribers->stripe_status = 'active';
            $subscribers->stripe_price = $request->packge_price;
            $subscribers->price = $request->price;
            $subscribers->quantity = 1;
            $subscribers->save();
        } else {
            $customer = $check_customer->stripe_user_id;
            $pm = $stripe->paymentMethods->attach(
                $request->payment_method,
                ['customer' => $customer]
            );
            // dd($pm);
            // dd($customer);
            $subscription = $stripe->subscriptions->create([
                'customer' => $customer,
                'items' => [['price' => $request->price_id]],
            ]);

            $subscribers = new Subscription;
            $subscribers->user_id = auth()->user()->id;
            $subscribers->type = $request->type;
            $subscribers->stripe_id = $subscription->id;
            $subscribers->stripe_user_id = $customer;
            $subscribers->stripe_status = 'active';
            $subscribers->stripe_price = $request->packge_price;
            $subscribers->price = $request->price;
            $subscribers->quantity = 1;
            $subscribers->save();
        }
    }
}
