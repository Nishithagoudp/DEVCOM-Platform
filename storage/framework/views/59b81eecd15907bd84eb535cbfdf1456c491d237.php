<div class="card mb-2">
    <div class="card-body">
        <p><strong><?php echo e($response->user->name); ?></strong> replied:</p>
        <p><?php echo e($response->body); ?></p>
        <?php if($response->code_snippet): ?>
        <h5>Code Snippet:</h5>
        <pre style="max-height: 350px"><code class="language-<?php echo e($language ?? 'javascript'); ?>"><?php echo e($response->code_snippet); ?></code></pre>
        <?php endif; ?>
        <p class="text-muted"><?php echo e($response->created_at->diffForHumans()); ?></p>

        <!-- Reply Form for each response -->
        <button class="btn btn-link text-decoration-none theme" data-bs-toggle="collapse" data-bs-target="#replyForm<?php echo e($response->id); ?>">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-reply" viewBox="0 0 16 16">
                <path d="M6.598 5.013a.144.144 0 0 1 .202.134V6.3a.5.5 0 0 0 .5.5c.667 0 2.013.005 3.3.822.984.624 1.99 1.76 2.595 3.876-1.02-.983-2.185-1.516-3.205-1.799a8.7 8.7 0 0 0-1.921-.306 7 7 0 0 0-.798.008h-.013l-.005.001h-.001L7.3 9.9l-.05-.498a.5.5 0 0 0-.45.498v1.153c0 .108-.11.176-.202.134L2.614 8.254l-.042-.028a.147.147 0 0 1 0-.252l.042-.028zM7.8 10.386q.103 0 .223.006c.434.02 1.034.086 1.7.271 1.326.368 2.896 1.202 3.94 3.08a.5.5 0 0 0 .933-.305c-.464-3.71-1.886-5.662-3.46-6.66-1.245-.79-2.527-.942-3.336-.971v-.66a1.144 1.144 0 0 0-1.767-.96l-3.994 2.94a1.147 1.147 0 0 0 0 1.946l3.994 2.94a1.144 1.144 0 0 0 1.767-.96z"/>
            </svg> Reply
        </button>

        <div id="replyForm<?php echo e($response->id); ?>" class="collapse mt-2">
            <form action="<?php echo e(route('discussions.responses.storeReply', $response->id)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <div class="mb-3">
                    <textarea class="form-control" name="body" rows="2" required></textarea>
                </div>
                <button type="submit" class="btn btn-theme">Submit Reply</button>
            </form>
        </div>

        <!-- Recursive display of child replies -->
        <?php if($response->children): ?>
        <div class="ms-4">
            <?php $__currentLoopData = $response->children; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $child): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php echo $__env->make('dashboard.discussions.partials.response', ['response' => $child], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php /**PATH C:\xampp\htdocs\DevCom\resources\views/dashboard/discussions/partials/response.blade.php ENDPATH**/ ?>