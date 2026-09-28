<?php
require_once __DIR__ . '/backend/bootstrap.php';    

// Maintenance mode (local XAMPP stays viewable)
if (MAINTENANCE_MODE && APP_ENV !== 'local') {
    http_response_code(503);
    header('Retry-After: 3600');

    //require FRONTEND_PATH . '/pages/error/maintenance.php';
    exit;
}

$pages = [
    'home_main' => 'main/home_main.php',
    'landing' => 'landing.php',
    'login' => 'auth/login.php',
    'register' => 'auth/register.php',
    'forget' => 'auth/forget.php',
    'verification' => 'auth/verification.php',
    'reset' => 'auth/reset.php',
    'set_password' => 'auth/set_password.php',
    'error404' => 'error/error404.php',
    'maintenance' => 'error/maintenance.php',
    'services_main' => 'main/services_main.php',
    'sample' => 'sample.php',
<<<<<<< HEAD
    'Myrequest' => 'main/requestpage.php',
    'cart' => 'main/cart.php'
=======
    'request_main' => 'main/request_main.php',
>>>>>>> ab9372fb86d49e9289c7e782e662a514a854c8ea
];

//                        change this 'register'. pick the page in the $pages
$page = $_GET['page'] ?? 'home_main';

if (
    !is_string($page) ||
    !isset($pages[$page]) ||
    !is_file(FRONTEND_PATH . '/pages/' . $pages[$page])
) {
    http_response_code(404);

    require FRONTEND_PATH . '/pages/error/error404.php';
    exit;
}

require FRONTEND_PATH . '/pages/' . $pages[$page];
