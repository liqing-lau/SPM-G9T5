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

    setcookie("fName", $userFirstName, time() + (86400 * 365), "/");

    if (!$admin) {
        header("Location: ../screens/user/homepage.php?");
        exit();
    } else if (!$toggleUser) {
        header("Location: ../screens/admin/homepage.php?");
        exit();
    } else {
        header("Location: ../screens/user/homepage.php?");
        exit();
    }
    
?>