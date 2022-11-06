<?php

if (isset($_POST["viewJR"])) {
    $jid = $_POST["viewJR"];
    $page = 'Location: ../screens/user/viewRole.php?role=' . $jid;
    header($page);
    exit();
}

if (isset($_POST["addjobRole"])) {
    $jid = $_POST["addjobRole"];
    $jName=$_POST["jobName"];
    $page = 'Location: ../screens/user/selectcourses.php?addjobrole=' . $jid.'&jobName='.$jName;
    header($page);
    exit();
}

if (isset($_POST["viewSkills"])) {
    $jid = $_POST["viewSkills"];
    $page = "Location: #";
    // $page = 'Location: ../screens/user/viewRole.php?viewSkills=' . $jid;
    header($page);
    exit();
}

?>