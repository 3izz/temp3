<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PricingPlanController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoachController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\AboutController;


// Public Routes
Route::get('/', [UserController::class, 'index'])->name('home');


Route::get('/about', [AboutController::class, 'index'])->name('about');

Route::get('/contact', function () {
    return view('contact');
})->name('contact');

Route::get('/faq', function () {
    return view('faq');
})->name('faq');

// Pricing Page (Public)
Route::get('/pricing', [PricingPlanController::class, 'index'])->name('pricing.index');

// Courses (Public)
Route::get('/courses', [CourseController::class, 'index'])->name('courses.index');
Route::get('/courses/search', [CourseController::class, 'search'])->name('courses.search');
Route::get('/home-search', [CourseController::class, 'homeSearch'])->name('home.search');
Route::get('/courses/{course}', [CourseController::class, 'show'])->name('courses.show');

// Authenticated Routes
Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User Dashboard
    Route::get('/dashboard', [UserController::class, 'home'])->middleware('verified')->name('dashboard');

    // Course Enrollment
    Route::post('/courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('/courses/{course}/unenroll', [CourseController::class, 'unenroll'])->name('courses.unenroll');

    // Chat
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{user}', [MessageController::class, 'show'])->name('chat.show');
    Route::get('/chat/{user}/messages', [MessageController::class, 'getMessages'])->name('chat.messages');
    Route::post('/chat/{user}/messages', [MessageController::class, 'sendMessage'])->name('chat.send');
});

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/dashboard', [CourseController::class, 'adminDashboard'])->name('admin.dashboard');

    // Courses Management
    Route::resource('courses', CourseController::class)->except(['index', 'show']);

    // Packages Management
    Route::get('/packages', [PricingPlanController::class, 'adminIndex'])->name('admin.packages.index');
    Route::get('/packages/create', [PricingPlanController::class, 'create'])->name('admin.packages.create');
    Route::post('/packages', [PricingPlanController::class, 'store'])->name('admin.packages.store');
    Route::get('/packages/{package}/edit', [PricingPlanController::class, 'edit'])->name('admin.packages.edit');
    Route::put('/packages/{package}', [PricingPlanController::class, 'update'])->name('admin.packages.update');
    Route::delete('/packages/{package}', [PricingPlanController::class, 'destroy'])->name('admin.packages.destroy');

    // Legacy admin routes (keeping for backward compatibility)
    Route::get('/dashboard/post', [UserController::class, 'post'])->name('admin.posts.index');
     
});
Route::get('/second', function() {
    return view('second'); // لازم تعمل ملف second.blade.php
})->name('second');

Route::get('/second2', function() {
    return view('second2'); // لازم تعمل ملف second2.blade.php
})->name('second2');
Route::get('/', [UserController::class, 'redirect'])->name('mainindex');
Route::get('/', function () {
    return view('home');  
})->name('home');

// Package Subscription Routes
Route::get('/pricing', [PricingPlanController::class, 'index'])->name('pricing.index');
Route::get('/pricing/select-courses/{package}', [PricingPlanController::class, 'selectCourses'])
    ->name('pricing.select-courses')
    ->middleware('auth'); // Require authentication to select courses
Route::post('/pricing/subscribe/{package}', [PricingPlanController::class, 'subscribe'])
    ->name('pricing.subscribe')
    ->middleware('auth'); // Require authentication to subscribe

// Checkout Routes
Route::get('/checkout', [CheckoutController::class, 'index'])
    ->name('checkout.index')
    ->middleware('auth'); // Require authentication for checkout
Route::post('/checkout/process', [CheckoutController::class, 'process'])
    ->name('checkout.process')
    ->middleware('auth'); // Require authentication for payment processing
Route::post('/checkout/cancel', [CheckoutController::class, 'cancel'])
    ->name('checkout.cancel')
    ->middleware('auth'); // Require authentication for cancellation

// الفورم لإضافة Coach أو Student من لوحة الإدارة
Route::post('/admin/add-coach', [RegisteredUserController::class, 'storeFromAdmin'])
    ->name('admin.store-coach')
    ->middleware(['auth', 'admin']); // ← إذا عندك Middleware يحمي Admin

// Coach Routes - Dedicated COACH interface
Route::middleware(['auth', 'coach'])->group(function () {
    Route::get('/coach-dashboard', [CoachController::class, 'dashboard'])
        ->name('coach.dashboard');
    
    // Course Management Routes for Coaches
    Route::get('/coach/courses/create', [CoachController::class, 'createCourse'])
        ->name('coach.courses.create');
    Route::post('/coach/courses', [CoachController::class, 'storeCourse'])
        ->name('coach.courses.store');
    Route::get('/coach/courses/{course}/edit', [CoachController::class, 'editCourse'])
        ->name('coach.courses.edit');
    Route::put('/coach/courses/{course}', [CoachController::class, 'updateCourse'])
        ->name('coach.courses.update');
    Route::delete('/coach/courses/{course}', [CoachController::class, 'destroyCourse'])
        ->name('coach.courses.destroy');
    Route::get('/coach/courses/{course}', [CoachController::class, 'showCourse'])
        ->name('coach.courses.show');
});

require __DIR__.'/auth.php';
