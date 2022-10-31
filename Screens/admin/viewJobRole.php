<?php
    session_start();
    session_destroy();

    $thisPage = 'roles';
    require_once("../../DAO/common.php");
    require_once("../../class/jobRole.php");

    //Fetch the info from jobrole csv
    $dao= new jobRoleDAO();
    $listJR= $dao->getAll();

    $final_list=[];

    foreach($listJR as $item){
            array_push($final_list,[$item->getId(), $item->getName(), $item->getDesc()]);
    }

    $allJobRoles=[];
    foreach($final_list as $eachItem){
        //shortens the description
        $shortened= mb_strimwidth($eachItem[2], 0, 50, "...");
        array_push($allJobRoles,"<tr><td>");
        array_push($allJobRoles,strval($eachItem[0]));
        array_push($allJobRoles,"</td><td>$eachItem[1]</td>");
        array_push($allJobRoles,"<td>$shortened</td>");
        array_push($allJobRoles,"<td>");
        //Fetch relevant skills from skill csv
        $skillList=$dao->getRelSkills($eachItem[0]);
        $strSkills="";
        if(sizeof($skillList)==0){
            array_push($allJobRoles,"No skills");
        }
        else{
            array_push($allJobRoles,"<ul>");
            foreach ($skillList as $skill){
                array_push($allJobRoles,"<li>$skill</li>");
                //make a string of skill names so i can hidden value it over
                $strSkills=$strSkills.";".$skill;
            }
            array_push($allJobRoles,"</ul></td>");
        }
        array_push($allJobRoles,"<td><form style='float:left; margin-block-end:0em' action='../../Admin/jobRoleUpdate.php' method='POST'>
                                    <input type='hidden' name='JRole_ID' value='$eachItem[0]'>
                                    <input type='hidden' name='JRole_Name' value='$eachItem[1]'>
                                    <input type='hidden' name='JRole_Desc' value='$eachItem[2]'>
                                    <input type='hidden' name='JRole_Skills' value='$strSkills'>
                                    <input type='submit' class='btn btn-outline-warning' value='Update' name='updateJR'/>
                                    </form>
                                    <form style='float:right; margin-block-end:0em' action='' method='POST'>
                                    <input type='hidden' name='JRole_ID' value='$eachItem[0]'>
                                    <input type='hidden' name='JRole_Name' value='$eachItem[1]'>
                                    <input type='hidden' name='JRole_Desc' value='$eachItem[2]'>
                                    <input type='submit' class='btn btn-outline-danger' value='Delete' name='deleteJR'/>
                                    </form>");
        array_push($allJobRoles,"</td></tr>");
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
    <title>Admin</title>
</head>
<body>


    <?php
    include("../navbar/adminNavbar.php");

    if(isset($_SESSION['updateSuccess'])){
        echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Success! </strong><br>'. $_SESSION["updateSuccess"] . '
                </div>';
    }

    if (isset($_SESSION['noUpdate'])) {
        echo '<div class="alert alert-warning alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>'. $_SESSION["noUpdate"] . '</strong>
                </div>';
    }

    
    if(isset($_SESSION['jobCreateSuccess'])){
        echo '<div class="alert alert-success alert-dismissible" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <strong>Success! </strong><br>'. $_SESSION["jobCreateSuccess"] . '
                </div>';

    } 
    
    if(isset($_SESSION['jobCreateFailure'])){
        $alert = '<div class="alert alert-danger alert-dismissible" role="alert">
                    <strong>Creation of job failed!</strong><br> 
                    Type of error(s):
                    <ol>'; 

        foreach($_SESSION['jobCreateFailure'] as $alertmessage){
            $alert .= '<li>' . $alertmessage . '</li>';
        }

        $alert .= '</ol>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>';

        echo $alert;
    } 

    

    ?>

    <div class="container">
    
        <div class="p-2">
            <a href= "./createJobRole.php" class="btn btn-outline-dark float-end" type="button">Create Job Role</a>
        </div>

        <div class="container">
            <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Job Role Name</th>
                    <th>Job Role Description</th>
                    <th>Job Role Skills</th>
                    <th>Edit options</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    echo $allJobRoles;
                ?>
            </tbody>
        </div>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>