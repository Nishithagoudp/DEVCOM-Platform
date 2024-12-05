<?php $__env->startSection('content'); ?>
<style>
    .theme {
        color: #ff6b6b; /* Use your theme color */
    }
</style>

<div class="container mx-auto mb-4 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Edit User</h2>
            <p>Modify user details below.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="<?php echo e(route('users.index')); ?>" class="btn btn-theme">
                    <i class="bi bi-arrow-left"></i> Back to Users
                </a>
            </div>
        </div>
    </div>

    <div class="card bg-gray-800 shadow-lg mb-8">
        <div class="card-body">
            <div class="bg-gray-800 p-4 rounded-lg mb-8">
                <form action="<?php echo e(route('users.update', $user->id)); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo e($user->name); ?>"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo e($user->email); ?>"
                               required>
                    </div>
                    <div class="mb-3">
                        <label for="role" class="form-label">Role</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="user" <?php echo e($user->role == 'user' ? 'selected' : ''); ?>>User</option>
                            <option value="admin" <?php echo e($user->role == 'admin' ? 'selected' : ''); ?>>Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="score" class="form-label">Score</label>
                        <input type="number" class="form-control" id="score" name="score" value="<?php echo e($user->score); ?>"
                               required>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-theme">Save Changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\DevCom\resources\views/dashboard/users/edit.blade.php ENDPATH**/ ?>