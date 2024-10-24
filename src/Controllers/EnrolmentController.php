<?php

namespace App\Controllers;

use App\Models\Course;
use App\Models\CourseEnrolment;
use App\Models\Student;
use App\Controllers\BaseController;

class EnrolmentController extends BaseController
{
    public function enrollmentForm()
    {
        $courseObj = new Course();
        $studentObj = new Student();
        $template = 'enrollment-form';
        $data = [
            'courses' => $courseObj->all(),
            'students' => $studentObj->all()
        ];

        $output = $this->render($template, $data);

        return $output;
    }

    

    public function enroll()
    {
        $course_code = $_POST['course_code'];
        $student_code = $_POST['student_code'];
        $enrolment_date = $_POST['enrolment_date'];

        $studentObj = new CourseEnrolment();
        $students = $studentObj->enroll($course_code, $student_code, $enrolment_date);

        
        header("Location: /courses/{$course_code}");
    }
}