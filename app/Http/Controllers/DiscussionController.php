<?php

namespace App\Http\Controllers;

use App\Models\Discussion;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DiscussionController extends Controller
{

    public function index()
    {
        $discussions = Discussion::latest()->paginate(10); // Fetch discussions with pagination
        return view('dashboard.discussions.index', compact('discussions'));
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'code_snippet' => 'nullable|string', // Validation for code snippet
        ]);

        $discussion = new Discussion();
        $discussion->title = $request->title;
        $discussion->body = $request->body;
        $discussion->code_snippet = $request->code_snippet;
        $discussion->user_id = auth()->id();
        $discussion->save();

        return redirect()->route('discussions.index')->with('success', 'Discussion created successfully!');
    }


    public function storeResponse(Request $request, $id)
    {
        $request->validate([
            'body' => 'required|string',
            'code_snippet' => 'nullable|string',
        ]);

        $discussion = Discussion::findOrFail($id);
        $discussion->responses()->create([
            'user_id' => Auth::id(),
            'body' => $request->input('body'),
            'code_snippet' => $request->input('code_snippet'),
        ]);

        return redirect()->route('discussions.show', $id)->with('success', 'Response added successfully!');
    }
    public function storeReply(Request $request, $parentId)
    {
        $request->validate([
            'body' => 'required|string',
            'code_snippet' => 'nullable|string',
        ]);
        $parentResponse = Response::findOrFail($parentId);

        $parentResponse->children()->create([
            'user_id' => Auth::id(),
            'discussion_id' => $parentResponse->discussion_id,
            'body' => $request->input('body'),
            'code_snippet' => $request->input('code_snippet')
        ]);

        return redirect()->route('discussions.show', $parentResponse->discussion_id)->with('success', 'Reply added successfully!');
    }


    public function show($id)
    {
        $discussion = Discussion::with('responses')->findOrFail($id);
        return view('dashboard.discussions.show', compact('discussion'));
    }


    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }
}
