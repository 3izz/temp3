<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePricingPlanRequest;
use App\Http\Requests\UpdatePricingPlanRequest;
use App\Models\PricingPlan;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PricingPlanController extends Controller
{
    /**
     * Display the public pricing page with all available packages.
     */
    public function index(): View
    {
        // Get all pricing plans with their associated courses
        $plans = PricingPlan::with('courses')->get();
        
        return view('pricing.index', compact('plans'));
    }

    /**
     * Display a listing of packages for admin.
     */
    public function adminIndex(): View
    {
        $plans = PricingPlan::with('courses')->latest()->paginate(10);

        return view('admin.packages.index', compact('plans'));
    }

    /**
     * Show the form for creating a new package.
     */
    public function create(): View
    {
        $courses = Course::where('status', 'active')->get();

        return view('admin.packages.create', compact('courses'));
    }

    /**
     * Store a newly created package.
     */
    public function store(StorePricingPlanRequest $request): RedirectResponse
    {
        $data = $request->validated();
        $courseIds = $data['course_ids'];
        unset($data['course_ids']);

        $plan = PricingPlan::create($data);
        $plan->courses()->attach($courseIds);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package created successfully.');
    }

    /**
     * Show the form for editing the specified package.
     */
    public function edit(PricingPlan $package): View
    {
        $package->load('courses');
        $courses = Course::where('status', 'active')->get();

        return view('admin.packages.edit', compact('package', 'courses'));
    }

    /**
     * Update the specified package.
     */
    public function update(UpdatePricingPlanRequest $request, PricingPlan $package): RedirectResponse
    {
        $data = $request->validated();
        $courseIds = $data['course_ids'];
        unset($data['course_ids']);

        $package->update($data);
        $package->courses()->sync($courseIds);

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package updated successfully.');
    }

    /**
     * Remove the specified package.
     */
    public function destroy(PricingPlan $package): RedirectResponse
    {
        $package->courses()->detach();
        $package->delete();

        return redirect()->route('admin.packages.index')
            ->with('success', 'Package deleted successfully.');
    }

    /**
     * Show course selection page for a specific package.
     * Displays all active courses; only courses in the package are unlockable/selectable.
     */
    public function selectCourses(PricingPlan $package): View
    {
        $package->load('courses');
        $unlockedCourseIds = $package->courses()->where('status', 'active')->pluck('courses.id')->toArray();
        $courses = Course::with('instructor')->where('status', 'active')->latest()->get();
        $maxSelectable = $package->max_courses ?? 1;

        return view('pricing.select-courses', compact('package', 'courses', 'unlockedCourseIds', 'maxSelectable'));
    }

    /**
     * Process the course selection and redirect to checkout.
     * Validates that user selected the exact number of courses as defined by admin.
     */
    public function subscribe(Request $request, PricingPlan $package): RedirectResponse
    {
        // Validate the request
        $request->validate([
            'selected_courses' => 'required|array',
            'selected_courses.*' => 'exists:courses,id',
        ]);

        $selectedCourses = array_values(array_unique($request->input('selected_courses', [])));
        $expectedCount = $package->max_courses ?? 1;
        $allowedCourseIds = $package->courses()->pluck('courses.id')->toArray();

        if (count($selectedCourses) !== $expectedCount) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'selected_courses' => "You must select exactly {$expectedCount} course(s) for this package. Selected: ".count($selectedCourses),
                ]);
        }

        foreach ($selectedCourses as $courseId) {
            if (! in_array((int) $courseId, $allowedCourseIds, true)) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['selected_courses' => 'One or more selected courses are not included in this package.']);
            }
        }

        // Store checkout data in session
        session([
            'checkout_data' => [
                'pricing_plan' => [
                    'id' => $package->id,
                    'name' => $package->name,
                    'description' => $package->description,
                    'price' => $package->price,
                    'max_courses' => $package->max_courses,
                ],
                'selected_courses' => $selectedCourses,
                'courses_details' => Course::whereIn('id', $selectedCourses)->get()->map(function($course) {
                    return [
                        'id' => $course->id,
                        'title' => $course->title,
                        'description' => $course->description,
                        'instructor' => $course->instructor->name ?? 'N/A',
                    ];
                })->toArray()
            ]
        ]);

        return redirect()->route('checkout.index')
            ->with('success', 'Course selection complete! Please proceed to checkout.');
    }
}
