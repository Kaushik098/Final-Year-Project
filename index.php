<html>
	<head>
	  	<!-- <link rel="stylesheet" href="css/user_styles.css"> -->
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
			// Escape email to protect against SQL injections
			if($_SERVER['REQUEST_METHOD'] == 'POST')
		  	{
		  		$count0 = 0;
				$count1 = 0;
				$count2 = 0;
			
		  		$email = $_POST['email'];
				$password = $_POST['password'];
				$encrypted_password = md5($password);
		        $emailsql=" SELECT email FROM tbmembers WHERE email='$email'";
		        $q0 = mysqli_query($mysqli,$emailsql);
		        $count0 = mysqli_num_rows($q0);
				$passsql =" SELECT password FROM tbmembers where password='$encrypted_password'";
				$q1 = mysqli_query($mysqli,$passsql);
				$count1 = mysqli_num_rows($q1);
		        $sql = "SELECT email,password FROM tbmembers WHERE email='$email' and password='$encrypted_password'";
		        $q2 = mysqli_query($mysqli,$sql);
		        $count2 = mysqli_num_rows($q2);
		        $votesql = "SELECT * FROM tbmembers WHERE email='$email' and password='$encrypted_password'";
		        $q3 = mysqli_query($mysqli,$votesql);
		        $row = mysqli_fetch_array($q3);
		        $votevalue = $row['voted'];

		        if($count0 == 0)
		        {
		            echo "<div class='alert alert-danger'>User doesn't exist</div>";
		        }
		        else if($count1 == 1)
		        {
		            if($count2 == 1)
		            {
		                if($votevalue == 0)
		                {
		                    $final = " SELECT * from tbmembers where email='$email' and password='$encrypted_password'";
		                    $finalresult = mysqli_query($mysqli, $final);
		    			    $user = mysqli_fetch_assoc($finalresult);
		    				$_SESSION['member_id'] = $user['member_id'];		    			
		    				header("location:manage-profile.php");		    				
		                }
					    else if($votevalue == 1)	    
					        echo "<div class='alert alert-danger'>You have already Voted! You will be intimated when a next poll is scheduled!</div>";
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
			<div id="header">
				<h1><i>Welcome Back!</i></h1>
				<div class="news" style="color: white;"><marquee behavior="alternate">New polls are up and running, but not forever! Login to vote. </marquee></div>
			</div>
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
				              		<center>
										<br>Not a member? <a href="registeracc.php"><b>Register</b></a><br><br>
									</center>
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