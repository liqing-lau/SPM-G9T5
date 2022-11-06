<?php

require_once("../../class/jobRole.php");
require_once("../../DAO/common.php");

$thisPage = 'roles';
$Staff_ID = $_COOKIE['empId'];

$dao = new ljDAO();

//GET created LJ WITH STAFF ID
$ljList = $dao->viewLJLangdingPage($Staff_ID);

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
    <div class="container-md pt-5">
        <div class="card">
            <div class="card-header text-center">
                <h3 class="card-title">List of Learning Journey</h5>
            </div>

            <div class="card-body">
                <div class="container">
                    <?php
                    if (sizeof($ljList) != 0) {
                        echo "
                            <table class='table'>
                            <thead>
                                <tr>
                                    <th>Learning Journey ID</th>
                                    <th>Job Role</th>
                                </tr>
                            </thead>
                            <tbody>
                        ";
                        foreach ($ljList as $data) {
                            echo"<form action='LJDetails.php' method='POST'>";
                            echo "<tr>";
                            $LJ_ID = $data[0];
                            $JobRole = $data[3];
                            echo "<td>" . $LJ_ID . "</td>";
                            echo "<td>" . $JobRole . "</td>";
                            echo "<td><input type='submit' name='viewDetails' value='View Details'/></td>";
                            echo "<input type='hidden' name='LJ_ID' value='$LJ_ID'/>";
                            echo "</form>";
                        }
                        echo "</tbody>
                        </table>";
                    } else {
                        echo "You currently do not have any learning journey";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>

</html>