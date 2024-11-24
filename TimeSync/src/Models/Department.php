<?php

namespace App\Models;

class Department extends BaseModel
{
    public function getAll()
    {
        $stmt = $this->db->query("SELECT ID, DepartmentName FROM Departments");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function count()
{
    $stmt = $this->db->query("SELECT COUNT(*) as count FROM Departments");
    return $stmt->fetchColumn();
}

}
