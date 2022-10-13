<?php
class jobRoleDAO {
    public function retrieveAll() {
        $connMgr = new ConnectionManager();      
        $pdo = $connMgr->connect();  
	  	$sql = 'SELECT * FROM jobRole';    
        $stmt = $pdo->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $result = [];
        while($row = $stmt->fetch()) {
            $result[] = new jobRole($row['JRole_ID'], $row['JRole_Name'],$row['JRole_Desc']);
        }
        $stmt->closeCursor();
        $pdo = null;
        return $result;
    }
}
?>