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

    $router->get('/register', '\App\Controllers\RegisterController@index');
    $router->post('/register', '\App\Controllers\RegisterController@store');

    $router->get('/login', '\App\Controllers\LoginController@login'); // Temporarily for testing
    $router->post('/login', '\App\Controllers\LoginController@login');

    // Define the route for the dashboard page
    $router->get('/admin-dashboard', '\App\Controllers\DashboardController@index');

    $router->get('/profile', '\App\Controllers\ProfileController@index');
    $router->post('/profile/update', '\App\Controllers\ProfileController@update');

    $router->get('/employee', 'EmployeeController@index');







    


    // Run it!
    $router->run();

} catch (Exception $e) {

    echo json_encode([
        'error' => $e->getMessage()
    ]);

}
