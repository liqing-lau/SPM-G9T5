<nav class="navbar navbar-expand-md bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="../login.html">LJMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link <?php if (isset($thisPage) && $thisPage == 'lj') {echo 'active aria-current="page"';}?> " href="../../screens/user/homepage.php">My Learning Journey</a>
        <a class="nav-link <?php if (isset($thisPage) && $thisPage == 'roles') {echo 'active aria-current="page"';}?> " href="../../screens/user/allRoles.php">All Roles</a>
        <a class="nav-link <?php if (isset($thisPage) && $thisPage == 'courses') {echo 'active aria-current="page"';}?> " href="../user/viewCourse.php">All Courses</a>
      </div>
      <div class="nav-items text-right ms-auto">
        <?php 
          $id = $_COOKIE['empId'];
          if (isset($_COOKIE['admin'])) {
              echo "<form method='POST' action='../../Admin/authenticateAdmin.php'>
                      <input type='hidden' name='empId' value=$id>
                      <input type='submit' name='true' value='Admin' class=''></input>
                  </form>";
          }
        ?>
      </div>
    </div>
  </div>
</nav>