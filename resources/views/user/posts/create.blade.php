@extends('layouts.app')

@section('title', 'Create Post')

@section('content')
    <form action="{{ route('post.store')}}" method="post" enctype="multipart/form-data">
        @csrf 

        <p class="mb-2 fw-bold">Category <span class="fw-light">(up to 3)</span></p>
        <div>
            @forelse($all_categories as $category)
                <div class="form-check form-check-inline">
                    <input type="checkbox" name="categories[]" id="{{ $category->name }}" value="{{ $category->id }}" class="form-check-input">
                    <label for="{{ $category->name }}" class="form-check-label">{{ $category->name }}</label>
                </div>
            @empty 
                <span class="text-muted">No categories found.</span>
            @endforelse
        </div>
        @error('categories')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        <label for="description" class="form-label mt-3 fw-bold">Description</label>
        <textarea name="description" id="description" class="form-control" placeholder="What's on your mind" rows="3">{{ old('description') }}</textarea>
        @error('description')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        <label for="image" class="form-label mt-3 fw-bold">Image</label>
        <input type="file" name="image" id="image" class="form-control">
        <p class="form-text mb-0">
            Acceptable formats: jpeg, jpg, png, gif <br>
            Max size: 1048 KB 
        </p>
        @error('image')
            <p class="mb-0 text-danger small">{{ $message }}</p>
        @enderror

        <button type="submit" class="btn btn-primary px-4 mt-3">Post</button>
    </form>

@endsection