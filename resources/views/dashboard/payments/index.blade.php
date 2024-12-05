@extends('layouts.front')

@section('content')
<div class="container mx-auto mb-3 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Payments</h2>
            <p>Manage and view all payment transactions.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="{{ route('payments.create') }}" class="btn btn-theme">
                    <i class="bi bi-plus-circle"></i> Add Payment
                </a>
            </div>
        </div>
    </div>
    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <!-- Filter Row -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('payments.index') }}" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="user" class="form-label">Filter by User</label>
                    <select name="user" id="user" class="form-select">
                        <option value="">All Users</option>
                        @foreach($users as $user)
                        <option value="{{ $user->id }}" {{ request('user') == $user->id ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Filter by Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="payment_method" class="form-label">Filter by Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="">All Methods</option>
                        <option value="paypal" {{ request('payment_method') == 'paypal' ? 'selected' : '' }}>PayPal</option>
                        <option value="credit_card" {{ request('payment_method') == 'credit_card' ? 'selected' : '' }}>Credit Card</option>
                    </select>
                </div>
                <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-theme">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-gray-300">User</th>
                    <th class="text-gray-300">Amount</th>
                    <th class="text-gray-300">Payment Method</th>
                    <th class="text-gray-300">Transaction ID</th>
                    <th class="text-gray-300">Status</th>
                    @if(Auth::user() && Auth::user()->role == 'admin')
                    <th class="text-gray-300 text-center">Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                <tr class="border-b border-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">{{ $payment->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">${{ number_format($payment->amount, 2) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">{{ ucfirst($payment->payment_methods) }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">{{ $payment->payment_id }}</td>
                    <td class="px-6 py-4">
                        <span class="badge
                            @switch($payment->payment_status)
                                @case('pending') bg-warning @break
                                @case('completed') bg-success @break
                                @default bg-secondary
                            @endswitch">
                            {{ ucfirst($payment->payment_status) }}
                        </span>
                    </td>
                    @if(Auth::user() && Auth::user()->role == 'admin')
                    <td class="py-2 text-center">
                        <a href="" class="text-blue-500 hover:underline"><i class="bi bi-eye"></i></a>
                    </td>
                    @endif
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
