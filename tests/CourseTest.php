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
        // protected function tearDown()
        // {
        //     Course::deleteAll();
        //     // Student::deleteAll();
        // }

        function test_getName()
        {
            //Arrange
            $name = "Bob Barker";
            $number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $number, $id);

            //Act
            $result = $test_course->getName();

            //Assert
            $this->assertEquals($name, $result);
        }

        function test_getNumber()
        {
            //Arrange
            $name = "Bob Barker";
            $number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $number, $id);

            //Act
            $result = $test_course->getNumber();

            //Assert
            $this->assertEquals($number, $result);
        }

        function test_getId()
        {
            //Arrange
            $name = "Bob Barker";
            $number = "BEER101";
            $id = 1;
            $test_course = new Course($name, $number, $id);

            //Act
            $result = $test_course->getId();

            //Assert
            $this->assertEquals(1, $result);
        }

        function test_setId()
        {
            //Arrange
            $name = "Bob Barker";
            $number = "BEER101";
            $id = null;
            $test_course = new Course($name, $number, $id);

            //Act
            $test_course->setId(2);

            //Assert
            $result = $test_course->getId();
            $this->assertEquals(2, $result);
        }


        // function test_save()
        //
        // function test_getAll()
        //
        // function test_deleteAll()
        //
        // function test_find()
        //
        // function test_update()
        //
        // function test_delete()
        //
        // function test_addStudent()
        //
        // function test_getStudents()
    }
?>
