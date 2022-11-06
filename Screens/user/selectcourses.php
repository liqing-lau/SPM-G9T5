<?php
//return to homepage
if(isset($_POST["return"])){
    echo"<script>window.location.href='homepage.php'</script>";
}

//only runs after submitting for creating LJ
if(isset($_POST['selectCourse'])){
    $JRole_ID=$_POST['JRole_ID'];
    $JRole_Name=$_POST['JRole_Name'];
    $sid=$_COOKIE['empId'];
    //if no courses are selected, reject, return
    if(isset($_POST['newCourse'])==false){
        echo"
        <head>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi' crossorigin='anonymous'>
        </head>
        <div class='container-md pt-5'><p>You must add at least one course!</p> 
        <form action='selectcourses.php' method='GET'>
        <input type='hidden' name='addjobrole' value='$JRole_ID'>
        <input type='hidden' name='jobName' value='$JRole_Name'>
        <input type='submit' name='missingcourse' value='Return to picking courses!'></form>
        </div>";
        exit();
    }
    //if course picked, create LJ and ljcourse
    else{
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
            session_start();
            $_SESSION['createLJ']=$createLJAlert;
            echo"<script>window.location.href='landing.php'</script>";
        }
        exit();
    }
}

if(isset($_GET["addjobrole"])){
    $JRole_ID=$_GET["addjobrole"];
    $JRole_ID=intval($JRole_ID);
    $JRole_Name=$_GET["jobName"];
    $sid = $_COOKIE["empId"];

    require_once("../../class/jobRole.php");
    require_once("../../class/lj.php");
    require_once "../../DAO/common.php";
    require_once "../../DAO/jobRoleDAO.php";
    require_once "../../DAO/courseSkillDAO.php";
    require_once "../../DAO/SkillDAO.php";
    require_once "../../DAO/ljDAO.php";

    $new_jr= new jobRoleDAO();
    $new_sd= new SkillDAO();
    $new_cs= new courseSkillDAO();
    $new_lj= new ljDAO();
    $relskills=$new_jr->getRelSkills($JRole_ID);


    // $new_lj = new ljDAO();
    // $createlj = $new_lj->createLJ($sid, $JRole_ID);

    // if($createlj==1){
    //     echo '<div class="alert alert-success alert-dismissible" role="alert">
    //     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //     <strong>Success! New LJ has been created for</strong><br>'. $JRole_Name . '
    //     </div>';
    // }
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
<div class="container-md pt-5">
    <div class="card">
        <div class="card-header text-center">
            <p>Adding courses to </p>
            <?php
            echo "<h1>$JRole_Name</h1>";
            ?>
        </div>

        <div class="card-body">

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
                        $idStr.="<li>$Course_ID<input type='checkbox' name='newCourse[]' value=$Course_ID></li>";
                        $regStr.="<li>Not Registered</li>";
                        $compStr.="<li></li>";
                        $anythingToAdd.="a";
                    }
                    else if($list_Reg[0]=="Registered"||$list_Reg[0]=="Waitlist"){
                        $courseStr.= "<li style='color:lightgrey' style='white-space: nowrap'>$Course_Name</li>";
                        //if course applied alr, disable button
                        $idStr.= "<li style='color:lightgrey'>$Course_ID<input type='checkbox' name='newCourse[]' value=$Course_ID disabled></li>";
                        $regStr.="<li style='color:lightgrey'>$list_Reg[0]</li>";
                        $compStr.="<li style='color:lightgrey'>$list_Reg[1]</li>";
                        $anythingToAdd.="";
                    }
                    else{
                        $courseStr.= "<li style='white-space: nowrap'>$Course_Name</li>";
                        $idStr.= "<li>$Course_ID<input type='checkbox' name='newCourse[]' value=$Course_ID></li>";
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
    echo"</table>";

    //if nothing can be selected LJ cannot be made with this JR
    if($anythingToAdd==""){
        echo"There are no courses for you to add to your Learning Journey. Click here to return to Home Page";
        echo"<br><input type='submit' name='return' class='brn btn-outline-dark' value='Return to Home Page'>";
    }
    //else LJ can be made
    else{
        echo"<input type='hidden' name='JRole_ID' value='$JRole_ID'>";
        echo"<input type='hidden' name='JRole_Name' value='$JRole_Name'>";
        echo"<input type='submit' name='selectCourse' class='brn btn-outline-dark' value='Create Learning Journey'>";
    }
        //Test code

        // echo "Stress test";
        // echo"<table>";
        // $course_list=[["tch014","150198"],["tch013","150193"],["tch002","150215"],["SAL003","150216"],["COR002","150205"],["WAAA","23113"]];
        // $expected=[["Registered",null],["Registered","Ongoing"],["Waitlist",null],["Rejected",null],["Registered","Completed"],[null,null]];
        // foreach($course_list as $course){
        //     $courseid=$course[0];
        //     $staid=$course[1];

        //     $list_Reg=$new_lj->isCourseTaken($courseid,$staid);
        //     if($list_Reg==[]){
        //         echo"<tr><td>Not Registered</td> <td></td></tr>";
        //     }
        //     else if($list_Reg[0]=="Registered"){
        //         echo"<tr><td>$list_Reg[0]</td>";
        //         echo"<td>$list_Reg[1]</td></tr>";
        //     }
        //     else if($list_Reg[0]=="Waitlist"){
        //         echo"<tr><td>$list_Reg[0]</td>";
        //         echo"<td></td></tr>";
        //     }
        //     else{
        //         echo"<tr><td>$list_Reg[0]</td><td></td></tr>";
        //     }
        // }
        // echo"</table>";

        // var_dump($expected);
?>
</div>
</div>
</div>
</html>