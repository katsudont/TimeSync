<?php

require "vendor/autoload.php";
require "init.php";

// Database connection object (from init.php (DatabaseConnection))
global $conn;

try {

    // Create Router instance
    $router = new \Bramus\Router\Router();

    // Define routes

    $router->get('/', '\App\Controllers\LandingController@index');

    $router->get('/register', '\App\Controllers\RegistrationController@showForm');
    $router->post('/register', '\App\Controllers\RegistrationController@processForm');

    $router->get('/login', '\App\Controllers\LoginController@showForm');
    $router->post('/login', '\App\Controllers\LoginController@processForm');

    $router->get('/admin-dashboard', '\App\Controllers\AdminController@showDashboard');


    // Run it!
    $router->run();

} catch (Exception $e) {

    echo json_encode([
        'error' => $e->getMessage()
    ]);

}
