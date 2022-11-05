<?php

session_start();

require_once '../DAO/common.php';

$courseDAO = new courseDAO();
$skillDAO = new SkillDAO();
$courseSkillDAO = new courseSkillDAO();

$skillId = $_POST['skillId'];
$selectedCourses = $_POST['courseId'];
$currentCourses = $_POST['courseList'];

$currentCourses = explode(",", $currentCourses);
$skillName = $skillDAO->getSkillNameById($skillId);

$_SESSION['skillId'] = $skillId;
$_SESSION['skillName'] = $skillName;

$removeSkillSuccess = "Successfully removed $skillName from: <br> <ol>"; 
$removeSkillFail = "Failed removing $skillName from: <br> <ol>"; 
$addSkillSuccess = "Successfully added $skillName to: <br> <ol>"; 
$addSkillFail = "Failed adding $skillName to: <br> <ol>";

$_SESSION['courseFail'] = '';
$_SESSION['courseSuccess'] = '';

if ($selectedCourses == $currentCourses) {
    $_SESSION['courseFail'] = "You did not make any adjustment, please try again";
    header('Location: ../screens/admin/courseAssignment.php');
    exit();
}

if (sizeof($selectedCourses) == 0) {
    $_SESSION['courseFail'] = "You cannot remove all courses from a skill";
    header('Location: ../screens/admin/courseAssignment.php');
    exit();
}

foreach($currentCourses as $currentCourseId) {
    if(!in_array($currentCourseId, $selectedCourses)) {
        $status = $courseSkillDAO->removeCourse($currentCourseId, $skillId);
        $courseName = $courseDAO->getCourseName($currentCourseId);
        if ($status) {
            $removeSkillSuccess .= "<li>$courseName</li>";
        } else {
            $removeSkillFail .= "<li>$courseName</li>";
        }
    }
}

foreach($selectedCourses as $selectedCourseId) {
    if(!in_array($selectedCourseId, $currentCourses)) {
        $status = $courseSkillDAO->addSkillToCourse($selectedCourseId, $skillId);
        $courseName = $courseDAO->getCourseName($selectedCourseId);
        if ($status) {
            $addSkillSuccess .= "<li>$courseName</li>";
        } else {
            $addSkillFail .= "<li>$courseName</li>";
        }
    }
}

if ($removeSkillSuccess != "Successfully removed $skillName from: <br> <ol>") {
    $_SESSION['courseSuccess'] .= $removeSkillSuccess . "</ol>";
} 

if ($removeSkillFail != "Failed removing $skillName from: <br> <ol>") {
    $_SESSION['courseFail'] .= $removeSkillFail . "</ol>";
}

if ($addSkillSuccess != "Successfully added $skillName to: <br> <ol>") {
    $_SESSION['courseSuccess'] .= $addSkillSuccess . "</ol>";
}

if ($addSkillFail != "Failed adding $skillName to: <br> <ol>") {
    $_SESSION['courseFail'] .= $addSkillFail . "</ol>";
} 

header('Location: ../screens/admin/courseAssignment.php');
exit();

?>