<?php

require_once 'common.php';

class CourseSkillDAO {

    public function checkCourseSkill($course_id,$skill_id) {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT * FROM `courseskill`
        WHERE `Course_ID` = :course_id and `Skill_ID` = :skill_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $output=[];

        while( $row = $stmt->fetch() ) {
            $cid = $row['Course_ID'];
            $sid = $row['Skill_ID'];
            array_push($output,[$cid,$sid]);
        }

        $stmt = null;
        $conn = null;

        if(empty($output)){
            return false;
        }
        else{return true;}
    }

    public function getCourseBySkill($skill_id) {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT `Course_ID` FROM `courseskill`
        WHERE `Skill_ID` = :skill_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_INT);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $output=[];

        while( $row = $stmt->fetch() ) {
            $cid = $row['Course_ID'];
            array_push($output,$cid);
        }

        $stmt = null;
        $conn = null;

        return $output;
    }

    public function getCourseIDandName($skillId){
        $sql = "SELECT `Course_ID`, `Course_Name`, `Course_Status` FROM `course` WHERE `Course_ID` =(SELECT `Course_ID` FROM `courseskill` WHERE `Skill_ID`=:skillId)";
    
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();
        
        $courseList = []; 

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':skillId', $skillId, PDO::PARAM_INT);
        
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while($row = $stmt->fetch()) {
            array_push($courseList, [$row['Course_ID'],$row['Course_Name'],$row['Course_Status']]);
        }

        $stmt = null;
        $conn = null;

        return $courseList;
    }
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