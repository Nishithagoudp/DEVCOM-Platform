

<?php $__env->startSection('content'); ?>
<style>
    /* General Styles */
    body {
        font-family: 'Nunito', sans-serif;
        color: #444;
    }

    .text-theme {
        color: #ff6b6b;
    }

    .btn-theme {
        background-color: #ff6b6b;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        font-size: 1.1rem;
        border-radius: 8px;
        transition: background-color 0.3s ease;
    }

    .btn-theme:hover {
        background-color: #e05e5e;
    }

    /* Hero Section */
    .hero {
        min-height: 80vh;
        background-image: url('<?php echo e(asset("images/hero-background.png")); ?>');
        background-size: cover;
        background-position: center;
        color: #fff;
        position: relative;
    }

    .hero::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0, 0, 0, 0.4);
        z-index: 1;
    }

    .hero .container {
        position: relative;
        z-index: 2;
    }

    .hero h1 {
        font-size: 3rem;
        font-weight: 700;
    }

    .hero p {
        font-size: 1.25rem;
        max-width: 600px;
    }

    .hero .btn-theme {
        padding: 0.75rem 1.5rem;
        font-size: 1.25rem;
    }

    /* Card Sections */
    .card {
        border: none;
        border-radius: 10px;
        overflow: hidden;
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
    }

    .card img {
        object-fit: cover;
        height: 200px;
    }

    .course-title {
        font-weight: 600;
        font-size: 1.2rem;
        color: #444;
        margin-top: 10px;
    }

    .course-info {
        color: #666;
        font-size: 0.95rem;
    }

    .enroll-course {
        color: #ff6b6b;
        font-weight: bold;
        text-decoration: none;
        transition: color 0.2s ease;
    }

    .enroll-course:hover {
        color: #e05e5e;
    }

    /* Featured Challenges Section */
    .featured-challenges {
        background-color: #f9f9f9;
    }

    /* Discussion Forum Section */
    .discussion-forum {
        background-color: #fff;
    }

    /* Call to Action Section */
    .cta-section {
        background-color: #333;
        color: white;
    }

    .cta-section h2 {
        font-size: 2.5rem;
        color: #ff6b6b;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero h1 {
            font-size: 2.25rem;
        }

        .hero p {
            font-size: 1.1rem;
        }
    }

</style>

<!-- Hero Section -->
<section class="hero d-flex align-items-center text-center text-md-start">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-6">
                <h1 class="display-4 fw-bold">Welcome to DevCom</h1>
                <p class="lead">Build skills for a brighter future. Join challenges, engage in discussions, and learn with us! This is where you need to build your career to higher levels</p>
                <a href="<?php echo e(route('register')); ?>" class="btn btn-theme btn-lg mt-4 m-2">Get Started</a>
                <a href="<?php echo e(route('pricing')); ?>" class="btn btn-theme btn-lg mt-4 m-2">Pricing</a>
            </div>
            <div class="col-md-6 text-center">
                <img src="<?php echo e(asset('images/hero-image.png')); ?>" alt="Hero Image" class="img-fluid rounded shadow-lg">
            </div>
        </div>
    </div>
</section>
<!-- About Section -->
<section class="about-section py-5 bg-white">
    <?php if(Session::has('error')): ?>
    <div class="alert alert-danger">
        <?php echo e(Session::get('error')); ?>

    </div>
    <?php endif; ?>
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Column: Image -->
            <div class="col-md-6 mb-4 mb-md-0">
                <img src="<?php echo e(asset('images/about.png')); ?>" alt="About Us" class="img-fluid rounded">
            </div>

            <!-- Right Column: Text Content -->
            <div class="col-md-6">
                <h2 class="fw-bold text-theme mb-3">About DevCom</h2>
                <p class="lead text-muted mb-4">
                    At DevCom, we believe in empowering developers by providing a collaborative and challenging environment to build essential coding skills. Our mission is to create a space where you can learn, grow, and connect with a community of passionate developers.
                </p>
                <p>
                    Join our platform to access a wide variety of coding challenges, engage in insightful discussions, and track your progress. Whether you're a beginner or a seasoned programmer, DevCom offers resources and tools tailored to help you succeed in your coding journey.
                </p>
                <a href="#" class="btn btn-theme mt-3">Learn More</a>
            </div>
        </div>
    </div>
