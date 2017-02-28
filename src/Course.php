<?php
    class Course
    {
        private $course_name;
        private $course_number;
        private $id;

        function __construct($course_name, $course_number, $id = null)
        {
            $this->course_name = $course_name;
            $this->course_number = $course_number;
            $this->id = $id;
        }

        function getCourseName()
        {
            return $this->course_name;
        }

        function getCourseNumber()
        {
            return $this->course_number;
        }
    }
?>
