
<?php
     require_once "../DAO/common.php";

     $dao = new jobRoleDAO();
     $allRoles = $dao->getAll();

    echo "<table border=1>
        <tr>
        <th>Job Role ID</th>
        <th>Job Role Name</th>
        <th style='width:70%' > Job Role Description </th>
        </tr>";

    $ljdao = new ljDAO();
    $ljs = $ljdao->retrieveAll(); //get the ljid staffID jroleID etc


    foreach($allRoles as $role){
        $added_role= False; //default display add role button
        echo "<tr>";
        echo "<td>" . $role->getID() . "</td>";
        echo "<td style='width:10%'> ". $role->getName() . "</td>";
        echo "<td>" . $role->getDesc() . " </td>";
          
        //check if the roleID exists in the lj table 
        foreach($ljs as $lj){
            $lj_role = $lj->getJRole_ID();
            $role_displayed = $role->getID();
            if( $lj_role == $role_displayed){
                $added_role=True;
            }
        }

        echo "<form action='' > ";
        if($added_role == True){
            echo "<td>ALREADY ADDED </td>";
        }
        else{
            echo "<td><input type='submit' name='addjobRole' value='ADD ROLE'/>
            </td>";
        }
       
        echo "<td><input type='submit' name='viewSkills' value='VIEW SKILLS'/>
        </form></td>";
        echo "</tr>";
    }


    echo "</table>"
?>