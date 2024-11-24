<?php

namespace App\Controllers;

use App\Models\Employee;

class LoginController extends BaseController
{
    public function showForm()
    {
        // Render the login form
        $this->render('login');
    }

    public function processForm()
    {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        // Verify email and password using the model
        $employeeModel = new Employee();
        $user = $employeeModel->verifyCredentials($email, $password);

        if ($user) {
            // Start session and store user data
            session_start();
            $_SESSION['user_id'] = $user['ID'];
            $_SESSION['department'] = $user['DepartmentName'];

            // Redirect based on department
            if (strtolower($user['DepartmentName']) === 'admin') {
                header('Location: /admin-dashboard');
            } else {
                header('Location: /employee-dashboard');
            }
        } else {
            // Handle invalid credentials
            echo "Invalid email or password. Please try again.";
        }
    }
}
