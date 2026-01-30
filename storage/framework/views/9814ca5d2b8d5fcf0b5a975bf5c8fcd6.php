<form action="<?php echo e(route('courses.index')); ?>" method="GET" style="display:flex; align-items:center; gap:10px; width:100%;">
    <i class="fa-solid fa-magnifying-glass" style="color:#777;"></i>
    <input
        type="text"
        name="query"
        placeholder="Search courses..."
        value="<?php echo e($query ?? request('query')); ?>"
        style="border:none; background:transparent; outline:none; width:100%; font-size:0.95rem;"
    >
    <button type="submit" style="border:none; background:transparent; color:#ff8c55; font-weight:600; cursor:pointer;">
        Search
    </button>
</form>
<?php /**PATH C:\xampp\htdocs\blog2\resources\views/courses/search.blade.php ENDPATH**/ ?>