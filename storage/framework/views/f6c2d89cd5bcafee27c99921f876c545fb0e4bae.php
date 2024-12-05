<?php $__env->startSection('content'); ?>
<div class="container mx-auto mb-3 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Payment Details</h2>
            <p>View the complete details of the selected payment transaction.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">
                <a href="<?php echo e(route('payments.index')); ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Payments
                </a>
            </div>
        </div>
    </div>

    <!-- Payment Details Section -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Transaction Overview</h5>
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="user_name" class="form-label">User</label>
                        <input type="text" id="user_name" class="form-control" value="<?php echo e($payment->user->name); ?>" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <input type="text" id="payment_method" class="form-control" value="<?php echo e(ucfirst($payment->payment_method)); ?>" readonly />
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="amount" class="form-label">Amount</label>
                        <input type="text" id="amount" class="form-control" value="$<?php echo e(number_format($payment->amount, 2)); ?>" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="status" class="form-label">Payment Status</label>
                        <input type="text" id="status" class="form-control" value="<?php echo e(ucfirst($payment->status)); ?>" readonly />
                    </div>
                </div>
            </div>

            <div class="mb-3">
                <label for="transaction_id" class="form-label">Transaction ID</label>
                <input type="text" id="transaction_id" class="form-control" value="<?php echo e($payment->transaction_id); ?>" readonly />
            </div>

            <!-- Payable Details Section -->
            <div class="row">
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payable_type" class="form-label">Payable Type</label>
                        <input type="text" id="payable_type" class="form-control" value="<?php echo e(ucfirst($payment->payable_type)); ?>" readonly />
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="mb-3">
                        <label for="payable_id" class="form-label">Payable ID</label>
                        <input type="text" id="payable_id" class="form-control" value="<?php echo e($payment->payable_id); ?>" readonly />
                    </div>
                </div>
            </div>

            <!-- Display Related Model Information -->
            <?php if($payment->payable_type === 'App\Models\Subscription'): ?>
            <div class="mb-3">
                <label for="plan_details" class="form-label">Subscription Plan</label>
                <div class="form-control">
                    <p><strong>Plan Name:</strong> <?php echo e($payableDetails->name ?? 'N/A'); ?></p>
                    <p><strong>Description:</strong> <?php echo e($payableDetails->description ?? 'N/A'); ?></p>
                    <p><strong>Price:</strong> $<?php echo e(number_format($payableDetails->price, 2) ?? 'N/A'); ?></p>
                </div>
            </div>
            <?php elseif($payment->payable_type === 'App\Models\Certificate'): ?>
            <div class="mb-3">
                <label for="certificate_details" class="form-label">Certificate Details</label>
                <div class="form-control">
                    <p><strong>Challenge:</strong> <?php echo e($payableDetails->name ?? 'N/A'); ?></p>
                    <p><strong>Issued At:</strong> <?php echo e($payment->payable->issued_at->format('Y-m-d')); ?></p>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Payment Timeline (Optional) -->
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Transaction Timeline</h5>
            <ul class="list-group">
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Payment Initiated</span>
                    <span class="badge bg-info text-white"><?php echo e($payment->created_at->format('Y-m-d H:i')); ?></span>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Payment Processed</span>
                    <span class="badge bg-secondary text-white"><?php echo e($payment->updated_at->format('Y-m-d H:i')); ?></span>
                </li>
                <?php if($payment->status == 'completed'): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Payment Completed</span>
                    <span class="badge bg-success text-white"><?php echo e($payment->completed_at ? $payment->completed_at->format('Y-m-d H:i') : 'N/A'); ?></span>
                </li>
                <?php endif; ?>
                <?php if($payment->status == 'failed'): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>Payment Failed</span>
                    <span class="badge bg-danger text-white"><?php echo e($payment->failed_at ? $payment->failed_at->format('Y-m-d H:i') : 'N/A'); ?></span>
                </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>

    <!-- Additional Notes (Optional) -->
    <?php if($payment->notes): ?>
    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <h5 class="card-title">Additional Notes</h5>
            <p><?php echo e($payment->notes); ?></p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="text-end">
        <a href="<?php echo e(route('payments.edit', $payment->id)); ?>" class="btn btn-primary">Edit Payment Status</a>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\DevCom\resources\views/dashboard/payments/show.blade.php ENDPATH**/ ?>