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

    .card {
        transition: transform 0.2s;
    }

    .card:hover {
        transform: scale(1.05);
    }

    .alert-icon {
        font-size: 1.5rem;
        margin-right: 0.5rem;
    }
</style>

<?php if(session('success')): ?>
<div class="alert alert-success mb-4">
    <?php echo e(session('success')); ?>

</div>
<?php endif; ?>
<?php if(session('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(session('error')); ?>

    </div>
<?php endif; ?>

<div class="container my-5">
    <div class="row mb-4">
        <div class="col-lg-10">
            <h2 class="fw-bold">Dashboard</h2>
            <p>Home/Dashboard</p>
        </div>
        <div class="col-lg-2">
            <div class="mb-4">

                <?php if(auth()->user()->two_factor_confirmed_at): ?>
                <div class="alert d-flex align-items-center" role="alert">
                    <i class="bi bi-check-circle-fill alert-icon"></i>
                    <div>

                        <form method="POST" action="<?php echo e(url('user/two-factor-authentication')); ?>" class="mr-4">
                            <?php echo csrf_field(); ?>
                            <?php echo method_field('DELETE'); ?>
                            <button type="submit" class="btn btn-theme hover:btn-theme mt-3">
                                Disable MFA
                            </button>
                        </form>
                    </div>
                </div>
                <?php else: ?>
                <form method="POST" action="<?php echo e(route('two-factor.enable')); ?>">
                    <?php echo csrf_field(); ?>
                    <button type="submit" class="btn btn-success hover:success mt-3">Enable MFA</button>
                </form>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <div class="row mt-3">

        <?php if(auth()->user()->two_factor_secret && !auth()->user()->two_factor_confirmed_at): ?>

        <div class="bg-dark p-4 rounded-3">
            <h2 class="h4 fw-bold mb-4 text-light">Two-Factor Authentication Setup</h2>
            <p class="mb-4 text-light">Scan this QR code with your authenticator application or enter the setup key
                manually:</p>

            <?php
            $google2fa = app('pragmarx.google2fa');
            $qrCodeUrl = $google2fa->getQRCodeUrl(
            config('app.name'),
            auth()->user()->email,
            decrypt(auth()->user()->two_factor_secret)
            );
            ?>

            <div class="mb-4">
                <div id="qrcode"></div>
            </div>

            <?php if(!auth()->user()->two_factor_confirmed_at): ?>
            <div class="alert alert-warning" role="alert">
                <strong>MFA is not confirmed yet!</strong>
                <p>Please scan the QR code and enter a verification code to confirm MFA.</p>
            </div>
            <?php endif; ?>

            <?php if(session('status') == 'two-factor-authentication-enabled'): ?>
            <div class="alert alert-success mb-4" role="alert">
                Two-factor authentication has been enabled.
            </div>
            <?php endif; ?>

            <?php if(session('status') == 'two-factor-authentication-disabled'): ?>
            <div class="alert alert-danger mb-4" role="alert">
                Two-factor authentication has been disabled.
            </div>
            <?php endif; ?>

            <p class="mt-4 mb-2 text-light">Manual Setup Key:</p>
            <p class="bg-dark text-light p-2 rounded mb-4"><?php echo e(decrypt(auth()->user()->two_factor_secret)); ?></p>

            <form method="POST" action="<?php echo e(route('two-factor.confirm')); ?>">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <label for="code" class="form-label text-light">Verification Code</label>
                    <input type="text" name="code" id="code" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">
                    Confirm & Enable
                </button>
            </form>
        </div>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                var qr = qrcode(0, 'M');
                qr.addData("<?php echo e($qrCodeUrl); ?>");
                qr.make();
                document.getElementById('qrcode').innerHTML = qr.createImgTag(5, 10);
            });
        </script>

        <?php endif; ?>

        <?php if(auth()->user()->two_factor_confirmed_at): ?>
        <div class="bg-dark p-4 rounded-3 mb-8">
            <h2 class="h4 fw-bold mb-4 text-light">Two-Factor Authentication Recovery Codes</h2>
            <p class="mt-4 mb-2 text-light">Please store these recovery codes in a secure location:</p>
            <ul class="list-disc list-inside mb-4 text-light">
                <?php $__currentLoopData = json_decode(decrypt(auth()->user()->two_factor_recovery_codes)); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $code): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($code); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
        <?php endif; ?>

    </div>
    <div class="row mt-3">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4 text-center border-success">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-check-circle-fill text-success"></i> Completed Challenges
                    </h5>
                    <h2 class="display-4 text-success"><?php echo e($completed); ?></h2>
                    <p class="card-text">Total challenges you have completed.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4 text-center border-warning">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-hourglass-sand text-warning"></i> Total Challenges</h5>
                    <h2 class="display-4 text-warning"><?php echo e($totalChallenges); ?></h2>
                    <p class="card-text">Total Challenges available in the system.</p>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm mb-4 text-center border-info">
                <div class="card-body">
                    <h5 class="card-title"><i class="bi bi-info-circle-fill text-info"></i>Earned Points</h5>
                    <h2 class="display-4 text-info"><?php echo e(Auth::user()->score); ?>/ <?php echo e($sumOfMarks); ?></h2>
                    <p class="card-text">Earned points out of the possible.</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="mb-4 mt-3">
            <h2 class="fw-bold">Challenge Progress</h2>
            <div class="progress">
                <div class="progress-bar btn-theme hover:btn-theme" role="progressbar"
                     style="width: <?php echo e(round($inProgressChallenges, 2)); ?>%;"
                     aria-valuenow="<?php echo e(round($inProgressChallenges, 2)); ?>" aria-valuemin="0" aria-valuemax="100">
                    <?php echo e(round($inProgressChallenges, 2)); ?>%
                </div>
            </div>
            <p class="mt-2"><?php echo e(round($inProgressChallenges, 2)); ?>% Done</p>
        </div>
    </div>




    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr>
                                <th>Challenge Title</th>
                                <th>Date Completed</th>
                                <th>Certificate</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__currentLoopData = $completedChallenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $challenge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td><?php echo e($challenge->title); ?></td>
                                <td>
                                    <?php if($challenge->created_at): ?>
                                    <?php echo e($challenge->created_at->format('d M Y')); ?>

                                    <?php else: ?>
                                    N/A
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php
                                    // Check if the user already has a certificate for this challenge
                                    $certificate = $challenge->certificates()->where('user_id', auth()->id())->first();
                                    ?>

                                    <?php if($certificate): ?>
                                    <!-- If a certificate exists, show the download button -->
                                    <a href="<?php echo e(route('certificate.download', $certificate->id)); ?>" class="btn btn-primary">Download</a>
                                    <?php else: ?>
                                    <!-- If no certificate exists, show the request form -->
                                    <form action="<?php echo e(route('purchase')); ?>" method="POST">
                                        <?php echo csrf_field(); ?>
                                        <input type="hidden" name="payable_type" value="certificate">
                                        <input type="hidden" name="payable_id" value="<?php echo e($challenge->id); ?>"> <!-- Payable ID: ID of the challenge -->
                                        <input type="hidden" name="user_id" value="<?php echo e(auth()->id()); ?>">
                                        <input type="hidden" name="amount" value="10">
                                        <button type="submit" class="btn btn-success">Request Certificate ($10)</button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>

                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-dark  text-white">
                    <h5 class="mb-0">📅 Subscription Information</h5>
                </div>
                <div class="card-body text-center py-5">
                    <h5 class="card-title mb-4 fw-bold text-secondary">Current Subscription</h5>

                    <?php if($currentPlan): ?>
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <h2 class="display-4 text-primary mb-3"><?php echo e($currentPlan->plan->name); ?></h2>
                        <p class="card-text text-muted mb-2">
                            <strong>Price:</strong> $<?php echo e(number_format($currentPlan->plan->price, 2)); ?>

                        </p>
                        <p class="card-text text-muted mb-3">
                            <strong>Validity:</strong> <?php echo e($currentPlan->start_date->format('M d, Y')); ?> to <?php echo e($currentPlan->end_date->format('M d, Y')); ?>

                        </p>

                    </div>
                    <?php else: ?>
                    <div class="d-flex justify-content-center flex-column align-items-center">
                        <h2 class="h4 text-danger mb-3">No Current Plan</h2>
                        <p class="card-text mb-4">You don’t have an active subscription.</p>
                        <a href="<?php echo e(route('pricing')); ?>">
                            <button class="btn btn-outline-theme px-4 py-2 rounded-pill shadow-sm hover:shadow-lg">
                                Get Started
                            </button>
                        </a>
                    </div>
                    <?php endif; ?>
                </div>


            </div>
        </div>
    </div>
</div>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/htdocs/resources/views/dashboard/home.blade.php ENDPATH**/ ?>