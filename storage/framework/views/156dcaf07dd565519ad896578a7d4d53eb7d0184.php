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



<section class="py-5">
    <div class="container">
        <div class="row mb-4">
            <div class="col-lg-10">
                <h2 class="fw-bold">Popular Challenges</h2>
                <p>Attempt as many challenges as possible.</p>
            </div>

            <?php if(Auth::user() && Auth::user()->role == 'admin'): ?>
            <div class="col-lg-2">
                <div class="mb-4">
                    <a href="<?php echo e(route('challenges.create')); ?>" class="btn btn-theme text-lg-end">Add Challenge</a>
                </div>
            </div>
            <?php endif; ?>

        </div>
        <?php if(session('success')): ?>
        <div class="alert alert-success mb-4">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-lg-12">
                <form action="<?php echo e(route('challenges')); ?>" method="GET" class="d-flex flex-column flex-md-row align-items-center">
                    <select name="difficulty" class="form-select me-2 mb-2 mb-md-0">
                        <option value="">All Difficulties</option>
                        <option value="easy" <?php echo e(request('difficulty') == 'easy' ? 'selected' : ''); ?>>Easy</option>
                        <option value="medium" <?php echo e(request('difficulty') == 'medium' ? 'selected' : ''); ?>>Medium</option>
                        <option value="hard" <?php echo e(request('difficulty') == 'hard' ? 'selected' : ''); ?>>Hard</option>
                    </select>

                    <select name="category" class="form-select me-2 mb-2 mb-md-0">
                        <option value="">All Categories</option>
                        <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($category->id); ?>" <?php echo e(request('category') == $category->id ? 'selected' : ''); ?>>
                        <?php echo e($category->name); ?>

                        </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>

                    <select name="sort" class="form-select me-2 mb-2 mb-md-0">
                        <option value="">Sort By Date</option>
                        <option value="asc" <?php echo e(request('sort') == 'asc' ? 'selected' : ''); ?>>Ascending</option>
                        <option value="desc" <?php echo e(request('sort') == 'desc' ? 'selected' : ''); ?>>Descending</option>
                    </select>

                    <button type="submit" class="btn btn-theme">
                        Filter
                    </button>
                </form>
            </div>
        </div>

        <div class="row">
            <?php $__currentLoopData = $challenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $challenge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0">
                    <img src="<?php echo e($challenge->image ? asset('storage/' . $challenge->image) : asset('images/challenge-placeholder.jpg')); ?>" class="card-img-top" alt="Challenge Image">
                    <div class="card-body">
                        <h5 class="card-title text-dark fw-bold"><?php echo e($challenge->title); ?></h5>
                        <p class="mb-1 text-muted small">
                            Estimated Time: <strong><?php echo e($challenge->time ?? '30'); ?></strong> &nbsp; | &nbsp;
                            Attempts: <strong><?php echo e($challenge->attempts ?? '0'); ?></strong>
                        </p>
                        <p class="text-secondary mb-2"><?php echo e($challenge->description); ?></p>

                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <span class="badge bg-primary"><?php echo e(ucfirst($challenge->difficulty)); ?></span>
                            <span class="badge bg-dark"><?php echo e($challenge->category->name ?? 'Uncategorized'); ?></span>
                        </div>

                        <a href="<?php echo e(route('challenges.editor', $challenge->id)); ?>" class="btn btn-theme btn-sm w-100 mb-2">
                            Start Challenge &rarr;
                        </a>
                        <!-- Admin-only Edit/Delete Buttons -->
                        <?php if(Auth::user() && Auth::user()->role == 'admin'): ?>
                        <div class="d-flex justify-content-between mt-2">
                            <a href="<?php echo e(route('challenges.edit', $challenge->id)); ?>" class="btn btn-outline-primary btn-sm w-50 me-1">
                                Edit
                            </a>
                            <form action="<?php echo e(route('challenges.destroy', $challenge->id)); ?>" method="POST" class="w-50">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Are you sure you want to delete this challenge?')">
                                    Delete
                                </button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/htdocs/resources/views/dashboard/challenges/index.blade.php ENDPATH**/ ?>