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
    $jDesc=$_POST['jobDesc'];
    $page = 'Location: ../screens/user/selectcourses.php?addjobrole=' . $jid.'&jobName='.$jName.'&jobDesc='.$jDesc;
    header($page);
    exit();
}


?>