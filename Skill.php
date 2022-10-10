<?php
class Skill {
    private $skill_id;
    private $skill_name;

    function __construct($skill_id, $skill_name){
    $this->skill_id = $skill_id;
    $this->skill_name = $skill_name;
    }

    function get_skillname() {
        return $this->skill_name;
    }

    function get_skillid() {
        return $this->skill_id;
    }

    
}