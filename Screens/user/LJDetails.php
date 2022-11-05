<?php
require_once("../../class/jobRole.php");
require_once("../../DAO/common.php");

$thisPage = 'roles';

$LJ_ID = $_POST['LJ_ID'];


if (isset($_POST["viewDetails"])) {
    $dao = new ljDAO();

    $addedCourseList = $dao->viewAddedCourseforEachLJ($LJ_ID);

    var_dump($addedCourseList);
}
$Staff_ID = $_COOKIE['empId'];





?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>View role</title>
</head>

<body>
    <?php include("../navbar/userNavbar.php"); ?>


    <div class="container-md pt-5">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title">Planned Courses</h5>
            </div>

            <div class="card-body">


                <div class="container">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Skill</th>
                                <th>Courses</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php

                            foreach ($addedCourseList as $data) {
                                echo "<tr>";
                                $skill = $data[1];
                                $courses = $data[0];
                                echo "<td>" . $skill . "</td>";
                                echo "<td>" . $courses . "</td>";
                            }

                            ?>
                        </tbody>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>