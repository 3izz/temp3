 
<?php echo $__env->make('navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>  
<link rel="stylesheet" href="<?php echo e(asset('single.css')); ?>">
 
<header>
    <div class="header-logo">
     <img src="<?php echo e($course->thumbnail ? asset('storage/' . $course->thumbnail) : 'https://via.placeholder.com/150'); ?>" alt="<?php echo e($course->title); ?>">


    </div>
    <div class="header-text">
        <h2><?php echo e($course->title); ?></h2>
        <h1><?php echo e($course->language); ?> - <?php echo e($course->level); ?><br><?php echo e($course->duration ?? 'N/A'); ?></h1>
    </div>
</header>

<div class="container">

    <div class="top-section">

        <div class="left-col">
            <h3 class="section-title">About The Course</h3>
            <p class="description">
                <?php echo e($course->description ?? 'No description available for this course.'); ?>

            </p>

            <h3 class="section-title">Objectives</h3>
            <ul class="objectives-list">
                <?php if($course->objectives): ?>
    <?php $__currentLoopData = explode(',', $course->objectives); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $objective): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <li><i class="far fa-check-circle"></i> <?php echo e(trim($objective)); ?></li>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php else: ?>
    <li><i class="far fa-check-circle"></i> No objectives added yet.</li>
<?php endif; ?>

            </ul>
        </div>

        <div class="right-col">
            <h3 class="section-title">Course Content</h3>

          <div class="curriculum-card"> 
    <ul class="curriculum-list">
        <?php if($course->content): ?>
            <?php $__currentLoopData = explode(',', $course->content); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <span><?php echo e(str_pad($index + 1, 2, '0', STR_PAD_LEFT)); ?> <?php echo e(trim($item)); ?></span>
                    <i class="fas fa-chevron-down"></i>
                </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php else: ?>
            <li>No content added yet.</li>
        <?php endif; ?>
    </ul>
</div>


                </ul>
            </div>

            <div class="dots-decoration">
                ....<br>....<br>....<br>....
            </div>
             
    </div>

    <div class="section-heading-row">
        <h3>Projects</h3>
        <div class="line"></div>
    </div>

    <div class="projects-grid">
    <?php if($course->projects): ?>
        <?php $__currentLoopData = explode(',', $course->projects); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="project-card">
                <div class="project-icon"><i class="fas fa-shield-alt"></i></div>
                <div>
                    <div class="project-title"><?php echo e(trim($project)); ?></div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php else: ?>
        <div class="project-card">No projects added yet.</div>
    <?php endif; ?>
</div>


    <div class="cta-box">
        <div class="cta-text">
            <h2>Wanna check more<br>about the course?</h2>
        </div>
        <div class="cta-buttons">
            <div class="btn-row">
                <a href="#" class="btn btn-outline"><i class="fas fa-desktop"></i> Demo</a>
                <a href="#" class="btn btn-outline"><i class="fas fa-bookmark"></i> Enroll Now</a>
            </div>
            <a href="#" class="btn btn-solid"><i class="fas fa-cloud-download-alt"></i> Download Curriculum</a>
        </div>
    </div>

   

        <div class="tools-section">
            <div class="section-heading-row">
                <h3>Tools & Platforms</h3>
                <div class="line"></div>
            </div>
            
            <div class="tools-icons">
                <div class="tool-circle">UI</div>
                <div class="tool-circle"><svg width="216" height="216" viewBox="0 0 216 216" fill="none" xmlns="http://www.w3.org/2000/svg">
<circle cx="108" cy="108" r="108" fill="#003F7D"/>
</svg>
</div>
                <div class="tool-circle"><i class="fas fa-infinity"></i></div>
                <div class="tool-circle">UI</div>
                <div class="tool-circle"><i class="fab fa-react"></i></div>
                <div class="tool-circle"><i class="fab fa-cutil"></i></div>
            </div>
        </div>
    </div>

</div>
<?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
 <?php /**PATH C:\xampp\htdocs\blog2\resources\views/single.blade.php ENDPATH**/ ?>