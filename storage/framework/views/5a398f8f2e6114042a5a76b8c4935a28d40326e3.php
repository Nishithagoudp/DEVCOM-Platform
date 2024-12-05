<?php $__env->startSection('content'); ?>
<style>
    .theme {
        color: #ff6b6b; /* Use your theme color */
    }
</style>

<div class="container mx-auto mb-4 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Edit Category</h2>
            <p>Edit the category details below.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="<?php echo e(route('categories.index')); ?>" class="btn btn-theme">
                    <i class="bi bi-arrow-left"></i> Back to Categories
                </a>
            </div>
        </div>
    </div>

    <div class="card bg-gray-800 shadow-lg mb-8">
        <div class="card-body">
            <form action="<?php echo e(route('categories.update', $category)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="mb-3">
                    <label for="name" class="form-label text-white">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value="<?php echo e($category->name); ?>" required>
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label text-white">Slug</label>
                    <input type="text" class="form-control" id="slug" name="slug" value="<?php echo e($category->slug); ?>" required>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-theme">Update Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/devcom.infinityfreeapp.com/htdocs/resources/views/dashboard/categories/edit.blade.php ENDPATH**/ ?>