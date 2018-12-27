<?php
	
	session_start();
	require('../connection.php');
	
	//If your session isn't valid, it returns you to the login screen for protection
	if(empty($_SESSION['admin_id']))
	{
	 header("location:access-denied.php");
	}
	
	//retrive positions from the tbpositions table
	$mysqli = new mysqli('localhost','root','','poll');
	$sql1 = "SELECT * FROM tbpositions";
	$result1 = mysqli_query($mysqli, $sql1); //or die("There are no records to display ... \n" . mysqli_error()); 
	
	if (mysqli_num_rows($result1)<1)
	{
	    $result1 = null;
	}

?>

<?php
	
	// inserting sql query
    $mysqli = new mysqli('localhost','root','','poll');
	if (isset($_POST['Submit']))
	{
		$newPosition = addslashes( $_POST['position'] ); //prevents types of SQL injection
		$sql2 = "INSERT INTO tbpositions(position_name) VALUES ('$newPosition')";
		$result2 = mysqli_query($mysqli, $sql2); //or die("Could not insert position at the moment". mysqli_error());
		// redirect back to positions
		header("location: positions.php");
	}

?>
<?php
	
	// deleting sql query
	// check if the 'id' variable is set in URL
	if (isset($_GET['id']))
	{
	 // get id value
	 $id = $_GET['id'];
	 
	 // delete the entry
	 $sql3 = "DELETE FROM tbpositions WHERE position_id='$id'";
	 $result3 = mysqli_query($mysqli, $sql3); //or die("The position does not exist ... \n"); 

	 // redirect back to positions
	 header("location: positions.php");
	}
	  
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Positions</title>
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
              <li class="active"><a href="positions.php">Manage Positions</a></li>
              <li><a href="candidates.php">Manage Candidates</a></li>
              <li><a href="refresh.php">Poll Results</a></li>
              <li><a href="index.php">Logout</a></li>
            </ul>
          </div>
        </nav>
		
		<div class="container-fluid text center">
			<div class="row content">
				<div class="col-lg-2">
					
				</div>
				<div class="col-lg-8">
					<div class="well contact-form-container">
						<form class="form-horizontal contactform" action="positions.php" method="post">
							<div class="row">
								<div class="col-lg-3">

								</div>
								<div class="col-lg-6">
									<div class="row">
										<div class="col-lg-3">
										</div>
										<div class="col-lg-6">
											<h4>ADD NEW POSITION</h4>
										</div>
										<div class="col-lg-3">
										</div>
									</div>
									<div class="row">
										<div class="col-lg-3">
											<h5>Position Name</h5>
										</div>
										<div class="col-lg-6">
											<input class="form-control" type="text" name="position" />
										</div>
										<div class="col-lg-3">
											<input class="btn btn-success" type="submit" name="Submit" value="Add" />
										</div>
									</div>
								</div>
								<div class="col-lg-3">

								</div>
							</div>
						</form>
						<form>
							<div class="row">
								<div class="col-lg-3">
									
								</div>
								<div class="col-lg-6">
									<div class="row">
										<div class="col-lg-3">

										</div>
										<div class="col-lg-6">
											<center>
												<h4>POSITIONS</h4>
											</center>											
										</div>
										<div class="col-lg-3">
										</div>
									</div>
								</div>
								<div class="col-lg-3">
										
								</div>
							</div>
							<div class="row">
								<div class="col-lg-4">
									<center>
										<b>ID</b>
									</center>
								</div>
								<div class="col-lg-4">
									<center>
										<b>Name</b>	
									</center>
								</div>
								<div class="col-lg-4">
									
								</div>
							</div>
							<div class="row">
                                <?php
                                    while ($row=mysqli_fetch_array($result1))
                                    {
                                        echo"<center>
                                        		<div class=col-lg-4>
                                            		$row[position_id]
                                        		</div>
                                        	</center>";
                                        echo "<center>
                                        		<div class=col-lg-4>
                                            		$row[position_name]
                                        		</div>
                                        	</center>";                                       
                                        echo'<center>
                                        		<div class=col-lg-4>
                                        			<a href="positions.php?id=' . $row['position_id'] . '">Remove Position</a>
                                        		</div>
                                        	</center>';                                        
                                    }
                                    mysqli_free_result($result1);
                                    mysqli_close($mysqli);
                                ?>
                            </div>
						</form>
					</div>
				</div>
				<div class="col-lg-2">
					
				</div>
			</div>
		</div>
	</body>
</html>