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
                <h2 class="fw-bold">Edit Challenge</h2>
                <p>Update challenge details below.</p>
            </div>
        </div>

        @if (session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
        @endif

        <div class="row mb-4">
            <div class="col-lg-12 mx-auto">
                <form action="{{ route('challenges.update', $challenge->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Challenge Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="{{ old('title', $challenge->title) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-control" required>{{ old('description', $challenge->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="difficulty" class="form-label">Difficulty</label>
                        <select id="difficulty" name="difficulty" class="form-select" required>
                            <option value="Easy" {{ $challenge->difficulty == 'Easy' ? 'selected' : '' }}>Easy</option>
                            <option value="Medium" {{ $challenge->difficulty == 'Medium' ? 'selected' : '' }}>Medium</option>
                            <option value="Hard" {{ $challenge->difficulty == 'Hard' ? 'selected' : '' }}>Hard</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" class="form-select" required>
                            @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ $challenge->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                            @endforeach
                        </select>
                    </div>


                        <input type="hidden" id="content" name="content" rows="6" value="null" required>{{ old('content', $challenge->content) }}>

                    <div class="mb-3">
                        <label for="image" class="form-label">Challenge Image</label>
                        <input type="file" id="image" name="image" class="form-control">
                        @if($challenge->image)
                        <img src="{{ asset('storage/' . $challenge->image) }}" alt="Current Image" class="mt-3" width="150">
                        @endif
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-theme">Update Challenge</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
@endsection
