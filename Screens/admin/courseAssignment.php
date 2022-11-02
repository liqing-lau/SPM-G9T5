<?php
    session_start();
    require_once '../../DAO/common.php';
    require_once '../../class/course.php';

    $courseDAO = new courseDAO();
    $skillDAO = new SkillDAO();
    $courseSkillDAO = new courseSkillDAO();

    if (isset($_POST['Skill_ID']) && isset($_POST['skillName'])) {
        $skillId = $_POST['Skill_ID'];
        $skillName = $_POST['skillName'];
        $_SESSION['skillId'] = $skillId;
        $_SESSION['skillName'] = $skillName;
    } elseif (isset($_SESSION['skillId']) && isset($_SESSION['skillName'])) {
        $skillId = $_SESSION['skillId'];
        $skillName = $_SESSION['skillName'];
    }

    $courseIdList = $courseSkillDAO->getCourseIdBySkill($skillId);
    
    $rows = [];

    foreach($courseIdList as $courseId) {
        $courseName = $courseDAO->getCourseName($courseId)[0];
        $row =  "<tr>
                <td>$courseId</td>
                <td>$courseName</td>
            </tr>";
        array_push($rows, $row);
    }

    $rows=implode("",$rows);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Assign Courses to Roles</title>
</head>
<body>
    <?php 
    $thisPage = 'skills';
    include("../navbar/adminNavbar.php");

    if(isset($_SESSION['courseSuccess']) && $_SESSION['courseSuccess'] != ''){
        echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Success! </strong><br>'. $_SESSION["courseSuccess"] . '
                </div>';
        $_SESSION['courseSuccess'] = '';
    } else if(isset($_SESSION['courseFail']) && $_SESSION['courseFail'] != ''){
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Error! </strong><br>'. $_SESSION["courseFail"] . '
                </div>';
        $_SESSION['courseFail'] = '';
    } 
    ?>
    
    <div class="container">
        <div class="container pt-3">
            <h3>
                <?php echo $skillName; ?>
            </h3>
            <hr>
        </div>
        
        <div class="p-2">
            <form action='./assignCourse.php' method='POST'>
                
                <input type='hidden' name='skillName' value='<?php echo $skillName?>'>
                <input type='hidden' name='skillId' value='<?php echo $skillId?>'>
                <button type='submit' class='btn btn-outline-dark float-end' name='assignCourse'>Amend assignment</button>
            </form>
        </div>

        <div class="container table-responsive">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>Role ID</th>
                        <th>Role Name</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        echo $rows;
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>