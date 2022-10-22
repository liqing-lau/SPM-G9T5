<?php
    require_once '../DAO/common.php';
    $jobRoleDAO = new jobRoleDAO();
    
    if(isset($_POST['createRoles'])) {
        
        $jobName = $_POST['jobName'];
        $jobDesc = $_POST['jobDesc'];
        $jobSkill= $_POST['jobSkills'];

        echo $jobName;
        echo $jobDesc;
        foreach ($jobSkill as $skill) {
            echo $skill;
        }

    }
?>