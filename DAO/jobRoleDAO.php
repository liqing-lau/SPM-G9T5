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

?>