<?php

    class jobRole{
        private $JRole_ID;
        private $JRole_Name;
        private $JRole_Desc;
        private $JRole_Status;

        public function __construct($JRole_ID,$JRole_Name,$JRole_Desc,$JRole_Status){
            $this->JRole_ID=$JRole_ID;
            $this->JRole_Name=$JRole_Name;
            $this->JRole_Desc=$JRole_Desc;
            $this->JRole_Status=$JRole_Status;
        }

        public function getId(){
            return $this->JRole_ID;
        }

        public function getName(){
            return $this->JRole_Name;
        }

        public function getDesc(){
            return $this->JRole_Desc;
        }

        public function getStatus(){
            return $this->JRole_Status;
        }
    }

?>