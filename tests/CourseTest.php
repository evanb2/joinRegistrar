<?php

    /**
    * @backupGlobals disabled
    * @backupStaticAttributes disabled
    */

    require_once "src/Course.php";
    // require_once "src/Student.php";

    $DB = new PDO('pgsql:host=localhost;dbname=join_registrar_test');

    class CourseTest extends PHPUnit_Framework_TestCase
    {
        protected function tearDown()
        {
            Course::deleteAll();
            // Student::deleteAll();
        }

        function test_getName()
        {
            //Arrange
            $name = "Bob Barker";
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
            $name = "Bob Barker";
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
            $name = "Bob Barker";
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
            $name = "Bob Barker";
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
            $name = "Bob Barker";
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
            $name = "Bob Barker";
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
            $name = "Bob Barker";
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
            $name = "Bob Barker";
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
            $name = "Bob Barker";
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

        // function test_delete()
        //
        // function test_addStudent()
        //
        // function test_getStudents()
    }
?>
