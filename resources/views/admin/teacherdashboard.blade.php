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
        
            
        </ul>
    </aside>

    <main class="main-content">
        <header class="top-navbar">
            <div class="menu-toggle" id="menu-toggle">
                <i class="fas fa-bars"></i>
            </div>
            
            

            <div class="nav-right">
                <div class="notification-icon">
                    <i class="fas fa-bell"></i>
                    <span class="badge">3</span>
                </div>
                <div class="profile-dropdown" data-section="profile">
                    <img src="https://i.pravatar.cc/150?img=12" alt="Admin" class="profile-img">
                    <span>Admin User</span>
                    <i class="fas fa-chevron-down" style="font-size: 0.8rem;"></i>
                </div>
            </div>
        </header>

        <div class="container">
            
            

            <section id="courses" class="content-section">
                <h2 class="section-title">Manage Courses</h2>
                @include('courses.create') <!-- Include the course creation form -->
                @include('courses.delete')
               <!-- Include the course deletion table -->
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

             

            

    <script src="{{ asset('js/admin-dashboard.js') }}"></script>
</body>
</html>