<?php

if(isset($_POST['toEdit'])){
    $LJ_ID=$_POST['LJ_ID'];

    if(isset($_POST['edit_Course'])==false){
        echo"
        <head>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi' crossorigin='anonymous'>
        </head>
        <div class='container-md pt-5'><p>Each LJ must have at least one course to exit!</p> 
        <form action='ljdetail.php' method='POST'>
        <input type='hidden' name='ljdata' value='$LJ_ID'>
        <input type='submit' name='pass_on' value='Return to picking courses!'></form>
        </div>";
    }

    else{
        $courses_checked=$_POST['edit_Course'];
        $these_Courses=[];

        foreach($courses_checked as $eachChecked){
            if(in_array($eachChecked,$these_Courses)==false){
                array_push($these_Courses,$eachChecked);
            }
        }

        require_once "../../DAO/common.php";
        require_once "../../DAO/ljDAO.php";

        $new_lj= new ljDAO();
        $existing_Courses=$new_lj->getLJCoursebyLJID($LJ_ID);
        
        $toadd=[];
        foreach($these_Courses as $added){
            if(in_array($added,$existing_Courses)==false){
                array_push($toadd,$added);
            }
        }

        $toremove=[];
        foreach($existing_Courses as $old){
            if(in_array($old,$these_Courses)==false){
                array_push($toremove,$old);
            }
        }
        
        if($toadd==[]&&$toremove==[]){
            echo "Nothing has been changed!";
        }

        $display=[];
        if($toadd!=[]){
            foreach($toadd as $add){
                $result=$new_lj->addCoursetoLJ($LJ_ID,$add);
                array_push($display,$result);
            }
        }

        if($toremove!=[]){
            foreach($toremove as $remove){
                $result=$new_lj->delCoursefromLJ($LJ_ID,$remove);
                array_push($display,$result);
            }
        }

        $display=implode("<br>",$display);

        echo"
        <head>
        <link href='https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css' rel='stylesheet' integrity='sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi' crossorigin='anonymous'>
        </head>
        <div class='container-md pt-5'><p>$display</p> 
        <form action='ljdetail.php' method='POST'>
        <input type='hidden' name='ljdata' value='$LJ_ID'>
        <input type='submit' name='pass_on' value='Return to LJ Details'></form>
        </div>";
    }

    exit();
}

$thisPage = 'lj';
require_once("../../DAO/common.php");

if(isset($_POST['ljdata'])){

$ljd = $_POST['ljdata'];

$ljt = new ljdao();
$ljdata = $ljt->getLJbyLJID($ljd);
$ljcourse = $ljt->getLJCoursebyLJID($ljd);
$jobid = $ljdata[0][2];

$jobr = new jobRoleDAO();
$JRdata = $jobr->getIndividualIDandName($jobid);

$jobName = $JRdata[0][1];
$jobDesc = $JRdata[0][2];

$js = new JobskillDAO();
$skills = $js->getSkillIdList($jobid);

$skillcourse = [];

foreach($skills as $skill){
    $sd = new SkillDAO();
    $sname = $sd->getSkillNameById($skill);
    array_push($skillcourse,[$skill,$sname,[],[]]);
}

for($x = 0; $x < count($skillcourse); $x++){

    foreach($ljcourse as $ljc){
        $cid = $ljc;
        $sid = $skillcourse[$x][0];
        $cs = new CourseSkillDAO();
        $cscheck = $cs->checkCourseSkill($cid,$sid);

        $check = new courseDAO();
        $scheck = $check->checkStatus($cid);

        if($cscheck and $scheck){
            array_push($skillcourse[$x][2],$cid);
            }
        }
    }
}

