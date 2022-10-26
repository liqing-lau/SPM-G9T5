<?php
class ljDAO {
    public function retrieveAll() {
        $connMgr = new ConnectionManager();      
        $pdo = $connMgr->connect();  
	  	$sql = 'SELECT * FROM lj';    
        $stmt = $pdo->prepare($sql);
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $stmt->execute();

        $result = [];
        while($row = $stmt->fetch()) {
            $result[] = new lj($row['Staff_ID'], $row['LJ_ID'], $row['JRole_ID'], $row['Course_ID']);
        }
        $stmt->closeCursor();
        $pdo = null;
        return $result;
    }
}


?>