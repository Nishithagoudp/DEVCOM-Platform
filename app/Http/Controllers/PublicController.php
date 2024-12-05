<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Challenge;
use App\Models\Discussion;
use App\Models\PricingPlan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PublicController extends Controller
{
    public function index()
    {
        // Fetch popular challenges and recent discussions
        $challenges = Challenge::orderBy('id', 'desc')->take(3)->get();
        $discussions = Discussion::orderBy('created_at', 'desc')->take(3)->get();
        $pricingPlans = PricingPlan::all();
        // Pass data to the view
        return view('index', compact('challenges', 'discussions','pricingPlans'));
    }

    private function getDifficultyColor($difficulty)
    {
        switch (strtolower($difficulty)) {
            case 'easy':
                return 'green';
            case 'medium':
                return 'yellow';
            case 'hard':
                return 'red';
            default:
                return 'gray';
        }
    }
}
