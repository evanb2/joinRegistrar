<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    require_once "src/Student.php";

    $DB = new PDO('pgsql:host=localhost;dbname=join_registrar_test');

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            Student::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);

            //Act
            $result = $test_course->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getCourseNumber()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);

            //Act
            $result = $test_course->getCourseNumber();

            //Assert
            $this->assertEquals($course_number, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);

            //Act
            $result = $test_course->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = null;
            $test_course = new Course($name, $course_number, $id);

            //Act
            $test_course->setId(2);

            //Assert
            $result = $test_course->getId();
            $this->assertEquals(2, $result);
        }


        function test_save()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals($test_course, $result[0]);
        }

        function test_getAll()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "Happy Gilmore";
            $course_number2 = "GOLF101";
            $id2 = 2;
            $test_course2 = new Course ($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            $result = Course::getAll();

            //Assert
            $this->assertEquals([$test_course, $test_course2], $result);
        }

        function test_deleteAll()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "Happy Gilmore";
            $course_number2 = "GOLF101";
            $id2 = 2;
            $test_course2 = new Course ($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            Course::deleteAll();
            $result = Course::getAll();

            //Assert
            $this->assertEquals([], $result);
        }

        function test_find()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $name2 = "Happy Gilmore";
            $course_number2 = "GOLF101";
            $id2 = 2;
            $test_course2 = new Course ($name2, $course_number2, $id2);
            $test_course2->save();

            //Act
            $result = Course::find($test_course->getId());

            //Assert
            $this->assertEquals($test_course, $result);
        }
        function test_update()
        {
            //Arrange
            $name = "Learn Abour Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $new_name = "Jackass";

            //Act
            $test_course->update($new_name);

            //Assert
            $this->assertEquals("Jackass", $test_course->getName());
        }

        function test_delete()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id2 = 2;
            $test_student = new Student($fullname, $enrolldate, $id2);
            $test_student->save();

            //Act
            $test_course->addStudent($test_student);
            $test_course->delete();

            //Assert
            $this->assertEquals([], $test_student->getCourses());
        }

        function test_addStudent()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id2 = 2;
            $test_student = new Student($fullname, $enrolldate, $id2);
            $test_student->save();

            //Act
            $test_course->addStudent($test_student);

            //Assert
            $this->assertEquals($test_course->getStudents(), [$test_student]);
        }

        function test_getStudents()
        {
            //Arrange
            $name = "Learn About Beer";
            $course_number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $course_number, $id);
            $test_course->save();

            $fullname = "Billy Madison";
            $enrolldate = "10/03/2015";
            $id2 = 2;
            $test_student = new Student($fullname, $enrolldate, $id2);
            $test_student->save();

            $fullname2 = "Happy Gilmore";
            $enrolldate2 = "10/02/1989";
            $id3 = 3;
            $test_student2 = new Student($fullname2, $enrolldate2, $id3);
            $test_student2->save();

            //Act
            $test_course->addStudent($test_student);
            $test_course->addStudent($test_student2);

            //Assert
            $this->assertEquals($test_course->getStudents(), [$test_student, $test_student2]);
        }
    }
?>
