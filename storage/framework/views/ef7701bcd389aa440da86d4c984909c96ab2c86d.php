<?php $__env->startSection('content'); ?>
<div class="container mx-auto mb-3 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Payment Details</h2>
            <p>View the details of the payment transaction.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="<?php echo e(route('payments.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Payments
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Details -->
    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?php echo e(route('payments.update', $payment->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Payment Method -->
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Payment Method</label>
                    <input type="text" id="payment_method" class="form-control" value="<?php echo e(ucfirst($payment->payment_method)); ?>" readonly />
                </div>

                <!-- User Name -->
                <div class="mb-3">
                    <label for="user_name" class="form-label">User</label>
                    <input type="text" id="user_name" class="form-control" value="<?php echo e($payment->user->name); ?>" readonly />
                </div>

                <!-- Amount -->
                <div class="mb-3">
                    <label for="amount" class="form-label">Amount</label>
                    <input type="text" id="amount" class="form-control" value="$<?php echo e(number_format($payment->amount, 2)); ?>" readonly />
                </div>

                <!-- Transaction ID -->
                <div class="mb-3">
                    <label for="transaction_id" class="form-label">Transaction ID</label>
                    <input type="text" id="transaction_id" class="form-control" value="<?php echo e($payment->transaction_id); ?>" readonly />
                </div>

                <!-- Payment Status -->
                <div class="mb-3">
                    <label for="status" class="form-label">Payment Status</label>
                    <select name="status" id="status" class="form-select" required>
                        <option value="pending" <?php echo e($payment->status == 'pending' ? 'selected' : ''); ?>>Pending</option>
                        <option value="completed" <?php echo e($payment->status == 'completed' ? 'selected' : ''); ?>>Completed</option>
                        <option value="failed" <?php echo e($payment->status == 'failed' ? 'selected' : ''); ?>>Failed</option>
                        <option value="refunded" <?php echo e($payment->status == 'refunded' ? 'selected' : ''); ?>>Refunded</option>
                    </select>
                </div>

                <!-- Action Button for Updating the Status -->
                <?php if(Auth::user() && Auth::user()->role == 'admin'): ?>
                <div class="text-end">
                    <button type="submit" class="btn btn-theme">Edit Status</button>
                </div>
                <?php endif; ?>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\DevCom\resources\views/dashboard/payments/edit.blade.php ENDPATH**/ ?>