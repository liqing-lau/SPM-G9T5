<?php
    spl_autoload_register(
        function($class){
            require_once "$class.php";
        }
    );

    $dao= new jobRoleDAO();
    $listJR= $dao->getAll();

    $final_list=[];

    foreach($listJR as $item){
            array_push($final_list,[$item->getId(), $item->getName(), $item->getDesc()]);
    }

    var_dump($final_list);
?>