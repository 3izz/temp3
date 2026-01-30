@extends('layouts.app')

@section('content')
<div class="container" style="max-width: 800px; padding: 30px;">
    <div class="mb-4">
        <a href="{{ route('coach.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <h1 class="mt-3" style="color: #2c3e50;">
            <i class="fas fa-edit"></i> Edit Course
        </h1>
        <p class="text-muted">Update the details for <strong>{{ $course->title }}</strong>.</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger">
            <h6 class="alert-heading">Please fix the following errors:</h6>
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('coach.courses.update', $course) }}" method="POST">
                @csrf
                @method('PUT')
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="form-label">Course Title *</label>
                            <input type="text" class="form-control" id="title" name="title" 
                                   value="{{ old('title', $course->title) }}" required placeholder="e.g., Web Development Fundamentals">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="category" class="form-label">Category *</label>
                            <input type="text" class="form-control" id="category" name="category" 
                                   value="{{ old('category', $course->category) }}" required placeholder="e.g., Web Development">
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description *</label>
                    <textarea class="form-control" id="description" name="description" rows="4" required 
                              placeholder="Provide a detailed description of what students will learn...">{{ old('description', $course->description) }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="level" class="form-label">Level *</label>
                            <select class="form-select" id="level" name="level" required>
                                <option value="">Select Level</option>
                                <option value="beginner" {{ old('level', $course->level) === 'beginner' ? 'selected' : '' }}>Beginner</option>
                                <option value="intermediate" {{ old('level', $course->level) === 'intermediate' ? 'selected' : '' }}>Intermediate</option>
                                <option value="advanced" {{ old('level', $course->level) === 'advanced' ? 'selected' : '' }}>Advanced</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="duration" class="form-label">Duration *</label>
                            <input type="text" class="form-control" id="duration" name="duration" 
                                   value="{{ old('duration', $course->duration) }}" required placeholder="e.g., 8 weeks">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <label for="language" class="form-label">Language *</label>
                            <input type="text" class="form-control" id="language" name="language" 
                                   value="{{ old('language', $course->language) }}" required placeholder="e.g., English">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="price" class="form-label">Price ($) *</label>
                            <div class="input-group">
                                <span class="input-group-text">$</span>
                                <input type="number" class="form-control" id="price" name="price" 
                                       value="{{ old('price', $course->price) }}" step="0.01" min="0" required placeholder="0.00">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="status" class="form-label">Status *</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="">Select Status</option>
                                <option value="active" {{ old('status', $course->status) === 'active' ? 'selected' : '' }}>Active</option>
                                <option value="inactive" {{ old('status', $course->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                                <option value="pending" {{ old('status', $course->status) === 'pending' ? 'selected' : '' }}>Pending</option>
                            </select>
                        </div>
                    </div>
                </div>

                <div class="card bg-light mb-4">
                    <div class="card-body">
                        <h6 class="card-title mb-3">Course Statistics</h6>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="text-primary" style="font-size: 1.5rem; font-weight: bold;">
                                        {{ $course->students()->count() }}
                                    </div>
                                    <small class="text-muted">Enrolled Students</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="text-success" style="font-size: 1.5rem; font-weight: bold;">
                                        {{ $course->status }}
                                    </div>
                                    <small class="text-muted">Current Status</small>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="text-center">
                                    <div class="text-info" style="font-size: 1.5rem; font-weight: bold;">
                                        {{ $course->created_at->diffForHumans() }}
                                    </div>
                                    <small class="text-muted">Created</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-between">
                    <a href="{{ route('coach.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                    <div>
                        <a href="{{ route('coach.courses.show', $course) }}" class="btn btn-outline-info me-2">
                            <i class="fas fa-eye"></i> View Course
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i> Update Course
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
