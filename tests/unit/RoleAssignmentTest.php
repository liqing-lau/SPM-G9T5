<?php
// use App\Admin\roleAssignment;
// use PHPUnit\Framework\TestCase;
// class RoleAssignmentTest extends TestCase {

//     public function testAddRoleAssignment() {
//         $url = "../../app/Admin/roleAssignment.php";
//         $formData = [
//             'skillId' => 1,
//             'roleId' => [1,2,3],
//             'roleList' => 2
//         ];
//         $formString = http_build_query($formData);

//         //open connection
//         $ch = curl_init();
//         curl_setopt($ch,CURLOPT_URL, $url);
//         curl_setopt($ch,CURLOPT_POST, true);
//         curl_setopt($ch,CURLOPT_POSTFIELDS, $formString);

//         curl_setopt($ch,CURLOPT_RETURNTRANSFER, false);
       
//         $result = curl_exec($ch);

//         echo isset($_SESSION['skillId']);

//         $expected = "Success!
//                     Successfully added Business Performance management to:
//                     1. Sales Rep
//                     2. Operations Manager";

//         $this->assertEquals($result, $expected);
        
//     }
// }

?>