@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding: 20px;">
    <div class="mb-4">
        <a href="{{ route('coach.dashboard') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Back to Dashboard
        </a>
        <h1 class="mt-3" style="color: #2c3e50;">
            <i class="fas fa-graduation-cap"></i> {{ $course->title }}
        </h1>
        <p class="text-muted">{{ $course->description }}</p>
    </div>

    <div class="row">
        <!-- Course Details -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Course Information</h5>
                        <div>
                            <a href="{{ route('coach.courses.edit', $course) }}" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i> Edit Course
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Category:</strong></td>
                                    <td>{{ $course->category }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Level:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $course->level === 'beginner' ? 'success' : ($course->level === 'intermediate' ? 'warning' : 'danger') }}">
                                            {{ ucfirst($course->level) }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td><strong>Duration:</strong></td>
                                    <td>{{ $course->duration }}</td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <table class="table table-borderless">
                                <tr>
                                    <td><strong>Language:</strong></td>
                                    <td>{{ $course->language }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Price:</strong></td>
                                    <td>${{ number_format($course->price, 2) }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Status:</strong></td>
                                    <td>
                                        <span class="badge bg-{{ $course->status === 'active' ? 'success' : ($course->status === 'pending' ? 'warning' : 'secondary') }}">
                                            {{ ucfirst($course->status) }}
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="mt-3">
                        <h6>Course Description</h6>
                        <p class="text-muted">{{ $course->description }}</p>
                    </div>
                </div>
            </div>

            <!-- Enrolled Students -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">
                        <i class="fas fa-users"></i> Enrolled Students ({{ $students->count() }})
                    </h5>
                </div>
                <div class="card-body">
                    @if($students->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Student Name</th>
                                        <th>Email</th>
                                        <th>Enrollment Date</th>
                                        <th>Package</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($students as $student)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" 
                                                         style="width: 32px; height: 32px; font-size: 0.875rem;">
                                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                                    </div>
                                                    <strong>{{ $student->name }}</strong>
                                                </div>
                                            </td>
                                            <td>{{ $student->email }}</td>
                                            <td>{{ $student->pivot->enrolled_at->format('M d, Y') }}</td>
                                            <td>
                                                @if($student->pivot->pricing_plan_id)
                                                    <span class="badge bg-info">
                                                        {{ \App\Models\PricingPlan::find($student->pivot->pricing_plan_id)?->name ?? 'Unknown' }}
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">Direct</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div style="font-size: 3rem; color: #dee2e6; margin-bottom: 1rem;">
                                <i class="fas fa-user-graduate"></i>
                            </div>
                            <h5 style="color: #6c757d;">No Students Yet</h5>
                            <p class="text-muted">Students haven't enrolled in this course yet.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Quick Stats -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Quick Stats</h5>
                </div>
                <div class="card-body">
                    <div class="text-center mb-3">
                        <div class="text-primary" style="font-size: 2rem; font-weight: bold;">
                            {{ $students->count() }}
                        </div>
                        <small class="text-muted">Total Students</small>
                    </div>
                    <div class="text-center">
                        <div class="text-success" style="font-size: 2rem; font-weight: bold;">
                            ${{ number_format($course->price * $students->count(), 2) }}
                        </div>
                        <small class="text-muted">Total Revenue</small>
                    </div>
                </div>
            </div>

            <!-- Course Actions -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('coach.courses.edit', $course) }}" class="btn btn-warning">
                            <i class="fas fa-edit"></i> Edit Course
                        </a>
                        @if($students->count() == 0)
                            <form action="{{ route('coach.courses.destroy', $course) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger w-100" onclick="return confirm('Are you sure you want to delete this course?')">
                                    <i class="fas fa-trash"></i> Delete Course
                                </button>
                            </form>
                        @else
                            <button class="btn btn-danger w-100" disabled title="Cannot delete course with enrolled students">
                                <i class="fas fa-trash"></i> Delete Course (Not Available)
                            </button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Course Timeline -->
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0">
                    <h5 class="mb-0">Course Timeline</h5>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-success text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                        <i class="fas fa-plus"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Course Created</h6>
                                    <small class="text-muted">{{ $course->created_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @if($course->updated_at != $course->created_at)
                        <div class="timeline-item">
                            <div class="d-flex">
                                <div class="flex-shrink-0">
                                    <div class="rounded-circle bg-warning text-white d-flex align-items-center justify-content-center" style="width: 32px; height: 32px; font-size: 0.875rem;">
                                        <i class="fas fa-edit"></i>
                                    </div>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <h6 class="mb-1">Last Updated</h6>
                                    <small class="text-muted">{{ $course->updated_at->format('M d, Y') }}</small>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.timeline-item {
    position: relative;
}

.timeline-item:not(:last-child)::after {
    content: '';
    position: absolute;
    left: 16px;
    top: 32px;
    width: 2px;
    height: calc(100% + 10px);
    background: #e9ecef;
}
</style>
@endsection
