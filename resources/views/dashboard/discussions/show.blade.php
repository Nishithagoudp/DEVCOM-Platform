@extends('layouts.front')

@section('content')
<div class="container mx-auto mb-3 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">{{ $discussion->title }}</h2>
            <p class="text-muted">Started by {{ $discussion->user->name }} on {{ $discussion->created_at->format('M d, Y') }}</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="" class="btn btn-theme">
                    <i class="bi bi-plus-circle"></i> Back to Discussions
                </a>
            </div>
        </div>
    </div>

    <div class="card mb-4">
        <div class="card-body">
            <p>{{ $discussion->body }}</p>
            @if($discussion->code_snippet)
            <h5>Here is the code snippet I used:</h5>
            <pre style="max-height: 400px"><code class="language-{{ $language ?? 'javascript' }}">{{ $discussion->code_snippet }}</code></pre>
            @endif
        </div>
    </div>

    <!-- Responses Section -->
    <h3 class="theme" >Responses</h3>
    @foreach ($discussion->responses->where('parent_id', null) as $response)
    @include('dashboard.discussions.partials.response', ['response' => $response])
    @endforeach

    <!-- Add a Response to the Discussion -->
    <div class="card mt-4">
        <div class="card-body">
            <form action="{{ route('discussions.responses.store', $discussion->id) }}" method="POST">
                @csrf
                <div class="mb-3">
                    <label for="responseBody" class="form-label">Your Response</label>
                    <textarea class="form-control" id="responseBody" name="body" rows="4" required></textarea>
                </div>
                <div class="mb-3 form-group">
                    <label for="code_snippet">Code Snippet (optional):</label>
                    <textarea name="code_snippet" id="code_snippet" class="form-control" rows="6" placeholder="Paste your code here..."></textarea>
                </div>

                <button type="submit" class="btn btn-theme">Submit Response</button>
            </form>
        </div>
    </div>
</div>
@endsection
