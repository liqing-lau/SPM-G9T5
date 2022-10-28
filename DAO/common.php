<?php
spl_autoload_register(
    function ($class){
        $class=(string)$class;
        require_once  "$class.php";
    }
);
?>