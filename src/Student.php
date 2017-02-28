<?php
    class Student
    {
        private $name;
        private $enrollment_date;
        private $id;

        function __construct($name, $enrollment_date, $id = null)
        {
            $this->name = $name;
            $this->enrollment_date = $enrollment_date;
            $this->id = $id;
        }

        function getName()
        {
            return $this->name;
        }

        function getEnrollmentDate()
        {
            return $this->enrollment_date;
        }

        function getId()
        {
            return $this->id;
        }

        function setName($new_name)
        {
            $this->name = $new_name;
        }

        function setEnrollmentDate($new_enrollment_date)
        {
            $this->enrollment_date = $new_enrollment_date;
        }

        function save()
        {
            $GLOBALS['DB']->exec("INSERT INTO students (name, enrollment_date) VALUES ('{$this->getName()}', '{$this->getEnrollmentDate()}');");
            $this->id = $GLOBALS['DB']->lastInsertId();
        }

        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students");
            $all_students_array = array();
            foreach($returned_students as $student)
            {
                $name = $student['name'];
                $enrollment_date = $student['enrollment_date'];
                $id = $student['id'];
                $new_student = new Student($name, $enrollment_date, $id);
                array_push($all_students_array, $new_student);
            }
            return $all_students_array;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students");
        }

        static function find($input_id)
        {
            $returned_students = Student::getAll();
            foreach ($returned_students as $returned_student)
            {
                $returned_id = $returned_student->getId();
                if ($returned_id == $input_id)
                {
                    return $returned_student;
                }
            }
        }

    }
?>
