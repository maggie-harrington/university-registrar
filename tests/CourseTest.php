<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    $server = 'mysql:host=localhost:8889;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            // Course::deleteAll();
        }

        function test_getCourseName()
        {
          // Arrange
          $course_name = "General Chemistry";
          $course_number = "CH 201";
          $test_course = new Course($course_name, $course_number);

          // Act
          $result = $test_course->getCourseName();

          // Assert
          $this->assertEquals($course_name, $result);
        }

    }
?>
