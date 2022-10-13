<?php

require_once 'common.php';

class JobroleDAO {

    public function getIDandName() {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "select JRole_ID, JRole_Name from jobrole;";
        $namelist = [];
        

        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);

        while( $row = $stmt->fetch() ) {
            $row_id = $row['JRole_ID'];
            $row_name = $row['JRole_Name'];
            array_push($namelist,[$row_id,$row_name]);
        }
        $stmt = null;
        $conn = null;

        return $namelist;
    }
}

?>