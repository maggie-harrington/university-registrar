<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";
    $server = 'mysql:host=localhost:8889;dbname=university_registrar_test';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);
    class StudentTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Student::deleteAll();
            // Course::deleteAll();
        }
        
        function test_getName()
        {
          // Arrange
          $name = "Maggie";
          $enrollment_date = "2017-02-28";
          $test_student = new Student($name, $enrollment_date);

          // Act
          $result = $test_student->getName();

          // Assert
          $this->assertEquals($name, $result);
        }

        function test_getEnrollmentDate()
        {
            // Arrange
            $name = "Maggie";
            $enrollment_date = "2017-02-28";
            $id = 1;
            $test_student = new Student($name, $enrollment_date, $id);

            // Act
            $result = $test_student->getEnrollmentDate();

            // Assert
            $this->assertEquals($enrollment_date, $result);
        }

        function test_getId()
        {
          // Arrange
          $name = "Maggie";
          $enrollment_date = "2017-02-28";
          $id = 1;
          $test_student = new Student($name, $enrollment_date, $id);

          // Act
          $result = $test_student->getId();

          // Assert
          $this->assertEquals($id, $result);
        }

        function test_setName()
        {
          // Arrange
          $name = "Maggie";
          $enrollment_date = "2017-02-28";
          $id = 1;
          $test_student = new Student($name, $enrollment_date, $id);

          $name_update = "Maggie Harrington";

          // Act
          $test_student->setName($name_update);
          $result = $test_student->getName();

          // Assert
          $this->assertEquals($name_update, $result);
        }

        function test_setEnrollmentDate()
        {
          // Arrange
          $name = "Maggie";
          $enrollment_date = "2017-02-28";
          $id = 1;
          $test_student = new Student($name, $enrollment_date, $id);

          $enrollment_date_update = "2017-02-27";

          // Act
          $test_student->setEnrollmentDate($enrollment_date_update);
          $result = $test_student->getEnrollmentDate();

          // Assert
          $this->assertEquals($enrollment_date_update, $result);
        }

        function test_save()
        {
            // Arrange
            $name = "Maggie";
            $enrollment_date = "2017-02-28";
            $id = 1;
            $test_student = new Student($name, $enrollment_date, $id);

            // Act
            $test_student->save();
            $result = Student::getAll();

            // Assert
            $this->assertEquals([$test_student], $result);
        }

        function test_getAll()
        {
            // Arrange
            $name = "Maggie";
            $enrollment_date = "2017-02-28";
            $id = 1;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $name2 = "Daisy";
            $enrollment_date2 = "2017-03-01";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment_date2, $id2);
            $test_student2->save();

            // Act
            $result = Student::getAll();

            // Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function test_deleteAll()
        {
            // Arrange
            $name = "Maggie";
            $enrollment_date = "2017-02-28";
            $id = 1;
            $test_student = new Student($name, $enrollment_date, $id);
            $test_student->save();

            $name2 = "Daisy";
            $enrollment_date2 = "2017-03-01";
            $id2 = 2;
            $test_student2 = new Student($name2, $enrollment_date2, $id2);
            $test_student2->save();

            // Act
            Student::deleteAll();
            $result = Student::getAll();

            // Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            // Arrange
            $name = "Maggie";
            $enrollment_date = "2017-02-28";
            $test_student = new Student($name, $enrollment_date);
            $test_student->save();

            $name2 = "Daisy";
            $enrollment_date2 = "2017-03-01";
            $test_student2 = new Student($name2, $enrollment_date2);
            $test_student2->save();

            // Act
            $result = Student::find($test_student->getId());

            // Assert
            $this->assertEquals($test_student, $result);
        }

        function test_delete()
        {
            // Arrange
            $name = "Maggie";
            $enrollment_date = "2017-02-28";
            $test_student = new Student($name, $enrollment_date);
            $test_student->save();

            $name2 = "Daisy";
            $enrollment_date2 = "2017-03-01";
            $test_student2 = new Student($name2, $enrollment_date2);
            $test_student2->save();

            // Act
            $test_student->delete();
            $result = Student::getAll();

            // Assert
            $this->assertEquals([$test_student2], $result);
        }

        function test_update()
        {
            // Arrange
            $name = "Maggie";
            $enrollment_date = "2017-02-28";
            $test_student = new Student($name, $enrollment_date);
            $test_student->save();

            $name_update = "Maggie Harrington";
            $enrollment_date_update = "2017-03-01";

            // Act
            $test_student->update($name_update, $enrollment_date_update);
            $result_name = $test_student->getName();
            $result_enrollment_date = $test_student->getEnrollmentDate();

            // Assert
            $this->assertEquals($name_update, $result_name);
            $this->assertEquals($enrollment_date_update, $result_enrollment_date);
        }

    }
?>
