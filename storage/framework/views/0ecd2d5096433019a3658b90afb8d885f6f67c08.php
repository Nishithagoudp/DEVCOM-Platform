<?php $__env->startSection('content'); ?>
<style>
   
    .theme {
        color: #ff6b6b; /* Use your theme color */
    }
    .card-header {
        background-color: #f7f7f7;
        border-bottom: 2px solid #ddd;
        font-weight: bold;
    }
    .card-header h5 button {
        font-size: 1.1rem;
        color: #ff6b6b;
    }
    .card {
        border: 1px solid #ddd;
        border-radius: 8px;
        overflow: hidden;
    }
    .card-body {
        background-color: #fff;
        padding: 1.5rem;
        border-radius: 0 0 8px 8px;
    }
    .collapse-button {
        display: flex;
        align-items: center;
        font-size: 1.1rem;
        font-weight: 500;
        color: #ff6b6b;
    }
    .icon {
        font-size: 1.3rem;
        margin-right: 0.5rem;
        color: #6c757d;
    }
    .info-box {
        padding: 1rem;
        border-left: 4px solid #ff6b6b;
        margin-bottom: 1rem;
        background-color: #fafafa;
        border-radius: 4px;
    }
    .info-box strong {
        color: #333;
    }
    .empty-message {
        color: #999;
    }
</style>

<div class="container mx-auto mb-4 mt-4">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="h2 fw-bold theme">User Details</h2>
            <p>View detailed information about this user below.</p>
        </div>
        <div class="col-lg-2 text-end">
            <a href="<?php echo e(route('users.index')); ?>" class="btn btn-theme">
                <i class="bi bi-arrow-left"></i> Back to Users
            </a>
        </div>
    </div>

    <div class="card shadow-lg mb-4">
        <div class="card-body">
            <div class="mb-3">
                <strong>Name:</strong> <span><?php echo e($user->name); ?></span>
            </div>
            <div class="mb-3">
                <strong>Email:</strong> <span><?php echo e($user->email); ?></span>
            </div>
            <div class="mb-3">
                <strong>Role:</strong> <span><?php echo e(ucfirst($user->role)); ?></span>
            </div>
            <div class="mb-3">
                <strong>Score:</strong> <span><?php echo e($user->score); ?></span>
            </div>
        </div>
    </div>

    <!-- User's Challenges -->
    <div class="card shadow-lg mb-4">
        <div class="card-header" id="challengesHeader">
            <h5 class="mb-0">
                <button class="btn btn-link text-decoration-none theme" type="button" data-bs-toggle="collapse" data-bs-target="#challenges" aria-expanded="true" aria-controls="challenges">
                    Challenges
                </button>
            </h5>
        </div>
        <div id="challenges" class="collapse show" aria-labelledby="challengesHeader">
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $user->completedChallenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $challenge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div>
                        <strong><?php echo e($challenge->title); ?></strong> (<?php echo e(ucfirst($challenge->difficulty)); ?>)
                        <p><?php echo e($challenge->description); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p>No completed challenges.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>


    <!-- User's Certificates -->
    <div class="card shadow-lg mb-4">
        <div class="card-header" id="certificatesHeader">
            <h5 class="mb-0">
                <button class="btn btn-link text-decoration-none theme collapse-button" type="button" data-bs-toggle="collapse" data-bs-target="#certificates" aria-expanded="true" aria-controls="certificates">
                    <i class="bi bi-award icon"></i> Certificates
                </button>
            </h5>
        </div>
        <div id="certificates" class="collapse" aria-labelledby="certificatesHeader">
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $user->certificates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $certificate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="info-box">
                        <strong>Challenge:</strong> <?php echo e($certificate->challenge->title); ?>

                        <p>Issued on: <?php echo e($certificate->issued_at->format('d M Y')); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="empty-message">No certificates issued.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- User's Solutions -->
    <div class="card shadow-lg mb-4">
        <div class="card-header" id="solutionsHeader">
            <h5 class="mb-0">
                <button class="btn btn-link text-decoration-none theme collapse-button" type="button" data-bs-toggle="collapse" data-bs-target="#solutions" aria-expanded="true" aria-controls="solutions">
                    <i class="bi bi-code-slash icon"></i> Solutions
                </button>
            </h5>
        </div>
        <div id="solutions" class="collapse" aria-labelledby="solutionsHeader">
            <div class="card-body">
                <?php $__empty_1 = true; $__currentLoopData = $user->solutions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $solution): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="info-box">
                        <strong>Challenge:</strong> <?php echo e($solution->challenge->title); ?>

                        <p>Status: <?php echo e(ucfirst($solution->status)); ?></p>
                        <p>Feedback: <?php echo e($solution->feedback); ?></p>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <p class="empty-message">No solutions submitted.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- User's Subscription -->
    <div class="card shadow-lg mb-4">
        <div class="card-header" id="subscriptionHeader">
            <h5 class="mb-0">
                <button class="btn btn-link text-decoration-none theme collapse-button" type="button" data-bs-toggle="collapse" data-bs-target="#subscription" aria-expanded="true" aria-controls="subscription">
                    <i class="bi bi-card-checklist icon"></i> Subscription
                </button>
            </h5>
        </div>
        <div id="subscription" class="collapse" aria-labelledby="subscriptionHeader">
            <div class="card-body">
                <?php if($user->subscription): ?>
                    <div class="info-box">
                        <strong>Plan:</strong> <?php echo e($user->subscription->plan->name); ?>

                        <p>Status: <?php echo e(ucfirst($user->subscription->status)); ?></p>
                        <p>Start Date: <?php echo e($user->subscription->start_date->format('d M Y')); ?></p>
                        <p>End Date: <?php echo e($user->subscription->end_date->format('d M Y')); ?></p>
                    </div>
                <?php else: ?>
                    <p class="empty-message">No active subscription.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/htdocs/resources/views/dashboard/users/show.blade.php ENDPATH**/ ?>