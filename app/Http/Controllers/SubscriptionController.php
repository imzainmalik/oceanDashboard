<?php

namespace App\Http\Controllers;

use App\Models\FamilyOwner;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Stripe\Stripe;

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
        $ownerId = FamilyOwner::where('owner_id', Auth::id())->value('id');
        $subscriptions = Subscription::where('user_id', auth()->user()->id)->latest()->get();

        return view('family_owner.subscriptions.index', compact('subscriptions'));
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
            $subscribers->quantity = 1; 
            $subscribers->save();

             
        }else{
            $customer = $check_customer->stripe_user_id;
        }

        // dd($customer);
        $subscription = $stripe->subscriptions->create([
            'customer' => $customer,
            'items' => [['price' => $request->price_id]],
        ]);

        Subscription::where('user_id', auth()->user()->id)->update(array(
             'stripe_user_id' => $customer,
             'stripe_price' => $request->price_id,
             'stripe_id' =>  $subscription->id,
             'stripe_status' => 'active'
        ));

    }
}
