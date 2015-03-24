<?php
    class Student
    {
        private $fullname;
        private $enrolldate;
        private $id;

        function __construct($fullname, $enrolldate, $id = null)
        {
            $this->fullname = $fullname;
            $this->enrolldate = $enrolldate;
            $this->id = $id;
        }

        //setters
        function setFullname($new_fullname)
        {
            $this->fullname = (string) $new_fullname;
        }

        function setEnrollDate($new_enrolldate)
        {
            $this->enrolldate = (string) $new_enrolldate;
        }

        function setId($new_id)
        {
            $this->id = (int) $new_id;
        }
        //getters
        function getFullname()
        {
            return $this->fullname;
        }

        function getEnrollDate()
        {
            return $this->enrolldate;
        }

        function getId()
        {
            return $this->id;
        }

        function save()
        {
            $statement = $GLOBALS['DB']->query("INSERT INTO students (fullname, enrolldate)
                VALUES ('{$this->getFullname()}', '{$this->getEnrollDate()}') RETURNING id;");
            $result = $statement->fetch(PDO::FETCH_ASSOC);
            $this->setId($result['id']);
        }

        function update($new_fullname)
        {
            $GLOBALS['DB']->exec("UPDATE students SET fullname = '{$new_fullname}'
                WHERE id = {$this->getId()};");
            $this->setFullname($new_fullname);
        }

        function delete()
        {
            $GLOBALS['DB']->exec("DELETE FROM students WHERE id = {$this->getId()};");
            $GLOBALS['DB']->exec("DELETE FROM students_courses WHERE student_id = {$this->getId()};");
        }
        //static functions
        static function getAll()
        {
            $returned_students = $GLOBALS['DB']->query("SELECT * FROM students;");
            $students = array();
            foreach($returned_students as $student) {
                $fullname = $student['fullname'];
                $enrolldate = $student['enrolldate'];
                $id = $student['id'];
                $new_student = new Student($fullname, $enrolldate, $id);
                array_push($students, $new_student);
            }
            return $students;
        }

        static function find($search_id)
        {
            $found_student = null;
            $students = Student::getAll();
            foreach($students as $student) {
                $student_id = $student->getId();
                if ($student_id == $search_id) {
                    $found_student = $student;
                }
            }
            return $found_student;
        }

        static function deleteAll()
        {
            $GLOBALS['DB']->exec("DELETE FROM students *;");
            $GLOBALS['DB']->exec("DELETE FROM students_courses *;");
        }

        function addCourse($course)
        {
            $GLOBALS['DB']->exec("INSERT INTO students_courses (student_id, course_id)
                VALUES ({$this->getId()}, {$course->getId()});");
        }

        function getCourses()
        {
            $query = $GLOBALS['DB']->query("SELECT course_id FROM students_courses
                WHERE student_id = {$this->getId()};");
            $course_ids = $query->fetchAll(PDO::FETCH_ASSOC);

            $courses = array();
            foreach($course_ids as $id) {
                $course_id = $id['course_id'];
                $result = $GLOBALS['DB']->query("SELECT * FROM courses WHERE id = {$course_id};");
                $returned_course = $result->fetchAll(PDO::FETCH_ASSOC);

                $name = $returned_course[0]['name'];
                $course_number = $returned_course[0]['course_number'];
                $id = $returned_course[0]['id'];
                $new_course = new Course($name, $course_number, $id);
                array_push($courses, $new_course);
            }
            return $courses;
        }


    }
?>
