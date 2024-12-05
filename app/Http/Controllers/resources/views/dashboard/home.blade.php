@extends('layouts.front')

@section('content')
<style>
    .btn-theme {
        background-color: #ff6b6b;
        color: white;
        border: none;
    }

    .btn-theme:hover {
        background-color: #e05e5e;
    }

    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .alert-icon {
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }
</style>

@if (session('success'))
<div class="alert alert-success mb-4">
    {{ session('success') }}
</div>
@endif
@if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<div class="container my-5">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="fw-bold">Dashboard</h2>
            <p>Home/Dashboard</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">

                @if(auth()->user()->two_factor_confirmed_at)
                <div class="alert d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill alert-icon"></i>
                    <div>

                        <form method="POST" action="{{ url('user/two-factor-authentication') }}" class="mr-4">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-theme hover:btn-theme mt-3">
                                Disable MFA
                            </button>
                        </form>
                    </div>
                </div>
                @else
                <form method="POST" action="{{ route('two-factor.enable') }}">
                    @csrf
                    <button type="submit" class="btn btn-success hover:success mt-3">Enable MFA</button>
                </form>
                @endif
            </div>
        </div>
    </div>

    <div class="row mt-3">

        @if(auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at)

        <div class="bg-dark p-4 rounded-3">
            <h2 class="h4 fw-bold mb-4 text-light">Two-Factor Authentication Setup</h2>
            <p class="mb-4 text-light">Scan this QR code with your authenticator application or enter the setup key
                manually:</p>

            @php
            $google2fa = app('pragmarx.google2fa');
            $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            auth()->user()->email,
            decrypt(auth()->user()->two_factor_secret)
            );
            @endphp

            <div class="mb-4">
                <div id="qrcode"></div>
            </div>

            @if(!auth()->user()->two_factor_confirmed_at)
            <div class="alert alert-warning" role="alert">
                <strong>MFA is not confirmed yet!</strong>
                <p>Please scan the QR code and enter a verification code to confirm MFA.</p>
            </div>
            @endif

            @if(session('status') == 'two-factor-authentication-enabled')
            <div class="alert alert-success mb-4" role="alert">
                Two-factor authentication has been enabled.
            </div>
            @endif

            @if(session('status') == 'two-factor-authentication-disabled')
            <div class="alert alert-danger mb-4" role="alert">
                Two-factor authentication has been disabled.
            </div>
            @endif

            <p class="mt-4 mb-2 text-light">Manual Setup Key:</p>
            <p class="bg-dark text-light p-2 rounded mb-4">{{ decrypt(auth()->user()->two_factor_secret) }}</p>

            <form method="POST" action="{{ route('two-factor.confirm') }}">
                @csrf
                <div class="mb-3">
                    <label for="code" class="form-label text-light">Verification Code</label>
                    <input type="text" name="code" id="code" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    Confirm & Enable
                </button>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var qr = qrcode(0, 'M');
                qr.addData("{{ $qrCodeUrl }}");
                qr.make();
                document.getElementById('qrcode').innerHTML = qr.createImgTag(5, 10);
            });
        </script>

        @endif

        @if(auth()->user()->two_factor_confirmed_at)
        <div class="bg-dark p-4 rounded-3 mb-8">
            <h2 class="h4 fw-bold mb-4 text-light">Two-Factor Authentication Recovery Codes</h2>
            <p class="mt-4 mb-2 text-light">Please store these recovery codes in a secure location:</p>
            <ul class="list-disc list-inside mb-4 text-light">
                @foreach (json_decode(decrypt(auth()->user()->two_factor_recovery_codes)) as $code)
                <li>{{ $code }}</li>
                @endforeach
            </ul>
        </div>
        @endif

    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4 text-center border-success">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-check-circle-fill text-success"></i> Completed Challenges
                    </h5>
                    <h2 class="display-4 text-success">{{ $completed }}</h2>
                    <p class="card-text">Total challenges you have completed.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4 text-center border-warning">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-hourglass-sand text-warning"></i> Total Challenges</h5>
                    <h2 class="display-4 text-warning">{{ $totalChallenges }}</h2>
                    <p class="card-text">Total Challenges available in the system.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4 text-center border-info">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-info-circle-fill text-info"></i>Earned Points</h5>
                    <h2 class="display-4 text-info">{{ Auth::user()->score }}/ {{$sumOfMarks}}</h2>
                    <p class="card-text">Earned points out of the possible.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mb-4 mt-3">
            <h2 class="fw-bold">Challenge Progress</h2>
            <div class="progress">
                <div class="progress-bar btn-theme hover:btn-theme" role="progressbar"
                     style="width: {{ round($inProgressChallenges, 2) }}%;"
                     aria-valuenow="{{ round($inProgressChallenges, 2) }}" aria-valuemin="0" aria-valuemax="100">
                    {{ round($inProgressChallenges, 2) }}%
                </div>
            </div>
            <p class="mt-2">{{ round($inProgressChallenges, 2) }}% Done</p>
        </div>
    </div>




    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Challenge Title</th>
                                <th>Date Completed</th>
                                <th>Certificate</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($completedChallenges as $challenge)
                            <tr>
                                <td>{{ $challenge->title }}</td>
                                <td>
                                    @if($challenge->created_at)
                                    {{ $challenge->created_at->format('d M Y') }}
                                    @else
                                    N/A
                                    @endif
                                </td>
                                <td>
                                    @php
                                    // Check if the user already has a certificate for this challenge
                                    $certificate = $challenge->certificates()->where('user_id', auth()->id())->first();
                                    @endphp

                                    @if($certificate)
                                    <!-- If a certificate exists, show the download button -->
                                    <a href="{{ route('certificate.download', $certificate->id) }}" class="btn btn-primary">Download</a>
                                    @else
                                    <!-- If no certificate exists, show the request form -->
                                    <form action="{{ route('purchase') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="payable_type" value="certificate">
                                        <input type="hidden" name="payable_id" value="{{ $challenge->id }}"> <!-- Payable ID: ID of the challenge -->
                                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                                        <input type="hidden" name="amount" value="10">
                                        <button type="submit" class="btn btn-success">Request Certificate ($10)</button>
                                    </form>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark  text-white">
                    <h5 class="mb-0">📅 Subscription Information</h5>
                </div>
                <div class="card-body text-center py-5">
                    <h5 class="card-title mb-4 fw-bold text-secondary">Current Subscription</h5>

                    @if($currentPlan)
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <h2 class="display-4 text-primary mb-3">{{ $currentPlan->plan->name }}</h2>
                        <p class="card-text text-muted mb-2">
                            <strong>Price:</strong> ${{ number_format($currentPlan->plan->price, 2) }}
                        </p>
                        <p class="card-text text-muted mb-3">
                            <strong>Validity:</strong> {{ $currentPlan->start_date->format('M d, Y') }} to {{ $currentPlan->end_date->format('M d, Y') }}
                        </p>

                    </div>
                    @else
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <h2 class="h4 text-danger mb-3">No Current Plan</h2>
                        <p class="card-text mb-4">You don’t have an active subscription.</p>
                        <a href="{{ route('pricing') }}">
                            <button class="btn btn-outline-theme px-4 py-2 rounded-pill shadow-sm hover:shadow-lg">
                                Get Started
                            </button>
                        </a>
                    </div>
                    @endif
                </div>


            </div>
        </div>
    </div>
</div>

@endsection
