<?php $__env->startSection('content'); ?>
<div class="container mx-auto mb-3 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Payments</h2>
            <p>Manage and view all payment transactions.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="<?php echo e(route('payments.create')); ?>" class="btn btn-theme">
                    <i class="bi bi-plus-circle"></i> Add Payment
                </a>
            </div>
        </div>
    </div>
    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <!-- Filter Row -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form action="<?php echo e(route('payments.index')); ?>" method="GET" class="row g-3">
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
                    <label for="status" class="form-label">Filter by Status</label>
                    <select name="status" id="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending" <?php echo e(request('status') == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="completed" <?php echo e(request('status') == 'completed' ? 'selected' : ''); ?>>Completed</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="payment_method" class="form-label">Filter by Payment Method</label>
                    <select name="payment_method" id="payment_method" class="form-select">
                        <option value="">All Methods</option>
                        <option value="paypal" <?php echo e(request('payment_method') == 'paypal' ? 'selected' : ''); ?>>PayPal</option>
                        <option value="credit_card" <?php echo e(request('payment_method') == 'credit_card' ? 'selected' : ''); ?>>Credit Card</option>
                    </select>
                </div>
                <div class="col-md-12 text-end mt-3">
                    <button type="submit" class="btn btn-theme">Apply Filters</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Payments Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                <tr>
                    <th class="text-gray-300">User</th>
                    <th class="text-gray-300">Amount</th>
                    <th class="text-gray-300">Payment Method</th>
                    <th class="text-gray-300">Transaction ID</th>
                    <th class="text-gray-300">Status</th>
                    <?php if(Auth::user() && Auth::user()->role == 'admin'): ?>
                    <th class="text-gray-300 text-center">Actions</th>
                    <?php endif; ?>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $payments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $payment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="border-b border-gray-700">
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400"><?php echo e($payment->user->name); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400">$<?php echo e(number_format($payment->amount, 2)); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400"><?php echo e(ucfirst($payment->payment_methods)); ?></td>
                    <td class="px-6 py-4 whitespace-nowrap text-gray-400"><?php echo e($payment->payment_id); ?></td>
                    <td class="px-6 py-4">
                        <span class="badge
                            <?php switch($payment->payment_status):
                                case ('pending'): ?> bg-warning <?php break; ?>
                                <?php case ('completed'): ?> bg-success <?php break; ?>
                                <?php default: ?> bg-secondary
                            <?php endswitch; ?>">
                            <?php echo e(ucfirst($payment->payment_status)); ?>

                        </span>
                    </td>
                    <?php if(Auth::user() && Auth::user()->role == 'admin'): ?>
                    <td class="py-2 text-center">
                        <a href="" class="text-blue-500 hover:underline"><i class="bi bi-eye"></i></a>
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

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/devcom.infinityfreeapp.com/htdocs/resources/views/dashboard/payments/index.blade.php ENDPATH**/ ?>