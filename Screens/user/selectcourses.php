<?php
require_once("../../class/jobRole.php");
require_once("../../class/lj.php");
require_once "../../DAO/common.php";
require_once "../../DAO/jobRoleDAO.php";
require_once "../../DAO/courseSkillDAO.php";
require_once "../../DAO/SkillDAO.php";
require_once "../../DAO/ljDAO.php";
session_start();

if(isset($_GET["addjobrole"])){
    $JRstring=$_GET["addjobrole"];
    $JRdata=explode(',',$JRstring);
    $sid = $_COOKIE["empId"];

    $JRole_ID = $JRdata[0];
    $JRole_Name = $JRdata[1];
    $JRole_Desc = $JRdata[2];

    $new_jr= new jobRoleDAO();
    $new_sd= new SkillDAO();
    $new_cs= new courseSkillDAO();
    $new_lj= new ljDAO();
    $relskills=$new_jr->getRelSkills($JRole_ID);
}

else{
    $JRstring=$_SESSION['jrdata'];
    $JRdata=explode(',',$JRstring);
    $sid = $_COOKIE["empId"];

    $JRole_ID = $JRdata[0];
    $JRole_Name = $JRdata[1];
    $JRole_Desc = $JRdata[2];

    $new_jr= new jobRoleDAO();
    $new_sd= new SkillDAO();
    $new_cs= new courseSkillDAO();
    $new_lj= new ljDAO();
    $relskills=$new_jr->getRelSkills($JRole_ID);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Admin</title>
</head>
<style>
    .noBull{
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
</style>
<?php
$thisPage = '';
include("../navbar/userNavbar.php");
?>
<div class="container-md pt-5">
    <div class="card">
        <div class="card-header text-center">
            <p>Adding courses to </p>
            <?php
            echo "<h1>$JRole_Name</h1>";
            ?>
        </div>

        <div class="card-body">
            <?php
                echo"<p class='card-text'>$JRole_Desc</p>";
            ?>

        <form action='selectcourses.php' method='POST'>
            <table class='table'>
                <tr>
                    <th>Required Skills</th>
                    <th>Possible Courses</th>
                    <th>Course ID</th>
                    <th>Registration Status</th>
                    <th>Course Status</th>
                </tr>
    <?php
    //First loop by skill
    $anythingToAdd="";
    foreach($relskills as $skills){
        echo "<tr>";
        $Skill_Name=$skills[0];
        $Skill_Status=$skills[1];

        //Only display active skills
        if($Skill_Status=="active"){
            echo"<td>$Skill_Name</td>";

            //Two steps to get Course ID, Name, Status
            $Skill_ID=$new_sd->getIDbyName($Skill_Name);
            $courseid_list=$new_cs->getCourseIdBySkill($Skill_ID[0]);

            $course_list=[];

            foreach($courseid_list as $eachID){
                $courseInfo=$new_cs->getCourseIDandName($eachID);
                array_push($course_list,$courseInfo);
            }

            
            //Create strings that end up as easy separate td
            $courseStr='<td><ul class="noBull">';
            $idStr='<td><ul class="noBull">';
            $regStr='<td><ul class="noBull">';
            $compStr='<td><ul class="noBull">';

            //Go course by course and add each course as a li of their specific td
            foreach($course_list as $course){
                $Course_ID=$course[0];
                $Course_Name=$course[1];
                $Course_Status=$course[2];

                //Only display active courses
                if($Course_Status=="Active"){
                    $list_Reg=$new_lj->isCourseTaken($Course_ID,$sid);
                    if($list_Reg==[]){
                        $courseStr.= "<li style='white-space: nowrap'>$Course_Name</li>";
                        $idStr.="<li><input type='checkbox' name='newCourse[]' value=$Course_ID> $Course_ID</li>";
                        $regStr.="<li>Not Registered</li>";
                        $compStr.="<li></li>";
                        $anythingToAdd.="a";
                    }
                    else if($list_Reg[0]=="Registered"||$list_Reg[0]=="Waitlist"){
                        $courseStr.= "<li style='white-space: nowrap'>$Course_Name</li>";
                        //if course applied alr, disable button
                        $idStr.= "<li><input type='checkbox' name='newCourse[]' value=$Course_ID> $Course_ID</li>";
                        if($list_Reg[0]=="Registered"){
                            $regStr.="<li style='color:green'>$list_Reg[0]</li>";
                        }
                        if($list_Reg[0]=="Waitlist"){
                            $regStr.="<li style='color:orange'>$list_Reg[0]</li>";
                        }
                        $compStr.="<li>$list_Reg[1]</li>";
                        $anythingToAdd.="a";
                    }
                    else{
                        $courseStr.= "<li style='white-space: nowrap'>$Course_Name</li>";
                        $idStr.= "<li><input type='checkbox' name='newCourse[]' value=$Course_ID> $Course_ID</li>";
                        $regStr.="<li>Rejected</li>";
                        $compStr.="<li></li>";
                        $anythingToAdd.="a";
                    }
                }
            }
            $courseStr.='</ul></td>';
            $idStr.='</ul></td>';
            $regStr.='</ul></td>';
            $compStr.='</ul></td>';

            //Create the tds
            echo $courseStr,$idStr,$regStr,$compStr;
        }
        echo"</tr>";
    }
    echo"</table>
        <button class='btn btn-primary' type = 'submit' name = 'selected_courses'>
            Create Learning Journey
        </button>
        </form>";

    if(isset($_POST['selected_courses'])){
        if(empty($_POST['newCourse'])){
            echo"Please select at least 1 course.";
        }

        else{
            // $JRole_ID=$_POST['JRstring'];
            // $JRole_Name=$_POST['JRole_Name'];
            $sid=$_COOKIE['empId'];
            // $JRole_Desc=$_POST['JRole_Desc'];


                $select_Course=$_POST['newCourse'];
                $these_Courses=[];
        
                //In case of repeat checkboxes
                foreach($select_Course as $eachCourse){
                    if(in_array($eachCourse,$these_Courses)==false){
                        array_push($these_Courses,$eachCourse);
                    }
                }
        
                require_once "../../DAO/ljDAO.php";
                $new_lj = new ljDAO();
                $createlj = $new_lj->createLJ($sid, $JRole_ID);
        
                if(isset($createlj)){
                    $createLJAlert='';
                    $LJ_ID=$createlj;
                    $createLJAlert.= "Learning Journey $LJ_ID created";
                    foreach($these_Courses as $eachCourse){
                        $addedCourse=$new_lj->addCoursetoLJ($LJ_ID,$eachCourse);
                        $createLJAlert.="<br>$addedCourse";
                    }
                    $_SESSION['createLJ']=$createLJAlert;
                    header('Location: ./homepage');
                exit();
            }
        }
    }
?>
</html>