</section>


<!-- Featured Challenges Section -->
<section class="py-5" style="background: linear-gradient(135deg, #f8f9fa, #e2e6ea);">
    <div class="container">
        <h2 class="fw-bold text-center mb-4">Latest Challenges</h2>
        <div class="row mb-5">
            <?php $__currentLoopData = $challenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $challenge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm border-0 d-flex flex-column h-100">
                    <img src="<?php echo e($challenge->image ? asset('storage/' . $challenge->image) : asset('images/challenge-placeholder.jpg')); ?>"
                         class="card-img-top" alt="Challenge Image">
                    <div class="card-body d-flex flex-column">
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
                        <div class="mt-auto">
                            <a href="<?php echo e(route('challenges.editor', $challenge->id)); ?>"
                               class="btn btn-theme btn-sm w-100 mb-2">Start Challenge &rarr;</a>
                        </div>
                        <?php if(Auth::user() && Auth::user()->role == 'admin'): ?>
                        <div class="d-flex justify-content-between mt-2">
                            <a href="<?php echo e(route('challenges.edit', $challenge->id)); ?>"
                               class="btn btn-outline-primary btn-sm w-50 me-1">Edit</a>
                            <form action="<?php echo e(route('challenges.destroy', $challenge->id)); ?>" method="POST" class="w-50">
                                <?php echo csrf_field(); ?>
                                <?php echo method_field('DELETE'); ?>
                                <button type="submit" class="btn btn-outline-danger btn-sm w-100" onclick="return confirm('Are you sure you want to delete this challenge?')">Delete</button>
                            </form>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <!-- Button Positioned at the Bottom of Section -->
        <div class="text-center">
            <a href="<?php echo e(route('challenges')); ?>" class="btn btn-theme">Explore All Challenges</a>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-4">Pricing Plans</h2>
        <p class="text-center mb-5">The hare our pricing plans and their features.</p>
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
                        <ul class="list-unstyled flex-grow-1 mb-4"> <!-- Flex-grow pushes the list to take up available space -->
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
</section>

<!-- Discussion Forum Section -->
<section class="discussion-forum bg-light py-5">
    <div class="container">
        <h2 class="fw-bold text-center mb-4">Join the Conversation</h2>
        <p class="text-center mb-5">Get insights, share knowledge, and solve problems with our community.</p>
        <div class="row">
            <?php $__currentLoopData = $discussions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $discussion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-md-4 mb-4">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h5 class="course-title"> <?php echo e($discussion->title); ?></h5>
                        <p class="course-info"> <i class="bi bi-person-fill me-1"></i>  Started by <?php echo e($discussion->user->name); ?> | <i class="bi bi-clock me-1"></i><?php echo e($discussion->created_at->diffForHumans()); ?></p>
                        <p class="mb-2"><?php echo e(Str::limit($discussion->body, 100)); ?></p>
                        <a href="<?php echo e(route('discussions.show', $discussion->id)); ?>" class="enroll-course">View Discussion</a>
                    </div>
                </div>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <div class="text-center mt-4">
            <a href="<?php echo e(route('discussions.index')); ?>" class="btn btn-theme">Join Discussions</a>
        </div>
    </div>
</section>


<!-- Call to Action Section -->
<section class="cta-section py-5 text-center">
    <div class="container">
        <h2 class="fw-bold">Ready to start your journey?</h2>
        <p>Join our growing community and build skills that matter!</p>
        <a href="<?php echo e(route('register')); ?>" class="btn btn-theme btn-lg">Sign Up Now</a>
    </div>
    <hr>

</section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.front', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\devcom1\resources\views/index.blade.php ENDPATH**/ ?>