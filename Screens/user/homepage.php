
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
      include("../navbar/userNavbar.php");
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
  ?>
    <div class="container-flex ms-3 mt-2">
        <h3>
            Welcome back, <?php echo $name = $_COOKIE['fName'];?> [User]
        </h3>
    </div>
    <div class="container-flex ms-3 mt-2">
      <div class="text-right float-end">
          <a href='./selectrole.php' class='btn btn-outline-primary' role='button'>Create New Learning Journey</a>
      </div>
      
      <div>
          <?php
            require_once("../../class/jobRole.php");
            require_once("../../class/lj.php");

            $ljdao = new ljDAO();
            $ljs = $ljdao->getLJ($_COOKIE["empId"]);

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

          $lj_display=[];
          for ($i=0 ; $i < count($ljID) ; $i++){
            $lj_display[$ljID[$i]] = $jobrolename[$i];
          }

          echo "<div class='container m-2'>";

          foreach($lj_display as $key => $value){
            echo "
            <form action = './ljdetail.php' method = 'POST'>
            <div class='card  m-2' style='width: 18rem;'>
              <div class='card-body'>
                <h5 class='card-title'>
                  Learning Journey ID: $key
                </h5>
                <p class='card-text'>$value</p>
                <button type='submit' name='ljdata' value='$key' class='btn btn-outline-dark'>
                  LJ Details
                </button>
                
              </div>
            </div>
            <form>";
            }

        }
        
          else{
                  echo "You currently do not have any Learning Journeys";

          }
          echo "</div>";
          ?>
      </div>
    </div>

</body>
</html>