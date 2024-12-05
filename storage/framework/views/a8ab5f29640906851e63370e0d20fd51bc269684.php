<?php $__env->startSection('content'); ?>
<style>
    .theme {
        color: #ff6b6b; /* Use your theme color */
    }
</style>

<div class="container mx-auto mb-4 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">User Details</h2>
            <p>View user information below.</p>
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
                <div class="mb-3">
                    <strong>Name:</strong> <span class="text-gray-400"><?php echo e($user->name); ?></span>
                </div>
                <div class="mb-3">
                    <strong>Email:</strong> <span class="text-gray-400"><?php echo e($user->email); ?></span>
                </div>
                <div class="mb-3">
                    <strong>Role:</strong> <span class="text-gray-400"><?php echo e(ucfirst($user->role)); ?></span>
                </div>
                <div class="mb-3">
                    <strong>Score:</strong> <span class="text-gray-400"><?php echo e($user->score); ?></span>
                </div>

                <div class="text-end">
                    <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="btn btn-theme">Edit User</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\DevCom\resources\views/dashboard/users/show.blade.php ENDPATH**/ ?>