<?php
session_start();
// All session items:
// JRole_ID, JRole_Skills, updateSkills
// JRole_Name, allSkills
// JRole_Desc, updateName
// skill_Temp, updateDesc

//makes sure session values only get reset if they press the update button again
if(isset($_POST["updateJR"])){
    $_SESSION['JRole_ID']=$_POST['JRole_ID'];
    $_SESSION['JRole_Name']=$_POST['JRole_Name'];
    $_SESSION['JRole_Desc']=$_POST['JRole_Desc'];
    $_SESSION['skillTemp']=$_POST['JRole_Skills'];

    //Had to try to pass a list, so passed it as string
    if ($_SESSION['skillTemp']!=""){
        $skillTemp=$_SESSION['skillTemp'];
        $skillTemp=explode(";",$skillTemp);
        array_shift($skillTemp);
        $_SESSION['JRole_Skills']=$skillTemp;
    }
    else{
        $skillTemp="No Skills";
        $_SESSION['JRole_Skills']=$skillTemp;
    }

    //Only grabs all skills once per form
    require_once("../DAO/common.php");
    if(isset($_SESSION['allSkills'])==False){
        $dao= new SkillDAO();
        $allSkills=$dao->getActiveSkillNames();
        $_SESSION['allSkills']=$allSkills;
    }
}

$JRole_Name=$_SESSION['JRole_Name'];
$JRole_Desc=$_SESSION['JRole_Desc'];
$JRole_Skills=$_SESSION['JRole_Skills'];
$allSkills=$_SESSION['allSkills'];

header('Location: ../screens/admin/jobRoleUpdate.php')
?>