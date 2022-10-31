<?php
    require_once '../DAO/common.php';
    $jobRoleDAO = new jobRoleDAO();
    session_start();
    function getErrors($jobName, $jobDesc, $jobNameTaken) {
        $errormsg = [];

        if (empty($jobName) ) {
            array_push($errormsg, "Job name is empty");
        }

        if (empty($jobDesc) ) {
            array_push($errormsg, "Description is empty");
        }
        
        if (strlen($jobName) > 50) {
            array_push($errormsg, "Job name more than 50 characters");
        }

        if (strlen($jobDesc) > 500) {
            array_push($errormsg, "Job description more than 500 characters");
        }

        if (!$jobNameTaken) {
            array_push($errormsg, "Job name is already in database");
        }

        return $errormsg;
    }
    
    if(isset($_POST['createRoles']) and isset($_POST['jobSkills'])) {
        $jobName = $_POST['jobName'];
        $jobDesc = $_POST['jobDesc'];
        $jobSkill= $_POST['jobSkills'];

        $jobNameTaken = $jobRoleDAO->checkJobNameInDB($jobName);

        $errormsg = getErrors($jobName, $jobDesc, $jobNameTaken);
        
        if(count($errormsg) == 0) {
            $job = $jobRoleDAO->createJobRole($jobName, $jobDesc, $jobSkill);
            if ($job === 0) {
                array_push($errormsg, $job);
            } else {
                $_SESSION['jobCreateSuccess'] = "You have successfully added $jobName";
            }
        } 

    } else {
        $errormsg = [];
        array_push($errormsg, "No skills selected or job name or description is empty");
    }

    if (!empty($errormsg)) {
        $_SESSION['jobCreateFailure']= $errormsg;
    }

    header("Location: ../screens/admin/viewJobRole.php");

?>