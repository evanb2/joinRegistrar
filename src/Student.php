<?php
    class Student
    {
        private $fullname;
        private $date;
        private $id;

        function __construct($fullname, $date, $id = null)
        {
            $this->fullname = $fullname;
            $this->date = $date;
            $this->id = $id;
        }


        //function getCourses()


    }
?>
