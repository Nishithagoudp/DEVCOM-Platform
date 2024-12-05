<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Fetch all challenges with their solutions
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

        // Retrieve the completed challenges for the user
        $completedChallenges = $user->completedChallenges()->get(); // Fetch the actual challenges
        $completed = $user->completedChallenges()->count(); // Fetch the actual challenges
        $sumOfMarks = $user->completedChallenges()->sum('marks');

        // Calculate the number of in-progress challenges
        //$inProgressChallenges = $user->solutions()->where('status', '!=', 'completed')->count();
        $inProgressChallenges = ($totalChallenges > 0) ? ($completed / $totalChallenges) * 100 : 0; // Avoid division by zero
        // Get MFA status
        $twoFactorEnabled = $user->two_factor_secret !== null;
        $twoFactorConfirmed = $user->two_factor_confirmed_at !== null;
        $recoveryCodes = $twoFactorConfirmed ? json_decode(decrypt($user->two_factor_recovery_codes)) : [];

        return view('dashboard.home', compact(
            'totalChallenges',
            'completedChallenges', // This is now a collection of challenges
            'inProgressChallenges',
            'challenges',
            'user',
            'pricingPlans',
            'currentPlan',
            'twoFactorEnabled',
            'twoFactorConfirmed',
            'recoveryCodes',
            'completed',
            'sumOfMarks'
        ));
    }



}
