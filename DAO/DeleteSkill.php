<?php
require_once("../DAO/common.php");



$JRole_ID = 12;
$Staff_ID = 130001;
$LJ_ID = 1;

$dao = new SkillDAO();

if(isset($_POST["deleteSkill"])){
    $Skill_Status = "Not Available";
    $dao->deleteSkill($_POST['Skill_ID'], $Skill_Status);
    echo $_POST['Skill_ID'];

}

$skillList = $dao->getAllSkill();
// var_dump($skillList);

?>

<!-- table start -->
<html>
<!-- <form action="DeleteSkill.php" method="POST"> -->
    <table border="1px">
        <tr>
            <th>Skill ID</th>
            <th>Skill Name</th>
            <th>Skill Status</th>
            <th>Update Button</th>
        </tr>
        <tr>
            <?php
            
            foreach ($skillList as $skillArray) {
                echo"<form action='DeleteSkill.php' method='POST'>";
                echo "<tr>";
                $Skill_ID = $skillArray[0];
                $Skill_Name = $skillArray[1];
                $Skill_Status = $skillArray[2];
                echo "<td>" . $Skill_ID . "</td>";
                echo "<td>" . $Skill_Name . "</td>";
                echo "<td>" . $Skill_Status . "</td>";
                echo "<td><input type='submit' name='deleteSkill' value='DELETE SKILL'/></td>";
                echo "<input type='hidden' name='Skill_ID' value='$Skill_ID'/>";
                echo "</form>";

            }


            ?>
        </tr>
    </table>
<!-- </form> -->
 
</html>