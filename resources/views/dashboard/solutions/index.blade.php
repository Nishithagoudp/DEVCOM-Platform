@extends('layouts.front')

@section('content')
<div class="container mx-auto mb-3 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Solutions</h2>
            <p>Manage and view submitted solutions.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="" class="btn btn-theme">
                    <i class="bi bi-plus-circle"></i> Add Solution
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Row -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="{{ route('solutions.index') }}" method="GET" class="row g-3">
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
                    <label for="challenge" class="form-label">Filter by Challenge</label>
                    <select name="challenge" id="challenge" class="form-select">
                        <option value="">All Challenges</option>
                        @foreach($challenges as $challenge)
                        <option value="{{ $challenge->id }}" {{ request('challenge') == $challenge->id ? 'selected' : '' }}>{{ $challenge->title }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Filter by Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Pending" {{ request('status') == 'Pending' ? 'selected' : '' }}>Pending</option>
                        <option value="passed" {{ request('status') == 'passed' ? 'selected' : '' }}>Passed</option>
                        <option value="failed" {{ request('status') == 'failed' ? 'selected' : '' }}>Failed</option>
                    </select>
                </div>
                <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-theme">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Solutions Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-gray-300">Submitted By</th>
                    <th class="text-gray-300">Challenge Title</th>
                    <th class="text-gray-300">Submitted At</th>
                    <th class="text-gray-300">Status</th>
                    @if(Auth::user() && Auth::user()->role == 'admin')
                    <th class="text-gray-300 text-center">Actions</th>
                    @endif
                </tr>
                </thead>
                <tbody>
                @foreach($solutions as $solution)
                <tr class="border-b border-gray-700">
                    <td class=" px-6 py-4  whitespace-nowrap text-gray-400">{{ $solution->user->name }}</td>
                    <td class="px-6 py-4   whitespace-nowrap text-gray-400">{{ $solution->challenge->title }}</td>
                    <td class="px-6 py-4  whitespace-nowrap text-gray-400">{{ $solution->submitted_at->format('Y-m-d H:i') }}</td>
                    <td class="px-6 py-4 ">
                        <span class="badge
                            @switch($solution->status)
                                @case('Pending') bg-warning @break
                                @case('passed') bg-success @break
                                @case('failed') bg-danger @break
                                @default bg-secondary
                            @endswitch">
                            {{ ucfirst($solution->status) }}
                        </span>
                    </td>
                    @if(Auth::user() && Auth::user()->role == 'admin')
                    <td class="py-2 text-center">
                        <a href="{{ route('solutions.show', $solution->id) }}" class="text-blue-500 hover:underline"><i class="bi bi-eye"></i></a>
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
