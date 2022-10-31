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
        $allSkills=$dao->getSkillNames();
        $_SESSION['allSkills']=$allSkills;
    }
}

$JRole_Name=$_SESSION['JRole_Name'];
$JRole_Desc=$_SESSION['JRole_Desc'];
$JRole_Skills=$_SESSION['JRole_Skills'];
$allSkills=$_SESSION['allSkills'];

header('Location: ../screens/admin/jobRoleUpdate.php')
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
    <?php include("../navbar/userNavbar.php");?>

    <form action="jobRoleUpdateConfirm.php" method="POST">
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
        //if they return from confirm page, they will se their changes still
        if(isset($_SESSION['updateSkills'])){
            foreach($allSkills as $skill){
                echo "<br>";
                if (in_array($skill,$_SESSION['updateSkills'],true)){
                    echo "$skill <input type='checkbox' name='newSkills[]' value='$skill' checked>";
                }
                else{
                    echo "$skill <input type='checkbox' name='newSkills[]' value='$skill'>";
                }
            }
        }
        else{
            if ($JRole_Skills=="No Skills"){
                foreach($allSkills as $skill){
                    echo "<br>";
                    echo "$skill <input type='checkbox' name='newSkills[]' value='$skill'>";
                }
            }
            else{
                foreach($allSkills as $skill){
                    echo "<br>";
                    if (in_array($skill,$JRole_Skills,true)){
                        echo "$skill <input type='checkbox' name='newSkills[]' value='$skill' checked>";
                    }
                    else{
                        echo "$skill <input type='checkbox' name='newSkills[]' value='$skill'>";
                    }
                }
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
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html> -->