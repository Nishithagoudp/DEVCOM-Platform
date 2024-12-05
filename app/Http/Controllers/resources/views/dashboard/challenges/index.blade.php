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
</style>



<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-10">
                <h2 class="fw-bold">Popular Challenges</h2>
                <p>Attempt as many challenges as possible.</p>
            </div>

            @if(Auth::user() && Auth::user()->role == 'admin')
            <div class="col-lg-2">
                <div class="mb-4">
                    <a href="{{ route('challenges.create') }}" class="btn btn-theme text-lg-end">Add Challenge</a>
                </div>
            </div>
            @endif

        </div>
        @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="row mb-4">
            <div class="col-lg-12">
                <form action="{{ route('challenges') }}" method="GET" class="d-flex flex-column flex-md-row align-items-center">
                    <select name="difficulty" class="form-select me-2 mb-2 mb-md-0">
                        <option value="">All Difficulties</option>
                        <option value="easy" {{ request('difficulty') == 'easy' ? 'selected' : '' }}>Easy</option>
                        <option value="medium" {{ request('difficulty') == 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="hard" {{ request('difficulty') == 'hard' ? 'selected' : '' }}>Hard</option>
                    </select>

                    <select name="category" class="form-select me-2 mb-2 mb-md-0">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                        </option>
                        @endforeach
                    </select>

                    <select name="sort" class="form-select me-2 mb-2 mb-md-0">
                        <option value="">Sort By Date</option>
                        <option value="asc" {{ request('sort') == 'asc' ? 'selected' : '' }}>Ascending</option>
                        <option value="desc" {{ request('sort') == 'desc' ? 'selected' : '' }}>Descending</option>
                    </select>

                    <button type="submit" class="btn btn-theme">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            @foreach($challenges as $challenge)
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <img src="{{ $challenge->image ? asset('storage/' . $challenge->image) : asset('images/challenge-placeholder.jpg') }}" class="card-img-top" alt="Challenge Image">
                    <div class="card-body">
                        <h5 class="card-title text-dark fw-bold">{{ $challenge->title }}</h5>
                        <p class="mb-1 text-muted small">
                            Estimated Time: <strong>{{ $challenge->time ?? '30' }}</strong> &nbsp; | &nbsp;
                            Attempts: <strong>{{ $challenge->attempts ?? '0' }}</strong>
                        </p>
                        <p class="text-secondary mb-2">{{ $challenge->description }}</p>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary">{{ ucfirst($challenge->difficulty) }}</span>
                            <span class="badge bg-dark">{{ $challenge->category->name ?? 'Uncategorized' }}</span>
                        </div>

                        <a href="{{ route('challenges.editor', $challenge->id) }}" class="btn btn-theme btn-sm w-100 mb-2">
                            Start Challenge &rarr;
                        </a>
                        <!-- Admin-only Edit/Delete Buttons -->
                        @if(Auth::user() && Auth::user()->role == 'admin')
                        <div class="d-flex justify-content-between mt-2">
                            <a href="{{ route('challenges.edit', $challenge->id) }}" class="btn btn-outline-primary btn-sm w-50 me-1">
                                Edit
                            </a>
                            <form action="{{ route('challenges.destroy', $challenge->id) }}" method="POST" class="w-50">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Are you sure you want to delete this challenge?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>
</section>
@endsection
