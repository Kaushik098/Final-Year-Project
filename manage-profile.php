<?php
    session_start();

    $mysqli = new mysqli('localhost','root','','poll');

    //If your session isn't valid, it returns you to the login screen for protection
    if(empty($_SESSION['member_id']))
    {
        header("location:access-denied.php");
    }

    //retrive student details from the tbmembers table
    $sqlm = "SELECT * FROM tbmembers WHERE member_id = '$_SESSION[member_id]'";
    $result = mysqli_query($mysqli, $sqlm); //or die("There are no records to display ... \n" . mysqli_error()); 
    
    if (mysqli_num_rows($result)<1)
    {
        $result = null;
    }
    
    $row = mysqli_fetch_array($result);
    
    if($row)
    {
        // get data from db
        $stdId = $row['member_id'];
        $firstName = $row['first_name'];
        $lastName = $row['last_name'];
        $email = $row['email'];
    }
?>

<?php
    // updating sql query
    if (isset($_POST['update']))
    {
        
        //$myId = addslashes($stdId);
        $query = "SELECT password from tbmembers where email='$email'";
        $up_result = mysqli_query($mysqli,$query);
        $up_row=mysqli_fetch_array($up_result);
        
        $old = $_POST['oldpassword'];
        $encold = md5($old);
        
        // echo $up_row['password'];
        // echo "\n$encold";
        if($encold==$up_row['password'])
        {
            $myPassword = $_POST['password'];
            $myconfirmpassword = $_POST['ConfirmPassword'];
            
            if($myPassword==$myconfirmpassword)
            {
                $newpass = md5($myPassword); //This will make your password encrypted into md5, a high security hash
                $sqlu = "UPDATE tbmembers SET password='$newpass' WHERE member_id = '$stdId'";
                $sql = mysqli_query($mysqli, $sqlu); //or die( mysqli_error() );
                // redirect back to profile
                echo "<div class='alert alert-success'>Password Updated Successfully!</div>";
                //header("location: manage-profile.php");
            }
            else
            {
             echo "<div class='alert alert-danger'>Password Mismatch</div>";
            }
        }
        else
        {
            echo "<div class='alert alert-danger'>OldPassword does not match!</div>";
        }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Voter Profile Management</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            body
            {
                background-image: url(images/Background.jpg);
                background-repeat: no-repeat;
                opacity: 0.6;
            }
            #header
            {
                text-align: center;
                color: white;
            }
        </style>
    </head>
    <body>         
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="home.php">Voting</a>
            </div>
            <ul class="nav navbar-nav">
              <li><a href="vote.php">Current Polls</a></li>
              <li class="active"><a href="manage-profile.php">Manage Account</a></li>
              <li><a href="index.php">Logout</a></li>
            </ul>
          </div>
        </nav>

        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-lg-1">
                </div>

                <div class="col-lg-10"> 
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="col-lg-12">
                                <div class="well contact-form-container">
                                    <form class="form-horizontal contactform" action="manage-profile.php" method="post"> 
                                        <div class="row">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <h4>MY PROFILE</h3>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>Voter Id:</label>
                                                </div> 
                                                <div class="col-lg-6">
                                                    <?php echo $stdId; ?>
                                                </div>                                           
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>First Name:</label>
                                                </div>

                                                <div class="col-lg-6">
                                                    <?php echo $firstName; ?>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>Last Name:</label>
                                                </div>

                                                <div class="col-lg-6">
                                                    <?php echo $lastName; ?>
                                                </div>
                                            </div>
                                            <br>
                                            <div class="row">
                                                <div class="col-lg-6">
                                                    <label>Email:</label>
                                                </div>
                                                <div class="col-lg-6">
                                                    <?php echo $email; ?>
                                                </div>
                                            </div>
                                            <br>
                                            <br>                                                                                                        
                                        </div>                             
                                    </form>
                                </div>
                            </div>
                        </div> 
                        <div class="col-lg-6">
                            <div class="col-lg-12">
                                <div class="well contact-form-container">
                                    <form class="form-horizontal contactform" action="manage-profile.php" method="post">                                         
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <h4>UPDATE PROFILE</h3>
                                            </div>
                                        </div>
                                        <div class="row">

                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label>Old Password:</label>
                                            </div>

                                            <div class="col-lg-5">
                                                <input class="form-control" type="password" name="oldpassword" required/>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                <label>New Password:</label>
                                            </div>

                                            <div class="col-lg-5">
                                                <input class="form-control" type="password" name="password" required>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-lg-6">
                                                    <label>Confirm New Password:</label>
                                            </div>

                                            <div class="col-lg-5">
                                                <input class="form-control" type="password" name="ConfirmPassword" required>
                                            </div>
                                        </div>
                                        <br>                               
                                        <div class="row">
                                            <div class="col-lg-12">
                                                <input class="btn btn-primary" type="submit" name="update" value="UPDATE">
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                
                                            </div>
                                        </div>  
                                        <div class="row">
                                            <div class="col-lg-12">
                                                
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-lg-12">
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-lg-12">
                                                
                                            </div>
                                        </div>                                           
                                    </form>
                                </div>
                            </div>
                        </div>                                           
                    </div>
                </div>

                <div class="col-lg-1">
                </div>

            </div>
        </div>
    </body>
</html>