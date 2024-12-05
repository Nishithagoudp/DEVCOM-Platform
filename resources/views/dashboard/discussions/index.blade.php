@extends('layouts.front')

@section('content')
<div class="container mx-auto mb-3 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">
                <i class="bi bi-chat-dots-fill me-2"></i>Discussions
            </h2>
            <p>Manage and view submitted solutions.</p>
        </div>
        <div class="col-lg-2 text-end">
            <div class="mb-4">
                <button type="button" class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#createDiscussionModal">
                    <i class="bi bi-plus-circle me-1"></i> Start a Discussion
                </button>
            </div>
        </div>
    </div>

    @if($discussions->isEmpty())
    <p class="text-muted">
        <i class="bi bi-info-circle me-1"></i> No discussions yet. Be the first to start one!
    </p>
    @else
    <div class="list-group">
        @foreach($discussions as $discussion)
        <a href="{{ route('discussions.show', $discussion->id) }}" class="list-group-item list-group-item-action mb-2">
            <h5 class="mb-1 theme">
                <i class="bi bi-chat-text me-2"></i>{{ $discussion->title }}
            </h5>
            <small>
                <i class="bi bi-person-fill me-1"></i> Started by {{ $discussion->user->name }} •
                <i class="bi bi-clock me-1"></i> {{ $discussion->created_at->diffForHumans() }}
            </small>
            <p class="mb-1 text-muted">
                {{ Str::limit($discussion->body, 170) }}
            </p>
        </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-4">
        {{ $discussions->links() }}
    </div>
    @endif
</div>

<!-- Create Discussion Modal -->
<div class="modal fade" id="createDiscussionModal" tabindex="-1" aria-labelledby="createDiscussionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDiscussionModalLabel">
                    <i class="bi bi-pencil-square me-2"></i>Start a New Discussion
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('discussions.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="discussionTitle" class="form-label">
                            <i class="bi bi-file-earmark-text me-1"></i> Title
                        </label>
                        <input type="text" class="form-control" id="discussionTitle" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="discussionBody" class="form-label">
                            <i class="bi bi-file-earmark-text me-1"></i> Discussion Details
                        </label>
                        <textarea class="form-control" id="discussionBody" name="body" rows="5" required></textarea>
                    </div>
                    <div class="mb-3 form-group">
                        <label for="code_snippet">
                            <i class="bi bi-code me-1"></i> Code Snippet (optional):
                        </label>
                        <textarea name="code_snippet" id="code_snippet" class="form-control" rows="6" placeholder="Paste your code here..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle me-1"></i> Cancel
                    </button>
                    <button type="submit" class="btn btn-theme">
                        <i class="bi bi-send me-1"></i> Start Discussion
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection
