<?php

namespace App\Models;

class Employee extends BaseModel
{
    public function create($name, $email, $password, $departmentID)
    {
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO Employees (Name, Email, Password, HireDate, DepartmentID) VALUES (?, ?, ?, NOW(), ?)");
        return $stmt->execute([$name, $email, $hashedPassword, $departmentID]);
    }

    public function verifyCredentials($email, $password)
    {
        $stmt = $this->db->prepare("
            SELECT e.ID, e.Password, d.DepartmentName
            FROM Employees e
            JOIN Departments d ON e.DepartmentID = d.ID
            WHERE e.Email = ?
        ");
        $stmt->execute([$email]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Verify password and return user data if valid
        if ($user && password_verify($password, $user['Password'])) {
            return $user;
        }
        return false;
    }

    public function count()
{
    $stmt = $this->db->query("SELECT COUNT(*) as count FROM Employees");
    return $stmt->fetchColumn();
}

}
