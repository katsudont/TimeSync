<?php

namespace App\Models;

class Department extends BaseModel
{
    public function getAll()
    {
        $query = "SELECT ID, DepartmentName FROM Department";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id)
{
    $query = "SELECT * FROM Department WHERE ID = :id";
    $stmt = $this->db->prepare($query);
    $stmt->execute(['id' => $id]); // Ensure 'id' matches ':id' in the query
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}

 // Count all departments
 public function countAll()
 {
     $stmt = $this->db->query("SELECT COUNT(*) FROM Department");
     return $stmt->fetchColumn();
 }

}
