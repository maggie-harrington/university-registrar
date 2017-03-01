<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    use Symfony\Component\Debug\Debug;
    Debug::enable();

    $server = 'mysql:host=localhost:8889;dbname=university_registrar';
    $username = 'root';
    $password = 'root';
    $DB = new PDO($server, $username, $password);

    $app = new Silex\Application();
    $app['debug'] = true;

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    // index, allows registrar to select between list of students and list of courses
    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.html.twig');
    });

    // routes from index to students page, displays all students
    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    // add a student
    $app->post("/students/add", function() use ($app) {
        $student = new Student($_POST['name'], $_POST['enrollment_date']);
        $student->save();

        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    // delete all students
    $app->delete("/students/delete_all", function() use ($app) {
        Student::deleteAll();

        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    // delete a student
    $app->delete("/students/{id}/delete", function($id) use ($app) {
        $student = Student::find($id);
        $student->delete();

        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    // edit a student, routes from students page to student edit page
    $app->get("/students/{id}/edit", function($id) use ($app) {
        $student = Student::find($id);

        return $app['twig']->render('student_edit.html.twig', array('student' => $student));
    });

    // submit edit to a student, routes back to students page from student edit page
    $app->patch("/students/{id}/submit_edit", function($id) use ($app) {
        $name = $_POST['name'];
        $enrollment_date = $_POST['enrollment_date'];
        $student = Student::find($id);
        $student->update($name, $enrollment_date);

        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    // start of courses routes:

    // routes from index to courses page, displays all courses
    $app->get("/courses", function() use ($app) {
        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    // add a course
    $app->post("/courses/add", function() use ($app) {
        $course = new Course($_POST['course_name'], $_POST['course_number']);
        $course->save();

        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    // delete all courses
    $app->delete("/courses/delete_all", function() use ($app) {
        Course::deleteAll();

        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    // delete a course
    $app->delete("/courses/{id}/delete", function($id) use ($app) {
        $course = Course::find($id);
        $course->delete();

        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    // edit a course, routes from courses page to course edit page
    $app->get("/courses/{id}/edit", function($id) use ($app) {
        $course = Course::find($id);

        return $app['twig']->render('course_edit.html.twig', array('course' => $course));
    });

    // submit edit to a course, routes back to courses page from course edit page
    $app->patch("/courses/{id}/submit_edit", function($id) use ($app) {
        $course_name = $_POST['course_name'];
        $course_number = $_POST['course_number'];
        $course = Course::find($id);
        $course->update($course_name, $course_number);

        return $app['twig']->render('courses.html.twig', array('courses' => Course::getAll()));
    });

    // start of routes using join table & join statements

    // routes from courses page to enroll students page and displays all students enrolled in that course
    $app->get("/courses/{id}/view_students", function($id) use ($app) {
        $course = Course::find($id);

        return $app['twig']->render('enroll_students.html.twig', array('course' => $course, 'all_students' => Student::getAll(), 'enrolled_students' => $course->getStudents()));
    });

    // add a student to a course, starts on enroll students page and stays on same page on submit to allow registrar to add multiple students to a course
    $app->post("/courses/{id}/add_student", function($id) use ($app) {
        $course = Course::find($id);
        // $course = Course::find($_POST['course_id']);
        $student = Student::find($_POST['student_id']);
        $course->addStudent($student);

        return $app['twig']->render('enroll_students.html.twig', array('course' => $course, 'all_students' => Student::getAll(), 'enrolled_students' => $course->getStudents()));
    });

    return $app;
?>
