<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use App\Models\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SubscriptionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function store(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:pricing_plans,id',
        ]);

        $plan = PricingPlan::findOrFail($request->input('plan_id'));
        $user = Auth::user();

        $activeSubscription = Subscription::where('user_id', $user->id)
            ->where('status', 'Active')
            ->first();

        if ($activeSubscription) {
            return redirect()->back()->with('error', 'You already have an active subscription. Please cancel it first.');
        }

        $subscription = Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'start_date' => now(),
            'end_date' => now()->addMonth(),
            'status' => 'Cancelled',
        ]);

        session([
            'payment_type' => 'subscription',
            'payment_amount' => $plan->price,
            'subscription_plan' => $plan->name,
            'subscription_duration' => 30,
            'payable_id' => $subscription->id,
        ]);

        // Render a form view to auto-submit to processTransaction
        return view('dashboard.payments.process', [
            'subscription_id' => $subscription->id,
            'amount' => $plan->price,
        ]);
    }




}
