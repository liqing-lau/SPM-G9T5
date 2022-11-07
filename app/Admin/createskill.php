<?php
    session_start();
    require_once '../DAO/common.php';

    if(isset($_POST['nskill'])){
        $s_name = $_POST['skillName'];
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
                $_SESSION['skillSuccess'] = "New skill $s_name successfully created!";
            } else {
                $_SESSION['skillFail'] = "Creation of skill failed";
            }
        }

        $_SESSION['skillFail'] = "Creation of skill failed. <br>Skill Name: $s_name already exists.";
        header("Location: ../screens/admin/viewSkills.php");
        exit();
    }

?>

</html>