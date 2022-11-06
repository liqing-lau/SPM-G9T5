<?php
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
                            <th>Courses Planned</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        foreach( $skillcourse as $sc){

                            $cplan = implode(', ',$sc[2]);
                            $cnplan = implode(',', $sc[3]);
                            echo "
                            <tr>
                            <td>$sc[1]</td>
                            <td>Planned: <b>$cplan</b><br>Other Courses available: $cnplan</td>
                            <td>
                                <button type = 'button' class='btn btn-outline-dark float-end'>
                                    Manage Courses
                                </button>
                            </td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                    </table>
                    <?php
                    echo"
                    <form method ='POST' action = '../../user/ljdeleteconfirm.php'>
                        <input type = hidden name = 'ljid' value = $ljd>
                        <input type = hidden name = 'jname' value = '$jobName'>
                        <button type='submit' name = 'confirm' class='btn btn-outline-danger float-end'>Delete LJ</button>
                    </form>";
                    
                    ?>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>