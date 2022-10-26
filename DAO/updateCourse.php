<?php
require_once("../DAO/common.php");

$JRole_ID = 14;
$Staff_ID = 130001;
$LJ_ID = 2;

$dao = new ljDAO();

if(isset($_POST['addCourse'])){

    if($dao->checkEmptyLJ($JRole_ID) === "1"){
        foreach($_POST['corSelect'] as $courseID){

            $dao->updateCourseForLJ($Staff_ID,$LJ_ID,$JRole_ID,$courseID);

        }
    }else{
        foreach($_POST['corSelect'] as $courseID){

            $dao->insertCourseForLJ($Staff_ID,$LJ_ID,$JRole_ID,$courseID);

        }
    }
    
   }

$ljList = $dao->getLJ($Staff_ID);
var_dump($ljList);

$notTakenCourseList = $dao->getCourseNotTaken($LJ_ID);
var_dump($notTakenCourseList);

$count = $dao->checkEmptyLJ($JRole_ID);
var_dump($count);

?>

<html>
<form action="updateCourse.php" method="POST">

    
    <br>
    Select Course Checkbox:
    <br>
    <?php
    foreach ($notTakenCourseList as $courseArray) {
        $corID = $courseArray[0];
        $corName = $courseArray[1];
        echo "
                <input type='checkbox' name='corSelect[]' value = '$corID'>$corID - $corName <br>
            ";

    }
    ?>

    <br>

    <input type="submit" value="Add Course" name="addCourse" />





</form>

</html>

<?php 
//    require_once '../DAO/common.php';

//    $dao = new ljDAO();

//    if(isset($_POST['addCourse'])){

//     if($dao->checkEmptyLJ($JRole_ID) === "1"){
//         foreach($_POST['corSelect'] as $courseID){

//             $dao->updateCourseForLJ($Staff_ID,$LJ_ID,$JRole_ID,$courseID);

//         }
//     }else{
//         foreach($_POST['corSelect'] as $courseID){

//             $dao->insertCourseForLJ($Staff_ID,$LJ_ID,$JRole_ID,$courseID);

//         }
//     }
    
//    }

   ?>

