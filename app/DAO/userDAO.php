<?php
use app\classes\User;

require_once 'common.php';
require_once '../classes/user.php';
class userDAO {
    public function getUser($empId) {
        $sql = "SELECT * FROM staff where Staff_ID = :empId";

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':empId', $empId, PDO::PARAM_INT);
        
        $stmt->execute();

        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        
        $status = false;

        if($row = $stmt->fetch()) {
            $user = new User($row['Staff_ID'], $row['Staff_FName'], $row['Staff_LName'],$row['Dept'],$row['Email'],$row['Role']);
        }

        $stmt = null;
        $conn = null;

        return $user;
    }
}

?>