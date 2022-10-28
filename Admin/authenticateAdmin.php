<?php

    require_once '../DAO/common.php';

    $empId = $_POST["empId"];

    $adminDAO = new adminDAO();
    $admin = $adminDAO->isAdmin($empId);
    
    $toggleUser = isset($_POST['false']);

    $userDAO = new userDAO();
    $user = $userDAO->getUser($empId);
    $userFirstName = $user->getFirstName();
    $userRole = $user->getDept();

    if (!$admin) {
        header("Location: ../screens/userHomepage.php?empId=$empId&a=$admin");
        exit();
    } else if (!$toggleUser) {
        header("Location: ../screens/adminHomepage.php?empId=$empId&a=$admin");
        exit();
    } else {
        header("Location: ../screens/userHomepage.php?empId=$empId&a=$admin");
        exit();
    }
    
?>