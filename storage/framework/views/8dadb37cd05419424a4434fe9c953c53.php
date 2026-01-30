<?php echo $__env->make('navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* تنسيقات الترقيم (Pagination) */
    .pagination { display: flex; gap: 10px; list-style: none; padding: 0; margin: 0; flex-wrap: wrap; justify-content: center; }
    .pagination .page-item { display: flex; }
    .pagination .page-link {
        min-width: 42px;
        height: 42px;
        padding: 0 14px;
        border-radius: 9999px;
        border: 1px solid #ffccb3;
        background: #fff;
        color: #555;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        line-height: 1;
        font-weight: 600;
        transition: 0.2s;
    }
    .pagination .page-link:hover { background: #fff7f2; border-color: #ff8c55; color: #0f2942; }
    .pagination .page-item.active .page-link { background: #ff8c55; border-color: #ff8c55; color: #fff; }
    .pagination .page-item.disabled .page-link { opacity: 0.55; cursor: not-allowed; }
    
    @media (max-width: 480px) {
        .pagination { gap: 8px; }
        .pagination .page-link { min-width: 38px; height: 38px; padding: 0 12px; font-size: 0.9rem; }
    }
</style>

<div style="font-family: 'Poppins', sans-serif; background-color: #f4f6f9; min-height: 100vh; padding: 40px 20px;">

    <div class="container" style="max-width: 1400px; margin: 0 auto;">

        
        <header class="page-header" style="text-align: center; margin-bottom: 30px;  ; padding: 10px 0;">
             <h1 style="font-size: 2.5rem; color: #0f2942; font-weight: 700; margin: 0;">
                 Courses <span style="color: #ff8c55;">List</span>
             </h1>
         

        <?php if(session('info')): ?>
            <div style="max-width: 900px; margin: 0 auto 20px auto; background: #fff7f2; border: 1px solid #ffccb3; color: #0f2942; padding: 12px 16px; border-radius: 10px; text-align: center;">
                <?php echo e(session('info')); ?>

            </div>
        <?php endif; ?>

        
        <div class="controls-bar" style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; margin-bottom: 40px; gap: 20px; background-color: #fff; padding: 15px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.03);">
            
            <div style="background-color: #eef1f6; padding: 10px 20px; border-radius: 5px; display: flex; align-items: center; width: 300px;">
                 <?php echo $__env->make('courses/search', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?> 
            </div>

            <div class="tabs" style="display: flex; gap: 30px; font-weight: 500; color: #777;">
                <a href="#" style="text-decoration: none; color: #777; padding-bottom: 5px;">All</a>
                <a href="#" style="text-decoration: none; color: #ff8c55; border-bottom: 3px solid #ff8c55; padding-bottom: 5px;">Opened</a>
                <a href="#" style="text-decoration: none; color: #777; padding-bottom: 5px;">Coming Soon</a>
                <a href="#" style="text-decoration: none; color: #777; padding-bottom: 5px;">Archived</a>
            </div>

            <div class="sort-box" style="color: #555; font-size: 0.9rem;">
                Sort by: 
                <select style="border: none; background: transparent; font-weight: 700; color: #333; outline: none; cursor: pointer;">
                    <option>Popular Class</option>
                    <option>Newest</option>
                    <option>Price</option>
                </select>
            </div>
        </div>
        </header>

        <div class="courses-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 30px;">
            <?php $__empty_1 = true; $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card" style="background-color: #fff; border-radius: 20px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.05); display: flex; flex-direction: column; transition: transform 0.2s;">
                    
                    <div class="card-top" style="background-color: #0a3d62; height: 140px; display: flex; align-items: center; justify-content: center; padding: 20px;">
                        <img src="<?php echo e($course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/150'); ?>" 
                             alt="<?php echo e($course->title); ?>" 
                             style="width: 80px; height: 80px; object-fit: contain; filter: drop-shadow(0 0 5px rgba(255,255,255,0.2));">
                    </div>

                    <div class="card-body" style="padding: 20px 20px 25px 20px; text-align: center; display: flex; flex-direction: column; flex-grow: 1;">
                        
                        <h3 class="card-title" style="font-size: 1.2rem; margin: 0 0 10px 0; color: #333; font-weight: 600;"><?php echo e($course->title); ?></h3>
                        
                        <p class="card-desc" style="font-size: 0.8rem; color: #777; line-height: 1.5; margin-bottom: 10px; flex-grow: 1;">
                            <?php echo e(Str::limit($course->description ?? 'No description available.', 80)); ?>

                        </p>

                        <p class="card-instructor" style="font-size: 0.75rem; color: #aaa; margin-bottom: 20px;">
                            <i class="fa-solid fa-user-tie"></i> <?php echo e($course->instructor->name ?? 'Instructor'); ?>

                        </p>

                        <div class="card-actions" style="display: flex; justify-content: space-between; gap: 10px; margin-bottom: 15px;">
                            <a href="<?php echo e(route('courses.show', $course)); ?>" style="flex: 1; background: #fff; border: 1px solid #ffccb3; border-radius: 6px; padding: 8px 0; color: #555; font-size: 0.75rem; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 5px;">
                                <i class="fa-solid fa-desktop"></i> Start Demo
                            </a>
                            <a href="<?php echo e(route('pricing.index')); ?>" style="flex: 1; background: #fff; border: 1px solid #ffccb3; border-radius: 6px; padding: 8px 0; color: #555; font-size: 0.75rem; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 5px;">
                                <i class="fa-regular fa-file-lines"></i> Enroll Now
                            </a>
                        </div>

                        <a href="#" style="background-color: #ff8c55; color: white; padding: 12px; border-radius: 50px; font-size: 0.85rem; font-weight: 600; text-decoration: none; display: flex; align-items: center; justify-content: center; gap: 8px; box-shadow: 0 4px 10px rgba(255, 140, 85, 0.3);">
                            <i class="fa-solid fa-cloud-arrow-down"></i> Download Curriculum
                        </a>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div style="grid-column: 1 / -1; text-align: center; color: #777; padding: 50px;">
                    <h3>No courses found.</h3>
                </div>
            <?php endif; ?>
        </div>

        <div style="margin-top: 50px; display: flex; justify-content: center;">
            <?php echo e($courses->onEachSide(1)->links('pagination::bootstrap-5')); ?>

        </div>

    </div>
</div>
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blog2\resources\views/courses/index.blade.php ENDPATH**/ ?>