<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
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
			
			//If your session isn't valid, it returns you to the login screen for protection
			if(empty($_SESSION['admin_id']))
			{
		 		header("location:access-denied.php");
			}
		?>
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
              <li><a href="candidates.php">Manage Candidates</a></li>
              <li><a href="refresh.php">Poll Results</a></li>
              <li><a href="index.php">Logout</a></li>
            </ul>
          </div>
        </nav>
        <div class="alert alert-info">
            <center>
                Click a link above to perform an administrative operation
            </center>
        </div>
		<!-- <div id="page">
			
			<p align="center">&nbsp;</p>
			<div id="container">
				<p align="center">Click a link above to perform an administrative operation.</p>
			</div>
	
		</div> -->
	</body>
</html>