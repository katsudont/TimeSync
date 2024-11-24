<?php

namespace App\Controllers;

use App\Models\Employee;
use App\Models\Department;
use App\Models\Attendance;

class AdminController extends BaseController
{
    public function showDashboard()
    {
        // Ensure the session is started
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

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
            'admin_name' => isset($_SESSION['user_name']) ? $_SESSION['user_name'] : 'Guest',
            'total_employees' => $totalEmployees,
            'total_departments' => $totalDepartments,
            'clocked_in_employees' => $clockedInEmployees,
            'recent_attendance' => $recentAttendance,
        ]);
    }
}
