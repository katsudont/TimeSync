<?php

namespace App\Models;

class Employee extends BaseModel
{
    public function create($data)
{
    $query = "INSERT INTO Employee (Name, Email, Birthdate, HireDate, DepartmentID)
              VALUES (:Name, :Email, :Birthdate, :HireDate, :DepartmentID)";
    $stmt = $this->db->prepare($query);
    $stmt->execute([
        'Name' => $data['Name'],
        'Email' => $data['Email'],
        'Birthdate' => $data['Birthdate'],
        'HireDate' => $data['HireDate'],
        'DepartmentID' => $data['DepartmentID']
    ]);
    return $this->db->lastInsertId();
}

public function countAll()
{
    $stmt = $this->db->query("SELECT COUNT(*) FROM Employee");
    return $stmt->fetchColumn();
}

}
