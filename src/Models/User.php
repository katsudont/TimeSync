<?php

namespace App\Models;

use App\Models\BaseModel;

class User extends BaseModel
{
    public function create($data)
{
    $query = "INSERT INTO User (Username, Password, EmployeeID, RoleID)
              VALUES (:Username, :Password, :EmployeeID, :RoleID)";
    $stmt = $this->db->prepare($query);
    $stmt->execute([
        'Username' => $data['Username'],
        'Password' => $data['Password'],
        'EmployeeID' => $data['EmployeeID'],
        'RoleID' => $data['RoleID']
    ]);
}

public function login($username, $password)
    {
        $query = "SELECT u.ID as id, u.Username as username, u.Password as password, u.RoleID as role_id 
                  FROM User u
                  WHERE u.Username = :username";

        $stmt = $this->db->prepare($query);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch(\PDO::FETCH_ASSOC);

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            return $user; // Return user details if password matches
        }
        return false; // Login failed
    }

    // Count admin users
    public function countAdmins()
    {
        $stmt = $this->db->query("
            SELECT COUNT(*) 
            FROM User u
            JOIN User_Role r ON u.RoleID = r.ID
            WHERE r.Role = 'Admin'
        ");
        return $stmt->fetchColumn();
    }

}
