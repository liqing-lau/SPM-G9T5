<?php

require_once("../../DAO/common.php");

if(isset($_POST['ljdata'])){

$ljd = $_POST['ljdata'];
$ljd = substr($ljd, -3);

$ljt = new ljdao();
$ljdata = $ljt->getLJbyLJID($ljd);
$jobid = $ljdata[0][2];

$jobr = new jobRoleDAO();
$JRdata = $jobr->getIndividualIDandName($jobid);

$jobName = $JRdata[0][1];
$jobDesc = $JRdata[0][2];

$js = new JobskillDAO();
$skills = $js->getSkillIdList($jobid);

$skillcourse = [];
// print_r($ljdata);

foreach($skills as $skill){
    $sd = new SkillDAO();
    $sname = $sd->getSkillNameById($skill);
    array_push($skillcourse,[$skill,$sname,[]]);
}

for($x = 0; $x < count($skillcourse); $x++){

    foreach($ljdata as $lj){
        $cid = $lj[3];
        $sid = $skillcourse[$x][0];
        $cs = new CourseSkillDAO();
        $cscheck = $cs->checkCourseSkill($cid,$sid);

        if($cscheck){
            array_push($skillcourse[$x][2],$cid);
        }
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
                <h3 class="card-title"><?php echo "Learning Journey JobRole: $jobName" ?></h5>
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
                            echo "
                            <tr>
                            <td>$sc[1]</td>
                            <td>$cplan</td>
                            <td><button type = 'button'>Manage Courses</button></td>
                            </tr>";
                        }
                        ?>
                    </tbody>
                </div>
            </div>
        </div>
    </div>
    <?php
    echo"
    <form method ='POST' action = 'ljdetail.php'>
        <input type = hidden name = 'ljid' value = $ljd>
        <input type = hidden name = 'decide' id = 'tf' value=<script> doit(); </script> >
        <button type='submit' name = 'confirm' onclick = 'doit()'>Delete LJ</button>
    </form>
    <script>
            function doit(){
                var doc = '';
                var result = confirm('Delete Learning Journey for $jobName?');
                if (result == true){
                    doc = 'yes';
                }
                else {doc = 'no';}
                cons
                document.getElementByID('tf').setAttribute('value',doc);
            }
    </script>
    ";
    // $ff = $_POST['decide'];
    //         print_r($ff);
        if(isset($_POST['confirm'])){
            echo $_POST['decide'];
            // if($_POST['decide'] = 'yes'){
            // $t = $_POST['ljid'];
            // $ljn = new ljDAO();
            // $ljdelete = $ljn->deleteLJ($t);
            // echo "<script>window.location.href='landing.php';</script>";
            // exit;}

            // elseif($_POST['decide'] = 'no'){echo "<script>window.location.href='landing.php';</script>";
            //     exit;}
        }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>

</html>