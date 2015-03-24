<?php
    class Student
    {
        private $name;
        private $date;
        private $id;

        function __construct($name, $date, $id = null)
        {
            $this->name = $name;
            $this->date = $date;
            $this->id = $id;
        }


    }
?>
