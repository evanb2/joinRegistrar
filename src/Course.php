<?php
    class Course
    {
        private $name;
        private $number;
        private $id;

        function __construct($name, $number, $id = null)
        {
            $this->name = $name;
            $this->number = $number;
            $this->id = $id;
        }
        //setters
        function setName($new_name)
        {
            $this->name = (string) $new_name;
        }

        function setNumber($new_number)
        {
            $this->number = (string) $new_number;
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

        function getNumber()
        {
            return $this->number;
        }

        function getId()
        {
            return $this->id;
        }


    }
?>
