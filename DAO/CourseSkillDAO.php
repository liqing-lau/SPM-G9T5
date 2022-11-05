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

}

?>