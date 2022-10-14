<?php
class jobRoleDAO{

    public function getAll(){

        $connMgr= new ConnectionManager();
        $conn =$connMgr->connect();

        $sql='SELECT * FROM `jobrole`';
        $stmt = $conn->prepare($sql);

        $listJR=[];

        if ($stmt->execute()){

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            while ($row=$stmt->fetch()){
                $listJR[]=new jobRole(
                                        $row["JRole_ID"],
                                        $row["JRole_Name"],
                                        $row["JRole_Desc"]
                );
            }

        }

        $stmt=null;
        $conn=null;

        return $listJR;
    }

    public function getRelSkills($JRole_ID){

        $connMgr= new ConnectionManager();
        $conn =$connMgr->connect();

        $sql="SELECT `Skill_Name` FROM `skill` WHERE `Skill_ID` IN (SELECT `Skill_ID` FROM `jobskill` WHERE `JRole_ID`= :JRole_ID;)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':JRole_ID',$JRole_ID, PDO::PARAM_STR);

        $listSkills=[];

        if ($stmt->execute()){

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            while ($row=$stmt->fetch()){
                array_push($listSkills,$row["Skill_Name"]);
            }

        }

        $stmt=null;
        $conn=null;

        return $listSkills;
    }

    public function getIDandName() {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "select JRole_ID, JRole_Name from jobrole;";
        $namelist = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while( $row = $stmt->fetch() ) {
            $row_id = $row['JRole_ID'];
            $row_name = $row['JRole_Name'];
            array_push($namelist,[$row_id,$row_name]);
        }
        $stmt = null;
        $conn = null;

        return $namelist;
    }
}



?>