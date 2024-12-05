<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;

use App\Models\Certificate;
use Illuminate\Http\Request;
use App\Models\Challenge;
use App\Models\Category;
use App\Models\Solution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class ChallengeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        // Check if the user has an active subscription
        $user = auth()->user();
        $hasActiveSubscription = $user->subscription()
            ->where('status', 'active')
            ->where('end_date', '>=', now())
            ->exists();
    
        // Build the query
        $query = Challenge::with('category');
    
        // Filter challenges based on subscription status
        if (!$hasActiveSubscription) {
            $query->where('difficulty', '!=', 'hard'); // Exclude hard challenges
        }
    
        // Filter by difficulty
        if ($request->has('difficulty') && $request->difficulty != '') {
            $query->where('difficulty', $request->difficulty);
        }
    
        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }
    
        // Sort by date
        if ($request->has('sort') && $request->sort != '') {
            $query->orderBy('created_at', $request->sort);
        }
    
        // Retrieve the filtered challenges
        $challenges = $query->get();
    
        // Fetch all categories for the filter dropdown
        $categories = Category::all();
    
        return view('dashboard.challenges.index', compact('challenges', 'categories'));
    }
    



    public function certificates()
    {
        $Certificates = Certificate::with('category')->get();
        return view('dashboard.certificates', compact('Certificates'));
    }


    public function create()
    {
        $categories = Category::all();
        return view('dashboard.challenges.create', compact('categories'));
    }

    public function store(Request $request)
{
    // Validate incoming request data
    $validatedData = $request->validate([
        'title' => 'required|max:255',
        'description' => 'required',
        'difficulty' => 'required|in:Easy,Medium,Hard',
        'category_id' => 'required|exists:categories,id',
        'content' => 'nullable',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validation for image file
        'time' => 'nullable|integer|min:1', // Validate time as an optional integer
        'marks' => 'nullable|integer|min:0', // Validate marks as an optional integer
    ]);

    // Create a new Challenge instance
    $challenge = new Challenge();
    $challenge->title = $validatedData['title'];
    $challenge->description = $validatedData['description'];
    $challenge->difficulty = $validatedData['difficulty'];
    $challenge->category_id = $validatedData['category_id'];
    $challenge->content = $validatedData['content'];
    $challenge->time = $validatedData['time'] ?? null; // Assign time if present
    $challenge->marks = $validatedData['marks'] ?? 0;   // Assign marks if present, default to 0

    // Handle the image file if it's uploaded
    if ($request->hasFile('image')) {
        $file = $request->file('image');

        // Generate a unique file name using the original name and timestamp
        $filename = time() . '_' . $file->getClientOriginalName();

        // Ensure the directory exists
        if (!file_exists(public_path('images/challenges'))) {
            mkdir(public_path('images/challenges'), 0755, true);
        }

        // Move the file to the desired location
        $file->move(public_path('images/challenges'), $filename);

        // Save the relative path to the database
        $challenge->image = 'images/challenges/' . $filename;
    }

    // Save the new challenge
    $challenge->save();

    return redirect()->route('challenges')->with('success', 'Challenge created successfully!');
}



    public function show()
    {
        $categories = Category::all();

        return view('dashboard.challenges.show', compact('categories'));
    }
    public function editor(Challenge $challenge)
    {
        return view('dashboard.challenges.editor', compact('challenge'));
    }

    public function submit(Request $request, Challenge $challenge)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'html' => 'required|string|max:50000',
            'css' => 'required|string|max:50000',
            'javascript' => 'required|string|max:50000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user has already submitted a solution for this challenge
        $existingSolution = Solution::where('user_id', $user->id)
            ->where('challenge_id', $challenge->id)
            ->first();

        if ($existingSolution) {
            // Update existing solution
            $existingSolution->update([
                'html' => $request->html,
                'css' => $request->css,
                'javascript' => $request->javascript,
                'submitted_at' => now(),
            ]);
            $solution = $existingSolution;
        } else {
            // Create new solution
            $solution = Solution::create([
                'user_id' => $user->id,
                'challenge_id' => $challenge->id,
                'html' => $request->html,
                'css' => $request->css,
                'javascript' => $request->javascript,
                'submitted_at' => now(),
            ]);
        }

        // Perform basic validation on the submitted code
        $validationResult = $this->validateSubmission($solution);

        // Update the solution status based on validation
        $solution->update([
            'status' => $validationResult['status'],
            'feedback' => $validationResult['feedback'],
        ]);

        // Update user's progress
        $this->updateUserProgress($user, $challenge);

        // Redirect back with appropriate message
        if ($validationResult['status'] === 'pending') {
            return redirect()->back()->with('success', 'Solution submitted successfully!');
        } else {
            return redirect()->back()->with('success', 'Solution submitted, but did not pass all validations. Please review the feedback and try again.');
        }
    }

    private function validateSubmission(Solution $solution)
    {
        // This is a basic validation. You might want to implement more sophisticated checks.
        $errors = [];

        // Check if HTML contains basic structure
        if (!preg_match('/<html.*>.*<\/html>/is', $solution->html)) {
            $errors[] = 'HTML must contain <html> tags.';
        }

        // Check if CSS is not empty
        if (empty(trim($solution->css))) {
            $errors[] = 'CSS should not be empty.';
        }

        // Check if JavaScript is not empty
        if (empty(trim($solution->javascript))) {
            $errors[] = 'JavaScript should not be empty.';
        }

        // You can add more specific checks based on the challenge requirements

        if (empty($errors)) {
            return [
                'status' => 'pending',
                'feedback' => 'All basic checks passed.',
            ];
        } else {
            return [
                'status' => 'failed',
                'feedback' => implode(' ', $errors),
            ];
        }
    }

    private function updateUserProgress($user, $challenge)
    {
        // Check if the user has completed this challenge
        $completedChallenge = $user->completedChallenges()->where('challenge_id', $challenge->id)->first();

        if (!$completedChallenge) {
            // If not completed, add it to completed challenges
            $user->completedChallenges()->attach($challenge->id, ['completed_at' => now()]);

            // Update user's total score
            $user->score += $challenge->points;
            $user->save();
        }
    }
    public function edit($id)
    {
        // Fetch the challenge by ID and pass it to the edit view
        $challenge = Challenge::findOrFail($id);
        $categories = Category::all(); // Assuming you want to allow category changes
        return view('dashboard.challenges.edit', compact('challenge', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // Validate incoming request data
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'difficulty' => 'required|in:Easy,Medium,Hard',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);
    
        // Find the challenge
        $challenge = Challenge::findOrFail($id);
    
        // Update other fields
        $challenge->title = $validatedData['title'];
        $challenge->description = $validatedData['description'];
        $challenge->difficulty = $validatedData['difficulty'];
        $challenge->category_id = $validatedData['category_id'];
        $challenge->content = $validatedData['content'];
    
        // Handle the image upload if there's a new image
        if ($request->hasFile('image')) {
            $file = $request->file('image'); // Get the uploaded file
        
            // Generate a unique file name using the original name and timestamp
            $filename = time() . '_' . $file->getClientOriginalName();
        
            // Define the path where the file should be stored
            $path = 'images/challenges/' . $filename;
        
            // Move the file to the desired location in the 'public' disk
            $file->move(public_path('images/challenges'), $filename);
        
            // Save the path to the database
            $challenge->image = $path;
        }
        
    
        // Save the updated challenge
        $challenge->save();
    
        return redirect()->route('challenges')->with('success', 'Challenge updated successfully!');
    }
    public function destroy($id)
    {
        $challenge = Challenge::findOrFail($id);

        // Check if an image exists and delete it from storage
        if ($challenge->image) {
            Storage::delete($challenge->image);
        }

        $challenge->delete();

        return redirect()->route('challenges')->with('success', 'Challenge deleted successfully!');
    }



}
