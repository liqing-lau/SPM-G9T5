<?php
require("connection.php");

// SQL query to select data from database
$sql = "SELECT * FROM skill;";
$result = $mysqli->query($sql);
$mysqli->close();



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
                    <h2 class="heading-section">Skill Table</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="table-wrap">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Skill ID</th>
                                    <th>Skill Name</th>
                                </tr>
                            </thead>
                            <tbody>

                                <!-- PHP CODE TO FETCH DATA FROM ROWS -->
                                <?php
                                // LOOP TILL END OF DATA
                                while ($rows = $result->fetch_assoc()) {
                                    $skillID = $rows['Skill_ID'];
                                    $skillName = $rows['Skill_Name'];
                                ?>
                                    <tr>

                                        <th scope="row"><?php echo $skillID; ?></th>
                                        <td><?php echo $skillName ?></td>
                                        <td><a href="#" class="btn btn-success">Update Skill</a></td>
                                        <td><a href="#" class="btn btn-warning">Delete Skill</a></td>
                                    </tr>

                                <?php
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