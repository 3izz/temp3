<?php $__env->startSection('content'); ?>
<h1>Admin Dashboard - All Courses</h1>

<?php if(session('success')): ?>
    <div style="color:green;"><?php echo e(session('success')); ?></div>
<?php endif; ?>

<table border="1" cellpadding="10">
    <thead>
        <tr>
            <th>Title</th>
            <th>Instructor</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $courses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $course): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($course->title); ?></td>
            <td><?php echo e($course->instructor->name ?? 'Unknown'); ?></td>
            <td><?php echo e($course->status); ?></td>
            <td>
                <a href="<?php echo e(route('courses.edit', $course->id)); ?>">Edit</a>

                <form action="<?php echo e(route('courses.destroy', $course->id)); ?>" method="POST" style="display:inline-block;" data-confirm="Are you sure you want to delete this course?">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit">
                        Delete
                    </button>
                </form>
            </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php echo e($courses->links()); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\blog2\resources\views/courses/delete.blade.php ENDPATH**/ ?>