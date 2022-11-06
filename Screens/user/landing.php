
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
    <?php include("../navbar/userNavbar.php");
    require_once("../../DAO/common.php");

    if(isset($_POST['yes'])){
      $dljid = $_POST['ljid'];
      $djname = $_POST['jname'];
      echo '<div class="alert alert-success alert-dismissible" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      <strong>Successfully Deleted Learning Journey (ID: '.$dljid.') for Job Role: '.$djname.'</strong><br>' . '
      </div>';
      $ljn = new ljDAO();
      $ljdelete = $ljn->deleteLJ($dljid);
    }

    elseif(isset($_POST['no'])){
      echo '<div class="alert alert-warning alert-dismissible" role="alert">
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      <strong>Cancelled deletion</strong>
      </div>';
    }

    session_start();
    if(isset($_SESSION["createLJ"])){
      echo '<div class="alert alert-success alert-dismissible" role="alert">
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          <strong>Success!</strong><br>'. $_SESSION["createLJ"] . '
          </div>';
    }
    session_destroy();

?>    

    <div class="text-right fixed-bottom">
         <a href='selectrole.php' class='btn btn-outline-primary' role='button'>Create New Learning Journey</a>
    </div>
    
    <div>
        <?php
          require_once("../../class/jobRole.php");
          require_once("../../class/lj.php");
          require_once "../../DAO/common.php";

        $ljdao = new ljDAO();
        $ljs = $ljdao->getLJ($_COOKIE["empId"]);
        // print_r ($ljs);

        if(count($ljs) > 0 ){
          
        $ljID = [];
        $jobroleID=[];
        foreach ($ljs as $lj){
          array_push($ljID, $lj[1] );
          array_push($jobroleID, $lj[2]);
        }

        $jobroledao= new jobRoleDAO();
        $jobroles = $jobroledao-> getAll(); 

       
        $jobrolename=[];
        foreach($jobroleID as $ID){
            foreach($jobroles as $jobrole){

              if($ID== $jobrole->getId()){
                array_push($jobrolename, $jobrole->getName() );
              }
            
          }
        }
      
        // print_r($ljID);
        // print_r($jobrolename);

      $lj_display=[];
      for ($i=0 ; $i < count($ljID) ; $i++){
        $lj_display[$ljID[$i]] = $jobrolename[$i];
      }

      // print_r($lj_display);
      foreach($lj_display as $key => $value){
        echo "
        <form action = 'ljdetail.php' method = 'POST'>
        <div class='card' style='width: 18rem;'>
          <div class='card-body'>
            <h5 class='card-title'>
              Learning Journey ID: $key
            </h5>
            <p class='card-text'>$value</p>
            <input type='submit' name = 'ljdata' value='LJ Details: $key'>
            
          </div>
        </div>
        <form>";
        }

    }
    
      else{
              echo "You currently do not have any Learning Journeys";

      }
        ?>
    </div>

</body>
</html>