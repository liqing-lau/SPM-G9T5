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
    }
    //COMES FROM CANCEL. session will drop on the hrjobview screen
    if (isset($_POST["cancelUpdate"])){
        echo "Are you sure you want to cancel updates?";
        echo"<form action='HR_jobRoleView.php'>
        <input type='submit' value='Cancel Updates and return to Job Role Main Page' name='exit'>
        </form>";

        echo "<form action='HR_jobRoleUpdate.php'>
        <input type='submit' value='Continue Updating' name='return'>
        </form>";
    }

    //COMES FROM UPDATE
    else{
        require_once "../DAO/common.php";

        //for some reason jrole id doesnt want to be an int
        $JRole_ID=intval($JRole_ID);
    
        $dao= new jobRoleDAO();
        $updateJR=$dao->updateJobRole($JRole_ID,$updateName,$updateDesc);
        
        echo $updateJR;

        echo "<form action='HR_jobRoleView.php'>
        <input type='submit' value='Return to Job Role Main Page'>
        </form>";
    }
?>