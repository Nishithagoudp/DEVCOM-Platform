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
    #timer {
        font-size: 3rem;
        font-weight: bold;
    }
</style>

<div class="container py-5" id="mainContainer">
    <div class="row mb-4">
        <div class="col-md-8">
            <h4 class="h4 fw-bold"><?php echo e($challenge->title); ?>(<?php echo e($challenge->marks); ?> Marks)</h4>
            <p class="text-muted">Difficulty: <span class="badge bg-primary"><?php echo e(ucfirst($challenge->difficulty)); ?></span></p>
        </div>
        <div class="col-md-2 text-center">
            <div id="timer" class="h1 text-danger"><?php echo e(gmdate("i:s", $challenge->time * 60)); ?></div>
            <button id="resetTimer" style="display: none;"></button>
        </div>
    </div>

    <!-- Info Modal -->
    <div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="infoModalLabel">Challenge Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>The timer will start immediately once you click "Start". The page will not allow refresh during the test, and the content will be hidden when the time ends.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" id="startTest" class="btn btn-theme">Start Challenge</button>
                </div>
            </div>
        </div>
    </div>

    <?php if($errors->any()): ?>
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>
    <?php if(session('success')): ?>
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo e(session('success')); ?>

        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <?php endif; ?>

    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h4 class="h4 fw-bold">Expectations</h4>
            <p class="text-secondary"><?php echo e($challenge->description); ?></p>
        </div>
    </div>

    <div class="card shadow-sm mb-5 bg-dark text-light">
        <div class="card-body">
            <h4 class="h4 fw-bold mb-4 text-white">Code Editor</h4>
            <iframe
                frameborder="0"
                height="800px"
                src="https://onecompiler.com/embed/html?theme=dark"
                width="100%"
                class="mb-3"
                style="background-color: #1e1e1e; border-radius: 8px;"
            ></iframe>
        </div>
    </div>

    <div class="card shadow-sm mb-5">
        <div class="card-body">
            <h4 class="h4 fw-bold mb-4">Submit Your Solution</h4>
            <form action="<?php echo e(route('challenges.submit', $challenge->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-4">
                    <label for="html" class="form-label">HTML:</label>
                    <textarea id="html" name="html" rows="6" class="form-control" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="css" class="form-label">CSS:</label>
                    <textarea id="css" name="css" rows="6" class="form-control" required></textarea>
                </div>
                <div class="mb-4">
                    <label for="javascript" class="form-label">JavaScript:</label>
                    <textarea id="javascript" name="javascript" rows="6" class="form-control" required></textarea>
                </div>
                <button type="submit" class="btn btn-theme btn-lg w-100">
                    Submit Solution
                </button>
            </form>
        </div>
    </div>
</div>

<script>
    let time = <?php echo e($challenge->time * 60); ?>; // Time from the database in seconds
    let timerInterval;
    let testStarted = false;

    // Show the modal on page load
    window.addEventListener('DOMContentLoaded', (event) => {
        const infoModal = new bootstrap.Modal(document.getElementById('infoModal'));
        infoModal.show();
    });

    function startTimer() {
        document.getElementById('startTest').style.display = 'none';
        testStarted = true;

        timerInterval = setInterval(() => {
            if (time <= 0) {
                clearInterval(timerInterval);
                alert("Time's up! The challenge will disappear immediately.");
                document.getElementById('mainContainer').classList.add('d-none'); // Hide the main container
            } else {
                time--;
                const minutes = Math.floor(time / 60);
                const seconds = time % 60;
                document.getElementById('timer').innerText = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
            }
        }, 1000);
    }

    document.getElementById('startTest').addEventListener('click', () => {
        startTimer();
        const infoModal = bootstrap.Modal.getInstance(document.getElementById('infoModal'));
        infoModal.hide(); // Close modal when the test starts
    });

</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/devcom.infinityfreeapp.com/htdocs/resources/views/dashboard/challenges/editor.blade.php ENDPATH**/ ?>