<?php

require_once '../Admin/authenticateAdmin.php';
require_once 'common.php';

class adminDAO{

    public function isAdmin($empId) {
        
        $sql = "SELECT * FROM staff where Staff_ID = :empId";

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':empId', $empId, PDO::PARAM_INT);
        
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $status = false;

        if($row = $stmt->fetch()) {
            $admin = $row['Role'];

            if ($admin == "1") {
                $status = true;
            }

        }

        $stmt = null;
        $conn = null;

        return $status;
    }

}