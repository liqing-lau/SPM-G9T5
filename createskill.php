<?php

    require_once 'common.php';

    if(isset($_POST['nskill'])){
        $s_name = $_POST['skill_name'];
        $new_skill = new SkillDAO();
        $skill = $new_skill->create($s_name);
        
        if($skill = "$s_name"){
            echo "New skill $skill successfully created!";
        }
        else{echo "Creation of skill failed";}
    }
?>