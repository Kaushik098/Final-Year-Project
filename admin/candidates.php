<?php
    
    session_start();
    require('../connection.php');
    
    //If your session isn't valid, it returns you to the login screen for protection
    if(empty($_SESSION['admin_id']))
    {
     header("location:access-denied.php");
    } 
    
    //retrive candidates from the tbcandidates table
    $mysqli = new mysqli('localhost','root','','poll');
    $sql1 = "SELECT * FROM tbcandidates";

    $result1 =mysqli_query($mysqli, $sql1); //or die("There are no records to display ... \n" . mysqli_error()); 
    
    if (mysqli_num_rows($result1)<1)
    {
        $result1 = null;
    }
    
?>

<?php
    
    // retrieving positions sql query
    $sql2 = "SELECT * FROM tbpositions";
    $result2 = mysqli_query($mysqli, $sql2); //or die("There are no records to display ... \n" . mysqli_error()); 

?>

<?php
    
    if (isset($_POST['Submit']))
    {
        $newCandidateName = addslashes( $_POST['candidate_name'] ); //prevents types of SQL injection
        $newCandidatePosition = addslashes( $_POST['candidate_position'] ); //prevents types of SQL injection

        // inserting the entry query
        $sql3 = "INSERT INTO tbcandidates(candidate_name,candidate_position) VALUES ('$newCandidateName','$newCandidatePosition')";
        $result3 = mysqli_query($mysqli, $sql3); //or die("Could not insert candidate at the moment". mysqli_error() );

        // redirect back to candidates
        header("location: candidates.php");
    }

?>

<?php
    
    // check if the 'id' variable is set in URL
    if (isset($_GET['id']))
    {
        // get id value
        $id = $_GET['id'];

        // deleting the entry query
        $sql4 = "DELETE FROM tbcandidates WHERE candidate_id='$id'";
        
        $result4 = mysqli_query($mysqli, $sql4); //or die("The candidate does not exist ... \n"); 

        // redirect back to candidates
        header("location: candidates.php");
    }
       
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
        <title>Candidates</title>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <style>
            body{
                background-image: url(images/Background.jpg);
                background-repeat: no-repeat;
                opacity: 0.6;
            }
            #header{
                text-align: center;
                color: white;
            }
        </style>
    </head>
    <body>
        <nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="admin.php">Voting</a>
            </div>
            <ul class="nav navbar-nav">
              <li><a href="manage-admins.php">Manage Administrators</a></li>
              <li><a href="positions.php">Manage Positions</a></li>
              <li class="active"><a href="candidates.php">Manage Candidates</a></li>
              <li><a href="refresh.php">Poll Results</a></li>
              <li><a href="index.php">Logout</a></li>
            </ul>
          </div>
        </nav>

        <div class="container-fluid text-center">    
            <div class="row content">
                <div class="col-lg-2">

                </div>
                <div class="col-lg-8"> 
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="well contact-form-container">
                                <form class="form-horizontal contactform" action="candidates.php" method="post"> 
                                    <div class="col-lg-3">
                                    
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="row">
                                            <div class=col-lg-12>
                                                <h4>ADD NEW CANDIDATE</h4>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class=col-lg-6>
                                                <h5>Candidate Name</h5>
                                            </div>
                                            <div class=col-lg-6>
                                                <input class="form-control" type="text" name="candidate_name" autocomplete="off" required/>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class=col-lg-6>
                                                <h5>Candidate Position</h5>
                                            </div>
                                            <div class=col-lg-6>
                                                <SELECT required class="form-control" name="candidate_position" id="candidate_position">
                                                    <OPTION VALUE="">--Select--
                                                    <?php
                                                        //loop through all table rows
                                                        while ($row=mysqli_fetch_array($result2))
                                                        {
                                                            echo "<OPTION VALUE=$row[position_name]>$row[position_name]";
                                                        }
                                                    ?>
                                                </SELECT>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class=col-lg-12>
                                                <input class="btn btn-success" type="submit" name="Submit" value="Add">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-3">

                                    </div>
                                </form>

                                <table border="0" width="620" align="center">
                                    <div class="row">
                                        <div class=col-lg-12>
                                            <h3>AVAILABLE CANDIDATES</h3>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class=col-lg-3>
                                            <h4>Candidate ID</h4>
                                        </div>
                                        <div class=col-lg-3>
                                            <h4>Candidate Name</h4>
                                        </div>
                                        <div class=col-lg-3>
                                            <h4>Candidate Position</h4>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <?php
                                            while ($row=mysqli_fetch_array($result1))
                                            {
                                                echo"<div class=col-lg-3>
                                                    $row[candidate_id]
                                                </div>";
                                                echo "<div class=col-lg-3>
                                                    $row[candidate_name]
                                                </div>";
                                                echo "<div class=col-lg-3>
                                                    $row[candidate_position]
                                                </div>";
                                                echo'<div class=col-lg-3>
                                                    <a href="candidates.php?id= '. $row['candidate_id'] . '">Remove Candidate</a></td>
                                                </div>';
                                            }
                                            mysqli_free_result($result1);
                                            mysqli_close($mysqli);
                                        ?>
                                    </div>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>  
                <div class="col-lg-2">

                </div>  
            </div>
        </div>
    </body>
</html>