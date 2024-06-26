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
                <input class="form-control" type="text" name='newName' value="<?php echo $JRole_Name;?>" required minlength='1' maxlength='50' >
            </div>

            <div class="mb-3">
                <label for="jobRoleName" class="form-label">Job Role Skills (Mandatory at least 1)</label>
                <div style="border: 1px solid #ced4da; border-radius: 10px; height: 150px; overflow-y: scroll;">
                    <?php
                    //if they return from confirm page, they will se their changes still
                    // var_dump()
                    if(isset($_SESSION['updateSkills'])){
                        foreach($allSkills as $skill){
                            if (in_array($skill,$_SESSION['updateSkills'],true)){
                                echo "<input type='checkbox' value='$skill' name='newSkills[]' checked> $skill";
                            }
                            else{
                                echo "<input type='checkbox' value='$skill' name='newSkills[]'> $skill";
                            }
                            echo "<br>";
                        }
                    }
                    else{
                        if ($JRole_Skills=="No Skills"){
                            foreach($allSkills as $skill){
                                echo "<input type='checkbox' value='$skill' name='newSkills[]'> $skill";
                                echo "<br>";
                            }
                        }
                        else{
                            foreach($allSkills as $skill){
                                if (in_array($skill,$JRole_Skills,true)){
                                    echo "<input type='checkbox' value='$skill' name='newSkills[]' checked> $skill";
                                }
                                else{
                                    echo "<input type='checkbox' value='$skill' name='newSkills[]'> $skill";
                                }
                                echo "<br>";
                            }
                        }
                    }
                    ?>
                </div>
            </div>
            
            <div class="mb-3">
                <?php
                    if (isset($_SESSION['updateDesc'])){
                        $JRole_Desc=$_SESSION['updateDesc'];
                    }
                ?>
                <label for="jobRoleDesc" class="form-label">Job Role Description (max 500)</label>
                <textarea class="form-control"  name='newDesc' rows='10' cols='50' maxlength='500'><?php echo $JRole_Desc;?></textarea>
            </div>

            <div class="container ms-2">
                <button type="submit" class="btn btn-outline-success float-end ms-2" name="newJR">Update Job Role</button>
            </div>

            <div class="container me-2">
                <button type="submit" class="btn btn-outline-warning float-end me-2" name="cancelUpdate">Cancel</button>
            </div>
            
        </form>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>