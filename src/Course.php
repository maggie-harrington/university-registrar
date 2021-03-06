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

        function update($new_course_name, $new_course_number)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET course_name = '{$new_course_name}', course_number = '{$new_course_number}' WHERE id = {$this->getId()};");
            $this->setCourseName($new_course_name);
            $this->setCourseNumber($new_course_number);
        }

        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO courses_students (course_id, student_id) VALUES ({$this->getId()}, {$student->getId()});");
        }

        function getStudents()
        {
            $query = $GLOBALS['DB']->query("SELECT student_id FROM courses_students WHERE course_id = {$this->getId()};");

            $students_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $students = array();
            foreach ($students_ids as $id)
            {
                $student_id = $id['student_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM students where id = {$student_id};");
                $returned_student = $result->fetchAll(PDO::FETCH_ASSOC);

                $name = $returned_student[0]['name'];
                $enrollment_date = $returned_student[0]['enrollment_date'];
                $id = $returned_student[0]['id'];
                $new_student = new Student($name, $enrollment_date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        function getStudentsJoinStatement()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT students.* FROM courses
                JOIN courses_students ON (courses_students.category_id = courses.id)
                JOIN students ON (students.id = courses_students.student_id)
                WHERE courses.id = {$this->getId()};");
            $students = array();
            foreach($returned_students as $student) {
                $name = $student['name'];
                $enrollment_date = $student['enrollment_date'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment_date, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

    }
?>
