<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

    <title><?php echo e(config('app.name', 'Laravel')); ?></title>
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@heroicons/vue@2.0.18/dist/heroicons.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/themes/prism.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.25.0/prism.min.js"></script>

    <style>
        body {
            color: #333;
            font-family: 'Helvetica Neue', Arial, sans-serif;
            background-color: #f8f9fa;
        }

        /* Navbar */
        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
            color: #ff6b6b;
        }
        .nav-link {
            color: #333;
        }
        .nav-link:hover {
            outline: 2px solid #ff6b6b; /* Outline color on hover */
            outline-offset: 2px; /* Space between the outline and the item */
        }

        /* Popular Courses Section */
        h2.fw-bold {
            font-size: 2rem;
            color: #333;
        }
        .card {
            border: none;
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card img {
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
        }
        .course-title {
            font-weight: bold;
            font-size: 1.15rem;
            color: #333;
            margin-top: 10px;
        }
        .course-info {
            color: #6c757d;
            font-size: 0.9rem;
        }
        .enroll-course {
            color: #ff6b6b;
            font-weight: bold;
            font-size: 1.1rem;
        }
        .enroll-course a {
            color: #ff6b6b;
            text-decoration: none;
        }
        .enroll-course a:hover {
            text-decoration: underline;
        }

        /* Footer */
        .footer {
            background-color: #333;
            color: #ccc;
            padding: 40px 0;
            font-size: 0.9rem;
        }
        .footer h6 {
            color: #fff;
            font-weight: bold;
            margin-bottom: 20px;
        }
        .footer a {
            color: #ccc;
            text-decoration: none;
        }
        .footer a:hover {
            color: #ff6b6b;
            text-decoration: underline;
        }
        .footer .input-group input {
            border-radius: 20px 0 0 20px;
            border-color: #6c757d;
        }
        .footer .input-group button {
            background-color: #ff6b6b;
            border-radius: 0 20px 20px 0;
            border: none;
        }
        .footer .input-group button:hover {
            background-color: #e65a5a;
        }
        .footer .input-group input::placeholder {
            color: #ccc;
        }
        .footer .small {
            color: #aaa;
            margin-top: 20px;
        }

        /* Responsive Adjustments */
        @media (max-width: 768px) {
            .navbar-brand {
                font-size: 1.2rem;
            }
            .enroll-course a {
                font-size: 1rem;
            }
        }
        .btn-theme {
            background-color: #ff6b6b;
            color: white;
            border: none;
        }
        .theme {
            color: #ff6b6b;
        }
        .btn-theme:hover {
            background-color: #e05e5e;
        }
        .form-control:focus {
            border-color: #ff6b6b;
            box-shadow: 0 0 0 0.25rem rgba(255, 107, 107, 0.25);
        }
        /* Style for dropdown menus */
        .dropdown-menu {
            display: none; /* Hide the dropdown by default */
            position: absolute;
            background-color: white; /* Background color of the dropdown */
            color: #ff6b6b;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            z-index: 1000; /* Ensures the dropdown appears above other elements */
        }

        .nav-item.dropdown:hover .dropdown-menu {
            display: block; /* Show dropdown on hover */

        }

        .nav-item.dropdown {
            position: relative; /* Ensure dropdown positioning works */
        }

        .nav-link {
            transition: color 0.3s ease; /* Smooth color transition on hover */
        }

        .nav-link:hover {
            color: #ff6b6b; /* Change color on hover for better visibility */
        }

    </style>


</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
            <?php echo e(config('app.name', 'Laravel')); ?>

        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('home')); ?>">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('discussions.index')); ?>">Discussion</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('challenges')); ?>">Challenges</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo e(route('pricing')); ?>">Pricing</a>
                </li>



                <?php if(auth()->guard()->guest()): ?>

                <?php if(Route::has('login')): ?>
                <li class="nav-item">
                    <a class="nav-link btn btn-outline-primary" href="<?php echo e(route('login')); ?>"><?php echo e(__('Login')); ?></a>
                </li>
                <?php endif; ?>
                <?php if(Route::has('register')): ?>
                <li class="nav-item">
                    <a class="nav-link btn-theme hover:btn-theme" href="<?php echo e(route('register')); ?>"><?php echo e(__('Register')); ?></a>
                </li>
                <?php endif; ?>
                <?php else: ?>
                <?php if(Auth::user()->role == 'admin'): ?> <!-- Corrected equality check -->
                <li class="nav-item dropdown">
                    <a class="nav-link" href="#" id="adminDropdown" role="button" aria-haspopup="true" aria-expanded="false">
                        Admin
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="adminDropdown">
                        <li><a class="dropdown-item" href="<?php echo e(route('users.index')); ?>">Users</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('categories.index')); ?>">Categories</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('payments.index')); ?>">Payments</a></li>
                        <li><a class="dropdown-item" href="<?php echo e(route('solutions.index')); ?>">Solutions</a></li>
                    </ul>
                </li>
                <?php endif; ?>
                <li class="nav-item dropdown">
                    <a id="navbarDropdown" class="nav-link " href="#" role="button" aria-haspopup="true" aria-expanded="false" v-pre>
                        <img src="<?php echo e(asset('images/avator.png')); ?>" alt="User Avatar" class="rounded-circle" style="width: 30px; height: 30px;"/> <?php echo e(Auth::user()->name); ?>

                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo e(route('logout')); ?>" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><?php echo e(__('Logout')); ?></a></li>
                        <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" class="d-none">
                            <?php echo csrf_field(); ?>
                        </form>
                    </ul>
                </li>
                <?php endif; ?>

            </ul>
        </div>
    </div>
</nav>





<?php echo $__env->yieldContent('content'); ?>

<!-- Footer -->
<footer class="footer">
    <div class="container text-center text-md-start">
        <div class="row">
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold">DevCom</h6>
                <p>Helping you build skills for a better future.</p>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold">home</h6>
                <ul class="list-unstyled">
                    <li><a href="#">challenges</a></li>
                    <li><a href="#">pricing</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold">Support</h6>
                <ul class="list-unstyled">
                    <li><a href="#">Help Center</a></li>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
            <div class="col-md-2 mb-4">
                <h6 class="fw-bold">Connect</h6>
                <ul class="list-unstyled">
                    <li><a href="#">Contact Us</a></li>
                    <li><a href="#">FAQs</a></li>
                    <li><a href="#">Community</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="fw-bold">Subscribe</h6>
                <form class="input-group">
                    <input type="email" class="form-control" placeholder="Enter your email">
                    <button class="btn btn-primary" type="button">Subscribe</button>
                </form>
            </div>
        </div>
        <div class="text-center mt-3">
            <p class="small">© 2024 DevCom. All rights reserved.</p>
        </div>
    </div>
</footer>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script type="text/javaScript">
        function testKeyCode(e) {
        var keycode;
        if (window.event) keycode = window.event.keyCode;
        else if (e) keycode = e.which;
        var e = e || window.event;
        if (e.ctrlKey &&
        (e.keyCode === 85 ||
        e.keyCode === 117)) {
        alert('This website is protected against attempts to clone. Your IP has been duly recorded on our server and if you persist it will be forwarded to the competent authorities');
        return false;
    } else {
        return true;
    }
    }
        document.onkeydown = testKeyCode;


        document.addEventListener('contextmenu', (event) => {
            event.preventDefault();
        });

</script>
</html>
<?php /**PATH /home/vol15_1/infinityfree.com/if0_37678337/devcom.infinityfreeapp.com/htdocs/resources/views/layouts/front.blade.php ENDPATH**/ ?>