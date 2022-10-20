<?php
session_start();

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
}

$JRole_Name=$_SESSION['JRole_Name'];
$JRole_Desc=$_SESSION['JRole_Desc'];
$JRole_Skills=$_SESSION['JRole_Skills'];
?>

<html>
    <form action="HR_jobRoleUpdateConfirm.php" method="POST">
        <h1>Job Role ID:</h1>
        <?php
        echo $_SESSION['JRole_ID'];
        ?>
        <br><br>

        <h1>Job Role Name (min 1, max 50)</h1>
        <?php
        //if they return from confirm page, they will see their changes still
        if (isset($_SESSION['updateName'])){
            $updateName=$_SESSION['updateName'];
            echo "<input type='text' value='$updateName' name='newName' required minlength='1' maxlength='50'>";
        }
        else{
            echo "<input type='text' value='$JRole_Name' name='newName'required minlength='1' maxlength='50'>";
        }
        ?>
        <br><br>

        <h1>Job Role Skills (Mandatory at least 1)</h1>
        <?php
        if ($JRole_Skills=="No Skills"){
            echo $JRole_Skills;
        }
        else{
            foreach($JRole_Skills as $skill){
                echo $skill."<br>";
            }
        }
        ?>
        <br><br>

        <h1>Job Role Description (max 500)</h1>
        <?php
        if (isset($_SESSION['updateDesc'])){
            $updateDesc=$_SESSION['updateDesc'];
            echo "<textarea name='newDesc' rows='10' cols='50' maxlength='500'>$updateDesc</textarea>";
        }
        else{
            echo "<textarea name='newDesc' rows='10' cols='50' maxlength='500'>$JRole_Desc</textarea>";
        }
        ?>
        <br><br>
        <input type="submit" value="Cancel" name="cancelUpdate"><br><br>
        <input type="submit" value="Update Job Role" name="newJR">

    </form>
</html>