@extends('layouts.front')

@section('content')
<style>
   
    .theme {
        color: #ff6b6b; /* Use your theme color */
    }
    .card-header {
        background-color: #f7f7f7;
        border-bottom: 2px solid #ddd;
        font-weight: bold;
    }
    .card-header h5 button {
        font-size: 1.1rem;
        color: #ff6b6b;
    }
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }
    .card-body {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: 0 0 8px 8px;
    }
    .collapse-button {
        display: flex;
        align-items: center;
        font-size: 1.1rem;
        font-weight: 500;
        color: #ff6b6b;
    }
    .icon {
        font-size: 1.3rem;
        margin-right: 0.5rem;
        color: #6c757d;
    }
    .info-box {
        padding: 1rem;
        border-left: 4px solid #ff6b6b;
        margin-bottom: 1rem;
        background-color: #fafafa;
        border-radius: 4px;
    }
    .info-box strong {
        color: #333;
    }
    .empty-message {
        color: #999;
    }
</style>

<div class="container mx-auto mb-4 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold theme">User Details</h2>
            <p>View detailed information about this user below.</p>
        </div>
        <div class="col-lg-2 text-end">
            <a href="{{ route('users.index') }}" class="btn btn-theme">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <div class="mb-3">
                <strong>Name:</strong> <span>{{ $user->name }}</span>
            </div>
            <div class="mb-3">
                <strong>Email:</strong> <span>{{ $user->email }}</span>
            </div>
            <div class="mb-3">
                <strong>Role:</strong> <span>{{ ucfirst($user->role) }}</span>
            </div>
            <div class="mb-3">
                <strong>Score:</strong> <span>{{ $user->score }}</span>
            </div>
        </div>
    </div>

    <!-- User's Challenges -->
    <div class="card shadow-lg mb-4">
        <div class="card-header" id="challengesHeader">
            <h5 class="mb-0">
                <button class="btn btn-link text-decoration-none theme" type="button" data-bs-toggle="collapse" data-bs-target="#challenges" aria-expanded="true" aria-controls="challenges">
                    Challenges
                </button>
            </h5>
        </div>
        <div id="challenges" class="collapse show" aria-labelledby="challengesHeader">
            <div class="card-body">
                @forelse ($user->completedChallenges as $challenge)
                    <div>
                        <strong>{{ $challenge->title }}</strong> ({{ ucfirst($challenge->difficulty) }})
                        <p>{{ $challenge->description }}</p>
                    </div>
                @empty
                    <p>No completed challenges.</p>
                @endforelse
            </div>
        </div>
    </div>


    <!-- User's Certificates -->
    <div class="card shadow-lg mb-4">
        <div class="card-header" id="certificatesHeader">
            <h5 class="mb-0">
                <button class="btn btn-link text-decoration-none theme collapse-button" type="button" data-bs-toggle="collapse" data-bs-target="#certificates" aria-expanded="true" aria-controls="certificates">
                    <i class="bi bi-award icon"></i> Certificates
                </button>
            </h5>
        </div>
        <div id="certificates" class="collapse" aria-labelledby="certificatesHeader">
            <div class="card-body">
                @forelse ($user->certificates as $certificate)
                    <div class="info-box">
                        <strong>Challenge:</strong> {{ $certificate->challenge->title }}
                        <p>Issued on: {{ $certificate->issued_at->format('d M Y') }}</p>
                    </div>
                @empty
                    <p class="empty-message">No certificates issued.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- User's Solutions -->
    <div class="card shadow-lg mb-4">
        <div class="card-header" id="solutionsHeader">
            <h5 class="mb-0">
                <button class="btn btn-link text-decoration-none theme collapse-button" type="button" data-bs-toggle="collapse" data-bs-target="#solutions" aria-expanded="true" aria-controls="solutions">
                    <i class="bi bi-code-slash icon"></i> Solutions
                </button>
            </h5>
        </div>
        <div id="solutions" class="collapse" aria-labelledby="solutionsHeader">
            <div class="card-body">
                @forelse ($user->solutions as $solution)
                    <div class="info-box">
                        <strong>Challenge:</strong> {{ $solution->challenge->title }}
                        <p>Status: {{ ucfirst($solution->status) }}</p>
                        <p>Feedback: {{ $solution->feedback }}</p>
                    </div>
                @empty
                    <p class="empty-message">No solutions submitted.</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- User's Subscription -->
    <div class="card shadow-lg mb-4">
        <div class="card-header" id="subscriptionHeader">
            <h5 class="mb-0">
                <button class="btn btn-link text-decoration-none theme collapse-button" type="button" data-bs-toggle="collapse" data-bs-target="#subscription" aria-expanded="true" aria-controls="subscription">
                    <i class="bi bi-card-checklist icon"></i> Subscription
                </button>
            </h5>
        </div>
        <div id="subscription" class="collapse" aria-labelledby="subscriptionHeader">
            <div class="card-body">
                @if ($user->subscription)
                    <div class="info-box">
                        <strong>Plan:</strong> {{ $user->subscription->plan->name }}
                        <p>Status: {{ ucfirst($user->subscription->status) }}</p>
                        <p>Start Date: {{ $user->subscription->start_date->format('d M Y') }}</p>
                        <p>End Date: {{ $user->subscription->end_date->format('d M Y') }}</p>
                    </div>
                @else
                    <p class="empty-message">No active subscription.</p>
                @endif
            </div>
        </div>
    </div>

</div>
@endsection
