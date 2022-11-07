<?php
    require_once '../../DAO/common.php';
    require_once '../../classes/course.php';

    $courseDAO = new courseDAO();
    $skillDAO = new SkillDAO();
    $courseSkillDAO = new courseSkillDAO();

    $skillName = $_POST['skillName'];
    $skillId = $_POST['skillId'];

    $courseList = $courseSkillDAO->getCourseIdBySkill($skillId);
    $allCourses = $courseDAO->getAllCourse();

    $courseIdList = [];
    $rows = [];

    foreach ($courseList as $courseId) {
        array_push($courseIdList, $courseId);
    }

    foreach ($allCourses as $course) { 
        $courseId = $course->getId();
        $courseName = $course->getName();
        $skills = $courseSkillDAO->getSkillIdList($courseId);

        $skillNameList = [];
        $checked = "";
        $assigned = "";
        
        foreach($skills as $getSkillId) {
            $getSkillName = $skillDAO->getSkillNameById($getSkillId);
            $temp = "<li>$getSkillName</li>";
            array_push($skillNameList, $temp);
        }

        if(in_array($courseId, $courseList)) {
            $checked = "checked";
            $assigned = "Already Assigned";
        }

        $skillNameList=implode("",$skillNameList);

        // if (empty($skillNameList)) {
        //     $skillNameList = "- Not assigned any skills - ";
        // } else {
        //     $skillNameList=implode("",$skillNameList);
        // }

        $row = "<tr>
                    <td>
                        <input class='form-check-input' type='checkbox' value='$courseId' name='courseId[]' $checked>
                    </td>
                    <td>$courseId</td>
                    <td>$courseName</td>
                    <td>
                        <ol>$skillNameList</ol>
                    </td>
                    <td>$assigned</td>
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
    <title>Assign Skills to Course</title>
</head>
<body>
    <?php 
    $thisPage = 'skills';
    include("../navbar/adminNavbar.php");
    ?>
    
    <div class="container">
        <div class="container pt-3">
            <h3>
                <?php echo $skillName; ?>
            </h3>
            <hr>
        </div>
        <div class="p-2">
            <form action='../../Admin/courseAssignment.php' method='POST'>
                <input type='hidden' name='skillId' value='<?php echo $skillId?>'>
                <input type='hidden' name='courseList' value='<?php echo implode(",", $courseList);?>'>
                    <div class="container table-responsive">
                        <table class="table text-nowrap">
                            <thead>
                                <tr>
                                    <th>Selected</th>
                                    <th>Course ID</th>
                                    <th>Course Name</th>
                                    <th>Skills</th>
                                    <th>Assigned?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                    echo $rows;
                                ?>
                            </tbody>
                        </table>
                    </div>
    
        
                <button type='submit' class='btn btn-outline-dark float-end' name='assignCourse'>Apply changes</button>
            </form>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>