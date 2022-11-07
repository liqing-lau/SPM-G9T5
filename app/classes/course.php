<?php
    class Course {
        private $courseId;
        private $courseName;
        private $courseDesc;
        private $courseStatus;
        private $courseType;
        private $courseCateogry;

        public function __construct($courseId, $courseName, $courseDesc, $courseStatus, $courseType, $courseCateogry) {
            $this->courseId=$courseId;
            $this->courseName=$courseName;
            $this->courseDesc=$courseDesc;
            $this->courseStatus=$courseStatus;
            $this->courseType=$courseType;
            $this->courseCateogry=$courseCateogry;
        }

        public function getId(){
            return $this->courseId;
        }

        public function getName(){
            return $this->courseName;
        }

        public function getDesc(){
            return $this->courseDesc;
        }

        public function getStatus(){
            return $this->courseStatus;
        }

        public function getType() {
            return $this->courseType;
        }

        public function getCategory() {
            return $this->courseCateogry;
        }
    }
?>