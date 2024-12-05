<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CodeIt - Front-end Developer Challenges</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'codeit-green': '#9fef00',
                        'codeit-dark': '#111927',
                        'codeit-darker': '#0a0e17',
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-codeit-dark text-gray-300 font-sans">
<nav class="bg-codeit-darker border-b border-gray-800">
    <div class="container mx-auto px-6 py-3 flex justify-between items-center">
        <a href="<?php echo e(route('home')); ?>" class="text-codeit-green text-3xl font-bold">CodeIt</a>
        <div class="space-x-6">
            <?php if(auth()->guard()->check()): ?>
            <!-- User is logged in, show name and logout dropdown -->
            <div class="relative inline-block text-left">
                <button class="hover:text-codeit-green flex items-center focus:outline-none" id="user-menu-button" aria-expanded="true" aria-haspopup="true">
                    <?php echo e(Auth::user()->name); ?>

                    <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </button>

                <!-- Dropdown -->
                <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg z-50 hidden" id="user-menu">
                    <a href="<?php echo e(route('logout')); ?>"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 hover:text-gray-900"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        Logout
                    </a>
                    <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="hidden">
                        <?php echo csrf_field(); ?>
                    </form>
                </div>
            </div>

            <!-- Script to toggle dropdown -->
            <script>
                document.getElementById('user-menu-button').addEventListener('click', function() {
                    const menu = document.getElementById('user-menu');
                    menu.classList.toggle('hidden');
                });
            </script>
            <?php else: ?>
            <!-- User is not logged in, show default links -->
            <a href="<?php echo e(route('challenges')); ?>" class="hover:text-codeit-green">Challenges</a>
            <a href="<?php echo e(route('leaderboard')); ?>" class="hover:text-codeit-green">Leaderboard</a>
            <a href="<?php echo e(route('pricing')); ?>" class="hover:text-codeit-green">Pricing</a>
            <a href="<?php echo e(route('login')); ?>" class="bg-codeit-green text-codeit-darker px-4 py-2 rounded-md hover:bg-opacity-80 transition duration-300">Sign In</a>
            <?php endif; ?>
        </div>

    </div>
</nav>

<header class="py-20 text-center bg-codeit-darker">
    <h1 class="text-5xl font-bold mb-4">Welcome to <span class="text-codeit-green">CodeIt</span></h1>
    <p class="text-xl mb-8">Master Front-end Development through Interactive Challenges</p>
    <a href="<?php echo e(route('challenges')); ?>" class="bg-codeit-green text-codeit-darker px-6 py-3 rounded-md font-semibold hover:bg-opacity-80 transition duration-300">Start Coding</a>
</header>

<main class="container mx-auto py-12">
    <!-- Display session messages -->
    <?php if(session('error')): ?>
    <div class=" bg-red-500 text-white p-4 rounded-md mb-4">
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('success')): ?>
    <div class="bg-green-500 text-white p-4 rounded-md mb-4">
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <section class="mb-12">
        <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Latest Challenges</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php $__currentLoopData = $featuredChallenges; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $challenge): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-codeit-darker p-6 rounded-lg border border-gray-800 hover:border-codeit-green transition duration-300">
                <h3 class="text-xl font-bold mb-2 text-codeit-green"><?php echo e($challenge['title']); ?></h3>
                <p class="mb-4"><?php echo e($challenge['description']); ?></p>
                <span class="bg-<?php echo e($challenge['difficulty_color']); ?>-900 text-<?php echo e($challenge['difficulty_color']); ?>-300 text-xs font-medium mr-2 px-2.5 py-0.5 rounded"><?php echo e($challenge['difficulty']); ?></span>
                <a href="<?php echo e(route('challenges.show', $challenge['id'])); ?>" class="text-codeit-green hover:underline mt-2 inline-block">Start Challenge →</a>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <section class="mb-12">
        <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Your Coding Progress</h2>
        <div class="bg-codeit-darker p-6 rounded-lg border border-gray-800">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-xl font-bold">Challenges Completed</h3>
                <span class="text-2xl font-bold text-codeit-green"><?php echo e($completedChallenges); ?> / <?php echo e($totalChallenges); ?></span>
            </div>
            <div class="w-full bg-gray-800 rounded-full h-2.5">
                <?php if($totalChallenges > 0): ?>
                <div class="w-full bg-gray-200 rounded-full h-2.5 mb-4 dark:bg-gray-700">
                    <div class="bg-codeit-green h-2.5 rounded-full" style="width: <?php echo e(($completedChallenges / $totalChallenges) * 100); ?>%"></div>
                </div>
                <p>Completed <?php echo e($completedChallenges); ?> out of <?php echo e($totalChallenges); ?> challenges</p>
                <?php else: ?>
                <p>Completed 0 out of <?php echo e($totalChallenges); ?> challenges</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <section class="mb-12">
        <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Front-end Skill Categories</h2>
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <?php $__currentLoopData = $skillCategories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <a href="<?php echo e(route('challenges')); ?>" class="bg-codeit-darker p-4 rounded-lg border border-gray-800 text-center hover:border-codeit-green transition duration-300">
                <h3 class="font-bold"><?php echo e($category['name']); ?></h3>
            </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>

    <section>
        <h2 class="text-3xl font-bold mb-6 text-center text-codeit-green">Pricing Plans</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <?php $__currentLoopData = $pricingPlans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $plan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="bg-codeit-darker p-6 rounded-lg border border-gray-800 hover:border-codeit-green transition duration-300">
                <h3 class="text-xl font-bold mb-2 text-codeit-green"><?php echo e($plan['name']); ?></h3>
                <p class="text-3xl font-bold mb-4">$<?php echo e($plan['price']); ?><span class="text-sm font-normal">/month</span></p>
                <ul class="mb-6 space-y-2">
                    <?php $__currentLoopData = $plan['features']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $feature): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><?php echo e($feature); ?></li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
                <form action="<?php echo e(route('subscriptions.store')); ?>" class="block text-center bg-codeit-green text-codeit-darker px-4 py-2 rounded-md hover:bg-opacity-80 transition duration-300" method="POST">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="plan_id" value="<?php echo e($plan['id']); ?>">
                    <button type="submit">
                        Choose Plan
                    </button>
                </form>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </section>
</main>

<footer class="bg-codeit-darker py-6 mt-12">
    <div class="container mx-auto px-6 text-center">
        <p>&copy; <?php echo e(date('Y')); ?> CodeIt. All rights reserved.</p>
    </div>
</footer>
</body>
</html>
<?php /**PATH C:\xampp\htdocs\CodeIt\resources\views/welcome.blade.php ENDPATH**/ ?>