<?php
    require_once __DIR__."/../vendor/autoload.php";
    require_once __DIR__."/../src/Student.php";
    require_once __DIR__."/../src/Course.php";

    $app = new Silex\Application();

    $DB = new PDO('pgsql:host=localhost;dbname=join_registrar');

    $app->register(new Silex\Provider\TwigServiceProvider(), array(
        'twig.path' => __DIR__.'/../views'
    ));

    use Symfony\Component\HttpFoundation\Request;
    Request::enableHttpMethodParameterOverride();

    $app->get("/", function() use ($app) {
        return $app['twig']->render('index.twig');
    });
    //READ all students
    $app->get("/students", function() use ($app) {
        return $app['twig']->render('students.twig', array('students' => Student::getAll()));
    });
    //READ all courses
    $app->get("/courses", function() use ($app) {
        return $app['twig']->render('courses.twig', array('courses' => Course::getAll()));
    });
    //READ singular course
    $app->get("/courses/{id}", function($id) use ($app) {
        $course = Course::find($id);
        return $app['twig']->render('courses.twig', array('course' => $course,
          'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });
    //READ singular student
    $app->get("/students/{id}", function($id) use ($app) {
        $student = Student::find($id);
        return $app['twig']->render('students.twig', array('student' => $student,
          'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });
    //READ edit forms
    $app->get("/courses/{id}/edit", function($id) use ($app) {
        $course = Course::find($id);
        return $app['twig']->render('course_edit.twig', array('course' => $course));
    });

    $app->get("/students/{id}/edit", function($id) use ($app) {
        $student = Student::find($id);
        return $app['twig']->render('students_edit.twig', array('student' => $student));
    });

    //CREATE course
    $app->post("/courses", function() use ($app) {
        $name = $_POST['name'];
        $course_number = $_POST['course_number'];
        $course = new Course($name, $course_number);
        $course->save();
        return $app['twig']->render('courses.twig', array('courses' => Course::getAll()));
    });

    //CREATE student
    $app->post("/students", function() use ($app) {
        $fullname = $_POST['fullname'];
        $enrolldate = $_POST['enrolldate'];
        $student = new Student($fullname, $enrolldate);
        $student->save();
        return $app['twig']->render('students.twig', array('students' => Student::getAll()));
    });

    //CREATE add students to course
    $app->post("/add_students", function() use ($app) {
        $course = Course::find($_POST['course_id']);
        $student = Student::find($_POST['student_id']);
        $course->addStudent($student);
        return $app['twig']->render('course.twig', array('course' => $course, 'courses' =>
            Course::getAll(), 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    //CREATE add courses to students
    $app->post("/add_courses", function() use ($app) {
        $course = Course::find($_POST['course_id']);
        $student = Student::find($_POST['student_id']);
        $student->addCourse($course);
        return $app['twig']->render('student.twig', array('student' => $student,
          'students' => Student::getAll(), 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });

    //DELETE all students
    $app->post("/delete_students", function() use ($app) {
        Student::deleteAll();
        return $app['twig']->render('index.twig');
    });

    //DELETE all courses
    $app->post("/delete_courses", function() use ($app) {
        Course::deleteAll();
        return $app['twig']->render('index.twig');
    });

    //DELETE singular course
    $app->delete("/courses/{id}", function($id) use ($app) {
      $course = Course::find($id);
      $course->delete();
      return $app['twig']->render('index.twig', array('courses' => Course::getAll()));
    });

    //DELETE singular student
    $app->delete("/students/{id}", function($id) use ($app) {
      $student = Student::find($id);
      $student->delete();
      return $app['twig']->render('index.twig', array('students' => Student::getAll()));
    });

    //PATCH routes
    $app->patch("/courses/{id}", function($id) use ($app) {
      $name = $_POST['name'];
      $course = Category::find($id);
      $course->update($name);
      return $app['twig']->render('course.twig', array('course' => $course, 'students' => $course->getStudents(), 'all_students' => Student::getAll()));
    });

    $app->patch("/students/{id}", function($id) use ($app) {
      $student = Student::find($id);
      $student->delete();
      return $app['twig']->render('students.twig', array('student' => $student, 'courses' => $student->getCourses(), 'all_courses' => Course::getAll()));
    });

    return $app;
?>
