<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create New Course</title>
    <style>
        /* ============================
           1. CSS VARIABLES & RESET
           ============================ */
        :root {
            --primary-color: #4f46e5; /* Indigo */
            --primary-hover: #4338ca;
            --text-dark: #1f2937;
            --text-light: #6b7280;
            --border-color: #d1d5db;
            --bg-color: #f3f4f6;
            --white: #ffffff;
            --radius: 8px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: var(--bg-color);
            padding: 40px 20px;
            color: var(--text-dark);
        }

        /* ============================
           2. MAIN CONTAINER
           ============================ */
        .course-form-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: var(--white);
            padding: 40px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .form-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 30px;
            color: var(--text-dark);
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }

        /* ============================
           3. FORM ELEMENTS
           ============================ */
        .form-group {
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: var(--text-dark);
            font-size: 0.95rem;
        }

        input[type="text"],
        input[type="number"],
        input[type="file"],
        select,
        textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            font-size: 1rem;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
            background-color: #fff;
        }

        /* Focus State */
        input:focus,
        select:focus,
        textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }

        textarea {
            resize: vertical; /* Allow vertical resizing only */
        }

        /* File Input Styling */
        input[type="file"] {
            padding: 10px;
            background-color: #f9fafb;
        }

        /* ============================
           4. GRID LAYOUT (Two Columns)
           ============================ */
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        /* Responsive: Stack on mobile */
        @media (max-width: 600px) {
            .form-row {
                grid-template-columns: 1fr;
            }
            .course-form-container {
                padding: 20px;
            }
        }

        /* ============================
           5. BUTTONS
           ============================ */
        .form-actions {
            margin-top: 30px;
            text-align: right;
        }

        .btn-submit {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 30px;
            border: none;
            border-radius: var(--radius);
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .btn-submit:hover {
            background-color: var(--primary-hover);
        }
    </style>
</head>
<body>
  <div class="course-form-container">
        <h2 class="form-title">Create New Course</h2>

        <form action="{{ route('courses.store') }}" method="POST" enctype="multipart/form-data">
            @csrf <!-- ← هذا يجب أن يكون داخل الفورم -->

            <div class="form-group">
                <label for="title">Course Title</label>
                <input type="text" id="title" name="title" placeholder="Enter course title (e.g. Master CSS Grid)" required>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="5" placeholder="Enter a detailed course description..."></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="language">Language</label>
                    <input type="text" id="language" name="language" placeholder="e.g. Python, English" required>
                </div>
                <div class="form-group">
                    <label for="level">Level</label>
                    <select id="level" name="level" required>
                        <option value="" disabled selected>Select level</option>
                        <option value="Beginner">Beginner</option>
                        <option value="Intermediate">Intermediate</option>
                        <option value="Advanced">Advanced</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="duration">Duration</label>
                    <input type="text" id="duration" name="duration" placeholder="e.g. 12 Hours">
                </div>
                <div class="form-group">
                    <label for="price">Price ($)</label>
                    <input type="number" id="price" name="price" placeholder="0.00" step="0.01">
                </div>
            </div>

            <div class="form-group">
                <label for="category">Category</label>
                <input type="text" id="category" name="category" placeholder="e.g. Web Development">
            </div>

            <div class="form-group">
                <label for="thumbnail">Thumbnail Image</label>
                <input type="file" id="thumbnail" name="thumbnail" accept="image/*">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="draft">Draft</option>
                    <option value="active">Active</option>
                    <option value="archived">Archived</option>
                </select>
            </div>
  <div class="form-row">
    <div class="form-group">
        <label for="content">Content</label>
        <textarea id="content" name="content" rows="3" placeholder="Enter course contents separated by commas (e.g. HTML,CSS,JS)"></textarea>
    </div>
    <div class="form-group">
        <label for="projects">Projects</label>
        <textarea id="projects" name="projects" rows="3" placeholder="Enter project topics separated by commas (e.g. Portfolio,App,Website)"></textarea>
    </div>
</div>

<div class="form-group">
    <label for="objectives">Objectives</label>
    <textarea id="objectives" name="objectives" rows="3" placeholder="Enter course objectives separated by commas (e.g. Learn HTML,Build App,Understand CSS)"></textarea>
</div>

            <div class="form-actions">
                <button type="submit" class="btn-submit">Create Course</button>
            </div>

        </form>
    </div>
</body>
</html>