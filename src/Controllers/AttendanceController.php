<?php

namespace App\Controllers;

use App\Models\Attendance;
use App\Models\Employee;
use App\Models\Department;
use FPDF; // Import the FPDF class

class AttendanceController extends BaseController
{
    public function index()
    {
        $attendanceModel = new Attendance();
        
        // Check for filter inputs from the GET request
        $filters = [
            'EmployeeID' => $_GET['EmployeeID'] ?? null,
            'EmployeeName' => $_GET['EmployeeName'] ?? null,
            'DepartmentName' => $_GET['DepartmentName'] ?? null,
            'ShiftID' => $_GET['ShiftID'] ?? null
        ];
        
        // Get filtered records
        $attendanceRecords = $attendanceModel->getFilteredAttendance($filters);
        
        // Render the view
        $this->render('attendance', ['attendanceRecords' => $attendanceRecords]);
    }

    public function exportToPDF()
{
    $attendanceModel = new Attendance();

    // Collect filters from the GET request
    $filters = [
        'EmployeeID' => $_GET['EmployeeID'] ?? null,
        'EmployeeName' => $_GET['EmployeeName'] ?? null,
        'DepartmentName' => $_GET['DepartmentName'] ?? null,
        'ShiftID' => $_GET['ShiftID'] ?? null,
    ];

    $attendanceRecords = $attendanceModel->getFilteredAttendance($filters);


    $pdf = new FPDF('L', 'mm', 'A4');
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 14);
    $pdf->Cell(290, 10, 'Attendance Summary', 0, 1, 'C');
    $pdf->Ln(10);
    $pdf->SetFont('Arial', 'B', 10);

    $pdf->Cell(25, 10, 'Employee ID', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Employee Name', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Department', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Time In', 1, 0, 'C');
    $pdf->Cell(25, 10, 'In Status', 1, 0, 'C');
    $pdf->Cell(45, 10, 'Out Time', 1, 0, 'C');
    $pdf->Cell(25, 10, 'Out Status', 1, 0, 'C');
    $pdf->Cell(30, 10, 'Shift ID', 1, 1, 'C');

    $pdf->SetFont('Arial', '', 10);

    foreach ($attendanceRecords as $record) {
        $pdf->Cell(25, 10, $record['EmployeeID'], 1, 0, 'C');
        $pdf->Cell(45, 10, $record['EmployeeName'], 1, 0, 'C');
        $pdf->Cell(30, 10, $record['DepartmentName'], 1, 0, 'C');
        $pdf->Cell(45, 10, $record['InTime'], 1, 0, 'C');
        $pdf->Cell(25, 10, $record['InStatus'], 1, 0, 'C');
        $pdf->Cell(45, 10, $record['OutTime'], 1, 0, 'C');
        $pdf->Cell(25, 10, $record['OutStatus'], 1, 0, 'C');
        $pdf->Cell(30, 10, $record['ShiftID'], 1, 1, 'C');
    }

    $pdf->Output('D', 'attendance_summary.pdf');
}


}
