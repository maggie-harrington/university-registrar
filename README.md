# University Registrar

#### _Epicodus PHP Week 4 - MySQL Database Join Statements and Many to Many Relationships, 2/28/2017_

#### By Maggie Harrington

## Description

A sample university registrar application written in PHP to demonstrate MySQL database join statements and many to many relationships. The registrar (user) can add students (name and date of enrollment) and courses (course name and number). They can assign students to a course, where each course can have many students and each student can have many courses.

## Setup/Installation Requirements

* Download project at my GitHub repository: https://github.com/university-registrar .
* To clone through GitHub, first make sure that you have PHP, Composer, and MAMP installed.
* See https://secure.php.net/ for details on installing PHP. Note: PHP is typically already installed on Macs.
* See https://getcomposer.org for details on installing Composer.
* See https://mamp.info/ for details on installing MAMP.
* Open the terminal and enter `cd Desktop`. Copy the link above (in the first bullet point), then type `git clone ` and enter the link. You will now have a copy of this project on your desktop.
* In the terminal, type `cd university-registrar/` and hit enter.
* From the terminal, run `composer install --prefer-source --no-interaction`
* Launch MAMP and select "start servers".
* Open a new terminal window and enter `cd ~`, then start MySQL at the command prompt with `/Applications/MAMP/Library/bin/mysql --host=localhost -uroot -proot`
* Use PHPMyAdmin `http://localhost:8888/phpmyadmin/` and `hair_salon.sql.zip` (located in the root level of the project folder) to import the `hair_salon` database.
* In the original terminal window, you should still be in the root of the project folder. Type `cd web` and start PHP with `php -S localhost:8000`
* In your web browser, navigate to `localhost:8000`, which will open the home page.

* If you would like to verify my PHPUnit class tests, use PHPMyAdmin to make a copy of the `hair_salon` database and name it `hair_salon_test` database.
* To run PHPUnit tests from the project root, enter `vendor/bin/phpunit tests` into the terminal.

## Known Bugs

No known bugs at this time.

## Support and contact details

If you run into any issues or have questions, ideas or concerns, please feel free to contact me at maggie.harrington@gmail.com

## Technologies Used

Written using Git Bash, Atom, PHP, Composer, Silex, Twig, PHPUnit, MySQL, MAMP and Bootstrap.

### MIT License

Copyright (c) 2017 Maggie Harrington


## Specifications

0. Create `university_registrar` production database with students and courses tables and make a copy into `university_registrar_test` for development.

1. Create Student class with construct, create and test getters & setters.

2. Create tests and methods for the following Student functions:
    * save
    * getAll
    * deleteAll
    * find - single instance
    * update - single instance
    * delete - single instance

3. Write Silex routes for Student in app.php after all tests pass.

4. Create index page to allow the registrar to select between viewing a list of students or a list of courses.

5. Create students page to list all students at the university, including a form to add new students.

6. Create Course class with construct, create and test getters & setters.

7. Create tests and methods for the following Course functions:
    * save
    * getAll
    * deleteAll
    * find - single instance
    * update - single instance
    * delete - single instance

8. Construct and test a method to return all of a student's courses

9. Write Silex routes for Course in app.php after all tests pass.

10. Create courses page to display all courses at the university, including a form to add new courses.

11. Construct and test a method to assign students to a course.

12. Write Silex routes for assigning students to a course in app.php after all tests pass.

13. Create an enroll student page to allow registrar to select a course and assign students to that course.

14. Add edit and delete buttons to students page, with a new page for the edit form.

15. Add edit and delete buttons to courses page, with a new page for the edit form.

16. Export `university_registrar` and `university_registrar_test` databases to include in project folder.
