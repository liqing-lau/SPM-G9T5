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
    $thisPage = '';
    include("../navbar/userNavbar.php");
    
    session_start();
    $LJ_ID = $_SESSION['LJ_ID'];
    ?>
    
    <div class="container">
        <div class="container p-2">
            Nothing has been changed!
        </div>

        <div class='container'>
            <form action='ljdetail.php' method='POST'>
            <input type='hidden' name='ljdata' value='<?php echo $LJ_ID;?>'>
            <button type='submit' name='pass_on' class='btn btn-primary'>
                Return to LJ Details
            </button>
        </form>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>