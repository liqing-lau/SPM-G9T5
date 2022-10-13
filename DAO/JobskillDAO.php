<?php

require_once 'common.php';

class JobskillDAO {

    public function create($jrole_id, $skill_id) {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "insert into jobskill
                    (JRole_ID, Skill_ID)
                    values
                    (:jrole_id, :skill_id)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':jrole_id', $jrole_id, PDO::PARAM_INT);
        $stmt->bindParam(':skill_id', $skill_id, PDO::PARAM_INT);

        $status = $stmt->execute();

        $stmt = null;
        $conn = null;

        return $status;
    }
}

?>