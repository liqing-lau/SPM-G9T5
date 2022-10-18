<?php

    require_once '../DAO/common.php';

    $empId = $_POST['empId'];

    $adminDAO = new adminDAO();
    $admin = $adminDAO->isAdmin($empId);

    $userDAO = new userDAO();
    $user = $userDAO->getUser($empId);
    $userFirstName = $user->getFirstName();
    $userRole = $user->getDept();

    if (!$admin) {
        echo "You are not authorised to see this page, $userFirstName ($userRole)";
    } else {
        
        echo "Welcome $userFirstName ($userRole)";
    }
    
?>
