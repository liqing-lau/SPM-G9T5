<?php
    require_once("../DAO/common.php");

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
        array_push($allJobRoles,"<td><form style='float:left; margin-block-end:0em' action='HR_jobRoleUpdate.php' method='POST'>
                                    <input type='hidden' name='JRole_ID' value='$eachItem[0]'>
                                    <input type='hidden' name='JRole_Name' value='$eachItem[1]'>
                                    <input type='hidden' name='JRole_Desc' value='$eachItem[2]'>
                                    <button name='Update' type='submit'>Update</button>
                                    </form>
                                    <form style='float:right; margin-block-end:0em' action='' method='POST'>
                                    <input type='hidden' name='JRole_ID' value='$eachItem[0]'>
                                    <input type='hidden' name='JRole_Name' value='$eachItem[1]'>
                                    <input type='hidden' name='JRole_Desc' value='$eachItem[2]'>
                                    <button name='Delete' type='submit' value='$eachItem[0]'>Delete</button>
                                    </form>");
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