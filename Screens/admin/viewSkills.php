<?php
    session_start();
    session_destroy();

    require_once '../../DAO/common.php';

    $dao = new SkillDAO();
    $skillList = $dao->getAllSkill();

    $displaySkills = [];

    foreach ($skillList as $skill) {
        $skillId = $skill[0];
        $skillName = $skill[1];
        $skillStatus = $skill[2];
        $row_colour = "";
        $disabled = "";

        if ($skillStatus != 'active') { 
            $row_colour = "class='table-secondary'";
            $disabled = "disabled";
            $buttons = "
                        <form action='../../Admin/deleteSkill.php' method='POST'>
                            <input type='hidden' name='skillName' value='$skillName'/>
                            <input type='hidden' name='Skill_ID' value='$skillId'/>
                            <button type='submit' class='btn btn-outline-light' name='enableSkill'>Enable</button>
                        </form>";
        } else {
            $buttons = "
                        <form action='../../Admin/deleteSkill.php' method='POST'>
                            <input type='hidden' name='skillName' value='$skillName'/>
                            <input type='hidden' name='Skill_ID' value='$skillId'/>
                            <button type='submit' class='btn btn-outline-danger' name='delSkill'>Delete</button>
                        </form>";
        }

        $row = "<tr $row_colour>
                <td>$skillId</td>
                <td>$skillName</td>
                <td>
                    <form action='./roleAssignment.php' method='POST'>
                        <input type='hidden' name='Skill_ID' value='$skillId'/>
                        <input type='hidden' name='skillName' value='$skillName'/>
                        <button type='submit' class='btn btn-outline-primary' name='assignRole' $disabled>Role Assignment</button>
                    </form>
                    <form action='./courseAssignment.php' method='POST'>
                        <input type='hidden' name='Skill_ID' value='$skillId'/>
                        <input type='hidden' name='skillName' value='$skillName'/>
                        <button type='submit' class='btn btn-outline-primary' name='assignCourse' $disabled>Course Assignment</button>
                    </form>
                    $buttons
                </td>
                </tr>";
        array_push($displaySkills, $row);
    }

    $displaySkills=implode("",$displaySkills);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Skills</title>
</head>
<body>
    <?php 
    $thisPage = 'skills';
    include("../navbar/adminNavbar.php");
    
    if(isset($_SESSION['skillSuccess']) && $_SESSION['skillSuccess'] != ''){
        echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Success! </strong><br>'. $_SESSION["skillSuccess"] . '
                </div>';
    } else if(isset($_SESSION['skillFail']) && $_SESSION['skillFail'] != ''){
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Error! </strong><br>'. $_SESSION["skillFail"] . '
                </div>';
    } 
    ?>

    <div class="container">
        
        <div class="p-2">
            <a href= "./createSkill.php" class="btn btn-outline-dark float-end" type="button">Create Skill</a>
        </div>
    </div>

        <div class="container table-responsive">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Skill Name</th>
                        <th>Edit options</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        echo $displaySkills;
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>