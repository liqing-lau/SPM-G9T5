<?php

    require_once '../DAO/common.php';

    $empId = $_POST['empId'];

    $adminDAO = new adminDAO();
    $admin = $adminDAO->isAdmin($empId);
    
    $toggleUser = isset($_POST['false']);

    $userDAO = new userDAO();
    $user = $userDAO->getUser($empId);
    $userFirstName = $user->getFirstName();
    $userRole = $user->getDept();

    if (!$admin) {
        echo "You are not authorised to see this page, $userFirstName ($userRole)";
    } else if (!$toggleUser) {
        echo "You are not authorised to see this page, $userFirstName ($userRole, User)";
        echo "<form method='post'>
                <input type='hidden' name='empId' value=$empId>
                <input type='submit' name='false' value='Change to Admin'></input>
                </form>";
    } else {
        echo "Welcome $userFirstName ($userRole, Admin)";
        echo "<form method='post'>
                <input type='hidden' name='empId' value=$empId>
                <input type='submit' name='true' value='Change to User'></input>
                </form>";
    }
    
?>