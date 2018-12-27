<?php
	session_start();
	require('../connection.php');
?>

<html>
	<head>
		<title>Admin</title>
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
	    <?php
			
			//If your session isn't valid, it returns you to the login screen for protection
		    $mysqli = new mysqli('localhost','root','','poll');
			
			if(empty($_SESSION['admin_id']))
			{
			 header("location:access-denied.php");
			}
			
			//Process
			if (isset($_POST['create']))
			{
				$FirstName = addslashes( $_POST['first_name'] ); //prevents types of SQL injection
				$LastName = addslashes( $_POST['last_name'] ); //prevents types of SQL injection
				$Email = $_POST['email'];
				$Password = $_POST['password'];
				$newpass = md5($Password); //This will make your password encrypted into md5, a high security hash
				$sql1 ="INSERT INTO tbadministrators(first_name, last_name, email, password) VALUES ('$FirstName','$LastName', '$Email', '$newpass')";
				$result1 = mysqli_query($mysqli, $sql1); //or die( mysqli_error() );
				echo "<div class='alert alert-success'>Admin Created</div>";
				//die( "A new administrator account has been created." );
			}
			
			//Process
			if (isset($_GET['id']) && isset($_POST['update']))
			{
				$Id = addslashes( $_GET['id']);
				$FirstName = addslashes( $_POST['first_name'] ); //prevents types of SQL injection
				$LastName = addslashes( $_POST['last_name'] ); //prevents types of SQL injection
				$Email = $_POST['email'];
				$Password = $_POST['password'];
				$newpass = md5($Password); //This will make your password encrypted into md5, a high security hash
				$sql2 = "UPDATE tbadministrators SET first_name='$FirstName', last_name='$LastName', email='$Email', password='$newpass' WHERE admin_id = '$Id'";
				$result2 = mysqli_query($mysqli, $sql2); //or die( mysqli_error() );
				echo "<div class='alert alert-success'>Account has been Successfully Updated!!</div>";
				//die( "An administrator account has been updated." );
			}
			
		?>
	</head>
	<body>
		<!--<center><b><font color = "brown" size="6">Online Voting using FHE</font></b></center><br><br>-->
		<nav class="navbar navbar-inverse">
          <div class="container-fluid">
            <div class="navbar-header">
              <a class="navbar-brand" href="admin.php">Voting</a>
            </div>
            <ul class="nav navbar-nav">
              <li class="active"><a href="manage-admins.php">Manage Administrators</a></li>
              <li><a href="positions.php">Manage Positions</a></li>
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
        			<div class="row">
        				<div class="col-lg-12">
        					<div class="well contact-form-container">
        						<form class="form-horizontal contactform" action="manage-admins.php?id=<?php echo $_SESSION['admin_id']; ?>" method="post">
        							<div class="row">
        								<div class="col-lg-2">
        									
        								</div>
        								<div class="col-lg-8">
        									<div class="row">
        										<center>
        											<h4>Update Account</h4>
        										</center>
        									</div>
        									<div class="row">
        										<div class="col-lg-6">
        											<center>
        												<h5>First Name</h5>
        											</center>
        										</div>
        										<div class="col-lg-6">        											
        											<input class="form-control" type="text" name="first_name" autocomplete="off" required/>
        										</div>
        									</div>
        									<br>
        									<div class="row">
        										<div class="col-lg-6">
        											<center>
        												<h5>Last Name</h5>
        											</center>
        										</div>
        										<div class="col-lg-6">        											
        											<input class="form-control" type="text" name="last_name" autocomplete="off" required/>
        										</div>
        									</div>
        									<br>
        									<div class="row">
        										<div class="col-lg-6">
        											<center>
        												<h5>Email</h5>
        											</center>
        										</div>
        										<div class="col-lg-6">        											
        											<input class="form-control" type="text" name="email" autocomplete="off" required/>
        										</div>
        									</div>
        									<br>
        									<div class="row">
        										<div class="col-lg-6">
        											<center>
        												<h5>New Password</h5>
        											</center>
        										</div>
        										<div class="col-lg-6">        											
        											<input class="form-control" type="password" name="password" autocomplete="off" required/>
        										</div>
        									</div>
        									<br>
        									<div class="row">
        										<div class="col-lg-6">
        											<center>
        												<h5>Confirm Password</h5>
        											</center>
        										</div>
        										<div class="col-lg-6">        											
        											<input class="form-control" type="password" name="ConfirmPassword" autocomplete="off" required/>
        										</div>
        									</div>
        									<br>
        									<div class="row">
        										<div class="col-lg-4">
        											
        										</div>
        										<div class="col-lg-4">
        											<center>
        												<input class="btn btn-success" type="submit" name="update" value="Update">
        											</center>
        										</div>
        										<div class="col-lg-4">
        											
        										</div>
        									</div>
        								</div>
        								<div class="col-lg-2">
        									
        								</div>
        							</div>
        						</form>
        						
        						<hr style="height:1px;color:#333;background-color:#333;">
        						
        						<form class="form-horizontal contactform" action="manage-admins.php?id=<?php echo $_SESSION['admin_id']; ?>" method="post">
        							<div class="row">
        								<div class="col-lg-2">
        									
        								</div>
        								<div class="col-lg-8">
        									<div class="row">
        										<center>
        											<h4>Add Account</h4>
        										</center>
        									</div>
        									<div class="row">
        										<div class="col-lg-6">
        											<center>
        												<h5>First Name</h5>
        											</center>
        										</div>
        										<div class="col-lg-6">        											
        											<input class="form-control" type="text" name="first_name" autocomplete="off" required />
        										</div>
        									</div>
        									<br>
        									<div class="row">
        										<div class="col-lg-6">
        											<center>
        												<h5>Last Name</h5>
        											</center>
        										</div>
        										<div class="col-lg-6">        											
        											<input class="form-control" type="text" name="last_name"  autocomplete="off" required/>
        										</div>
        									</div>
        									<br>
        									<div class="row">
        										<div class="col-lg-6">
        											<center>
        												<h5>Email</h5>
        											</center>
        										</div>
        										<div class="col-lg-6">        											
        											<input class="form-control" type="email" name="email" autocomplete="off" required/>
        										</div>
        									</div>
        									<br>
        									<div class="row">
        										<div class="col-lg-6">
        											<center>
        												<h5>New Password</h5>
        											</center>
        										</div>
        										<div class="col-lg-6">        											
        											<input class="form-control" type="password" name="password" autocomplete="off" required/>
        										</div>
        									</div>
        									<br>
        									<div class="row">
        										<div class="col-lg-6">
        											<center>
        												<h5>Confirm Password</h5>
        											</center>
        										</div>
        										<div class="col-lg-6">        											
        											<input class="form-control" type="password" name="ConfirmPassword" autocomplete="off" required/>
        										</div>
        									</div>
        									<br>
        									<div class="row">
        										<div class="col-lg-4">
        											
        										</div>
        										<div class="col-lg-4">
        											<center>
        												<input class="btn btn-success" type="submit" name="create" value="Create">
        											</center>
        										</div>
        										<div class="col-lg-4">
        											
        										</div>
        									</div>
        								</div>
        								<div class="col-lg-2">
        									
        								</div>
        							</div>
        						</form>
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