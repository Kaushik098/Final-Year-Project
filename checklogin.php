<!--<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<title>Online Voting using FHE Access Denied</title>
		<link href="css/user_styles.css" rel="stylesheet" type="text/css" />
	</head>
	<body bgcolor="tan">
	<center><a href ="https://sourceforge.net/projects/pollingsystem/"><img src = "images/logo" alt="site logo"></a></center><br>     
		<center><b><font color = "brown" size="6">Online Voting using FHE</font></b></center><br><br>
		<body>
			<div id="page">
				<div id="header">
					<h1>Invalid Credentials Provided </h1>
					<p align="center">&nbsp;</p>
				</div>
				<div id="container">
					<?php
						/*ini_set ("display_errors", "1");
						error_reporting(E_ALL);
						ob_start();
						session_start();
						require 'connection.php';
						// Defining your login details into variables
						$email=$_POST['email'];
						$password=$_POST['password'];

						$encrypted_password=md5($password); //MD5 Hash for security
						// MySQL injection protections

						$email = stripslashes($email);
						$password = stripslashes($password);
						$email = mysqli_real_escape_string($email);
						$password = mysqli_real_escape_string($password);

						$sql="SELECT * FROM tbmembers WHERE email='$email' and password='$encrypted_password'";// or die(mysqli_error());
						$result= mysqli_query($sql);// or die(mysqli_error());

						// Checking table row
						$count= mysqli_num_rows($result);
						// If username and password is a match, the count will be 1

						if($count==1)
						{
							// If everything checks out, you will now be forwarded to student.php
							$user = mysql_fetch_assoc($result);
							$_SESSION['member_id'] = $user['member_id'];
							header("location:student.php");
						}
						//If the username or password is wrong, you will receive this message below.
						else 
						{
							echo "Wrong Username or Password<br><br>Return to <a href=\"index.php\">login</a>";
						}
						ob_end_flush();*/
					?> 
				</div>
				<div id="footer"> 
		  			<div class="bottom_addr">&copy; Prepared by RMKCET</div>
				</div>
			</div>
		</body>
	</body>
</html>-->

<!--<?php
	//session_start();
	//$mysqli = new mysqli('localhost','root','','poll');
	 //User login process, checks if user exists and password is correct */

	// Escape email to protect against SQL injections
	/*$email=$_POST['email'];
	$password=$_POST['password'];

	$encrypted_mypassword=md5($mypassword);

	$email = stripslashes($email);
	$password = stripslashes($password);

	$email = $mysqli->real_escape_string($email);
	$password = $mysqli->real_escape_string($password);

	$sql="SELECT * FROM tbmembers WHERE email='$email' and password='$encrypted_mypassword'";
	$result= mysqli_query($sql);

	$count= mysqli_num_rows($result);

	if($count==1)
	{
		// If everything checks out, you will now be forwarded to student.php
		$user = mysql_fetch_assoc($result);
		$_SESSION['member_id'] = $user['member_id'];
		header("location:student.php");
	}
	else 
	{
		echo "Wrong Username or Password<br><br>Return to <a href=\"index.php\">login</a>";*/
	}


	/*$emailresult = mysqli_query($mysqli,"SELECT email FROM tbmembers WHERE email='$email'");
	$passwordresult = mysqli_query($mysqli,"SELECT password FROM tbmembers WHERE password='$password'");
	if ( $emailresult->num_rows == 0 )
	{ 	
		echo "User doesn't exist!";
	}
	else
	{ 
		// User exists
	    $user = $emailresult->fetch_assoc();
	    if ( password_verify($_POST['password'], $user['password']) )
	    {
	        
	        $_SESSION['email'] = $user['email'];
	        $_SESSION['first_name'] = $user['first_name'];
	        $_SESSION['last_name'] = $user['last_name'];

	        $_SESSION['active'] = $user['active'];
	        // This is how we'll know the user is logged in
    	    $_SESSION['logged_in'] = true;
	    }
	    else 
	    {
	        $_SESSION['message'] = "You have entered wrong password, try again!";
	    }
	}*/
?>-->