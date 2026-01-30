<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CourseController extends Controller
{
    // عرض كل الكورسات
    public function index(Request $request)
    {
        $query = trim((string) $request->query('query', ''));

        $coursesQuery = Course::with('instructor');

        if ($query !== '') {
            $coursesQuery->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('category', 'LIKE', "%{$query}%")
                    ->orWhereHas('instructor', function ($iq) use ($query) {
                        $iq->where('name', 'LIKE', "%{$query}%");
                    });
            });
        }

        $courses = $coursesQuery->latest()->paginate(10)->withQueryString();

        return view('courses.index', compact('courses', 'query'));
    }

    // عرض تفاصيل كورس واحد
    public function show(Course $course)
    {
        return view('single', compact('course'));
    }

    // صفحة إضافة كورس جديد (للمدرس)
    public function create()
    {
        return view('courses.create');
    }

    // حفظ الكورس الجديد
    public function store(Request $request)
    {
        // Validation
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'language' => 'required|string|max:50',
            'level' => 'required|string|max:50',
            'duration' => 'nullable|string|max:50',
            'price' => 'nullable|numeric',
            'category' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:active,draft,archived',
            'content' => 'nullable|string',
            'projects' => 'nullable|string',
            'objectives' => 'nullable|string',
        ]);

        $data = $request->only([
            'title', 'description', 'language', 'level', 'duration', 'price',
            'category', 'status', 'content', 'projects', 'objectives'
        ]);

        $data['instructor_id'] = Auth::id();

        // حفظ الصورة إذا تم رفعها
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        Course::create($data);

        return redirect()->route('admin.dashboard')->with('success', 'Course created successfully!');
    }

    // تعديل الكورس
    public function edit(Course $course)
    {
        $this->authorizeCourse($course);
        return view('courses.edit', compact('course'));
    }

    // تحديث الكورس
    public function update(Request $request, Course $course)
    {
        $this->authorizeCourse($course);

        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'language' => 'required|string|max:50',
            'level' => 'required|string|max:50',
            'duration' => 'nullable|string|max:50',
            'price' => 'nullable|numeric',
            'category' => 'nullable|string|max:50',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:active,draft,archived',
            'content' => 'nullable|string',
            'projects' => 'nullable|string',
            'objectives' => 'nullable|string',
        ]);

        $data = $request->only([
            'title', 'description', 'language', 'level', 'duration', 'price',
            'category', 'status', 'content', 'projects', 'objectives'
        ]);

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->update($data);

        return redirect()->route('admin.dashboard')->with('success', 'Course updated successfully!');
    }

    // حذف الكورس
    public function destroy(Course $course)
    {
        $this->authorizeCourse($course);
        $course->delete();
        return redirect()->route('admin.dashboard')->with('success', 'Course deleted successfully!');
    }

    // تسجيل الطالب في الكورس
    public function enroll(Course $course)
    {
        $user = Auth::user();
        if (!$user->enrolledCourses->contains($course->id)) {
            $user->enrolledCourses()->attach($course->id, ['enrolled_at' => now()]);
        }
        return redirect()->back()->with('success', 'You have enrolled in the course!');
    }

    // إلغاء التسجيل
    public function unenroll(Course $course)
    {
        $user = Auth::user();
        $user->enrolledCourses()->detach($course->id);
        return redirect()->back()->with('success', 'You have unenrolled from the course!');
    }

    // لوحة إدارة الكورسات
    public function adminDashboard()
    {
        $courses = Course::with('instructor')->latest()->paginate(10);
        $totalCourses = Course::count();
        $activeCourses = Course::where('status', 'active')->count();
        $totalPackages = \App\Models\PricingPlan::count();
        $popularPackages = \App\Models\PricingPlan::where('is_popular', true)->count();
        $totalStudents = \App\Models\User::where('role', 'user')->count();
        
        return view('admin.dashboard', compact('courses', 'totalCourses', 'activeCourses', 'totalPackages', 'popularPackages', 'totalStudents'));
    }

    // دالة للتحقق من صلاحية التعديل أو الحذف
    private function authorizeCourse(Course $course)
    {
        if ($course->instructor_id != Auth::id()) {
            abort(403);
        }
    }
     public function search(Request $request)
    {
        return $this->index($request);
    }

    public function homeSearch(Request $request): RedirectResponse
    {
        $query = trim((string) $request->query('query', ''));

        if ($query === '') {
            return redirect()->route('courses.index');
        }

        $exists = Course::query()
            ->where(function ($q) use ($query) {
                $q->where('title', 'LIKE', "%{$query}%")
                    ->orWhere('description', 'LIKE', "%{$query}%")
                    ->orWhere('category', 'LIKE', "%{$query}%")
                    ->orWhereHas('instructor', function ($iq) use ($query) {
                        $iq->where('name', 'LIKE', "%{$query}%");
                    });
            })
            ->exists();

        $redirect = redirect()->route('courses.index', ['query' => $query]);

        if (!$exists) {
            $redirect = $redirect->with('info', 'No courses were found for your search.');
        }

        return $redirect;
    }
      public function plans()
    {
        return $this->hasMany(Plan::class);
    }
    
    
}
