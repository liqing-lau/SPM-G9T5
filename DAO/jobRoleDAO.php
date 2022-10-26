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

        $sql="SELECT `Skill_Name` FROM `skill` WHERE `Skill_ID` IN (SELECT `Skill_ID` FROM `jobskill` WHERE `JRole_ID`=$JRole_ID)";
        $stmt = $conn->prepare($sql);

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


    public function getIndividualIDandName($JRole_ID) {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT * FROM jobrole WHERE JRole_ID='$JRole_ID';";
        $namelist = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while( $row = $stmt->fetch() ) {
            $row_id = $row['JRole_ID'];
            $row_name = $row['JRole_Name'];
            $row_desc = $row['JRole_Desc'];
            array_push($namelist,[$row_id,$row_name,$row_desc]);
        }
        $stmt = null;
        $conn = null;

        return $namelist;
    }




    public function getIndividualJobSkill($JRole_ID){
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT s.Skill_ID, s.Skill_Name FROM jobskill j
        LEFT JOIN skill s ON j.Skill_ID = s.Skill_ID
        WHERE j.JRole_ID = $JRole_ID;";
        $namelist = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while( $row = $stmt->fetch() ) {
            $row_id = $row['Skill_ID'];
            $row_name = $row['Skill_Name'];
            array_push($namelist,[$row_id,$row_name]);
        }
        $stmt = null;
        $conn = null;

        return $namelist;

    }


    public function getIndividualCourseSkill($JRole_ID){
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT C.Course_ID, C.Skill_ID, S.Skill_Name FROM courseskill C
        LEFT JOIN skill s ON s.Skill_ID = C.Skill_ID
         WHERE C.Skill_ID IN (SELECT S.Skill_ID FROM jobskill J, skill S WHERE J.Skill_ID = S.Skill_ID AND J.JRole_ID = $JRole_ID)
        ";
        $namelist = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while( $row = $stmt->fetch() ) {
            array_push($namelist,$row);
        }
        $stmt = null;
        $conn = null;

        return $namelist;

    }

    public function getCourseTaken($Staff_ID){
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT r.Course_ID, Reg_Status, Completion_Status FROM registration r WHERE  Staff_ID='$Staff_ID';";
        $takenList = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while( $row = $stmt->fetch() ) {
            array_push($takenList,$row);
        }
        $stmt = null;
        $conn = null;

        return $takenList;

    }

  
    



}

?>