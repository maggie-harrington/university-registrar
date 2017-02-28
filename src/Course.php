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

        function getId()
        {
            return $this->id;
        }

        function setCourseName($new_course_name)
        {
            $this->course_name = $new_course_name;
        }

        function setCourseNumber($new_course_number)
        {
            $this->course_number = $new_course_number;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO courses (course_name, course_number) VALUES ('{$this->getCourseName()}', '{$this->getCourseNumber()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses");
            $all_courses_array = array();
            foreach($returned_courses as $course)
            {
                $course_name = $course['course_name'];
                $course_number = $course['course_number'];
                $id = $course['id'];
                $new_course = new Course($course_name, $course_number, $id);
                array_push($all_courses_array, $new_course);
            }
            return $all_courses_array;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses");
        }

        static function find($input_id)
        {
            $returned_courses = Course::getAll();
            foreach ($returned_courses as $returned_course)
            {
                $returned_id = $returned_course->getId();
                if ($returned_id == $input_id)
                {
                    return $returned_course;
                }
            }
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
        }

    }
?>
