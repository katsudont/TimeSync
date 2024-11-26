<?php

namespace App\Controllers;

use App\Models\Employee;

class EmployeeController extends BaseController
{
    public function index()
    {
        // Start session (only once)
        session_start();

        // Check if the user is logged in
        if (!isset($_SESSION['is_logged_in']) || !$_SESSION['is_logged_in']) {
            header('Location: /login');
            exit;
        }

        // Initialize the Employee model
        $employeeModel = new Employee();

        // Fetch employee data
        $employeeData = $employeeModel->getEmployeeData();

        // Prepare data for the view
        $data = [
            'employees' => $employeeData
        ];

        return $this->render('employee', $data); // Render employee view
    }
}
