<?php
	session_start();
?>
<html>
	<head>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link href="css/user_styles.css" rel="stylesheet" type="text/css" />
	</head>
	<body bgcolor="#888888">  
		<center><b><font color = "brown" size="6">Online Voting using FHE</font></b></center><br><br>
		<div id="page">
			<div id="header">
				<h1>Logged Out Successfully </h1>
				<p align="center">&nbsp;</p>
			</div>
			<div align="center">
				<?php
					session_destroy();
				?>
				You have been successfully logged out.<br><br><br>
				Return to <a href="index.php">Login</a>
			</div>
			<div id="footer" align="center">
				<div class="bottom_addr">&copy; Prepared by RMKCET</div>
			</div>
		</div>
	</body>
</html>