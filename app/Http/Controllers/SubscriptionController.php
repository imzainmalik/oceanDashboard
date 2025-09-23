<?php

namespace App\Http\Controllers;

use App\Models\FamilyOwner;
use App\Models\Subscription;
use Illuminate\Support\Facades\Auth;

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
        $subscriptions = Subscription::where('family_owner_id', $ownerId)->latest()->get();

        return view('family_owner.subscriptions.index', compact('subscriptions'));
    }
}
