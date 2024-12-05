<?php $__env->startSection('content'); ?>
<style>
    .theme {
        color: #ff6b6b;
    }
    .btn-theme {
        background-color: #ff6b6b;
        color: white;
    }
    .card {
        border: 1px solid #dee2e6; /* Add a border to the card */
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Add a shadow effect */
    }
</style>
<div class="container mx-auto mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">User Management</h2>
            <p>Manage system Users</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="<?php echo e(route('users.create')); ?>" class="btn btn-theme">
                    <i class="bi bi-plus-circle"></i> Add User
                </a>
            </div>
        </div>
    </div>

    <div class="card bg-gray-800 p-4 mb-4 mt-3">

        <table class="table table-striped table-hover text-white">
            <thead>
            <tr>
                <th class="text-gray-300">Name</th>
                <th class="text-gray-300">Email</th>
                <th class="text-gray-300">Role</th>
                <th class="text-gray-300">Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr>
                <td class="text-gray-400"><?php echo e($user->name); ?></td>
                <td class="text-gray-400"><?php echo e($user->email); ?></td>
                <td class="text-gray-400"><?php echo e(ucfirst($user->role)); ?></td>
                <td>
                    <a href="<?php echo e(route('users.show', $user->id)); ?>" class="theme p-2"><i class="bi bi-eye"></i></a> |
                    <a href="<?php echo e(route('users.edit', $user->id)); ?>" class="theme p-2"><i class="bi bi-pencil"></i></a> |
                    <form action="<?php echo e(route('users.destroy', $user->id)); ?>" method="POST" class="d-none">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="theme p-2  "><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/htdocs/resources/views/dashboard/users/index.blade.php ENDPATH**/ ?>