<?php
require_once 'common.php';
class ljDAO
{
    //IF WE EVER WANT TO IMPLEMENT HR OVERVIEW

    // public function retrieveAll()
    // {
    //     $connMgr = new ConnectionManager();
    //     $pdo = $connMgr->connect();
    //     $sql = 'SELECT * FROM lj';
    //     $stmt = $pdo->prepare($sql);
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);
    //     $stmt->execute();

    //     $result = [];
    //     while ($row = $stmt->fetch()) {
    //         $result[] = new lj($row['Staff_ID'], $row['LJ_ID'], $row['JRole_ID']);
    //     }
    //     $stmt->closeCursor();
    //     $pdo = null;
    //     return $result;
    // }

    public function getLJ($Staff_ID)
    {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT * FROM lj WHERE Staff_ID=$Staff_ID;";
        $namelist = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $stmt->fetch()) {
            $row_Staff_ID = $row['Staff_ID'];
            $row_LJ_ID = $row['LJ_ID'];
            $row_JRole_ID = $row['JRole_ID'];
            array_push($namelist, [$row_Staff_ID, $row_LJ_ID, $row_JRole_ID]);
        }
        $stmt = null;
        $conn = null;

        return $namelist;
    }

    // public function getCourseNotTaken($LJ_ID)
    // {
    //     $connMgr = new ConnectionManager();
    //     $conn = $connMgr->connect();

    //     $sql = "SELECT DISTINCT C.Course_ID, CN.Course_Name, JR.JRole_Name FROM jobrole JR, jobskill J, courseskill C, course CN
    //     WHERE CN.Course_ID = C.Course_ID
    //     AND JR.JRole_ID = J.JRole_ID
    //     AND J.Skill_ID = C.Skill_ID 
    //     AND JR.JRole_ID IN (SELECT JRole_ID FROM lj WHERE LJ_ID = $LJ_ID)
    //     AND C.Course_ID NOT IN (SELECT Course_ID FROM lj WHERE LJ_ID = $LJ_ID);";


    //     $namelist = [];


    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //     while ($row = $stmt->fetch()) {
    //         $row_id = $row['Course_ID'];
    //         $row_name = $row['Course_Name'];
    //         array_push($namelist, [$row_id, $row_name]);
    //     }
    //     $stmt = null;
    //     $conn = null;

    //     return $namelist;
    // }


    // public function updateCourseForLJ($Staff_ID, $LJ_ID, $JRole_ID, $Course_ID)
    // {
    //     $connMgr = new ConnectionManager();
    //     $conn = $connMgr->connect();

    //     $sql = "UPDATE lj 
    //     SET Course_ID = :Course_ID 
    //     WHERE Staff_ID = :Staff_ID 
    //     AND LJ_ID = :LJ_ID 
    //     AND JRole_ID = :JRole_ID;";

    //     $stmt = $conn->prepare($sql);


    //     // Your code goes here

    //     $stmt->bindParam(":Staff_ID", $Staff_ID, PDO::PARAM_INT);
    //     $stmt->bindParam(":LJ_ID", $LJ_ID, PDO::PARAM_INT);
    //     $stmt->bindParam(":JRole_ID", $JRole_ID, PDO::PARAM_INT);
    //     $stmt->bindParam(":Course_ID", $Course_ID, PDO::PARAM_STR);
        
    //     $Course_ID = $stmt->execute();


    //     // Your code goes here
    //     $stmt = null;
    //     $conn = null;


    //     return $Course_ID;
    // }

    // public function insertCourseForLJ($Staff_ID, $LJ_ID, $JRole_ID, $Course_ID)
    // {
    //     $connMgr = new ConnectionManager();
    //     $conn = $connMgr->connect();

    //     $sql = "INSERT INTO lj 
    //     (Staff_ID, LJ_ID, JRole_ID, Course_ID)
    //     VALUES (:Staff_ID, :LJ_ID, :JRole_ID, :Course_ID);";


    //     $stmt = $conn->prepare($sql);


    //     // Your code goes here

    //     $stmt->bindParam(":Staff_ID", $Staff_ID, PDO::PARAM_INT);
    //     $stmt->bindParam(":LJ_ID", $LJ_ID, PDO::PARAM_INT);
    //     $stmt->bindParam(":JRole_ID", $JRole_ID, PDO::PARAM_INT);
    //     $stmt->bindParam(":Course_ID", $Course_ID, PDO::PARAM_STR);

    //     $Course_ID = $stmt->execute();


    //     // Your code goes here
    //     $stmt = null;
    //     $conn = null;


    //     return $Course_ID;
    // }

    // public function checkEmptyLJ($JRole_ID)
    // {
    //     $connMgr = new ConnectionManager();
    //     $conn = $connMgr->connect();

    //     $sql = "SELECT COUNT(JRole_ID) AS Count FROM lj WHERE JRole_ID = $JRole_ID AND Course_ID = '';";
    //     // $namelist = [];


    //     $stmt = $conn->prepare($sql);
    //     $stmt->execute();
    //     $stmt->setFetchMode(PDO::FETCH_ASSOC);

    //     while ($row = $stmt->fetch()) {
    //         $count_JRole_ID = $row['Count'];
    //         // array_push($namelist, [$count_JRole_ID]);
    //     }
    //     $stmt = null;
    //     $conn = null;

    //     return $count_JRole_ID;
    // }

    public function getLJRoles($Staff_ID)
    {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT JRole_ID FROM lj WHERE Staff_ID=$Staff_ID;";
        $output = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $stmt->fetch()) {
            $row_JRole_ID = $row['JRole_ID'];
            array_push($output, $row_JRole_ID);
        }
        $stmt = null;
        $conn = null;

        return $output;
    }

    public function createLJ($sid, $jrid){

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "insert into lj
                    (Staff_ID, JRole_ID)
                    values
                    (:sid, :jrid)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':sid', $sid, PDO::PARAM_INT);
        $stmt->bindParam(':jrid', $jrid, PDO::PARAM_INT);
        
        $stmt->execute();

        $last_id = $conn->lastInsertId();

        $stmt = null;
        $conn = null;

        return $last_id;
    }

    public function isCourseTaken($Course_ID, $Staff_ID){
        $connMgr= new ConnectionManager();
        $conn =$connMgr->connect();

        $sql= "SELECT `Reg_Status`, `Completion_Status` FROM `registration` WHERE `Course_ID`=:Course_ID AND `Staff_ID`= :Staff_ID";
        $stmt=$conn->prepare($sql);
        $stmt->bindParam(':Course_ID', $Course_ID, PDO::PARAM_STR);
        $stmt->bindParam(':Staff_ID', $Staff_ID, PDO::PARAM_INT);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        $list_Reg=[];

        while($row=$stmt->fetch()){
            array_push($list_Reg,$row["Reg_Status"],$row["Completion_Status"]);
        }

        $stmt=null;
        $conn=null;

        return $list_Reg;
    }

    public function courseInLJ($Course_ID,$LJ_ID){
        $connMgr= new ConnectionManager();
        $conn=$connMgr->connect();

        $sql="SELECT `LJ_ID` FROM `ljcourse` WHERE `LJ_ID`=:LJ_ID AND `Course_ID`=:Course_ID";
        $stmt=$conn->prepare($sql);
        $stmt->bindParam(':LJ_ID',$LJ_ID,PDO::PARAM_INT);
        $stmt->bindParam(':Course_ID',$Course_ID,PDO::PARAM_STR);

        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while($row=$stmt->fetch()){
            $final=$row["LJ_ID"];
        }

        $stmt=null;
        $conn=null;

        if(isset($final)){
            return "inLJ";
        }
        else{
            return "notinLJ";
        }
    }

    public function addCoursetoLJ($LJ_ID,$Course_ID){
        $connMgr= new ConnectionManager();
        $conn= $connMgr->connect();

        $sql="INSERT INTO `ljcourse` (`LJ_ID`,`Course_ID`) VALUES (:LJ_ID, :Course_ID)";

        $stmt=$conn->prepare($sql);
        $stmt->bindParam(':LJ_ID',$LJ_ID,PDO::PARAM_INT);
        $stmt->bindParam(':Course_ID',$Course_ID,PDO::PARAM_STR);

        $stmt->execute();
        $stmt=null;
        $conn=null;

        return "Successfully added $Course_ID into Learning Journey $LJ_ID";
    }

    public function viewLJLangdingPage($Staff_ID){

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT L.LJ_ID, L.Staff_ID, L.JRole_ID, J.JRole_Name FROM lj L, jobrole J WHERE L.JRole_ID = J.JRole_ID AND L.Staff_ID = $Staff_ID";


        $namelist = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $stmt->fetch()) {
            $row_LJID = $row['LJ_ID'];
            $row_StaffID = $row['Staff_ID'];
            $row_JRoleID = $row['JRole_ID'];
            $row_JRoleName = $row['JRole_Name'];
            array_push($namelist, [$row_LJID, $row_StaffID, $row_JRoleID, $row_JRoleName]);
        }
        $stmt = null;
        $conn = null;

        return $namelist;

    } 

    public function viewAddedCourseforEachLJ($LJ_ID){

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT CS.Course_ID, S.Skill_Name FROM skill S, courseskill CS
        WHERE S.Skill_ID = CS.Skill_ID
        AND Course_ID IN (SELECT Course_ID FROM ljcourse WHERE LJ_ID = $LJ_ID)";


        $namelist = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $stmt->fetch()) {
            $row_CourseID = $row['Course_ID'];
            $row_SkillName = $row['Skill_Name'];
            array_push($namelist, [$row_CourseID, $row_SkillName]);
        }
        $stmt = null;
        $conn = null;

        return $namelist;

    } 



    public function getLJCoursebyLJID($LJ_ID)
    {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT * FROM ljcourse WHERE LJ_ID=$LJ_ID;";
        $output = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $stmt->fetch()) {
            $row_Course_ID = $row['Course_ID'];
            array_push($output, $row_Course_ID);
        }
        $stmt = null;
        $conn = null;

        return $output;
    }

    public function deleteLJ($ljid){

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "delete from `lj`
                    where
                    `LJ_ID` = $ljid";

        $stmt = $conn->prepare($sql);

        $status = $stmt->execute();

        $stmt = null;
        $conn = null;

        return $status;
    }

    public function getLJbyLJID($LJ_ID)
    {
        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "SELECT * FROM lj WHERE LJ_ID=$LJ_ID;";
        $output = [];


        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while ($row = $stmt->fetch()) {
            $row_LJ_ID = $row['LJ_ID'];
            $row_Staff_ID = $row['Staff_ID'];
            $row_JRole_ID = $row['JRole_ID'];
            array_push($output, [$row_LJ_ID,$row_Staff_ID,$row_JRole_ID]);
        }
        $stmt = null;
        $conn = null;

        return $output;
    }

    public function delLJcourse($LJ_ID){
        $connMgr= new ConnectionManager();
        $conn =$connMgr->connect();

        $sql="DELETE FROM `ljcourse` WHERE `LJ_ID`=:LJ_ID";

        $stmt= $conn->prepare($sql);
        $stmt->bindParam(':LJ_ID',$LJ_ID,PDO::PARAM_INT);

        $status=$stmt->execute();

        $stmt = null;
        $conn = null;

        return $status;
    }

    public function delCoursefromLJ($LJ_ID,$Course_ID){
        $connMgr= new ConnectionManager();
        $conn=$connMgr->connect();

        $sql="DELETE FROM `ljcourse` WHERE `LJ_ID`=:LJ_ID AND `Course_ID`=:Course_ID";

        $stmt=$conn->prepare($sql);
        $stmt->bindParam(":LJ_ID",$LJ_ID,PDO::PARAM_INT);
        $stmt->bindParam(":Course_ID",$Course_ID,PDO::PARAM_STR);

        $stmt->execute();

        $stmt=null;
        $conn=null;

        return "Successfully deleted $Course_ID from Learning Journey $LJ_ID";
    }
}
?>
