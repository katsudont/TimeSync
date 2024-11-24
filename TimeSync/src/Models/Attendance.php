<?php

namespace App\Models;

use App\Models\BaseModel;

class Attendance extends BaseModel
{
    // Count how many employees are currently clocked in
    public function countClockedIn()
    {
        $stmt = $this->db->prepare("
            SELECT COUNT(*) as count 
            FROM Attendance 
            WHERE Status = 'Present' 
            AND TimeIn IS NOT NULL 
            AND Date = CURDATE()
        ");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    // Fetch the most recent attendance records (limit by $limit)
    public function getRecent($limit = 5)
    {
        $stmt = $this->db->prepare("
            SELECT a.TimeIn, a.TimeOut, e.Name as EmployeeName, d.DepartmentName, a.Status
            FROM Attendance a
            JOIN Employees e ON a.EmployeeID = e.ID
            JOIN Departments d ON e.DepartmentID = d.ID
            WHERE a.TimeIn IS NOT NULL
            ORDER BY a.Date DESC, a.TimeIn DESC
            LIMIT :limit
        ");
        
        // Bind the limit parameter as an integer
        $stmt->bindParam(':limit', $limit, \PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    // Add a new attendance record (for clock-in or clock-out)
    public function addAttendance($employeeID, $status)
    {
        // Check if an attendance record already exists for today
        $stmt = $this->db->prepare("
            SELECT COUNT(*) 
            FROM Attendance 
            WHERE EmployeeID = ? 
            AND Date = CURDATE()
        ");
        $stmt->execute([$employeeID]);
        
        if ($stmt->fetchColumn() > 0) {
            return false; // Prevent duplicate records
        }

        // Add the new attendance record
        $stmt = $this->db->prepare("
            INSERT INTO Attendance (EmployeeID, Date, TimeIn, Status)
            VALUES (?, CURDATE(), NOW(), ?)
        ");
        return $stmt->execute([$employeeID, $status]);
    }

    // Update attendance record when clocking out
    public function updateAttendance($attendanceID)
    {
        $stmt = $this->db->prepare("
            UPDATE Attendance 
            SET TimeOut = NOW(), Status = 'Clocked Out'
            WHERE ID = ? AND TimeOut IS NULL
        ");
        return $stmt->execute([$attendanceID]);
    }
}