for($x = 0; $x < count($skillcourse); $x++){
    $sid = $skillcourse[$x][0];
    $st = $skillcourse[$x][2];
    $course = new CourseSkillDAO;
    $cids = $course->getCourseBySkill($sid);

    
    foreach($cids as $cid){

        $check = new courseDAO();
        $scheck = $check->checkStatus($cid);

        if(in_array($cid,$st) == false and $scheck){
            array_push($skillcourse[$x][3],$cid);
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>View all Learning Journey</title>
</head>
<style>
    .noBull{
        list-style-type: none;
        padding: 0;
        margin: 0;
    }
</style>
<body>
    <?php include("../navbar/userNavbar.php");?>

    <div class="container-md pt-5">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title"><?php echo "Learning Journey Job Role: $jobName" ?></h5>
            </div>

            <div class="card-body">
                <p class="card-text"><?php echo $jobDesc ?></p>

                <div class="container">
                    <table class="table">
                    <thead>
                        <tr>
                            <th>Skill</th>
                            <th>Related Courses</th>
                            <th>Course ID</th>
                            <th>Course Status</th>
                            <th>In Learning Journey<br>(You can check and uncheck these to add or remove courses from LJ)</th>
                            <th>Registration Status</th>
                            <th>Completion Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <form action='ljdetail.php' method='POST'>
                        <?php

                        $new_cs= new courseSkillDAO();
                        foreach( $skillcourse as $sc){
                            $Skill_ID=$sc[0];
                            $Skill_Name=$sc[1];
                            $Staff_ID=$_COOKIE['empId'];
                            $courseid_list=$new_cs->getCourseIdBySkill($Skill_ID[0]);

                            $thisSkillCourse=[];
                
                            foreach($courseid_list as $eachID){
                                $courseInfo=$new_cs->getCourseIDandName($eachID);
                                array_push($thisSkillCourse,$courseInfo);
                            }

                            // var_dump($thisSkillCourse);


                            echo "<tr>";
                            echo "<td>$Skill_Name</td>";

                            $CN_Str="<td><ul class='noBull'>";
                            $CID_Str="<td><ul class='noBull'>";
                            $CST_Str="<td><ul class='noBull'>";
                            $inLJ_Str="<td><ul class='noBull'>";
                            $reg_Str="<td><ul class='noBull'>";
                            $Comp_Str="<td><ul class='noBull'>";

                            foreach($thisSkillCourse as $eachCourse){
                                $Course_ID=$eachCourse[0];
                                $Course_Name=$eachCourse[1];
                                $Course_Status=$eachCourse[2];
                                $inLJ=$ljt->courseInLJ($Course_ID,$ljd);

                                if($inLJ=='inLJ'||$Course_Status=='Active'){
                                    $isCompleted=$ljt->isCourseTaken($Course_ID,$Staff_ID);
                                    $CN_Str.="<li style='white-space: nowrap'>$Course_Name</li>";

                                    $CID_Str.="<li>$Course_ID</li>";

                                    $CST_Str.="<li>$Course_Status</li>";

                                    if($inLJ=="inLJ"){
                                        $inLJ_Str.="<li style='color:blue'>Already Added<input type='checkbox' name='edit_Course[]' value='$Course_ID'checked></li>";
                                    }
                                    else{
                                        $inLJ_Str.="<li>No<input type='checkbox' name='edit_Course[]' value='$Course_ID'></li>";
                                    }
                    
                                    if($isCompleted==[]){
                                        $reg_Str.="<li>Not Registered</li>";
                                        $Comp_Str.="<li></li>";
                                    }
                    
                                    else if($isCompleted[0]=="Registered"){
                                        $reg_Str.="<li style='color:green'>$isCompleted[0]</li>";
                                        $Comp_Str.="<li>$isCompleted[1]</li>";
                                    }
                    
                                    else if($isCompleted[0]=="Waitlist"){
                                        $reg_Str.="<li style='color:orange'>$isCompleted[0]</li>";
                                        $Comp_Str.="<li>$isCompleted[1]</li>";
                                    }
                    
                                    else{
                                        $reg_Str.="<li style='color:red'>Not Registered</li>";
                                        $Comp_Str.="<li></li>";
                                    }
                                }
                            }
                            $CN_Str.="</ul></td>";
                            $CID_Str.="</ul></td>";
                            $CST_Str.="</ul></td>";
                            $inLJ_Str.="</ul></td>";
                            $reg_Str.="</ul></td>";
                            $Comp_Str.="</ul></td>";
                            echo $CN_Str,$CID_Str,$CST_Str,$inLJ_Str,$reg_Str,$Comp_Str;
                            echo"</tr>";
                        }
                        echo"<input type='hidden' name='LJ_ID' value=$ljd>";
                        echo"<input type='submit' name='toEdit' value='Apply Changes'>";
                        ?>
                        </form>
                    </tbody>
                    </table>
                    <?php
    echo"
    <form method ='POST' action = 'ljdeleteconfirm.php'>
        <input type = hidden name = 'ljid' value = $ljd>
        <input type = hidden name = 'jname' value = '$jobName'>
        <button class='btn-danger' type='submit' name = 'confirm' '>Delete LJ</button>
    </form>";
    
    ?>

                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>