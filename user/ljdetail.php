<?php
session_start();
require_once "../DAO/common.php";
require_once "../DAO/ljDAO.php";

    if(isset($_POST['toEdit'])){
        $LJ_ID=$_POST['LJ_ID'];
        $_SESSION['LJ_ID']=$LJ_ID;
        if(!isset($_POST['edit_Course'])){
            header('Location: ../screens/user/noCourseSelect.php');
            exit();
        }

        else{
            $courses_checked=$_POST['edit_Course'];
            $these_Courses=[];

            foreach($courses_checked as $eachChecked){
                if(in_array($eachChecked,$these_Courses)==false){
                    array_push($these_Courses,$eachChecked);
                }
            }

            $new_lj= new ljDAO();
            $existing_Courses=$new_lj->getLJCoursebyLJID($LJ_ID);
            
            $toadd=[];
            foreach($these_Courses as $added){
                if(in_array($added,$existing_Courses)==false){
                    array_push($toadd,$added);
                }
            }

            $toremove=[];
            foreach($existing_Courses as $old){
                if(in_array($old,$these_Courses)==false){
                    array_push($toremove,$old);
                }
            }
            
            if($toadd==[]&&$toremove==[]){
                header('Location: ../screens/user/noChanges.php');
                exit(); 
            }

            $display=[];
            if($toadd!=[]){
                foreach($toadd as $add){
                    $result=$new_lj->addCoursetoLJ($LJ_ID,$add);
                    array_push($display,$result);
                }
            }

            if($toremove!=[]){
                foreach($toremove as $remove){
                    $result=$new_lj->delCoursefromLJ($LJ_ID,$remove);
                    array_push($display,$result);
                }
            }

            $display=implode("<br>",$display);
            $_SESSION['display'] = $display;
            header('Location: ../screens/user/changeSuccessfully.php');
        }

    exit();
}

?>