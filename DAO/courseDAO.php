<?php

require_once 'common.php';
class courseDAO {

    public function getAllCourse() {
        $sql = "SELECT * FROM `course`";

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $stmt = $conn->prepare($sql);
        
        $courseList=[];

        if ($stmt->execute()){

            $stmt->setFetchMode(PDO::FETCH_ASSOC);

            while ($row=$stmt->fetch()){
                $courseList[]=new Course($row['Course_ID'], 
                                        $row['Course_Name'], 
                                        $row['Course_Desc'],
                                        $row['Course_Status'],
                                        $row['Course_Type'],
                                        $row['Course_Category']);
            }

        }

        $stmt=null;
        $conn=null;

        return $courseList;
    }

    public function getCourse($courseId) {
        $sql = "SELECT * FROM `course` WHERE `Course_ID` = :courseId";

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_STR);
        
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $status = false;

        if($row = $stmt->fetch()) {
            $course = new Course($row['Course_ID'], 
                                $row['Course_Name'], 
                                $row['Course_Desc'],
                                $row['Course_Status'],
                                $row['Course_Type'],
                                $row['Course_Category']);
        }

        $stmt = null;
        $conn = null;

        return $course;
    }

    public function getCourseName($courseId) {
        $sql = "SELECT `Course_Name` FROM `course` WHERE `Course_ID` = :courseId";

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':courseId', $courseId, PDO::PARAM_STR);
        
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        if($row = $stmt->fetch()) {
            $course = $row['Course_Name'];
        }

        $stmt = null;
        $conn = null;

        return $course;
    }

    public function checkStatus($course_id) {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT `Course_Status` FROM `course`
        WHERE `Course_ID` = :course_id";

        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':course_id', $course_id, PDO::PARAM_STR);

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $output='';

        while( $row = $stmt->fetch() ) {
            $cstatus = $row['Course_Status'];
            $output = $cstatus;
        }

        $stmt = null;
        $conn = null;

        if($output == 'Active'){
            return true;
        }
        else{return false;}
    }
    }

?>