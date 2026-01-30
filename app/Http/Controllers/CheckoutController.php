<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\PricingPlan;
use App\Models\Course;
use App\Models\User;

class CheckoutController extends Controller
{
    /**
     * Display the checkout page with selected courses and pricing plan.
     */
    public function index(): View|RedirectResponse
    {
        $checkoutData = session('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('pricing.index')
                ->with('error', 'No checkout data found. Please select a package and courses first.');
        }

        return view('checkout.index', compact('checkoutData'));
    }

    /**
     * Process the checkout and create the subscription.
     */
    public function process(Request $request): RedirectResponse
    {
        $checkoutData = session('checkout_data');
        
        if (!$checkoutData) {
            return redirect()->route('pricing.index')
                ->with('error', 'No checkout data found. Please select a package and courses first.');
        }

        // Validate payment information (simplified for demo)
        $request->validate([
            'payment_method' => 'required|string|in:credit_card,paypal,bank_transfer',
            'terms_accepted' => 'accepted',
        ]);

        $user = auth()->user();
        $planId = $checkoutData['pricing_plan']['id'];
        $selectedCourses = $checkoutData['selected_courses'];

        // Get the pricing plan
        $package = PricingPlan::findOrFail($planId);

        // Create subscription by enrolling user in selected courses
        foreach ($selectedCourses as $courseId) {
            // Check if user is already enrolled in this course
            $alreadyEnrolled = $user->courses()
                ->where('course_id', $courseId)
                ->where('pricing_plan_id', $package->id)
                ->exists();
                
            if (!$alreadyEnrolled) {
                // Enroll user in the course with package reference
                $user->courses()->attach($courseId, [
                    'pricing_plan_id' => $package->id,
                    'enrolled_at' => now(),
                    'payment_method' => $request->payment_method,
                    'payment_status' => 'completed',
                ]);
            }
        }

        // Clear checkout data
        session()->forget('checkout_data');

        return redirect()->route('dashboard')
            ->with('success', "Payment successful! You are now enrolled in " . count($selectedCourses) . " course(s) with the {$package->name} package.");
    }

    /**
     * Cancel checkout and return to pricing page.
     */
    public function cancel(): RedirectResponse
    {
        session()->forget('checkout_data');
        
        return redirect()->route('pricing.index')
            ->with('info', 'Checkout cancelled. You can select a different package if needed.');
    }
}
