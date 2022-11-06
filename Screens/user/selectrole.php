<?php
    require_once("../../class/jobRole.php");
    require_once("../../class/lj.php");
    require_once "../../DAO/common.php";

    $dao = new jobRoleDAO();
    $allRoles = $dao->getAll();

?>
<html lang="en">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>User Select Roles</title>
</head>
<body>
    <?php include("../navbar/userNavbar.php");?>

<form method="POST" action="selectrole.php">

<h1>Select 1 Job Role to embark on a new Learning Journey</h1>

<table border='1'>
<tr>
    <th>Selected</th>
    <th>Job Role ID</th>
    <th>Job Role Name</th>
    <th style='width:70%'> Job Role Description </th>
</tr>

<?php 
foreach($allRoles as $role){
    $tid = $role->getId();
    $tName=$role->getName();
    echo "<tr> <td>
    <input type='radio' name='selectedRole' value = '$tid'>
    <input type='hidden' name='JRole_Name' value='$tName'> </td>
    <td>{$role->getID()}</td>
    <td style='width:10%'>{$role->getName()}</td>
    <td>{$role->getDesc()}</td>";
}
?>

</table>


<input type='submit' value='Add Role' name = 'r_select'/>


</form>
</html>
<?php
ob_start();
require_once "../../DAO/common.php";

if(isset($_POST["r_select"])){

  if(empty($_POST["selectedRole"])){
    exit( "Please select 1 Job Role to create new Learning Journey");
  }

  $sid = $_COOKIE["empId"];
  $sr = $_POST["selectedRole"];
  $sname=$_POST["JRole_Name"];

  //Cannot create new LJ without selecting courses
  // $new_lj = new ljDAO();
  // $createlj = $new_lj->createLJ($sid, $sr);
  
  $url='selectcourses.php?addjobrole=' . $sr.'&jobName='.$sname;
  echo "<input type='hidden' value='$url' name='redirect' id='redirect'>"
  ?>
  <script>
    var redirecturl=document.getElementById('redirect').value;
window.location.href = redirecturl;
</script>
  <?php
}

?>