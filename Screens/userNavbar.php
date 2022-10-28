<nav class="navbar navbar-expand-md bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">LJMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="../screens/userHomepage.php">My Learning Journey</a>
        <a class="nav-link" href="#">All Roles</a>
        <a class="nav-link" href="#">All Courses</a>
        <?php 
          $id = $_COOKIE['empId'];
          if (isset($_COOKIE['admin'])) {
              echo "<form method='POST' action='../Admin/authenticateAdmin.php' class='col-md-offset-100'>
                      <input type='hidden' name='empId' value=$id>
                      <input type='submit' name='true' value='Admin' class=''></input>
                  </form>";
          }
        ?>
        
      </div>
    </div>
  </div>
</nav>