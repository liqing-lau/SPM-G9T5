<?php
    session_start();
    session_destroy();
    
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
        array_push($allJobRoles,"<td><form style='float:left; margin-block-end:0em' action='HR_jobRoleUpdate.php' method='POST'>
                                    <input type='hidden' name='JRole_ID' value='$eachItem[0]'>
                                    <input type='hidden' name='JRole_Name' value='$eachItem[1]'>
                                    <input type='hidden' name='JRole_Desc' value='$eachItem[2]'>
                                    <input type='hidden' name='JRole_Skills' value='$strSkills'>
                                    <input type='submit' value='Update' name='updateJR'/>
                                    </form>
                                    <form style='float:right; margin-block-end:0em' action='' method='POST'>
                                    <input type='hidden' name='JRole_ID' value='$eachItem[0]'>
                                    <input type='hidden' name='JRole_Name' value='$eachItem[1]'>
                                    <input type='hidden' name='JRole_Desc' value='$eachItem[2]'>
                                    <input type='submit' value='Delete' name='deleteJR'/>
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