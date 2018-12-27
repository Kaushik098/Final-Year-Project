<!DOCTYPE html>
<html>
	<head>
		<title></title>
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
		 	$emailcheck = "";
		 	
		 	//connect to database
		 	$mysqli = new mysqli('localhost','root','','poll');

		  	if($_SERVER['REQUEST_METHOD'] == 'POST')
		  	{
				//$adhaarnumber = $mysqli->real_escape_string($_POST['adhaarnumber']);
		  	  	$emailcheck = $mysqli->real_escape_string($_POST['email']);

		  	  	$sql2 = "SELECT email FROM tbmembers WHERE email ='$emailcheck'";
		      	$result2 = mysqli_query($mysqli, $sql2);
		    
		      	if(mysqli_num_rows($result2)>0)
		       	{
		        		echo "<div class='alert alert-danger'>Email exists!</div>";
		       	}
		      	else 
		      	{
		        	if($_POST['password'] == $_POST['ConfirmPassword'])//if two passwords are equal
		        	{  
		          		//print_r($_FILES);
		          		$first_name = $_POST['first_name'];
		          		$last_name = $_POST['last_name'];
		          		$email = $_POST['email'];
		        		$password = $_POST['password'];
		        		$password = md5($password);
		        		echo "$password";
		          
		         		$sql = "INSERT INTO tbmembers(first_name,last_name,email, password) VALUES ('$first_name','$last_name','$email','$password')";
				         
				   		//if the query is successful,redirect to resulting page
				        if($mysqli->query($sql) == true)
				        {
				           	echo "<div class='alert alert-success'>Registration Successful!</div>";
				           	//header("location:welcome.php");
				        }
				        else
				        {
				           	echo "<div class='alert alert-danger'>User could not be added!</div>";
				        }
				    }
		           	else
		        	{
		        		echo "<div class='alert alert-danger'>Password Mismatch!</div>";
		        	}
		      	}  
		  	}
		?>
	</head>
	<body>
		<div align="center" style="color: white;">
			<h1>Voter Registration </h1>
		</div>
		
		<center style="color: white;"> <h3>Register by filling in the needed information below:</h3> </center> <br>
		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					
				</div>

				<div class="col-lg-4">
					<div class="col-lg-12">
						<div class="well contact-form-container">
							<form action="registeracc.php" method="post" autocomplete="off">
								<div>
									<input type="text" class="form-control" placeholder="First Name" name="first_name" autocomplete="off" required /><br> 
								</div>
								<div align="center">
									<input type="text" class="form-control" placeholder="Last Name" name="last_name" autocomplete="off" required /><br> 
								</div>
								<div align="center">
									<input type='email' class="form-control" placeholder="Email" name="email" required autocomplete="off"/><br> 
								</div>
								<div align="center">
									<input type='password' class="form-control" placeholder="Password" name="password" autocomplete="new-password" required /><br> 
								</div>
								<div align="center">
									<input type='password' class="form-control" placeholder="Confirm Password" name="ConfirmPassword" autocomplete="new-password" required /><br> 
								</div>
								<div align="center">
									<input class="btn btn-primary" type='submit' name="submit" value="Register" />
								</div>
								<br>
								<div align="center">
									<p>Already have an account? <a href="index.php"> <b>Login</b> </a> </p>
								</div>			
							</form>
						</div>
					</div>
				<div class="col-lg-4">
					
				</div>
			</div>
		</div>
	</body>
</html>