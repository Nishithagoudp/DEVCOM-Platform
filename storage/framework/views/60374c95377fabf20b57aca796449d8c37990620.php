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
<div class="container mt-4 mb-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold">Pricing Plans</h2>
            <p>Choose the plan that suits your needs best.</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">


            </div>
        </div>
    </div>


    <div class="row">
        <?php $__currentLoopData = $pricingPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-4 d-flex align-items-stretch"> <!-- Keeps each column aligned evenly -->
            <div class="card shadow-lg border-0 mb-4 flex-fill"> <!-- flex-fill ensures cards take equal height -->
                <div class="card-header text-center btn-theme">
                    <h4 class="h4 fw-bold"><?php echo e($plan->name); ?></h4>
                </div>
                <div class="card-body bg-light text-center d-flex flex-column">
                    <h3 class="text-3xl fw-bold mb-4">$<?php echo e($plan->price); ?>/month</h3>
                    <p class="mb-4">Ideal for <?php echo e(strtolower($plan->name)); ?> users</p>
                    <ul class="list-unstyled flex-grow-1"> <!-- Flex-grow pushes the list to take up available space -->
                        <?php $__currentLoopData = $plan->features; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>✔️ <?php echo e($feature); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                    <div class="d-grid mt-auto"> <!-- mt-auto pushes this div to the bottom -->
                    <form id="processPaymentForm" action="<?php echo e(route('purchase')); ?>" method="POST">
                                <?php echo csrf_field(); ?>
                                <input type="hidden" name="payable_type" value="subscription"> <!-- Payable type: 'subscription' or 'certificate' -->
                                <input type="hidden" name="payable_id" value="<?php echo e($plan->id); ?>"> <!-- Payable ID: ID of the subscription or certificate -->
                                <input type="hidden" name="user_id" value="<?php echo e(auth()->id()); ?>"> <!-- User ID: Current authenticated user's ID -->
                                <input type="hidden" name="amount" value="<?php echo e($plan->price); ?>"> <!-- Amount: The payment amount -->
                                <button type="submit" class="btn btn-theme btn-lg fw-bold">
                                    Subscribe
                                </button>
                            </form>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>


</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/htdocs/resources/views/pricing.blade.php ENDPATH**/ ?>