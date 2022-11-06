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

<div class="container">

<div class="card">
    <div class="card-header text-center">
      <h1>Select 1 Job Role to embark on a new Learning Journey</h1>
    </div>

    <div class="card-body">
        <div class="container">

        <table class="table">
          <thead>
            <tr>
              <th>Selected</th>
              <th>Job Role ID</th>
              <th>Job Role Name</th>
              <th style='width:70%'> Job Role Description </th>
            </tr>
          </thead>
          <tbody>
          <?php 
            foreach($allRoles as $role){
                $tid = $role->getId();
                echo "<tr> <td>
                <input type='radio' name='selectedRole' value = '$tid'> </td>
                <td>{$role->getID()}</td>
                <td style='width:10%'>{$role->getName()}</td>
                <td>{$role->getDesc()}</td>";
            }
          ?>
          </tbody>
        </table>


        <button type='submit' name = 'r_select' class='btn btn-outline-primary'>Add Role</button>
        </div>

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

  $new_lj = new ljDAO();
  $createlj = $new_lj->createLJ($sid, $sr);
  ?>
  <script type="text/javascript">
window.location.href = 'selectcourses.php';
</script>
  <?php
}

?>