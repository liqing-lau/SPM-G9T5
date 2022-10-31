<?php
session_start(); 
require_once("../DAO/common.php");

$dao = new SkillDAO();

if(isset($_POST["delSkill"])){
    $Skill_Status = "Not Available";
    $status = $dao->deleteSkill($_POST['Skill_ID'], $Skill_Status);
    
    if ($status) {
        $_SESSION['skillSuccess'] = $_POST['skillName'] . " successfully deleted";
    } else {
        $_SESSION['skillFail'] = "Unable to delete " . $_POST['skillName'] . ".";
        $_SESSION['skillFail'] .= "<br> Please try again.";
    }
    header("Location: ../screens/admin/viewSkills.php");
    exit();
}

if(isset($_POST["enableSkill"])){
    $Skill_Status = "active";
    $status = $dao->deleteSkill($_POST['Skill_ID'], $Skill_Status);
    
    if ($status) {
        $_SESSION['skillSuccess'] = $_POST['skillName'] . " successfully enabled";
    } else {
        $_SESSION['skillFail'] = "Unable to enable " . $_POST['skillName'] . ".";
        $_SESSION['skillFail'] .= "<br> Please try again.";
    }
    header("Location: ../screens/admin/viewSkills.php");
    exit();
}
?>