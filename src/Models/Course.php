<?php

namespace App\Models;

use App\Models\BaseModel;
use \PDO;

class Course extends BaseModel
{
    public function all()
    {
        $sql = "SELECT c.id, c.course_code, c.course_name, COUNT(e.student_code) AS enrolled_students
        FROM courses c
        INNER JOIN enrolments e ON c.course_code = e.course_code
        GROUP BY c.course_code, c.course_name";
        $statement = $this->db->prepare($sql);
        $statement->execute();
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Course');
        return $result;
    }

    public function find($course_code)
    {
        $sql = "SELECT * FROM courses WHERE course_code = :course_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['course_code' => $course_code]);
        return $statement->fetchObject(PDO::FETCH_CLASS, '\App\Models\Course');
    }

    public function getEnrolees($course_code)
    {
        $sql = "SELECT s.*
                FROM enrolments AS ce
                LEFT JOIN students AS s ON (s.student_code=ce.student_code)
                WHERE ce.course_code = :course_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['course_code' => $course_code]);
        $result = $statement->fetchAll(PDO::FETCH_CLASS, '\App\Models\Course');
        return $result;
    }

    public function getCourseCode($course_code) {
        $sql = "SELECT course_code FROM courses WHERE course_code = :course_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['course_code' => $course_code]);
        return $statement->fetchColumn();
    }

    public function getCourseName($course_code) {
        $sql = "SELECT course_name FROM courses WHERE course_code = :course_code";
        $statement = $this->db->prepare($sql);
        $statement->execute(['course_code' => $course_code]);
        return $statement->fetchColumn();
    }
}
