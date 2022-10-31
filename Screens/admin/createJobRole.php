<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create Job Roles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
  </head>
  <body>
  
    <?php
      $thisPage ='roles';
      include("../navbar/adminNavbar.php");
      ?>

    <div class="container-fluid">
        <div class="container mt-5">

            <h2>Create Job Role</h2>

            <form action="../../Admin/createJobRole.php" method="post">
                <div class="form-group">
                    <label for="formControlJobName">Job Name</label>
                    <textarea class="form-control" name="jobName" placeholder="Job Name"></textarea>
                </div>
        
                <div class="form-group">
                    <label for="formControlJobDesc">Job Description</label>
                    <textarea class="form-control" name="jobDesc" placeholder="Job Description"></textarea>
                </div>
        
                <div class="form-group">
                  
                    <label for="formControlJobSkills">Skills</label>
                    <select multiple class="form-control" name="jobSkills[]">
                    
                    <?php 
                        require_once '../../DAO/common.php';

                        $skillDAO = new SkillDAO();
                        $skillIdList = $skillDAO->getAllSkillId();
                        $skillNameList = $skillDAO->getAllSkillName();

                        foreach ($skillIdList as $skillId) {
                          $idx = $skillId - 1;
                          $skillName = $skillNameList[$idx];

                          echo "<option value=$skillId>$skillName</option>";
                        }
                        
                    ?>
                    </select>
                </div>
                
                
                <button type="submit" class="btn btn-primary" name="createRoles">Submit</button>
              </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
  </body>
</html>