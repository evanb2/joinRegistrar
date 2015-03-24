<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Student.php";
    require_once "src/Course.php";

    $DB = new PDO('pgsql:host=localhost;dbname=join_registrar_test');

    class StudentTest extends PHPUnit_Framework_TestCase
    {

        protected function tearDown()
        {
            Student::deleteAll();
            Course::deleteAll();
        }

        function test_getFullname()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);


            //Act
            $result = $test_student->getFullname();

            //Assert
            $this->assertEquals($fullname, $result);
        }

        function test_setFullname()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);

            //Act
            $test_student->setFullname("Walter White");
            $result = $test_student->getFullname();

            //Assert
            $this->assertEquals("Walter White", $result);
        }

        function test_getId()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);

            //Act
            $result = $test_student->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);
            $test_student->save();

            //Act
            $test_student->setId(3);

            //Assert
            $result = $test_student->getId();
            $this->assertEquals(3, $result);
        }

        function test_saveSetsId()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);

            //Act
            $test_student->save();

            //Assert
            $this->assertEquals(true, is_numeric($test_student->getId()));
        }

        function test_save()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);

            //Act
            $test_student->save();

            //Assert
            $result = Student::getAll();
            $this->assertEquals($test_student, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);
            $test_student->save();

            $fullname2 = "Happy Gilmore";
            $enrolldate2 = "10/09/1989";
            $id2 = 3;
            $test_student2 = new Student($fullname2, $enrolldate2, $id2);
            $test_student2->save();

            //Act
            $result = Student::getAll();

            //Assert
            $this->assertEquals([$test_student, $test_student2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);
            $test_student->save();

            $fullname2 = "Happy Gilmore";
            $enrolldate2 = "10/09/1989";
            $id2 = 3;
            $test_student2 = new Student($fullname2, $enrolldate2, $id2);
            $test_student2->save();

            //Act
            Student::getAll();

            //Assert
            $result = Student::getAll();
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);
            $test_student->save();

            $fullname2 = "Happy Gilmore";
            $enrolldate2 = "10/09/1989";
            $id2 = 3;
            $test_student2 = new Student($fullname2, $enrolldate2, $id2);
            $test_student2->save();

            //Act
            $result = Student::find($test_student->getId());

            //Assert
            $this->assertEquals($test_student, $result);
        }

        function test_update()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);
            $test_student->save();

            $new_fullname = "Adam Sandler";

            //Act
            $test_student->update($new_fullname);

            //Assert
            $this->assertEquals("Adam Sandler", $test_student->getFullname());
        }

        function test_deleteStudent()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);
            $test_student->save();

            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id2 = 1;
            $test_course = new Course($name, $course_number, $id2);
            $test_course->save();

            //Act
            $test_student->addCourse($test_course);
            $test_student->delete();

            //Assert
            $this->assertEquals([], $test_course->getStudents());
        }

        function test_addCourse()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);
            $test_student->save();

            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id2 = 1;
            $test_course = new Course($name, $course_number, $id2);
            $test_course->save();

            //Act
            $test_student->addCourse($test_course);

            //Assert
            $this->assertEquals($test_student->getCourses(), [$test_course]);
        }

        function test_getCourses()
        {
            //Arrange
            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id = 2;
            $test_student = new Student($fullname, $enrolldate, $id);
            $test_student->save();

            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id2= 1;
            $test_course = new Course($name, $course_number, $id2);
            $test_course->save();

            $name2 = "Happy Gilmore";
            $course_number2 = "GOLF101";
            $id3 = 2;
            $test_course2 = new Course ($name2, $course_number2, $id3);
            $test_course2->save();

            //Act
            $test_student->addCourse($test_course);
            $test_student->addCourse($test_course2);

            //Assert
            $this->assertEquals($test_student->getCourses(), [$test_course, $test_course2]);
        }
    }
?>
