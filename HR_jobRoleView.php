<?php
    require_once("common.php");

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
        if(sizeof($skillList)==0){
            array_push($allJobRoles,"No skills");
        }
        else{
            array_push($allJobRoles,"<ul>");
            foreach ($skillList as $skill){
                array_push($allJobRoles,"<li>$skill</li>");
            }
            array_push($allJobRoles,"</ul></td>");
        }
        array_push($allJobRoles,"<td><input type='button' value='Update' id='updateRole'>");
        array_push($allJobRoles,"<input type='button' value='Delete' id='DeleteRole'>");
        array_push($allJobRoles,"</td></tr>");
    }
    $allJobRoles=implode("",$allJobRoles);
?>

<!-- table start -->
<html>
    <table border="1px">
        <tr>
            <th>Job Role ID</th>
            <th>Job Role Name</th>
            <th>Job Role Description</th>
            <th>Job Role Skills</th>
            <th>Edit options</th>
        </tr>
        <?php
        echo $allJobRoles;
        ?>
    </table>
</html>