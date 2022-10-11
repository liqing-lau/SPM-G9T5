<?php 
require("connection.php"); 


$jobRole = "General Manager";
$sql = "SELECT * FROM jobrole WHERE JRole_Name='$jobRole';";
$result = $mysqli->query($sql);
$mysqli->close();

while($rows=$result->fetch_assoc()){
	$jobRoleName =  $rows['JRole_Name'];
	$jobRoleDesc =  $rows['JRole_Desc'];
	$jobRoleID = $rows['JRole_ID'];
}

?>

<!doctype html>
<html lang="en">
  <head>
  	<title>Table 09</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link href='https://fonts.googleapis.com/css?family=Roboto:400,100,300,700' rel='stylesheet' type='text/css'>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
	<link rel="stylesheet" href="css/style.css">

	</head>
	<body>
	<section class="ftco-section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-6 text-center mb-5">
					<h2 class="heading-section"><?php echo $jobRoleName ?></h2>
					<h2 class="heading-section"><?php echo $jobRoleDesc ?></h2>
					<h2 class="heading-section"><?php echo $jobRoleID ?></h2>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="table-wrap">
						<table class="table table-striped">
						  <thead>
						    <tr>
						      <th>Skill</th>
						      <th>Courses</th>
						      
						    </tr>
						  </thead>
						  <tbody>
							<!-- PHP CODE TO FETCH DATA FROM ROWS -->
							<?php
							require("connection.php"); 

							$getSkill = "SELECT S.Skill_Name FROM jobskill J, skill S WHERE J.Skill_ID = S.Skill_ID AND J.JRole_ID = $jobRoleID;";
							$skillList = $mysqli->query($getSkill);
							$mysqli->close();
                			// LOOP TILL END OF DATA
                			while($rows=$skillList->fetch_assoc())
                			{
								$skillName = $rows['Skill_Name'];
            				?>
						    <tr>
								<!-- FETCHING DATA FROM EACH ROW OF EVERY COLUMN -->
						      <th scope="row"><?php echo $skillName;
							  
							  require("connection.php"); 

							$getCourse = "SELECT * FROM courseskill C, skill S WHERE C.Skill_ID = S.Skill_ID AND S.Skill_Name = '$skillName';";
							$courseList = $mysqli->query($getCourse);
							$mysqli->close();
                			// LOOP TILL END OF DATA
                			while($rows=$courseList->fetch_assoc())
                			{
								$courseID = $rows['Course_ID'];


							  ?></th>
							  
						      <td><?php echo $courseID ?></td>
						      
						      <td><a href="#" class="btn btn-success">Edit Courses</a></td>
						    </tr>
							<?php
                }
			}
            ?>
						  </tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="js/jquery.min.js"></script>
  <script src="js/popper.js"></script>
  <script src="js/bootstrap.min.js"></script>
  <script src="js/main.js"></script>

	</body>
</html>

