@extends('layouts.app')

@section('content')
<div class="container-fluid" style="padding: 20px;">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h1 style="color: #2c3e50; font-weight: 600;">
                        <i class="fas fa-chalkboard-user"></i> Coach Dashboard
                    </h1>
                    <p class="text-muted mb-0">Welcome back, {{ auth()->user()->name }}! Manage your courses and track student progress.</p>
                </div>
                <div>
                    <a href="{{ route('chat.index') }}" class="btn btn-info me-2">
                        <i class="fas fa-comments"></i> Messages
                    </a>
                    <a href="{{ route('coach.courses.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Course
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1" style="font-size: 0.875rem; opacity: 0.9;">Total Courses</h6>
                            <h3 class="mb-0">{{ $stats['total_courses'] }}</h3>
                        </div>
                        <div style="font-size: 2rem; opacity: 0.7;">
                            <i class="fas fa-book"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1" style="font-size: 0.875rem; opacity: 0.9;">Total Students</h6>
                            <h3 class="mb-0">{{ $stats['total_students'] }}</h3>
                        </div>
                        <div style="font-size: 2rem; opacity: 0.7;">
                            <i class="fas fa-users"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1" style="font-size: 0.875rem; opacity: 0.9;">Active Courses</h6>
                            <h3 class="mb-0">{{ $stats['active_courses'] }}</h3>
                        </div>
                        <div style="font-size: 2rem; opacity: 0.7;">
                            <i class="fas fa-play-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1">
                            <h6 class="card-title mb-1" style="font-size: 0.875rem; opacity: 0.9;">Pending Courses</h6>
                            <h3 class="mb-0">{{ $stats['pending_courses'] }}</h3>
                        </div>
                        <div style="font-size: 2rem; opacity: 0.7;">
                            <i class="fas fa-clock"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Courses Section -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="mb-0" style="color: #2c3e50;">
                        <i class="fas fa-graduation-cap"></i> My Courses
                    </h5>
                </div>
                <div class="card-body">
                    @if($courses->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Course</th>
                                        <th>Level</th>
                                        <th>Students</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($courses as $course)
                                        <tr>
                                            <td>
                                                <div>
                                                    <strong>{{ $course->title }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $course->category }} • {{ $course->duration }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $course->level === 'beginner' ? 'success' : ($course->level === 'intermediate' ? 'warning' : 'danger') }}">
                                                    {{ ucfirst($course->level) }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-info">
                                                    {{ $course->students_count ?? 0 }} students
                                                </span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $course->status === 'active' ? 'success' : ($course->status === 'pending' ? 'warning' : 'secondary') }}">
                                                    {{ ucfirst($course->status) }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <a href="{{ route('coach.courses.show', $course) }}" class="btn btn-outline-primary" title="View">
                                                        <i class="fas fa-eye"></i>
                                                    </a>
                                                    <a href="{{ route('coach.courses.edit', $course) }}" class="btn btn-outline-warning" title="Edit">
                                                        <i class="fas fa-edit"></i>
                                                    </a>
                                                    <form action="{{ route('coach.courses.destroy', $course) }}" method="POST" style="display: inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-outline-danger" title="Delete" onclick="return confirm('Are you sure you want to delete this course?')">
                                                            <i class="fas fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <div style="font-size: 3rem; color: #dee2e6; margin-bottom: 1rem;">
                                <i class="fas fa-book-open"></i>
                            </div>
                            <h5 style="color: #6c757d;">No Courses Yet</h5>
                            <p class="text-muted">Start by creating your first course.</p>
                            <a href="{{ route('coach.courses.create') }}" class="btn btn-primary">
                                <i class="fas fa-plus"></i> Create Your First Course
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pt-4">
                    <h5 class="mb-0" style="color: #2c3e50;">
                        <i class="fas fa-history"></i> Recent Enrollments
                    </h5>
                </div>
                <div class="card-body">
                    @if(count($recentEnrollments) > 0)
                        <div class="timeline">
                            @foreach($recentEnrollments as $enrollment)
                                <div class="timeline-item mb-3">
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                <i class="fas fa-user"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <h6 class="mb-1">{{ $enrollment['student']->name }}</h6>
                                            <p class="mb-1 text-muted">Enrolled in <strong>{{ $enrollment['course']->title }}</strong></p>
                                            <small class="text-muted">{{ $enrollment['enrolled_at']->diffForHumans() }}</small>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div style="font-size: 2rem; color: #dee2e6; margin-bottom: 1rem;">
                                <i class="fas fa-user-clock"></i>
                            </div>
                            <p class="text-muted mb-0">No recent enrollments</p>
                        </div>
                    @endif
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
    left: 20px;
    top: 40px;
    width: 2px;
    height: calc(100% + 10px);
    background: #e9ecef;
}

.card {
    transition: transform 0.2s ease-in-out;
}

.card:hover {
    transform: translateY(-2px);
}

.btn-group-sm .btn {
    padding: 0.25rem 0.5rem;
}

.table th {
    border-top: none;
    font-weight: 600;
    color: #495057;
    font-size: 0.875rem;
}
</style>
@endsection
