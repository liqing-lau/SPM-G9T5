
<?php
    require_once '../DAO/common.php';
    $jdata = new jobRoleDAO();
    $jidname = $jdata->getIDandName();

?>
<html>
<form action = "createskill.php" method = "POST">
    
    Enter New Skill Name (min 2, max 50):<br>
    <input type="text" name="skill_name" required minlength="2" maxlength="50"/>
    <br>
    <br>
    Select JobRole to assign:<br> 
    <?php
        foreach($jidname as $jr){
            $jid = $jr[0];
            $jname = $jr[1];
            echo "
                <input type='checkbox' name='jrselect[]' value = '$jid'>$jname
            ";
        }
    ?>
    <br><br>
    <input type = "submit" value = "Create Skill" name = "nskill" />

</form>
</html>


<?php

    require_once '../DAO/common.php';

    if(isset($_POST['nskill'])){

        $s_name = $_POST['skill_name'];
        $new_skill = new SkillDAO();
        $sid_check = $new_skill->getIDbyName($s_name);

        $jrselect = $_POST['jrselect'];

        if(count($sid_check) == 0){
            $skill = $new_skill->create($s_name);
            $sid = $new_skill->getIDbyName($s_name);
            $sid = $sid[0];

            $new_assign = new JobskillDAO();
            foreach($jrselect as $jrid){
                $jobskill = $new_assign->create($jrid, $sid);
                
            }

            if($skill = "$s_name"){
                exit("Success! New skill $s_name successfully created!");
            }
            else{exit("Error! Creation of skill failed");}
            
        }

        exit("Error! Skill Name: $s_name already exists. Creation of skill failed.");

        
    }

?>

</html>