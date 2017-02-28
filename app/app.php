<?php
    date_default_timezone_set('America/Los_Angeles');
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    // require_once __DIR__."/../src/Course.php";

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
        $student = Student::find($id);
        $student->update($name);

        return $app['twig']->render('students.html.twig', array('students' => Student::getAll()));
    });

    return $app;
?>
