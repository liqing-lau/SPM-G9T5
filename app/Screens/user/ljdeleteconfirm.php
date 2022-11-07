<!DOCTYPE html>
<html lang="en">
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>View all Learning Journey</title>
</head>
<body>
    <?php 
        $thisPage = 'lj';
        include("../navbar/userNavbar.php");?>
    <div class="container m-3">
        <div class="container p-2">
            <?php
                if(isset($_POST['confirm'])){
                $ljid = $_POST['ljid'];
                $jname = $_POST['jname'];
                echo "Delete Learning Journey $ljid for JobRole : $jname ?";
                }
            
            echo "<form action='./homepage.php' method = 'POST'>
                <input type = 'hidden' name = 'ljid' value = '$ljid'>
                <input type = 'hidden' name = 'jname' value = '$jname'>
                <button type='submit' class='btn btn-danger' name='yes' >Delete LJ</button>
            </form>";
            ?>
        </div>
        
        <div class="container p-2">
            <form action='./homepage.php' method = 'POST'>
                <button type='submit' class="btn btn-primary" name='no' value = '0'>Cancel</button>
            </form>
        </div>

</html>