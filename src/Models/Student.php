<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Student extends BaseModel
{

    public function find($student_code)
    {
        $sql = "SELECT * FROM students WHERE student_code = :student_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['student_code' => $student_code]);
        return $statement->fetchObject(PDO::FETCH_CLASS, '\App\Models\Student');
    }

    public function all()
    {
        $sql = "SELECT id, student_code, CONCAT(first_name, ' ', last_name) AS student_name, email, date_of_birth, sex FROM students";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Student');
        return $result;
    }

    public function getStudentCode($student_code) {
        $sql = "SELECT student_code FROM students WHERE student_code = :student_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['student_code' => $student_code]);
        return $statement->fetchObject(PDO::FETCH_CLASS, '\App\Models\Student');
    }

    public function getEmail($student_code) {
        $sql = "SELECT email FROM students WHERE student_code = :student_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['student_code' => $student_code]);
        return $statement->fetchObject(PDO::FETCH_CLASS, '\App\Models\Student');
    }

    public function getFullName($student_code) {
        $sql = "SELECT CONCAT(first_name, ' ', last_name) AS fullname 
            FROM students WHERE student_code = :student_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['student_code' => $student_code]);
        return $statement->fetchObject(PDO::FETCH_CLASS, '\App\Models\Student');
    }
}