<?php

namespace App\Controllers;

use App\Models\User;

class LoginController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function login()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        // Authenticate user
        $user = $this->userModel->login($username, $password);

        if ($user) {
            // Reset login attempts
            $_SESSION['login_attempts'] = 0;

            // Store session data
            $_SESSION['is_logged_in'] = true;
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role_id'] = $user['role_id'];

            // Redirect based on role
            if ($user['role_id'] == 1) {
                header('Location: /admin-dashboard');
            } elseif ($user['role_id'] == 2) {
                header('Location: /employee-dashboard');
            }
            exit();
        } else {
            // Increment login attempts and display error
            $_SESSION['login_attempts'] = ($_SESSION['login_attempts'] ?? 0) + 1;

            $data = [
                'title' => 'Login',
                'error' => 'Login failed. Please check your username and password.',
            ];
            return $this->render('login', $data);
        }
    }
}
