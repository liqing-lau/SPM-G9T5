<?php 


class lj{
    private $staff_ID;
    private $lj_ID;
    private $JRole_ID;

    public function __construct($staff_ID, $lj_ID, $JRole_ID){
        $this->staff_ID=$staff_ID;
        $this->lj_ID=$lj_ID;
        $this->JRole_ID=$JRole_ID;
    }

    public function getstaff_ID(){
        return $this->staff_ID;
    }

    public function getlj_ID(){
        return $this->lj_ID;
    }

    public function getJRole_ID(){
        return $this->JRole_ID;
    }
}


?>
