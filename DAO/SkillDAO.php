<?php

require_once 'common.php';

class SkillDAO
{

    public function create($skill_name)
    {

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

    public function getIDbyName($s_name)
    {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT Skill_ID FROM `skill` WHERE Skill_Name = :s_name;";
        $idlist = [];


        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':s_name', $s_name, PDO::PARAM_STR);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            $row_id = $row['Skill_ID'];
            array_push($idlist, $row_id);
        }
        $stmt = null;
        $conn = null;

        return $idlist;
    }


    public function getAllSkill(){

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT * FROM skill;";
        $namelist = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while( $row = $stmt->fetch() ) {
            $row_id = $row['Skill_ID'];
            $row_name = $row['Skill_Name'];
            $row_status = $row['Skill_Status'];
            array_push($namelist,[$row_id,$row_name,$row_status]);
        }
        $stmt = null;
        $conn = null;

        return $namelist;

    }


    public function deleteSkill($Skill_ID, $Skill_Status)
    {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "UPDATE
                    skill
                SET
                    Skill_Status = :Skill_Status
                WHERE 
                    Skill_ID = :Skill_ID";

        $stmt = $conn->prepare($sql);

        // Your code goes here
        $stmt->bindParam(":Skill_Status", $Skill_Status, PDO::PARAM_STR);
        $stmt->bindParam(":Skill_ID", $Skill_ID, PDO::PARAM_INT);

        $Skill_Status = $stmt->execute(); // DO NOT MODIFY THIS LINE

        // Your code goes here
        $stmt = null;
        $conn = null;


        return $Skill_Status;
    }
}
