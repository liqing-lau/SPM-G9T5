<?php
require_once("../DAO/common.php");

$JRole_ID = 14;
$Staff_ID = '130001';

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

<!-- table start -->
<html>
<h1>Job Role: <?php echo $jobName ?></h1>
<h2>Job Description: <?php echo $jobDesc ?></h2>
<table border="1px">
    <tr>
        <th>Skill</th>
        <th>Courses</th>
        <th>Registered</th>
        <th>Completed</th>
    </tr>
    <tr>
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
    </tr>
</table>
<br>


</html>