<!DOCTYPE html>
<html>
	<head>
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
			session_start();
			$mysqli = new mysqli('localhost','root','','poll');
			$email = "";
			$password = "";
			$encrypted_password = "";
			
			/* User login process, checks if user exists and password is correct */
			// Escape email to protect against SQL injections
			if($_SERVER['REQUEST_METHOD'] == 'POST')
		  	{
		  		$count0 = 0;
				$count1 = 0;
				$count2 = 0;

				$email = $_POST['email'];
				$password = $_POST['password'];

				$encrypted_password = md5($password);

				$email = stripslashes($email);
				$password = stripslashes($encrypted_password);

				$email = $mysqli->real_escape_string($email);
				$password = $mysqli->real_escape_string($password);

				$sql0 ="SELECT email FROM tbadministrators WHERE email='$email'";;
				$result0 = mysqli_query($mysqli, $sql0);
				$count0 = mysqli_num_rows($result0);

				$sql1 ="SELECT password FROM tbadministrators where password='$password'";
				$result1 = mysqli_query($mysqli,$sql1);
				$count1 = mysqli_num_rows($result1);

				$sql2 = "SELECT * FROM tbadministrators WHERE email='$email' and password='$password'";
		        $result2 = mysqli_query($mysqli,$sql2);
		        $count2 = mysqli_num_rows($result2);

		        if($count0 == 0)
		        {
		            echo "<div class='alert alert-danger'>Entries does not match our records!!</div>";
		        }
		        else if($count1 !=0)
		        {
		            if($count2 == 1)
		            {
		            	
		                // If everything checks out, you will now be forwarded to student.php
						$user = mysqli_fetch_assoc($result2);
						$_SESSION['admin_id'] = $user['admin_id'];
						header("location:admin.php");
		            }
		            else
		            {
		                echo "<div class='alert alert-danger'>Username and Password does not match!</div>";
		            }
		        }
		        else
		        {
		            echo "<div class='alert alert-danger'>Incorrect Password</div>";
		        }
		    }
		?>
	</head>
	
	<body>
		<center><b><font color = "white" size="6">Online Voting</font></b></center><br><br>
		<div id="page">
			<div id="header" align="center">
				<h1><i>Welcome Admin!</i></h1>
			</div>
			<br>
			<div class="container">
				<div class="row">
					<div class="col-lg-3">

					</div>

					<div class="col-lg-6" >
						<div class="col-lg-12">
							<div class="well contact-form-container">
								<form class="form-horizontal contactform" action="index.php" method="post"  autocomplete="off">
									<div class="form-group col-lg-12">
										<input style="color: black;" type="email" class="form-control" placeholder="Email" name="email" autocomplete="off" required />
			       					</div>

				       				<div class="form-group col-lg-12">	  
										<input style="color: black;" type="password" class="form-control" placeholder="Password" name="password" autocomplete="off" required />								
					              	</div>

				              		<div class="form-group" align="center" >
				              			<input type="submit" class="btn btn-primary" name="submit" value="Log In" />
				              		</div>				      
								</form>
							</div>
						</div>
					</div>

					<div class="col-lg-3">

					</div>
				</div>
			</div>
		</div>
	</body>
</html>