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
         /* Password field styling */
     .form-control {
         border: 1px solid #ced4da;
         padding: 0.5rem;
         font-size: 1rem;
     }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    /* Progress bar customization */
    .progress-bar {
        transition: width 0.4s ease;
    }

    /* Feedback message styling */
    #passwordHelp {
        font-size: 0.9rem;
        font-weight: 500;
        color: #6c757d;
    }

    /* Colors for different feedback levels */
    .bg-danger {
        background-color: #dc3545 !important;
    }
    .bg-warning {
        background-color: #ffc107 !important;
    }
    .bg-success {
        background-color: #28a745 !important;
    }

</style>
<div class="container mt-3 mb-3">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-lg border-0">
                <div class="card-header text-center btn-theme">
                    <h4 class="fw-bold">Registration</h4>
                </div>
                <div class="card-body bg-light">
                    <form method="POST" action="<?php echo e(route('register')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('name')); ?>" required autofocus aria-label="Name">
                            <?php $__errorArgs = ['name'];
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
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" value="<?php echo e(old('email')); ?>" required aria-label="Email">
                            <?php $__errorArgs = ['email'];
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
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" id="password" name="password" class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required aria-label="Password">

                            <!-- Progress bar for password strength -->
                            <div class="progress mt-2" style="height: 8px;">
                                <div id="passwordStrengthBar" class="progress-bar" role="progressbar" style="width: 0%;"></div>
                            </div>

                            <!-- Password feedback message -->
                            <small id="passwordHelp" class="form-text text-muted mt-2">Password must be at least 8 characters, with uppercase, lowercase, number, and special character.</small>

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


                        <div class="mb-4">
                            <label for="password_confirmation" class="form-label">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required aria-label="Confirm Password">
                        </div>
                        <div class="d-grid gap-2 mb-3">
                            <button type="submit" class="btn btn-theme btn-lg fw-bold">Register</button>
                        </div>
                        <div class="text-center">
                            <a href="<?php echo e(route('login')); ?>" class="text-decoration-none text-danger fw-bold">Already have an account?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    document.getElementById('password').addEventListener('input', function () {
        const password = this.value;
        const message = document.getElementById('passwordHelp');
        const strengthBar = document.getElementById('passwordStrengthBar');

        // Validation criteria
        const isLongEnough = password.length >= 8;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSymbol = /[\W]/.test(password);

        // Calculate strength score
        let strengthScore = 0;
        if (isLongEnough) strengthScore += 20;
        if (hasUpperCase) strengthScore += 20;
        if (hasLowerCase) strengthScore += 20;
        if (hasNumber) strengthScore += 20;
        if (hasSymbol) strengthScore += 20;

        // Update progress bar and message
        strengthBar.style.width = `${strengthScore}%`;
        if (strengthScore < 60) {
            strengthBar.className = 'progress-bar bg-danger';
            message.textContent = "Weak password. Make sure to include all required elements.";
            message.style.color = "red";
        } else if (strengthScore < 80) {
            strengthBar.className = 'progress-bar bg-warning';
            message.textContent = "Moderate password. Add more elements to strengthen it.";
            message.style.color = "orange";
        } else {
            strengthBar.className = 'progress-bar bg-success';
            message.textContent = "Strong password!";
            message.style.color = "green";
        }
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\DevCom\resources\views/auth/registration.blade.php ENDPATH**/ ?>