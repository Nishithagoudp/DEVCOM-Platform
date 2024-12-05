@extends('layouts.front')

@section('content')
<div class="container mx-auto mb-3 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Payment Details</h2>
            <p>View the complete details of the selected payment transaction.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="{{ route('payments.index') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Payments
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Details Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Transaction Overview</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">User</label>
                        <input type="text" id="user_name" class="form-control" value="{{ $payment->user->name }}" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <input type="text" id="payment_method" class="form-control" value="{{ ucfirst($payment->payment_method) }}" readonly />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" id="amount" class="form-control" value="${{ number_format($payment->amount, 2) }}" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Payment Status</label>
                        <input type="text" id="status" class="form-control" value="{{ ucfirst($payment->status) }}" readonly />
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="transaction_id" class="form-label">Transaction ID</label>
                <input type="text" id="transaction_id" class="form-control" value="{{ $payment->transaction_id }}" readonly />
            </div>

            <!-- Payable Details Section -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payable_type" class="form-label">Payable Type</label>
                        <input type="text" id="payable_type" class="form-control" value="{{ ucfirst($payment->payable_type) }}" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payable_id" class="form-label">Payable ID</label>
                        <input type="text" id="payable_id" class="form-control" value="{{ $payment->payable_id }}" readonly />
                    </div>
                </div>
            </div>

            <!-- Display Related Model Information -->
            @if($payment->payable_type === 'subscription')
            <div class="mb-3">
                <label for="plan_details" class="form-label">Subscription Plan</label>
                <div class="form-control">
                    <p><strong>Plan Name:</strong> {{ $payableDetails->name ?? 'N/A' }}</p>
                    <p><strong>Description:</strong> {{ $payableDetails->description ?? 'N/A' }}</p>
                    <p><strong>Price:</strong> ${{ number_format($payableDetails->price, 2) ?? 'N/A' }}</p>
                </div>
            </div>
            @elseif($payment->payable_type === 'certificate')
            <div class="mb-3">
                <label for="certificate_details" class="form-label">Certificate Details</label>
                <div class="form-control">
                    <p><strong>Challenge:</strong> {{ $payableDetails->name ?? 'N/A' }}</p>
                    <p><strong>Issued At:</strong> {{ $payment->payable->issued_at->format('Y-m-d') }}</p>
                </div>
            </div>
            @endif
        </div>
    </div>

    <!-- Payment Timeline (Optional) -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Transaction Timeline</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Payment Initiated</span>
                    <span class="badge bg-info text-white">{{ $payment->created_at->format('Y-m-d H:i') }}</span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Payment Processed</span>
                    <span class="badge bg-secondary text-white">{{ $payment->updated_at->format('Y-m-d H:i') }}</span>
                </li>
                @if($payment->status == 'completed')
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Payment Completed</span>
                    <span class="badge bg-success text-white">{{ $payment->completed_at ? $payment->completed_at->format('Y-m-d H:i') : 'N/A' }}</span>
                </li>
                @endif
                @if($payment->status == 'failed')
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Payment Failed</span>
                    <span class="badge bg-danger text-white">{{ $payment->failed_at ? $payment->failed_at->format('Y-m-d H:i') : 'N/A' }}</span>
                </li>
                @endif
            </ul>
        </div>
    </div>

    <!-- Additional Notes (Optional) -->
    @if($payment->notes)
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Additional Notes</h5>
            <p>{{ $payment->notes }}</p>
        </div>
    </div>
    @endif

    <!-- Action Buttons -->
    <div class="text-end">
        <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-primary">Edit Payment Status</a>
    </div>
</div>
@endsection
