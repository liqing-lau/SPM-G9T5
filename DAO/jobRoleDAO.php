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

        $sql="SELECT `Skill_Name` FROM `skill` WHERE `Skill_ID` IN (SELECT `Skill_ID` FROM `jobskill` WHERE `JRole_ID`= $JRole_ID)";
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
}

    public function addJobSkill($jobId, $skillId) {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "insert into jobskill
        (Job_ID, Skill_ID)
        values
        (:jobId, :skillId)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':jobId', $jobId, PDO::PARAM_STR);
        $stmt->bindParam(':skillId', $skillId, PDO::PARAM_STR);
        
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;

        return $status;
    }

    public function checkJobNameInDB($name) {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT `JRole_Name` FROM `jobrole`
        WHERE `JRole_Name` = :name";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        while( $row = $stmt->fetch() ) {
            $name = $row["JRole_Name"];
            if (!empty($name)) {
                $stmt = null;
                $conn = null;

                return false;
            }
        }

        $stmt = null;
        $conn = null;

        return true;
    }
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