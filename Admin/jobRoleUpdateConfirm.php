<?php
    session_start();
    //these codes run regardless of whether you came here through cancel or update, so
    //changes made can be stored for useability
    $JRole_ID=$_SESSION['JRole_ID'];
    $JRole_Name=$_SESSION['JRole_Name'];
    $JRole_Desc=$_SESSION['JRole_Desc'];
    $JRole_Skills=$_SESSION['JRole_Skills'];
    //make sure cancel update still stores the info they keyed in before so they can revert
    //by creating update name and desc session variables
    if(isset($_POST["newJR"])or isset($_POST["cancelUpdate"])){
        $newName=$_POST["newName"];
        $newDesc=$_POST["newDesc"];
    
        if($newName==$JRole_Name){
            $updateName=$JRole_Name;
        }
        else{
            $updateName=$newName;
            $_SESSION['updateName']=$updateName;
        }

        if($newDesc==$JRole_Desc){
            $updateDesc=$JRole_Desc;
        }
        else{
            $updateDesc=$newDesc;
            $_SESSION['updateDesc']=$updateDesc;
        }

        if(isset($_POST['newSkills'])){
            $newSkills=$_POST["newSkills"];
            if($newSkills==$JRole_Skills){
                $updateSkills=$JRole_Skills;
            }
            else{
                $updateSkills=$newSkills;
                $_SESSION['updateSkills']=$updateSkills;
            }
        }
        //Exits if no skill is picked, minimal codes run
        else{
            if (isset($_POST["cancelUpdate"])==false){
            echo "Job Role requires at least 1 skill.<br>";
            echo "Please check at least one skill if you want to continue updating";
            echo "<form action='jobRoleUpdate.php'>
            <input type='submit' value='Continue Updating' name='return'>
            </form><br>";
            echo "Or you can cancel updates and return to Job Role Main Page";
            echo"<form action='../screens/admin/viewJobRole.php'>
            <input type='submit' value='Return to Job Role Main Page and Cancel Updates' name='exit'>
            </form>";
            exit();
            }
        }
    }
    //COMES FROM CANCEL. session will drop on the hrjobview screen
    if (isset($_POST["cancelUpdate"])){
        echo "Are you sure you want to cancel updates?";
        echo"<form action='../screens/admin/viewJobRole.php'>
        <input type='submit' value='Return to Job Role Main Page and Cancel Updates' name='exit'>
        </form>";

        echo "<form action='jobRoleUpdate.php'>
        <input type='submit' value='Continue Updating' name='return'>
        </form>";
    }

    //COMES FROM UPDATE
    else{
        //Check if nothing is changed
        if(isset($_SESSION['updateName'])==false&&isset($_SESSION['updateDesc'])==false&&isset($_SESSION['updateSkills'])==false ){
            echo "No changes made";
        }
        //Only runs if anything has been changed
        else{
            require_once "../DAO/common.php";

            $JRole_ID=intval($JRole_ID);
            $dao= new jobRoleDAO();
            
            //Only runs if Name or Desc has been changed
            if(isset($_SESSION['updateName'])||isset($_SESSION['updateDesc'])){
                $updateJR=$dao->updateJobRole($JRole_ID,$updateName,$updateDesc);
            }
        
             //Only runs if skills have been changed
            if(isset($_SESSION['updateSkills'])){
                $removedSkills=[];
                $addedSkills=[];
                $dao2= new SkillDAO();
                //If JR had skills before
                if($JRole_Skills!="No Skills"){
                    foreach($JRole_Skills as $orig){
                        //Check for removed skills by checking if something is missing from update
                        if(in_array($orig,$updateSkills)==false){
                            $removed_ID=$dao2->getIDbyName($orig);
                            array_push($removedSkills,$removed_ID[0]);
                        }
                    }
                    foreach($updateSkills as $new){
                        //Check for added skills by checking if something is missing from original
                        if(in_array($new,$JRole_Skills)==false){
                            $added_ID=$dao2->getIDbyName($new);
                            array_push($addedSkills,$added_ID[0]);
                        }
                    }
                }
                //If JR had 0 skills before just add everything as new
                else{
                    foreach($_SESSION['updateSkills'] as $new){
                        $added_ID=$dao2->getIDbyName($new);
                        array_push($addedSkills,$added_ID[0]);
                    }
                }

                if($removedSkills!=[]){
                    foreach($removedSkills as $removed_ID){
                        $removed_ID=intval($removed_ID);
                        $remove=$dao->deleteRelSkills($JRole_ID,$removed_ID);
                    }
                }
                if($addedSkills!=[]){
                    foreach($addedSkills as $added_ID){
                        $added_ID=intval($added_ID);
                        $add=$dao->addRelSkills($JRole_ID,$added_ID);
                    }
                }
            }
            echo "Changes made";
        }
        echo "<form action='../screens/admin/viewJobRole.php'>
        <input type='submit' value='Return to Job Role Main Page'>
        </form>";
    }
?>

<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <?php 
    include("../navbar/adminNavbar.php");?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html> -->