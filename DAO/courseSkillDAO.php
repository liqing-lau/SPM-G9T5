<?php

    require_once 'common.php';

    class courseSkillDAO {
        public function getCourseIdBySkill($skillId) {
            $sql = "SELECT `Course_ID` FROM `courseskill` WHERE `Skill_ID` =:skillId";
    
            $connMgr = new ConnectionManager();
            $conn = $connMgr->connect();
            
            $courseIdList = []; 

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':skillId', $skillId, PDO::PARAM_INT);
            
            $stmt->execute();
    
            $stmt->setFetchMode(PDO::FETCH_ASSOC);
            
            $status = false;
    
            while($row = $stmt->fetch()) {
                $data = $row['Course_ID'];
                array_push($courseIdList, $data);
            }
    
            $stmt = null;
            $conn = null;
    
            return $courseIdList;
        }

        public function addSkillToCourse($courseId, $skillId) {

            $connMgr = new ConnectionManager();
            $conn = $connMgr->connect();
    
            $sql = "INSERT INTO `courseskill`
                    (`Course_ID`, `Skill_ID`) 
                        VALUES
                        (:courseId, :skillId)";
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':courseId', $courseId, PDO::PARAM_STR);
            $stmt->bindParam(':skillId', $skillId, PDO::PARAM_INT);
    
            $status = $stmt->execute();
    
            $stmt = null;
            $conn = null;
    
            return $status;
        }

        public function getSkillIdList($courseId) {

            $connMgr = new ConnectionManager();
            $conn = $connMgr->connect();
    
            $sql = "SELECT `Skill_ID` FROM `courseskill` WHERE `Course_ID` = :courseId";
            $list = [];
    
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':courseId', $courseId, PDO::PARAM_STR);
    
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

        public function removeCourse($courseId, $Skill_ID)
    {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "DELETE FROM `courseskill` WHERE `Course_ID` =:courseId AND `Skill_ID` =:skillId";

        $stmt = $conn->prepare($sql);

        // Your code goes here
        $stmt->bindParam(":courseId", $courseId, PDO::PARAM_STR);
        $stmt->bindParam(":skillId", $Skill_ID, PDO::PARAM_INT);

        $Skill_Status = $stmt->execute(); // DO NOT MODIFY THIS LINE

        // Your code goes here
        $stmt = null;
        $conn = null;

        return $Skill_Status;
    }
    }

?>