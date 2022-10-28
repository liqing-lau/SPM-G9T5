<?php
    require_once("../../class/jobRole.php");
    require_once("../../DAO/common.php");

    $thisPage = 'roles';

$JRole_ID = $_GET['role'];
$Staff_ID = $_COOKIE['empId'];

$dao = new jobRoleDAO();

//GET JOBROLE AND DESC WITH JOBROLE_ID
$jobRoleList = $dao->getIndividualIDandName($JRole_ID);
//  var_dump($jobRoleList);
$jobName = $jobRoleList[0][1];
$jobDesc = $jobRoleList[0][2];

$skillList = $dao->getIndividualJobSkill($JRole_ID);

$coursesList = $dao->getIndividualCourseSkill($JRole_ID);


foreach ($coursesList as $eachcourse) {

    // echo($eachcourse[0]);

    $coursetaken = $dao->getCourseTaken($Staff_ID);

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>View role</title>
</head>
<body>
    <?php include("../navbar/userNavbar.php");?>

    <h1>Job Role: <?php echo $jobName ?></h1>
    <h2>Job Description: <?php echo $jobDesc ?></h2>

    <div class="container">
        <table class="table">
        <thead>
            <tr>
                <th>Skill</th>
                <th>Courses</th>
                <th>Registered</th>
                <th>Completed</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $registrationServiceIn = new RegistrationService();

            $registrationList = $registrationServiceIn->registrationDataByJobRoleId($JRole_ID, $Staff_ID);
        
            foreach ($registrationList as $data) {
                echo "<tr>";
                echo "<td>" . $data['skill'] . "</td>";
                echo "<td>" . $data['course'] . "</td>";
                echo "<td>" . $data['registered'] . "</td>";
                echo "<td>" . $data['completed'] . "</td>";
            }
    
            ?>
        </tbody>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>