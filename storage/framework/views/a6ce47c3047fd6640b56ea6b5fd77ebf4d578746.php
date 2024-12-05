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
    <div class="row justify-content-center">
        <div class=" p-3 col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center btn-theme">
                    <h4 class="h4 fw-bold">Confirm Password</h4>
                </div>
                <div class="card-body bg-light">
                    <p class="mb-4 text-gray-600">Please confirm your password before continuing.</p>

                    <form method="POST" action="<?php echo e(route('password.confirm')); ?>">
                        <?php echo csrf_field(); ?>

                        <div class="mb-4">
                            <label for="password" class="form-label">Password</label>
                            <input id="password" type="password"
                                   class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                   name="password" required autocomplete="current-password">

                            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>

                        <div class="d-flex justify-end">
                            <button type="submit" class="btn btn-theme btn-lg text-white fw-bold">
                                Confirm Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\DevCom\resources\views/auth/confirm-password.blade.php ENDPATH**/ ?>