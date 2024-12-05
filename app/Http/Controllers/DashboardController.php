<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $challenges = Challenge::with('solutions')->get();

        // Get the currently authenticated user
        $user = auth()->user();
        $currentPlan = $user->subscription()
            ->where('status', 'Active') // Adjust as needed for your status names
            ->first();

        // Fetch all pricing plans from the database
        $pricingPlans = PricingPlan::all()->map(function ($plan) {
            return [
                'id' => $plan->id,
                'name' => $plan->name,
                'price' => $plan->price,
                'features' => $plan->features,
            ];
        });

        $totalChallenges = Challenge::count();
        $completedChallenges = $user->completedChallenges()->count();

        // Get MFA status
        $twoFactorEnabled = $user->two_factor_secret !== null;
        $twoFactorConfirmed = $user->two_factor_confirmed_at !== null;
        $recoveryCodes = $twoFactorConfirmed ? json_decode(decrypt($user->two_factor_recovery_codes)) : [];

        return view('dashboard.home', compact(
            'totalChallenges',
            'completedChallenges',
            'challenges',
            'user',
            'pricingPlans',
            'currentPlan',
            'twoFactorEnabled',
            'twoFactorConfirmed',
            'recoveryCodes'
        ));
    }

}
