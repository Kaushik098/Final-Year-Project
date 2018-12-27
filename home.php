<?php
	
	require('connection.php');
	session_start();
	
	//If your session isn't valid, it returns you to the login screen for protection
	if(empty($_SESSION['member_id']))
	{
		header("location:access-denied.php");
	}
	
?>
<html>
	<head>
		<link href="css/user_styles.css" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
	</head>
	<body>
		<nav class="navbar navbar-inverse">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="home.php">Voting</a>
		    </div>
		    <ul class="nav navbar-nav">
		      <li><a href="vote.php">Current Polls</a></li>
		      <li><a href="manage-profile.php">Manage My Profile</a></li>
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
                        <div class="well contact-form-container">
                            <div class="row">
                            	<label>Credits & Contact</label>		
                            </div>
                            <div class="row">
                            	<b>Developed by</b><br>
                            	<label>Kaushik L</label><br>
                            	<label>Manikandan R</label><br>
                            	<label>Nagarjun V</label><br>
                            	<label>Prabhu R</label><br>
                            </div>
                            <div class="row">
                            		
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