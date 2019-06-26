<?php require_once 'controllers/authController.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Boostrap 4 CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <title>Forgot Password</title>
    </head>
    <body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 offset-md-4">
            <form action="sendmail.php" method="post">
            <h3 class="text center">Forgot Password</h3>
            
             <?php if(isset($_SESSION['success_message'])){ ?>
            <div class="alert alert-success">
                <li><?php echo $_SESSION['success_message']; ?></li>
               <?php unset($_SESSION['success_message']); ?>
            </div>
            <?php }  ?>

  <?php if(isset($_SESSION['errors'])){ ?>
            <div class="alert alert-danger">
                <li><?php echo $_SESSION['errors']; ?></li>
               <?php unset($_SESSION['errors']); ?>
            </div>
            <?php }  ?>

           
         

            <div class="form-group">
                <label for="username">Email</label>
                <input type="text" name="useremail" class="form-control form-control-lg" required>
            </div>
            

            <div class="form-group">
            <button type="submit" name="forgot-btn" class="btn btn-primary btn-block btn-lg">Submit</button>
            </div>
            <p class="text-center"><a href="login.php">Login</a></p>
            </form>
            </div>
        </div>
    </div>        



    </body>
    </html>