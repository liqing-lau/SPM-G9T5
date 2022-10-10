<?php

require_once 'common.php';

class SkillDAO {

    public function create($skill_name) {

        $connMgr = new ConnectionManager();
        $conn = $connMgr->connect();

        $sql = "insert into skill
                    (Skill_Name)
                    values
                    (:skill_name)";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':skill_name', $skill_name, PDO::PARAM_STR);

        $status = $stmt->execute();

        $stmt = null;
        $conn = null;

        return $status;
    }
}

?>