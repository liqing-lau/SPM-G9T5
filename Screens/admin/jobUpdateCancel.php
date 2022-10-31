<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Document</title>
</head>
<body>
    <?php 
    session_start();
    $thisPage = 'roles';
    include("../navbar/adminNavbar.php");?>

    <div class="container m-3">
        <div class="container p-2">
            <?php
                if($_SESSION["cancelUpdate"]) {
                    echo "<h5>Are you sure you want to cancel updates?</h5>";
                } else {
                    echo "Job Role requires at least 1 skill.<br>
                    Please check at least one skill if you want to continue updating";
                }
            ?>
            <form action='../../Admin/jobRoleUpdate.php'>
                <button type='submit' class="btn btn-primary" name='return'> Continue Updating</button>
            </form>
        </div>
        
        <div class="container p-2">
            <?php
                if(!$_SESSION['cancelUpdate']) {
                    echo "<p>Or you can cancel updates and return to Job Role Main Page</p>";
                }
            ?>
            <form action='./viewJobRole.php' action='POST'>
                <?php
                    $_SESSION['noUpdate'] =  "No changes made to " .$_SESSION['JRole_Name'];
                ?>
                <button type='submit' class="btn btn-danger" name='exit'>Cancel Updates</button>
            </form>
        </div>

        

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>