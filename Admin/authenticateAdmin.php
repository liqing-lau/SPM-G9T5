<?php

    require_once '../DAO/common.php';

    $empId = $_POST["empId"];
    setcookie("empId", $empId, time() + (86400 * 365), "/");

    $adminDAO = new adminDAO();
    $admin = $adminDAO->isAdmin($empId);
    setcookie("admin", $admin, time() + (86400 * 365), "/");
    
    $toggleUser = isset($_POST['false']);

    $userDAO = new userDAO();
    $user = $userDAO->getUser($empId);
    $userFirstName = $user->getFirstName();
    $userRole = $user->getDept();

    if (!$admin) {
        header("Location: ../screens/userHomepage.php?");
        exit();
    } else if (!$toggleUser) {
        header("Location: ../screens/adminHomepage.php?");
        exit();
    } else {
        header("Location: ../screens/userHomepage.php?");
        exit();
    }
    
?>