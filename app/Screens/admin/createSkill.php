<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <title>Skills</title>
</head>
<body>
    <?php 
    $thisPage = 'skills';
    include("../navbar/adminNavbar.php");?>

    <div class="container-fluid">
        <div class="container mt-5">

            <h2>Create Skill</h2>

            <form action="../../Admin/createSkill.php" method="POST">
                <div class="form-group">
                    <label for="formControlJobName">Skill Name</label>
                    <textarea class="form-control" name="skillName" placeholder="Skill Name" required minlength="2" maxlength="50"></textarea>
                </div>
        
                <div class="form-group">
                  
                    <label for="formControlJobSkills">Job</label>
                    <div style="border: 1px solid #ced4da; border-radius: 10px; height: 150px; overflow-y: scroll;">
                    
                    <?php 
                        require_once '../../DAO/common.php';

                        $jdata = new jobRoleDAO();
                        $jidname = $jdata->getIDandName();
                        foreach($jidname as $jr){
                            $jid = $jr[0];
                            $jname = $jr[1];
                            echo "<input type='checkbox' name='jrselect[]'' value='$jid'> $jname";
                            echo "<br>";
                        }
                        
                    ?>
                    </div>
                </div>
                
                
                <button type="submit" class="btn btn-primary" name="nskill">Submit</button>
              </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>

</body>
</html>