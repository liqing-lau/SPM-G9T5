<nav class="navbar navbar-expand-md bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="../../screens/login.html">LJMS</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
      <div class="navbar-nav">
        <a class="nav-link <?php if (isset($thisPage) && $thisPage == 'roles') {echo 'active aria-current="page"';}?> " href="../admin/viewJobRole.php">Roles</a>
        <a class="nav-link <?php if (isset($thisPage) && $thisPage == 'skills') {echo 'active aria-current="page"';}?> " href="../admin/viewSkills.php">Skills</a>
        <a class="nav-link <?php if (isset($thisPage) && $thisPage == 'courses') {echo 'active aria-current="page"';}?> " href="../admin/viewCourse.php">Courses</a>
      </div>
      <div class="nav-items text-right ms-auto">
      <?php 
          $id = $_COOKIE['empId'];
          echo "<form method='POST' action='../../Admin/authenticateAdmin.php' >
                  <input type='hidden' name='empId' value=$id>
                  <input type='submit' name='false' value='User' ></input>
              </form>";
        ?>
      </div>
    </div>

  </div>
</nav>