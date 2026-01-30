<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modern Course Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* =========================================
           1. CORE VARIABLES & RESET
           ========================================= */
        :root {
            --primary-color: #4f46e5; /* Indigo */
            --primary-hover: #4338ca;
            --secondary-color: #64748b;
            --bg-color: #f3f4f6;
            --sidebar-bg: #1e293b; /* Dark Slate */
            --card-bg: #ffffff;
            --text-dark: #1f2937;
            --text-light: #9ca3af;
            --danger: #ef4444;
            --success: #10b981;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --radius: 12px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            display: flex;
            min-height: 100vh;
            color: var(--text-dark);
            overflow-x: hidden;
        }

        /* =========================================
           2. SIDEBAR STYLING
           ========================================= */
        .sidebar {
            width: 260px;
            background-color: var(--sidebar-bg);
            color: #fff;
            display: flex;
            flex-direction: column;
            transition: var(--transition);
            position: fixed;
            height: 100%;
            z-index: 1000;
        }

        .sidebar-header {
            padding: 20px;
            font-size: 1.5rem;
            font-weight: bold;
            text-align: center;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .nav-links {
            list-style: none;
            padding-top: 20px;
            flex: 1;
        }

        .nav-links li a {
            display: flex;
            align-items: center;
            padding: 15px 25px;
            color: #cbd5e1;
            text-decoration: none;
            transition: var(--transition);
            cursor: pointer;
        }

        .nav-links li a:hover, .nav-links li a.active {
            background-color: var(--primary-color);
            color: white;
            border-left: 4px solid #fff;
        }

        .nav-links li a i {
            margin-right: 15px;
            width: 20px;
        }

        /* =========================================
           3. MAIN CONTENT LAYOUT
           ========================================= */
        .main-content {
            margin-left: 260px; /* Width of sidebar */
            flex: 1;
            display: flex;
            flex-direction: column;
            width: calc(100% - 260px);
        }

        /* =========================================
           4. TOP NAVBAR STYLING
           ========================================= */
        .top-navbar {
            background-color: var(--card-bg);
            padding: 15px 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: var(--shadow);
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .menu-toggle {
            display: none; /* Hidden on desktop */
            font-size: 1.5rem;
            cursor: pointer;
            color: var(--text-dark);
        }

        .search-bar {
            position: relative;
        }

        .search-bar input {
            padding: 10px 15px 10px 40px;
            border-radius: 20px;
            border: 1px solid #e2e8f0;
            outline: none;
            width: 300px;
            transition: var(--transition);
        }

        .search-bar input:focus {
            border-color: var(--primary-color);
            width: 350px;
        }

        .search-bar i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--secondary-color);
        }

        .nav-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .notification-icon {
            position: relative;
            cursor: pointer;
            font-size: 1.2rem;
            color: var(--secondary-color);
        }

        .badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: var(--danger);
            color: white;
            font-size: 0.7rem;
            padding: 2px 5px;
            border-radius: 50%;
        }

        .profile-dropdown {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
        }

        .profile-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--primary-color);
        }

        /* =========================================
           5. CONTENT SECTIONS
           ========================================= */
        .container {
            padding: 30px;
        }

        .section-title {
            margin-bottom: 25px;
            font-size: 1.8rem;
            color: var(--text-dark);
        }

        /* Helper to hide/show sections via JS */
        .content-section {
            display: none;
            animation: fadeIn 0.4s ease-in-out;
        }

        .content-section.active {
            display: block;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* --- Dashboard Cards --- */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .card {
            background: var(--card-bg);
            padding: 25px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            display: flex;
            align-items: center;
            justify-content: space-between;
            transition: var(--transition);
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card-info h3 {
            font-size: 2.2rem;
            color: var(--text-dark);
        }

        .card-info p {
            color: var(--secondary-color);
            font-size: 0.9rem;
        }

        .card-icon {
            font-size: 2.5rem;
            opacity: 0.2;
            color: var(--primary-color);
        }

        /* --- Tables --- */
        .table-container {
            background: var(--card-bg);
            padding: 20px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background-color: #f8fafc;
            color: var(--secondary-color);
            font-weight: 600;
        }

        /* Status Badges */
        .status {
            padding: 5px 12px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 500;
        }
        .status.active { background-color: #d1fae5; color: #065f46; }
        .status.inactive { background-color: #fee2e2; color: #991b1b; }
        .status.pending { background-color: #fef3c7; color: #92400e; }

        /* Buttons */
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: var(--transition);
            font-size: 0.9rem;
        }
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        .btn-primary:hover { background-color: var(--primary-hover); }
        
        .btn-danger {
            background-color: var(--danger);
            color: white;
        }
        .btn-danger:hover { background-color: #dc2626; }

        .action-btn {
            margin-right: 5px;
            padding: 5px 10px;
        }

        /* --- Teams Form --- */
        .form-container {
            background: var(--card-bg);
            padding: 25px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            margin-top: 25px;
            max-width: 600px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
        }

        .form-group input, .form-group textarea, .form-group select {
            width: 100%;
            padding: 10px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            outline: none;
        }

        .form-group input:focus {
            border-color: var(--primary-color);
        }

        /* --- Analytics Charts --- */
        .charts-container {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
        }
        
        .chart-card {
            background: var(--card-bg);
            padding: 20px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            height: 350px;
            position: relative;
        }

        /* --- Profile Section --- */
        .profile-container {
            display: flex;
            gap: 30px;
            flex-wrap: wrap;
        }

        .profile-pic-section {
            background: var(--card-bg);
            padding: 30px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            text-align: center;
            flex: 1;
            min-width: 250px;
        }

        .profile-pic-large {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 15px;
            border: 4px solid var(--bg-color);
        }

        .profile-details-section {
            background: var(--card-bg);
            padding: 30px;
            border-radius: var(--radius);
            box-shadow: var(--shadow);
            flex: 2;
            min-width: 300px;
        }

        /* =========================================
           6. RESPONSIVE DESIGN (Mobile/Tablet)
           ========================================= */
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
                width: 100%;
            }

            .menu-toggle {
                display: block;
            }

            .search-bar input {
                width: 150px;
            }
            
            .search-bar input:focus {
                width: 200px;
            }

            .charts-container {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>

    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <i class="fas fa-graduation-cap"></i> EduDash
        </div>
        <ul class="nav-links">
            <li><a href="#" data-section="dashboard" class="active" id="nav-dashboard"><i class="fas fa-home"></i> Dashboard</a></li>
            <li><a href="#" data-section="courses" id="nav-courses"><i class="fas fa-book-open"></i> Courses</a></li>
            <li><a href="#" data-section="students" id="nav-students"><i class="fas fa-user-graduate"></i> Students</a></li>
            <li><a href="#" data-section="instructors" id="nav-instructors"><i class="fas fa-chalkboard-user"></i> Instructors</a></li>
            <li><a href="#" data-section="packages" id="nav-packages"><i class="fas fa-box"></i> Packages</a></li>
            <li><a href="#" data-section="analytics" id="nav-analytics"><i class="fas fa-chart-line"></i> Analytics</a></li>
            <li><a href="#" data-section="settings" id="nav-settings"><i class="fas fa-cog"></i> Settings</a></li>
            <li><a href="#" data-section="profile" id="nav-profile"><i class="fas fa-user-circle"></i> Profile</a></li>
        </ul>
    </aside>

    <main class="main-content">
        <header class="top-navbar">
    <div class="menu-toggle" id="menu-toggle">
        <i class="fas fa-bars"></i>
    </div>
    
    <div class="search-bar">
        <i class="fas fa-search"></i>
        <input type="text" placeholder="Search courses, students...">
    </div>

    <div class="nav-right">
        <div class="notification-icon">
             
             
        </div>

        <div class="profile-dropdown" data-section="profile">
            
            <img src="<?php echo e(Auth::user()->profile_image ? asset('storage/' . Auth::user()->profile_image) : 'https://i.pravatar.cc/150?img=12'); ?>" 
                 alt="<?php echo e(Auth::user()->name); ?>" class="profile-img">

            
            <span><?php echo e(Auth::user()->name); ?></span>

            <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
        </div>
    </div>
</header>

        <div class="container">
            
            <section id="dashboard" class="content-section active">
                <h2 class="section-title">Dashboard Overview</h2>
                <div class="cards-grid">
                    <div class="card">
                        <div class="card-info">
                            <h3><?php echo e($totalCourses ?? 0); ?></h3>
                            <p>Total Courses</p>
                        </div>
                        <div class="card-icon"><i class="fas fa-book"></i></div>
                    </div>
                    <div class="card">
                        <div class="card-info">
                            <h3><?php echo e($activeCourses ?? 0); ?></h3>
                            <p>Active Courses</p>
                        </div>
                        <div class="card-icon"><i class="fas fa-check-circle"></i></div>
                    </div>
                    <div class="card">
                        <div class="card-info">
                            <h3><?php echo e($totalPackages ?? 0); ?></h3>
                            <p>Total Packages</p>
                        </div>
                        <div class="card-icon"><i class="fas fa-box"></i></div>
                    </div>
                    <div class="card">
                        <div class="card-info">
                            <h3><?php echo e($popularPackages ?? 0); ?></h3>
                            <p>Popular Packages</p>
                        </div>
                        <div class="card-icon"><i class="fas fa-star"></i></div>
                    </div>
                    <div class="card">
                        <div class="card-info">
                            <h3><?php echo e($totalStudents ?? 0); ?></h3>
                            <p>Total Students</p>
                        </div>
                        <div class="card-icon"><i class="fas fa-users"></i></div>
                    </div>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-top: 30px;">
                    <div>
                        <h3 style="margin-bottom: 15px;">Quick Actions</h3>
                        <div style="display: flex; flex-direction: column; gap: 10px;">
                            <a href="<?php echo e(route('admin.packages.index')); ?>" style="background-color: #4f46e5; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 500;">
                                <i class="fas fa-box"></i> Manage Packages
                            </a>
                            <a href="<?php echo e(route('admin.packages.create')); ?>" style="background-color: #10b981; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 500;">
                                <i class="fas fa-plus"></i> Create New Package
                            </a>
                            <a href="<?php echo e(route('courses.create')); ?>" style="background-color: #f59e0b; color: white; padding: 12px 20px; border-radius: 6px; text-decoration: none; font-weight: 500;">
                                <i class="fas fa-book"></i> Create New Course
                            </a>
                        </div>
                    </div>
                    <div>
                        <h3 style="margin-bottom: 15px;">Recent Courses</h3>
                        <div class="table-container">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Title</th>
                                        <th>Status</th>
                                        <th>Instructor</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $courses->take(5); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($course->title); ?></td>
                                            <td><span class="status <?php echo e($course->status); ?>"><?php echo e(ucfirst($course->status)); ?></span></td>
                                            <td><?php echo e($course->instructor->name ?? 'N/A'); ?></td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        <tr>
                                            <td colspan="3" style="text-align: center; padding: 20px; color: #64748b;">No courses found</td>
                                        </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </section>

            <section id="courses" class="content-section">
                <h2 class="section-title">Manage Courses</h2>
                <?php echo $__env->make('courses.create', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> <!-- Include the course creation form -->
                <?php echo $__env->make('courses.delete', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
               <!-- Include the course deletion table -->
            </section>

            <section id="packages" class="content-section">
                <h2 class="section-title">Packages Management</h2>
                <div style="margin-bottom: 20px;">
                    <a href="<?php echo e(route('admin.packages.create')); ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Create New Package
                    </a>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Courses</th>
                                <th>Type</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $packages = \App\Models\PricingPlan::with('courses')->latest()->take(10)->get();
                            ?>
                            <?php $__empty_1 = true; $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td>
                                        <strong><?php echo e($package->name); ?></strong>
                                        <?php if($package->is_popular): ?>
                                            <span class="status active" style="margin-left: 8px;">Popular</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>₹ <?php echo e(number_format($package->price, 2)); ?></td>
                                    <td><?php echo e($package->courses->count()); ?> course(s)</td>
                                    <td><?php echo e(ucfirst($package->target_type)); ?></td>
                                    <td>
                                        <a href="<?php echo e(route('admin.packages.edit', $package)); ?>" class="btn btn-primary action-btn">
                                            <i class="fas fa-edit"></i> Edit
                                        </a>
                                        <form action="<?php echo e(route('admin.packages.destroy', $package)); ?>" method="POST" style="display: inline-block;" data-confirm="Are you sure you want to delete this package?">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('DELETE'); ?>
                                            <button type="submit" class="btn btn-danger action-btn">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="5" style="text-align: center; padding: 20px; color: #64748b;">No packages found. <a href="<?php echo e(route('admin.packages.create')); ?>">Create your first package</a></td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
                <div style="margin-top: 20px;">
                    <a href="<?php echo e(route('admin.packages.index')); ?>" class="btn btn-primary">View All Packages</a>
                </div>
            </section>

            <section id="analytics" class="content-section">
                <h2 class="section-title">Performance Analytics</h2>
                <div class="charts-container">
                    <div class="chart-card">
                        <h3>Student Distribution</h3>
                        <canvas id="pieChart"></canvas>
                    </div>
                    <div class="chart-card">
                        <h3>Enrollment per Course</h3>
                        <canvas id="barChart"></canvas>
                    </div>
                    <div class="chart-card">
                        <h3>Completion Rate (Over Time)</h3>
                        <canvas id="lineChart"></canvas>
                    </div>
                </div>
            </section>

            <section id="profile" class="content-section">
                <h2 class="section-title">My Profile</h2>
                <div class="profile-container">
                    <div class="profile-pic-section">
                        <img src="https://i.pravatar.cc/150?img=12" alt="User" class="profile-pic-large">
                        <h3>Admin User</h3>
                        <p class="status active" style="display:inline-block; margin-top:5px;">Administrator</p>
                        <br><br>
                        <button class="btn btn-primary">Change Photo</button>
                    </div>
                    
                    <div class="profile-details-section">
                        <h3>Edit Details</h3>
                        <br>
                        <form onsubmit="event.preventDefault(); alert('Profile Saved Successfully!');">
                            <div class="form-group">
                                <label>Full Name</label>
                                <input type="text" value="Admin User">
                            </div>
                            <div class="form-group">
                                <label>Email Address</label>
                                <input type="email" value="admin@edudash.com">
                            </div>
                            <div class="form-group">
                                <label>New Password</label>
                                <input type="password" placeholder="Leave blank to keep current">
                            </div>
                            <div class="form-group">
                                <label>Bio</label>
                                <textarea rows="4" style="width:100%; border:1px solid #cbd5e1; border-radius:6px; padding:10px;">Senior Administrator managing all courses.</textarea>
                            </div>
                            <div style="text-align: right;">
                                <button class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </section>

            <section id="students" class="content-section">
                <h2>Students Section</h2><p>Content placeholder...</p>
            </section>
           <section id="instructors" class="content-section">
    <h2>Instructors Section</h2>

    <!-- الفورم لإضافة Coach / Student -->
    <div class="add-coach-form" style="max-width:500px; margin:auto; padding:20px; border:1px solid #ccc; border-radius:8px; background:#f9f9f9;">
        <!-- رسالة النجاح -->
        <?php if(session('success')): ?>
            <div style="color: green; text-align:center; margin-bottom:15px;">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <form action="<?php echo e(route('admin.store-coach')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>

            <!-- الاسم -->
            <div style="margin-bottom:15px;">
                <label>Name:</label>
                <input type="text" name="name" value="<?php echo e(old('name')); ?>" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
                <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:red; font-size:13px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- الايميل -->
            <div style="margin-bottom:15px;">
                <label>Email:</label>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:red; font-size:13px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- كلمة المرور -->
            <div style="margin-bottom:15px;">
                <label>Password:</label>
                <input type="password" name="password" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
                <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:red; font-size:13px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- تأكيد كلمة المرور -->
            <div style="margin-bottom:15px;">
                <label>Confirm Password:</label>
                <input type="password" name="password_confirmation" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
            </div>

            <!-- اختيار الدور -->
            <div style="margin-bottom:15px;">
                <label>Role:</label>
                <select name="role" style="width:100%; padding:8px; border-radius:4px; border:1px solid #ccc;">
                    <option value="student" <?php echo e(old('role') == 'student' ? 'selected' : ''); ?>>Student</option>
                    <option value="coach" <?php echo e(old('role') == 'coach' ? 'selected' : ''); ?>>Coach</option>
                </select>
                <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:red; font-size:13px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- رفع صورة البروفايل -->
            <div style="margin-bottom:20px;">
                <label>Profile Photo (optional):</label>
                <input type="file" name="profile_photo" style="width:100%; padding:8px;">
                <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div style="color:red; font-size:13px;"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </div>

            <!-- زر الإرسال -->
            <div style="text-align:center;">
                <button type="submit" style="padding:10px 20px; border:none; border-radius:5px; background:#4CAF50; color:white; cursor:pointer;">
                    Add User
                </button>
            </div>
        </form>
    </div>

</section>

            <section id="settings" class="content-section">
                <h2>Settings Section</h2><p>Content placeholder...</p>
            </section>

        </div>
    </main>

    <script src="<?php echo e(asset('js/admin-dashboard.js')); ?>"></script>
</body>
</html><?php /**PATH C:\xampp\htdocs\blog2\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>