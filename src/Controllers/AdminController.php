<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;

class AdminController extends BaseController
{
    public function showDashboard()
    {
        // Fetch stats
        $employeeModel = new Employee();
        $departmentModel = new Department();
        $attendanceModel = new Attendance();

        $totalEmployees = $employeeModel->count();
        $totalDepartments = $departmentModel->count();
        $clockedInEmployees = $attendanceModel->countClockedIn();
        $recentAttendance = $attendanceModel->getRecent(5);

        // Render the dashboard
        $this->render('admin-dashboard', [
            'admin_name' => $_SESSION['user_name'], // Assuming you store admin's name in the session
            'total_employees' => $totalEmployees,
            'total_departments' => $totalDepartments,
            'clocked_in_employees' => $clockedInEmployees,
            'recent_attendance' => $recentAttendance,
        ]);
    }
}
