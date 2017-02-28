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
            Course::deleteAll();
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

        function test_getCourseNumber()
        {
            // Arrange
            $course_name = "General Chemistry";
            $course_number = "CH 201";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);

            // Act
            $result = $test_course->getCourseNumber();

            // Assert
            $this->assertEquals($course_number, $result);
        }

        function test_getId()
        {
          // Arrange
          $course_name = "General Chemistry";
          $course_number = "CH 201";
          $id = 1;
          $test_course = new Course($course_name, $course_number, $id);

          // Act
          $result = $test_course->getId();

          // Assert
          $this->assertEquals($id, $result);
        }

        function test_setCourseName()
        {
          // Arrange
          $course_name = "General Chemistry";
          $course_number = "CH 201";
          $id = 1;
          $test_course = new Course($course_name, $course_number, $id);

          $course_name_update = "General Chemistry Term 1";

          // Act
          $test_course->setCourseName($course_name_update);
          $result = $test_course->getCourseName();

          // Assert
          $this->assertEquals($course_name_update, $result);
        }

        function test_setCourseNumber()
        {
          // Arrange
          $course_name = "General Chemistry";
          $course_number = "CH 201";
          $id = 1;
          $test_course = new Course($course_name, $course_number, $id);

          $course_number_update = "CH 101";

          // Act
          $test_course->setCourseNumber($course_number_update);
          $result = $test_course->getCourseNumber();

          // Assert
          $this->assertEquals($course_number_update, $result);
        }

        function test_save()
        {
            // Arrange
            $course_name = "General Chemistry";
            $course_number = "CH 201";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);

            // Act
            $test_course->save();
            $result = Course::getAll();

            // Assert
            $this->assertEquals([$test_course], $result);
        }

        function test_getAll()
        {
            // Arrange
            $course_name = "General Chemistry";
            $course_number = "CH 201";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            $course_name2 = "General Biology";
            $course_number2 = "BI 201";
            $id2 = 2;
            $test_course2 = new Course($course_name2, $course_number2, $id2);
            $test_course2->save();

            // Act
            $result = Course::getAll();

            // Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function test_deleteAll()
        {
            // Arrange
            $course_name = "General Chemistry";
            $course_number = "CH 201";
            $id = 1;
            $test_course = new Course($course_name, $course_number, $id);
            $test_course->save();

            $course_name2 = "General Biology";
            $course_number2 = "BI 201";
            $id2 = 2;
            $test_course2 = new Course($course_name2, $course_number2, $id2);
            $test_course2->save();

            // Act
            Course::deleteAll();
            $result = Course::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            // Arrange
            $course_name = "General Chemistry";
            $course_number = "CH 201";
            $test_course = new Course($course_name, $course_number);
            $test_course->save();

            $course_name2 = "General Biology";
            $course_number2 = "BI 201";
            $test_course2 = new Course($course_name2, $course_number2);
            $test_course2->save();

            // Act
            $result = Course::find($test_course->getId());

            // Assert
            $this->assertEquals($test_course, $result);
        }

        function test_delete()
        {
            // Arrange
            $course_name = "General Chemistry";
            $course_number = "CH 201";
            $test_course = new Course($course_name, $course_number);
            $test_course->save();

            $course_name2 = "General Biology";
            $course_number2 = "BI 201";
            $test_course2 = new Course($course_name2, $course_number2);
            $test_course2->save();

            // Act
            $test_course->delete();
            $result = Course::getAll();

            // Assert
            $this->assertEquals([$test_course2], $result);
        }


    }
?>
