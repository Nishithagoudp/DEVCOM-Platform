<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Solution;
use App\Models\User;
use Illuminate\Http\Request;

class SolutionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        $users = User::all();
        $challenges = Challenge::all();

        // Fetch solutions with user and challenge relationships, applying filters if specified
        $solutions = Solution::with('user', 'challenge')
            ->when($request->user, function ($query) use ($request) {
                return $query->where('user_id', $request->user);
            })
            ->when($request->challenge, function ($query) use ($request) {
                return $query->where('challenge_id', $request->challenge);
            })
            ->when($request->status, function ($query) use ($request) {
                return $query->where('status', $request->status);
            })
            ->get();

        // Pass solutions, users, and challenges to the view
        return view('dashboard.solutions.index', compact('solutions', 'users', 'challenges'));
    }

    public function show($id)
    {
        $solution = Solution::with('user', 'challenge')->findOrFail($id);
        return view('dashboard.solutions.show', compact('solution'));
    }
    public function updateStatus(Request $request, $id)
    {
        $solution = Solution::findOrFail($id);

        // Update the status based on the button clicked
        if ($request->input('action') === 'pass') {
            $solution->status = 'Passed';
        } elseif ($request->input('action') === 'fail') {
            $solution->status = 'Failed';
        }

        $solution->save();

        return redirect()->route('solutions.show', $solution->id)
            ->with('success', 'Solution status updated successfully.');
    }
    public function mark(Request $request, Solution $solution)
    {
        // Validate incoming data
        $validated = $request->validate([
            'feedback' => 'required|string',
            'score' => 'required|integer|min:0|max:100',
            'status' => 'required|in:Pending,Passed,Failed',
        ]);

        // Update the solution status and feedback
        $solution->feedback = $validated['feedback'];
        $solution->status = $validated['status'];
        $solution->save();

        // Increment the user's score
        $user = $solution->user;
        $user->score += $validated['score'];  // Increment the user's current score
        $user->save();

        // Redirect back with success message
        return redirect()->route('solutions.show', $solution->id)
            ->with('success', 'Solution marked successfully and score updated!');
    }
}
