<?php
    class Course
    {
        private $name;
        private $course_number;
        private $id;

        function __construct($name, $course_number, $id = null)
        {
            $this->name = $name;
            $this->course_number = $course_number;
            $this->id = $id;
        }
        //setters
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setCourseNumber($new_course_number)
        {
            $this->course_number = (string) $new_course_number;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }
        //getters
        function getName()
        {
            return $this->name;
        }

        function getCourseNumber()
        {
            return $this->course_number;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO courses (name, course_number)
                VALUES ('{$this->getName()}', '{$this->getCourseNumber()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function update($new_name)
        {
            $GLOBALS['DB']->exec("UPDATE courses SET name = '{$new_name}' WHERE id = {$this->getId()};");
            $this->setName($new_name);
        }
        //static functions
        static function getAll()
        {
            $returned_courses = $GLOBALS['DB']->query("SELECT * FROM courses;");
            $courses = array();
            foreach($returned_courses as $course) {
                $name = $course['name'];
                $course_number = $course['course_number'];
                $id = $course['id'];
                $new_course = new Course($name, $course_number, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }

        static function find($search_id)
        {
            $found_course = null;
            $courses = Course::getAll();
            foreach($courses as $course) {
                $course_id = $course->getId();
                if ($course_id == $search_id) {
                    $found_course = $course;
                }
            }
            return $found_course;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses *;");
            $GLOBALS['DB']->exec("DELETE FROM students_courses *;");
        }

        function addStudent($student)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (student_id, course_id)
                VALUES ({$student->getId()}, {$this->getId()});");
        }

        function getStudents()
        {
            $query = $GLOBALS['DB']->query("SELECT student_id FROM students_courses
                WHERE course_id = {$this->getId()};");
            $student_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $students = array();
            foreach($student_ids as $id) {
                    $student_id = $id['student_id'];
                    $result = $GLOBALS['DB']->query("SELECT * FROM students WHERE id = {$student_id};");
                    $returned_student = $result->fetchAll(PDO::FETCH_ASSOC);

                    $fullname = $returned_student[0]['fullname'];
                    $enrolldate = $returned_student[0]['enrolldate'];
                    $id = $returned_student[0]['id'];
                    $new_student = new Student($fullname, $enrolldate, $id);
                    array_push($students, $new_student);
            }
            return $students;
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM courses WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE course_id = {$this->getId()};");
        }
    }
?>
