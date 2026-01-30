<?php echo $__env->make('navbar', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pricing Plans - <?php echo e(config('app.name')); ?></title>
    <link rel="stylesheet" href="<?php echo e(asset('prising.css')); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>

    <div class="background-curve"></div>
    <div class="dots-decoration left-dots"></div>
    <div class="dots-decoration right-dots"></div>

    <div class="container">
        <h1 class="main-title">Our <span class="highlight">Pricing</span></h1>

        <div class="pricing-wrapper">
            <?php $__empty_1 = true; $__currentLoopData = $plans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <div class="card <?php echo e($plan->is_popular ? 'featured' : ''); ?>">
                    <div class="badge"><?php echo e($plan->name); ?></div>

                    <div class="card-header">
                        <div class="price">$ <?php echo e(number_format($plan->price, 2)); ?> <span class="tax">+ Tax</span></div>
                        <div class="subtext">(Exclusive of GST & Taxes)</div>
                    </div>

                    <div class="card-body">
                        <ul class="features">
                            <li>
                                <i class="fa-solid fa-<?php echo e($plan->target_type === 'group' ? 'school' : 'user'); ?>"></i>
                                <span>
                                    <?php if($plan->target_type === 'group'): ?>
                                        For Colleges, Universities <br>& Group Of Students
                                    <?php else: ?>
                                        1-1 Individuals
                                    <?php endif; ?>
                                </span>
                            </li>
                            <li>
                                <i class="fa-regular fa-calendar-<?php echo e($plan->schedule_type === 'fixed' ? 'days' : ($plan->schedule_type === 'choose' ? 'check' : 'plus')); ?>"></i>
                                <span>
                                    <?php echo e(ucfirst($plan->schedule_type)); ?> Timings
                                </span>
                            </li>
                            
                            <?php if($plan->courses->count() > 0): ?>
                                <li>
                                    <i class="fa-solid fa-book"></i>
                                    <span>
                                        Includes <?php echo e($plan->courses->count()); ?> Course(s)
                                        <ul class="course-list">
                                            <?php $__currentLoopData = $plan->courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>• <?php echo e($course->title); ?></li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                    </span>
                                </li>
                            <?php endif; ?>
                        </ul>

                        <?php if(auth()->check()): ?>
                            <a href="<?php echo e(route('pricing.select-courses', $plan->id)); ?>" class="btn">Choose Plan</a>
                        <?php else: ?>
                            <a href="<?php echo e(route('login')); ?>" class="btn">Login to Choose Plan</a>
                        <?php endif; ?>

                        <div class="logo">
                            <i class="fa-solid fa-bolt"></i> العز للدفع عند الاستلام
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="no-plans">
                    <p>No pricing plans available at the moment.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php echo $__env->make('footer', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
</body>
</html><?php /**PATH C:\xampp\htdocs\blog2\resources\views/pricing/index.blade.php ENDPATH**/ ?>