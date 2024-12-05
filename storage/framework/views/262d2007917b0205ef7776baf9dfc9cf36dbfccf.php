<?php $__env->startSection('content'); ?>
<style>
    .theme {
        color: #ff6b6b; /* Use your theme color */
    }
</style>

<div class="container mx-auto mb-4 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Category Management</h2>
            <p>Manage your categories below.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <button class="btn btn-theme" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                    <i class="bi bi-plus-circle"></i> Add Category
                </button>
            </div>
        </div>
    </div>

    <div class="card bg-gray-800 shadow-lg mb-8">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-gray-300">Name</th>
                    <th class="text-gray-300">Slug</th>
                    <th class="text-gray-300">Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?php echo e($category->name); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300"><?php echo e($category->slug); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="<?php echo e(route('categories.edit', $category)); ?>" class="theme"><i class="bi bi-pencil"></i></a> |
                        <form action="<?php echo e(route('categories.destroy', $category)); ?>" method="POST" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="theme" onclick="return confirm('Are you sure you want to delete this category?')"><i class="bi bi-trash"></i></button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-labelledby="addCategoryModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCategoryModalLabel">Add Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="<?php echo e(route('categories.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="slug" class="form-label">Slug</label>
                        <input type="text" class="form-control" id="slug" name="slug" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-theme">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/devcom.infinityfreeapp.com/htdocs/resources/views/dashboard/categories/index.blade.php ENDPATH**/ ?>