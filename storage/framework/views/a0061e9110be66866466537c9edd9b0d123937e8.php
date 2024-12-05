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
                <h2 class="fw-bold">Edit Challenge</h2>
                <p>Update challenge details below.</p>
            </div>
        </div>

        <?php if(session('success')): ?>
        <div class="alert alert-success mb-4">
            <?php echo e(session('success')); ?>

        </div>
        <?php endif; ?>

        <div class="row mb-4">
            <div class="col-lg-12 mx-auto">
                <form action="<?php echo e(route('challenges.update', $challenge->id)); ?>" method="POST" enctype="multipart/form-data">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('PUT'); ?>

                    <div class="mb-3">
                        <label for="title" class="form-label">Challenge Title</label>
                        <input type="text" id="title" name="title" class="form-control" value="<?php echo e(old('title', $challenge->title)); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea id="description" name="description" rows="4" class="form-control" required><?php echo e(old('description', $challenge->description)); ?></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="difficulty" class="form-label">Difficulty</label>
                        <select id="difficulty" name="difficulty" class="form-select" required>
                            <option value="Easy" <?php echo e($challenge->difficulty == 'Easy' ? 'selected' : ''); ?>>Easy</option>
                            <option value="Medium" <?php echo e($challenge->difficulty == 'Medium' ? 'selected' : ''); ?>>Medium</option>
                            <option value="Hard" <?php echo e($challenge->difficulty == 'Hard' ? 'selected' : ''); ?>>Hard</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select id="category_id" name="category_id" class="form-select" required>
                            <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <option value="<?php echo e($category->id); ?>" <?php echo e($challenge->category_id == $category->id ? 'selected' : ''); ?>>
                                <?php echo e($category->name); ?>

                            </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                    </div>


                        <input type="hidden" id="content" name="content" rows="6" value="null" required><?php echo e(old('content', $challenge->content)); ?>>

                    <div class="mb-3">
                        <label for="image" class="form-label">Challenge Image</label>
                        <input type="file" id="image" name="image" class="form-control">
                        <?php if($challenge->image): ?>
                        <img src="<?php echo e(asset('storage/' . $challenge->image)); ?>" alt="Current Image" class="mt-3" width="150">
                        <?php endif; ?>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-theme">Update Challenge</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/devcom.infinityfreeapp.com/htdocs/resources/views/dashboard/challenges/edit.blade.php ENDPATH**/ ?>