<?php
    session_start();
    session_destroy();

    require_once '../../DAO/common.php';
    require_once '../../class/course.php';

    $dao = new courseDAO();
    $courseList = $dao->getAllCourse();

    $displayCourses = [];

    foreach ($courseList as $course) {
        $courseId = $course->getId();
        $courseName = $course->getName();
        $courseStatus = $course->getStatus();
        $row_colour = "";
        $disabled = "";

        if ($courseStatus == 'Retired') { 
            $row_colour = "class='table-secondary'";
            $disabled = "disabled";
        } elseif ($courseStatus == 'Pending') {
            $row_colour = "class='table-warning'";
        }

        $row = "<tr $row_colour>
                <td>$courseId</td>
                <td>$courseName</td>
                </tr>";
        array_push($displayCourses, $row);
    }

    $displayCourses=implode("",$displayCourses);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Course</title>
</head>
<body>
    <?php 
    $thisPage = 'courses';
    include("../navbar/userNavbar.php");
    
    if(isset($_SESSION['courseSuccess']) && $_SESSION['courseSuccess'] != ''){
        echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Success! </strong><br>'. $_SESSION["courseSuccess"] . '
                </div>';
    } else if(isset($_SESSION['courseFail']) && $_SESSION['courseFail'] != ''){
        echo '<div class="alert alert-danger alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Error! </strong><br>'. $_SESSION["courseFail"] . '
                </div>';
    } 
    ?>

    <div class="container">
        
        <!-- <div class="p-2">
            <a href= "./createSkill.php" class="btn btn-outline-dark float-end" type="button">Create Skill</a>
        </div> -->
    </div>

        <div class="container table-responsive">
            <table class="table text-nowrap">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Skill Name</th>
                        <!-- <th>Edit options</th> -->
                    </tr>
                </thead>
                <tbody>
                    <?php
                        echo $displayCourses;
                    ?>
                </tbody>
            </table>
        </div>
        
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>