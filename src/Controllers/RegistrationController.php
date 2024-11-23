<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Models\Department;

class RegistrationController extends BaseController
{
    public function showForm()
    {
        // Fetch all departments
        $departmentModel = new Department();
        $departments = $departmentModel->getAll();

        // Render the registration form
        $this->render('register', [
            'departments' => $departments,
        ]);
    }

    public function processForm()
    {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $departmentID = $_POST['department'] ?? '';

        // Insert employee into database using the model
        $employeeModel = new Employee();
        if ($employeeModel->create($name, $email, $password, $departmentID)) {
            // Redirect on success
            header('Location: /login');
        } else {
            // Handle failure (e.g., display an error message)
            echo "Failed to register. Please try again.";
        }
    }
}
