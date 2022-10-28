<?php
    require_once("../../class/jobRole.php");
    require_once("../../class/lj.php");
    require_once "../../DAO/common.php";

    $thisPage = 'roles';

    $empId = $_COOKIE['empId'];

    $dao = new jobRoleDAO();
    $allRoles = $dao->getAll();

    $ljdao = new ljDAO();
    $ljRoleIdList = $ljdao->getLJRoles($empId); //get the ljid staffID jroleID etc

    $allJobRoles = [];

    foreach($allRoles as $role){
        $roleId = $role->getID();
        $roleName = $role->getName();
        $roleDesc = $role->getDesc();

        $row = "<tr>
                    <td>$roleId</td>
                    <td>$roleName</td>
                    <td>$roleDesc</td>
                    <form action='../../user/getJRPage.php' method='post'>
                        <td>
                            <button type='submit' class='btn btn-light' name='viewJR' value=$roleId>
                                View Job
                            </button>
                        </td>
                        <td>";

        if (in_array($roleId, $ljRoleIdList)) {
            $row .= "<button type='submit' class='btn btn-light' name='addjobRole' value=$roleId disabled>
                        Added
                    </button>";
        } else {
            $row .= "<button type='submit' class='btn btn-light' name='addjobRole' value=$roleId>
                        Add role
                    </button>";
        }

        $row .= "</td>
                <td>
                    <button type='submit' class='btn btn-light' name='viewSkills' value=$roleId>
                        View Skills
                    </button>
                </td>
                </form>
                </tr>";

        array_push($allJobRoles, $row);
    }

    $allJobRoles=implode("",$allJobRoles);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>View all roles</title>
</head>
<body>
    <?php include("../navbar/userNavbar.php");?>

    <div class="container">
        <table class="table">
        <thead>
            <tr>
                <th>Job Role ID</th>
                <th>Job Role Name</th>
                <th> Job Role Description </th>
                <!-- <th style='width:70%' > Job Role Description </th> -->
            </tr>
        </thead>
        <tbody>
            <?php
                echo $allJobRoles;
            ?>
        </tbody>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>