<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CoachController extends Controller
{
    /**
     * Display the coach dashboard.
     * Shows courses managed by the coach and statistics
     */
    public function dashboard(): View
    {
        $coach = auth()->user();
        
        // Get courses taught by this coach
        $courses = $coach->coursesTeaching()->withCount('students')->get();
        
        // Get statistics
        $stats = [
            'total_courses' => $courses->count(),
            'total_students' => $courses->sum(function($course) {
                return $course->students_count ?? 0;
            }),
            'active_courses' => $courses->where('status', 'active')->count(),
            'pending_courses' => $courses->where('status', 'pending')->count(),
        ];
        
        // Get recent enrollments
        $recentEnrollments = [];
        foreach ($courses as $course) {
            $enrolledStudents = $course->students()
                ->withPivot('enrolled_at', 'pricing_plan_id')
                ->orderBy('course_user.enrolled_at', 'desc')
                ->take(3)
                ->get();
            foreach ($enrolledStudents as $student) {
                $recentEnrollments[] = [
                    'student' => $student,
                    'course' => $course,
                    'enrolled_at' => $student->pivot->enrolled_at
                ];
            }
        }
        
        // Sort by enrollment date
        usort($recentEnrollments, function($a, $b) {
            return $b['enrolled_at'] <=> $a['enrolled_at'];
        });
        
        $recentEnrollments = array_slice($recentEnrollments, 0, 5);
        
        return view('coach.dashboard', compact('courses', 'stats', 'recentEnrollments'));
    }
    
    /**
     * Show the form for creating a new course.
     */
    public function createCourse(): View
    {
        return view('coach.courses.create');
    }
    
    /**
     * Store a newly created course.
     */
    public function storeCourse(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'language' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,pending',
        ]);
        
        $course = Course::create([
            'title' => $request->title,
            'description' => $request->description,
            'level' => $request->level,
            'duration' => $request->duration,
            'category' => $request->category,
            'language' => $request->language,
            'price' => $request->price,
            'status' => $request->status,
            'instructor_id' => auth()->id(),
        ]);
        
        return redirect()->route('coach.dashboard')
            ->with('success', 'Course created successfully!');
    }
    
    /**
     * Show the form for editing the specified course.
     */
    public function editCourse(Course $course): View
    {
        // Ensure the coach owns this course
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'You can only edit your own courses.');
        }
        
        return view('coach.courses.edit', compact('course'));
    }
    
    /**
     * Update the specified course.
     */
    public function updateCourse(Request $request, Course $course): RedirectResponse
    {
        // Ensure the coach owns this course
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'You can only edit your own courses.');
        }
        
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'level' => 'required|in:beginner,intermediate,advanced',
            'duration' => 'required|string|max:100',
            'category' => 'required|string|max:100',
            'language' => 'required|string|max:50',
            'price' => 'required|numeric|min:0',
            'status' => 'required|in:active,inactive,pending',
        ]);
        
        $course->update($request->all());
        
        return redirect()->route('coach.dashboard')
            ->with('success', 'Course updated successfully!');
    }
    
    /**
     * Remove the specified course.
     */
    public function destroyCourse(Course $course): RedirectResponse
    {
        // Ensure the coach owns this course
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'You can only delete your own courses.');
        }
        
        // Check if course has enrolled students
        if ($course->students()->count() > 0) {
            return redirect()->route('coach.dashboard')
                ->with('error', 'Cannot delete course with enrolled students.');
        }
        
        $course->delete();
        
        return redirect()->route('coach.dashboard')
            ->with('success', 'Course deleted successfully!');
    }
    
    /**
     * Show course details with enrolled students.
     */
    public function showCourse(Course $course): View
    {
        // Ensure the coach owns this course
        if ($course->instructor_id !== auth()->id()) {
            abort(403, 'You can only view your own courses.');
        }
        
        $students = $course->students()->withPivot('enrolled_at', 'pricing_plan_id')->get();
        
        return view('coach.courses.show', compact('course', 'students'));
    }
}
