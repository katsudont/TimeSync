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
        // Create instances of models
        $attendanceModel = new Attendance();
        $employeeModel = new Employee();
        $departmentModel = new Department();
    
        // Fetch all attendance records
        $attendanceRecords = $attendanceModel->getAllAttendance();
    
        // Render the view with the attendance records
        $this->render('attendance', ['attendanceRecords' => $attendanceRecords]);
    }
    
    public function exportToPDF()
    {
        // Fetch the attendance records
        $attendanceModel = new Attendance();
        $attendanceRecords = $attendanceModel->getAllAttendance(); // Assuming this method fetches all records
    
        // Instantiate the FPDF class
        $pdf = new FPDF('L', 'mm', 'A4'); // Set the page orientation to landscape
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14); // Set the font for title
        
        // Title of the PDF
        $pdf->Cell(290, 10, 'Attendance Report', 0, 1, 'C'); // Centered title with adjusted width for landscape
    
        // Line break
        $pdf->Ln(10);
    
        // Set font for the table header
        $pdf->SetFont('Arial', 'B', 10);
    
        // Table header with adjusted column widths
        $pdf->Cell(25, 10, 'Employee ID', 1, 0, 'C');
        $pdf->Cell(45, 10, 'Employee Name', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Department', 1, 0, 'C'); // Adjusted width for Department
        $pdf->Cell(45, 10, 'Time In', 1, 0, 'C'); // Adjusted width for Time In
        $pdf->Cell(25, 10, 'In Status', 1, 0, 'C');
        $pdf->Cell(45, 10, 'Time Out', 1, 0, 'C'); // Adjusted width for Time Out
        $pdf->Cell(25, 10, 'Out Status', 1, 0, 'C');
        $pdf->Cell(30, 10, 'Shift ID', 1, 1, 'C'); // Adjusted width for Shift ID
    
        // Set font for the table content
        $pdf->SetFont('Arial', '', 10);
    
        // Loop through records and populate the table
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
    
        // Output the PDF to the browser
        $pdf->Output('D', 'attendance_report.pdf');
    }

}
