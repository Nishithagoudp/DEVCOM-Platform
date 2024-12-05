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
        <div class="col-md-6">
            <div class="bg-gray-800 shadow-md rounded px-8 pt-6 pb-8 mb-4">
                <div class="mb-6 text-center">
                    <h4 class=" h4 text-2xl font-bold text-gray-300">Two-Factor Authentication</h4>
                </div>

                <form method="POST" action="<?php echo e(route('two-factor.login')); ?>">
                    <?php echo csrf_field(); ?>

                    <?php if(session('status')): ?>
                    <div class="bg-green-500 text-white px-4 py-2 rounded mb-4" role="alert">
                        <?php echo e(session('status')); ?>

                    </div>
                    <?php endif; ?>

                    <p class="text-gray-400 mb-4 text-sm">Please confirm access to your account by entering the authentication code provided by your authenticator application.</p>

                    <div class="mb-4">
                        <label class="block text-gray-400 text-sm font-bold mb-2" for="code">
                            Authentication Code
                        </label>
                        <input class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               id="code"
                               type="text"
                               name="code"
                               required
                               autofocus>
                        <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs italic mt-2"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex items-center justify-end mb-6">
                        <button class="btn-theme btn-lg text-white fw-bold" type="submit">
                            Verify
                        </button>
                    </div>
                </form>

                <hr class="my-6 border-gray-700">

                <form method="POST" action="<?php echo e(route('two-factor.login')); ?>">
                    <?php echo csrf_field(); ?>

                    <p class="text-gray-400 mb-4 text-sm">Or confirm access to your account by entering one of your emergency recovery codes.</p>

                    <div class="mb-4">
                        <label class="block text-gray-400 text-sm font-bold mb-2" for="recovery_code">
                            Recovery Code
                        </label>
                        <input class="form-control <?php $__errorArgs = ['recovery_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                               id="recovery_code"
                               type="text"
                               name="recovery_code">
                        <?php $__errorArgs = ['recovery_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <p class="text-red-500 text-xs italic mt-2"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <div class="flex items-center justify-end">
                        <button class="btn-theme btn-lg text-white fw-bold" type="submit">
                            Verify
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/devcom.infinityfreeapp.com/htdocs/resources/views/auth/two-factor-challenge.blade.php ENDPATH**/ ?>