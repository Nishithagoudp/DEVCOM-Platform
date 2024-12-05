@extends('layouts.front')

@section('content')
<div class="container mx-auto mb-4 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">{{ $solution->challenge->title }} </h2>
            <p>Submitted on {{ $solution->submitted_at->format('Y-m-d') }} at {{ $solution->submitted_at->format('H:i') }} by {{ $solution->user->name }}</p>
        </div>
        <div class="col-lg-2 text-end">
            <a href="{{ route('solutions.index') }}" class="btn btn-theme">
                <i class="bi bi-arrow-left"></i> Back to Solutions
            </a>
        </div>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <p><strong>Description: </strong> {{ $solution->challenge->description }}</p>
            <p><strong> Status : </strong>
                <span class="badge
                    @switch($solution->status)
                        @case('Pending') bg-warning @break
                        @case('Passed') bg-success @break
                         @case('passed') bg-success @break
                        @case('Failed') bg-danger @break
                        @default bg-secondary
                    @endswitch">
                    {{ ucfirst($solution->status) }}
                </span>
            </p>
            @if($solution->feedback)
            <p><strong>System Feedback:</strong> {{ $solution->feedback }}</p>
            @endif
        </div>
    </div>

    <div class="card shadow-sm mt-3 mb-3">
        <div class="card-body">
            <h5 class="card-title fw-bold">Compiled Output</h5>
            <div class="bg-light p-3 rounded">
                <iframe
                    frameBorder="0"
                    height="800px"
                    srcdoc="<!DOCTYPE html>
                <html lang='en'>
                <head>
                    <meta charset='UTF-8'>
                    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
                    <title>Solution Preview</title>
                    <style>
                        {{ $solution->css }}
                    </style>
                </head>
                <body>
                    {{ $solution->html }}
                    <script>
                        {{ $solution->javascript }}
                    </script>
                </body>
                </html>"
                    width="100%">
                </iframe>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-4 mb-4 d-flex">
            <div class="card shadow flex-fill">
                <div class="card-header btn-theme text-white">
                    <h5 class="mb-0">HTML</h5>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded">{{ $solution->html }}</pre>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4 d-flex">
            <div class="card shadow flex-fill">
                <div class="card-header btn-theme text-white">
                    <h5 class="mb-0">CSS</h5>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded">{{ $solution->css }}</pre>
                </div>
            </div>
        </div>

        <div class="col-lg-4 mb-4 d-flex">
            <div class="card shadow flex-fill">
                <div class="card-header btn-theme text-white">
                    <h5 class="mb-0">JavaScript</h5>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded">{{ $solution->javascript }}</pre>
                </div>
            </div>
        </div>
    </div>

    <!-- Button to trigger the modal -->
    <div class="text-center mt-4">
        @if($solution->status === 'pending')
        <!-- Show the mark button if the solution is pending -->
        <button class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#markSolutionModal">
            Mark Solution
        </button>
        @else
        <!-- Hide the mark button if the solution is already marked -->
        <p class="text-muted">Solution has already been marked.</p>
        @endif
    </div>

    <!-- Modal -->
    <div class="modal fade" id="markSolutionModal" tabindex="-1" aria-labelledby="markSolutionModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="markSolutionModalLabel">Mark Solution out of {{$solution->challenge->marks}}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('solutions.mark', $solution->id) }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="feedback" class="form-label">Feedback</label>
                            <textarea id="feedback" name="feedback" rows="4" class="form-control" required></textarea>
                        </div>

                        <div class="mb-3">
                            <label for="score" class="form-label">Score</label>
                            <input type="number" id="score" name="score" class="form-control" min="0" max="100" required>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select id="status" name="status" class="form-select" required>
                                <option value="Pending">Pending</option>
                                <option value="Passed">Passed</option>
                                <option value="Failed">Failed</option>
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-theme">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
