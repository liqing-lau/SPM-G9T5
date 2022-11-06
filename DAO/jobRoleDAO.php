<?php
require_once 'common.php';

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
                                    $row["JRole_Desc"],
                                    $row["JRole_Status"]
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

        $sql="SELECT `Skill_Name`, `Skill_Status` FROM `skill` WHERE `Skill_ID` IN (SELECT `Skill_ID` FROM `jobskill` WHERE `JRole_ID`= $JRole_ID)";
        $stmt = $conn->prepare($sql);

        $listSkills=[];

        if ($stmt->execute()){

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            while ($row=$stmt->fetch()){
                array_push($listSkills,[$row["Skill_Name"],$row["Skill_Status"]]);
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

    public function checkJobNameInDB($JRole_Name) {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT `JRole_Name` FROM `jobrole`
        WHERE `JRole_Name` = :JRole_Name";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':JRole_Name', $JRole_Name, PDO::PARAM_STR);

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

  
    public function updateJobRole($JRole_ID,$JRole_Name,$JRole_Desc){
        $connMgr= new ConnectionManager();
        $conn = $connMgr->connect();

        $sql ="UPDATE `jobrole` SET `JRole_Name`= ?, `JRole_Desc`= ? WHERE `JRole_ID`= ? ";

        $stmt =$conn->prepare($sql);

        $stmt->bindParam(1, $JRole_Name, PDO::PARAM_STR);
        $stmt->bindParam(2, $JRole_Desc, PDO::PARAM_STR);
        $stmt->bindParam(3, $JRole_ID,PDO::PARAM_INT);

        $stmt->execute();

        $stmt= null;
        $conn= null;
        return "<br>Name and Description updated";
    }

    public function deleteRelSkills($JRole_ID,$Skill_ID){
        $connMgr=new ConnectionManager();
        $conn =$connMgr->connect();

        $sql="DELETE FROM `jobskill` WHERE `JRole_ID`=? AND `Skill_ID`=?";

        $stmt=$conn->prepare($sql);

        $stmt->bindParam(1,$JRole_ID,PDO::PARAM_INT);
        $stmt->bindParam(2,$Skill_ID,PDO::PARAM_INT);

        $stmt->execute();
        $stmt=null;
        $conn=null;
        return "<br>Deleted skill";
    }

    public function addRelSkills($JRole_ID,$Skill_ID){
        $connMgr=new ConnectionManager();
        $conn=$connMgr->connect();

        $sql="INSERT INTO `jobskill` (`JRole_ID`, `Skill_ID`) VALUES (:JRole_ID, :Skill_ID)";

        $stmt=$conn->prepare($sql);
        $stmt->bindparam(':JRole_ID',$JRole_ID,PDO::PARAM_INT);
        $stmt->bindparam(':Skill_ID',$Skill_ID,PDO::PARAM_INT);

        $stmt->execute();
        $stmt=null;
        $conn=null;
        return "<br>Added skill";
    }

    public function createJobRole($name, $desc, $skills) {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sqlJob = "insert into jobrole
        (JRole_Name, JRole_Desc)
        values
        (:name, :desc)";

        $stmt = $conn->prepare($sqlJob);
        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':desc', $desc, PDO::PARAM_STR);
        
        $status = $stmt->execute();

        $stmt = null;
        $conn = null;

        $jobRoleDAO = new jobRoleDAO();

        $jobId = $jobRoleDAO->getIdByName($name);
        
        foreach ($skills as $skillId) {
            $jobSkill = $jobRoleDAO->addJobSkill($jobId, $skillId);
            if ($jobSkill === 0) {
                return "An error occurred during inserting skills";
            }
        }
        return $status;
    }

    public function getIdByName($name) {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT `JRole_ID` FROM `jobrole`
        WHERE `JRole_Name` = :name";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        while( $row = $stmt->fetch() ) {
            $jobId = $row['JRole_ID'];
        }

        $stmt = null;
        $conn = null;

        return $jobId;
    }

    public function deleteJR($JRole_ID, $JRole_Status){
        $connMgr= new ConnectionManager();
        $conn = $connMgr->connect();

        $sql= "UPDATE jobrole 
                SET JRole_Status=:JRole_Status 
                WHERE JRole_ID=:JRole_ID";

        $stmt=$conn->prepare($sql);

        $stmt->bindParam(":JRole_Status", $JRole_Status, PDO::PARAM_STR);
        $stmt->bindParam(":JRole_ID", $JRole_ID, PDO::PARAM_INT);

        $JRole_Status=$stmt->execute();

        $stmt=null;
        $conn=null;

        return $JRole_Status;
    }
}

?>