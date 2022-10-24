<?php

require_once 'common.php';

class SkillDAO {

    public function create($skill_name) {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "insert into skill
                    (Skill_Name)
                    values
                    (:skill_name)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':skill_name', $skill_name, PDO::PARAM_STR);

        $status = $stmt->execute();

        $stmt = null;
        $conn = null;

        return $status;
    }

    public function getIDbyName($s_name) {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT Skill_ID FROM `skill` WHERE Skill_Name = :s_name;";
        $idlist = [];
        
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':s_name', $s_name, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        while( $row = $stmt->fetch() ) {
            $row_id = $row['Skill_ID'];
            array_push($idlist,$row_id);
        }
        $stmt = null;
        $conn = null;

        return $idlist;
    }

    public function getAllSkillId() {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT `Skill_ID` FROM `skill`";
        $skillIdList = [];

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        while( $row = $stmt->fetch() ) {
            $skillId = $row['Skill_ID'];
            array_push($skillIdList,$skillId);
        }
        $stmt = null;
        $conn = null;

        return $skillIdList;
    }

    public function getAllSkillName() {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT `Skill_Name` FROM `skill`";
        $skillNameList = [];

        $stmt = $conn->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        while( $row = $stmt->fetch() ) {
            $skillName = $row['Skill_Name'];
            array_push($skillNameList,$skillName);
        }
        $stmt = null;
        $conn = null;

        return $skillNameList;
    }
}

?>