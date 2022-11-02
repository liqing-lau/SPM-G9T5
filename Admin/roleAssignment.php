<?php

session_start();

require_once '../DAO/common.php';

$skillDAO = new SkillDAO();
$jobSkillDAO = new JobskillDAO();
$jobRoleDAO = new jobRoleDAO();

$skillId = $_POST['skillId'];
$selectedRoles = $_POST['roleId'];
$currentRoles = $_POST['roleList'];

$currentRoles = explode(",", $currentRoles);
$skillName = $skillDAO->getSkillNameById($skillId);

$_SESSION['skillId'] = $skillId;
$_SESSION['skillName'] = $skillName;

$removeSkillSuccess = "Successfully removed $skillName from: <br> <ol>"; 
$removeSkillFail = "Failed removing $skillName from: <br> <ol>"; 
$addSkillSuccess = "Successfully added $skillName to: <br> <ol>"; 
$addSkillFail = "Failed adding $skillName to: <br> <ol>";

$_SESSION['skillFail'] = '';
$_SESSION['skillSuccess'] = '';

if ($selectedRoles == $currentRoles) {
    $_SESSION['skillFail'] = "You did not make any adjustment, please try again";
    header('Location: ../screens/admin/roleAssignment.php');
    exit();
}

foreach($currentRoles as $currentRoleId) {
    if(!in_array($currentRoleId, $selectedRoles)) {
        $status = $jobSkillDAO->removeRole($currentRoleId, $skillId);
        $jobName = $jobRoleDAO->getIndividualIDandName($currentRoleId)[0][1];
        if ($status) {
            $removeSkillSuccess .= "<li>$jobName</li>";
        } else {
            $removeSkillFail .= "<li>$jobName</li>";
        }
    }
}

foreach($selectedRoles as $selectedRoleId) {
    if(!in_array($selectedRoleId, $currentRoles)) {
        $status = $jobSkillDAO->create($selectedRoleId, $skillId);
        $jobName = $jobRoleDAO->getIndividualIDandName($currentRoleId)[0][1];
        if ($status) {
            $addSkillSuccess .= "<li>$jobName</li>";
        } else {
            $addSkillFail .= "<li>$jobName</li>";
        }
    }
}

if ($removeSkillSuccess != "Successfully removed $skillName from: <br> <ol>") {
    $_SESSION['skillSuccess'] .= $removeSkillSuccess . "</ol>";
} 

if ($removeSkillFail != "Failed removing $skillName from: <br> <ol>") {
    $_SESSION['skillFail'] .= $removeSkillFail . "</ol>";
}

if ($addSkillSuccess != "Successfully added $skillName to: <br> <ol>") {
    $_SESSION['skillSuccess'] .= $addSkillSuccess . "</ol>";
}

if ($addSkillFail != "Failed adding $skillName to: <br> <ol>") {
    $_SESSION['skillFail'] .= $addSkillFail . "</ol>";
} 

header('Location: ../screens/admin/roleAssignment.php');
exit();
?>