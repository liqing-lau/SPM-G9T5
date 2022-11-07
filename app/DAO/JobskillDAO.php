<?php

require_once 'common.php';

class JobskillDAO {

    public function create($jrole_id, $skill_id) {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "insert into jobskill
                    (JRole_ID, Skill_ID)
                    values
                    (:jrole_id, :skill_id)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':jrole_id', $jrole_id, PDO::PARAM_INT);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_INT);

        $status = $stmt->execute();

        $stmt = null;
        $conn = null;

        return $status;
    }

    public function getRoleIdList($skill_id) {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT `JRole_ID` FROM `jobskill` WHERE `Skill_ID` = :skill_id";
        $list = [];

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_INT);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $stmt->fetch()) {
            $row_JRole_ID = $row['JRole_ID'];
            array_push($list, $row_JRole_ID);
        }
        $stmt = null;
        $conn = null;

        return $list;
    }

    public function getSkillIdList($jrole_id) {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT `Skill_ID` FROM `jobskill` WHERE `JRole_ID` = :jrole_id";
        $list = [];

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':jrole_id', $jrole_id, PDO::PARAM_INT);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $stmt->fetch()) {
            $row_Skill_ID = $row['Skill_ID'];
            array_push($list, $row_Skill_ID);
        }
        $stmt = null;
        $conn = null;

        return $list;
    }

    public function removeRole($jrole_id, $Skill_ID)
    {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "DELETE FROM `jobskill` WHERE `Skill_ID` =:Skill_ID AND `JRole_ID`= :jrole_id;";

        $stmt = $conn->prepare($sql);

        // Your code goes here
        $stmt->bindParam(":jrole_id", $jrole_id, PDO::PARAM_INT);
        $stmt->bindParam(":Skill_ID", $Skill_ID, PDO::PARAM_INT);

        $Skill_Status = $stmt->execute(); // DO NOT MODIFY THIS LINE

        // Your code goes here
        $stmt = null;
        $conn = null;

        return $Skill_Status;
    }
}

?>