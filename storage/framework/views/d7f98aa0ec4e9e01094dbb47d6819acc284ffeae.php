<?php $__env->startSection('content'); ?>
<style>
    .btn-theme {
        background-color: #ff6b6b;
        color: white;
        border: none;
    }
    .btn-theme:hover {
        background-color: #e05e5e;
    }
</style>
<div class="container py-5">
    <div class="card mx-auto shadow p-4" style="max-width: 80%;">
        <h4 class="text-center mb-4">Create New Challenge</h4>
        <form action="<?php echo e(route('challenges.store')); ?>" method="POST" enctype="multipart/form-data">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label for="title" class="form-label">Challenge Title</label>
                <input type="text" id="title" name="title" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea id="description" name="description" rows="4" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label for="difficulty" class="form-label">Difficulty</label>
                <select id="difficulty" name="difficulty" class="form-select" required>
                    <option value="Easy">Easy</option>
                    <option value="Medium">Medium</option>
                    <option value="Hard">Hard</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category</label>
                <select id="category_id" name="category_id" class="form-select" required>
                    <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($category->id); ?>"><?php echo e($category->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>

            <input type="hidden" id="content" name="content" value="null" class="form-control">

            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label for="time" class="form-label">Time (in minutes)</label>
                <input type="number" id="time" name="time" class="form-control" min="1" placeholder="Enter time allowed for the challenge">
            </div>

            <div class="mb-3">
                <label for="marks" class="form-label">Marks</label>
                <input type="number" id="marks" name="marks" class="form-control" min="0" placeholder="Enter marks for the challenge">
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-theme hover:btn-theme">
                    Create Challenge
                </button>
            </div>
        </form>

    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/devcom.infinityfreeapp.com/htdocs/resources/views/dashboard/challenges/show.blade.php ENDPATH**/ ?>