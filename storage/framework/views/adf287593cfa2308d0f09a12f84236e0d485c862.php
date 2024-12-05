<?php $__env->startSection('content'); ?>
<div class="container mx-auto mb-3 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Solutions</h2>
            <p>Manage and view submitted solutions.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="" class="btn btn-theme">
                    <i class="bi bi-plus-circle"></i> Add Solution
                </a>
            </div>
        </div>
    </div>

    <!-- Filter Row -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('solutions.index')); ?>" method="GET" class="row g-3">
                <div class="col-md-4">
                    <label for="user" class="form-label">Filter by User</label>
                    <select name="user" id="user" class="form-select">
                        <option value="">All Users</option>
                        <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($user->id); ?>" <?php echo e(request('user') == $user->id ? 'selected' : ''); ?>><?php echo e($user->name); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="challenge" class="form-label">Filter by Challenge</label>
                    <select name="challenge" id="challenge" class="form-select">
                        <option value="">All Challenges</option>
                        <?php $__currentLoopData = $challenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $challenge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($challenge->id); ?>" <?php echo e(request('challenge') == $challenge->id ? 'selected' : ''); ?>><?php echo e($challenge->title); ?></option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="status" class="form-label">Filter by Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="Pending" <?php echo e(request('status') == 'Pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="passed" <?php echo e(request('status') == 'passed' ? 'selected' : ''); ?>>Passed</option>
                        <option value="failed" <?php echo e(request('status') == 'failed' ? 'selected' : ''); ?>>Failed</option>
                    </select>
                </div>
                <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-theme">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Solutions Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-gray-300">Submitted By</th>
                    <th class="text-gray-300">Challenge Title</th>
                    <th class="text-gray-300">Submitted At</th>
                    <th class="text-gray-300">Status</th>
                    <?php if(Auth::user() && Auth::user()->role == 'admin'): ?>
                    <th class="text-gray-300 text-center">Actions</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $solutions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $solution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b border-gray-700">
                    <td class=" px-6 py-4  whitespace-nowrap text-gray-400"><?php echo e($solution->user->name); ?></td>
                    <td class="px-6 py-4   whitespace-nowrap text-gray-400"><?php echo e($solution->challenge->title); ?></td>
                    <td class="px-6 py-4  whitespace-nowrap text-gray-400"><?php echo e($solution->submitted_at->format('Y-m-d H:i')); ?></td>
                    <td class="px-6 py-4 ">
                        <span class="badge
                            <?php switch($solution->status):
                                case ('Pending'): ?> bg-warning <?php break; ?>
                                <?php case ('passed'): ?> bg-success <?php break; ?>
                                <?php case ('failed'): ?> bg-danger <?php break; ?>
                                <?php default: ?> bg-secondary
                            <?php endswitch; ?>">
                            <?php echo e(ucfirst($solution->status)); ?>

                        </span>
                    </td>
                    <?php if(Auth::user() && Auth::user()->role == 'admin'): ?>
                    <td class="py-2 text-center">
                        <a href="<?php echo e(route('solutions.show', $solution->id)); ?>" class="text-blue-500 hover:underline"><i class="bi bi-eye"></i></a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/devcom.infinityfreeapp.com/htdocs/resources/views/dashboard/solutions/index.blade.php ENDPATH**/ ?>