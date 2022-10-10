<?php
     spl_autoload_register(
        function($class){
            require_once "$class.php";
        }
     );
     $dao = new jobRoleDAO();
     $allRoles = $dao->retrieveAll();

    echo "<table border=1>
        <tr>
        <th>Job Role ID</th>
        <th>Job Role Name</th>
        <th style='width:70%' > Job Role Description </th>
        </tr>";

    foreach($allRoles as $role){
        echo "<tr>";
        echo "<td>" . $role->getID() . "</td>";
        echo "<td style='width:10%'> ". $role->getName() . "</td>";
        echo "<td>" . $role->getDesc() . " </td>";
        
        echo "<form action='//goes to create role screen' > 
        <td><input type='submit' name='addjobRole' value='ADD ROLE'/>
        </td>
        <td><input type='submit' name='viewSkills' value='VIEW SKILLS'/>
        </form></td>";
        echo "</tr>";
    }


    echo "</table>"
?>
