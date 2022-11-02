<?php
session_start(); 
require_once("../DAO/common.php");

$dao = new jobRoleDAO();

if(isset($_POST["deleteJR"])){
    $JRole_ID=$_POST["JRole_ID"];
    $JRole_Name=$_POST["JRole_Name"];

    $JRole_Status= "Not Available";
    $status= $dao->deleteJR($JRole_ID,$JRole_Status);

    if($status){
        $_SESSION['JRSuccess']=$JRole_Name. " successfully deleted";
    }
    else{
        $_SESSION['JRFail']="Unable to delete ". $JRole_Name.".<br> Please try again";
    }
    header("Location: ../screens/admin/viewJobRole.php");
    exit();
}

if(isset($_POST["enableJR"])){
    $JRole_ID=$_POST["JRole_ID"];
    $JRole_Name=$_POST["JRole_Name"];

    $JRole_Status="active";
    $status=$dao->deleteJR($JRole_ID,$JRole_Status);

    if($status){
        $_SESSION["JRSuccess"]=$JRole_Name. "successfully enabled";
    }
    else{
        $_SESSION["JRFail"]="Unable to enable ". $JRole_Name. ".<br> Please try again.";
    }
    header("Location: ../screens/admin/viewJobRole.php");
    exit();
}
?>