<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Update Job Role</title>
</head>
<body>
    <?php 
    $thisPage = 'roles';
    include("../navbar/adminNavbar.php");
    session_start();

    $JRole_Name=$_SESSION['JRole_Name'];
    $JRole_Desc=$_SESSION['JRole_Desc'];
    $JRole_Skills=$_SESSION['JRole_Skills'];
    $allSkills=$_SESSION['allSkills'];
    $roleId = $_SESSION['JRole_ID'];
    ?>

    <div class="container">

        <form action="../../Admin/jobRoleUpdateConfirm.php" method="POST">
        
        <div class="input-group mb-3 pt-4">
            <span class="input-group-text" id="jobRoleId">Job Role ID:</span>
            <input class="form-control" type="text" value="<?php echo $roleId;?>" disabled readonly>
        </div>

        <div class="mb-3">
            <?php
                if (isset($_SESSION['updateName'])){
                    $JRole_Name=$_SESSION['updateName'];
                }
            ?>
            <label for="jobRoleName" class="form-label">Job Role Name (min 1, max 50)</label>
            <input class="form-control" type="text" name='newName' value=<?php echo $JRole_Name;?> required minlength='1' maxlength='50' >
        </div>

        <div class="mb-3">
            <label for="jobRoleName" class="form-label">Job Role Skills (Mandatory at least 1)</label>
            <select multiple class="form-control" name="jobSkills[]"></select>
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
        </div>
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
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>